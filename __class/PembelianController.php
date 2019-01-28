<?php
error_reporting(0);
require_once "db.php";
require_once "BarangController.php";
require_once "SatuanBarangController.php";

class PembelianController extends db{

    protected function procedNumberUrut($angka){
        $format_tanggal = date(ym);
        if($angka < 10):
            $result = "TB".$format_tanggal."000".$angka;
        elseif($angka < 100):
            $result = "TB".$format_tanggal."00".$angka;
        elseif($angka < 1000):
            $result = "TB".$format_tanggal."0".$angka;
        else:
            $result = "TB".$format_tanggal.$angka;
        endif;

        return $result;
    }

    public function SetIdPembelian(){
        //check max kode SetKodeBarang
        $tabel = "pembelian";
        $fild = "IFNULL(MAX(RIGHT(id_pembelian,4)),0) as max";
        
        foreach(parent::select($tabel, $fild) as $datamax):
            $max = $datamax['max']+1;
        endforeach;

        $id_pembelian = $this->procedNumberUrut($max);

        return $id_pembelian; 
    }

    public function data($periode=null,$limit=null, $kepemilikan="all"){
        $tabel = array(
            'pembelian PE',
            'pemasok PM',
            'user U'
        ); 
        $fild = "*";

        $where_kepemilikan = "";
        $where_periode = "";

        if($kepemilikan!='all'):
            $where_kepemilikan = " AND B.id_kepemilikan='$kepemilikan'";
        endif;

        if($periode!=null || !empty($periode)):
            $awal = substr($periode,0,10);
            $akhir = substr($periode,13,10);

            $where_periode = " AND date(PE.tanggal_pembelian)>='$awal' AND date(PE.tanggal_pembelian)<='$akhir'";
        endif;
        
        $where = "PE.id_pemasok=PM.id_pemasok AND PE.id_user=U.id_user $where_kepemilikan $where_periode";
        $order = "PE.tanggal_pembelian DESC";
        
        $i = 0;
        $no = 1;
        foreach(parent::select($tabel, $fild, $where, '',$order,$limit) as $data):
            $datas[$i]['no'] = $no++;
            $datas[$i]['id_pembelian'] = $data['id_pembelian'];
            $datas[$i]['nama_pemasok'] = ucwords($data['nama_pemasok']);
            $datas[$i]['nama_petugas'] = ucwords($data['nama_lengkap']);
            $datas[$i]['tanggal'] = date("d M Y, H:i", strtotime($data['tanggal_pembelian']));
            $datas[$i]['total'] = "Rp   ".formatRupiah($data['total_pembelian']);
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    public function getDetilPembelian($id){
        $tabel = array(
            'detil_pembelian D',
            'barang B',
            'satuan_barang as S'
        ); 
        $fild = "*";
        $where = "D.kode_barang=B.kode_barang AND S.id_satuan_barang=D.id_satuan_barang AND D.id_pembelian='$id'";
        $order = "B.nama_barang ASC";

        $i = 0;
        $no = 1;
        foreach(parent::select($tabel, $fild, $where, '',$order) as $data):
            $datas[$i]['no'] = $no++;
            $datas[$i]['kode_barang'] = $data['kode_barang'];
            $datas[$i]['nama_barang'] = ucwords($data['nama_barang']);
            $datas[$i]['jumlah'] = $data['jumlah_beli'];
            $datas[$i]['satuan'] = $data['nama_satuan_barang'];
            $datas[$i]['harga'] = $data['harga_beli'];
            $datas[$i]['kepemilikan'] = $data['id_kepemilikan'];
            $datas[$i]['subtotal'] = $data['harga_beli']*$data['jumlah_beli'];
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    public function SelectBarang(){
        $BarangCon = new BarangController();
        $orderby = "ASC";
        $data = $BarangCon->dataBarangBeli($orderby);

        return $data;
    }

    public function SelectSatuanBarang(){
        $SatuanCon = new SatuanBarangController();
        $orderby = "ASC";
        $data = $SatuanCon->data($orderby);

        return $data;
    }

    public function getNameSatuan($id){
        $SatuanCon = new SatuanBarangController();
        $data = $SatuanCon->getDataByID($id);

        return $data;
    }
    

    public function get_kepemilikan_barang($id){
        $tabel = "kepemilikan_barang";
        $fild = "nama_pemilik";
        $where = "id_kepemilikan=$id";

        foreach(parent::select($tabel, $fild, $where) as $data):
        endforeach;

        return $data['nama_pemilik'];
    }

}
?>