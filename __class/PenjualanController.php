<?php
error_reporting(0);
require_once "db.php";

class PenjualanController extends db{

    protected function procedNumberUrut($angka){
        $format_tanggal = date(ym);
        if($angka < 10):
            $result = "TJ".$format_tanggal."000".$angka;
        elseif($angka < 100):
            $result = "TJ".$format_tanggal."00".$angka;
        elseif($angka < 1000):
            $result = "TJ".$format_tanggal."0".$angka;
        else:
            $result = "TJ".$format_tanggal.$angka;
        endif;

        return $result;
    }

    public function SetIdPenjualan(){
        //check max kode SetKodeBarang
        $tabel = "penjualan";
        $fild = "IFNULL(MAX(RIGHT(id_penjualan,4)),0) as max";

        foreach(parent::select($tabel, $fild) as $datamax):
            $max = $datamax['max']+1;
        endforeach;

        $id_penjualan = $this->procedNumberUrut($max);

        return $id_penjualan; 
    }

    public function data($periode=null,$limit=null, $kepemilikan="all"){
        $kedudukanpgw = $_SESSION['kedudukan'];
        $namekedudukan = parent::kedudukan_session($kedudukanpgw);


        $tabel = array(
            'penjualan PE',
            'pelanggan PL',
            'user U',
            'detil_penjualan DP',
            'barang B'
        ); 
        $fild = "DISTINCT PE.id_penjualan, PL.nama_pelanggan, U.nama_lengkap, PE.tanggal_penjualan, PE.total, PE.diskon";

        $where_kepemilikan = "";
        $where_periode = "";

        if($kepemilikan!='all'):
            $where_kepemilikan = " AND B.id_kepemilikan='$kepemilikan'";
        endif;

        if($periode!=null || !empty($periode)):
            $awal = substr($periode,0,10);
            $akhir = substr($periode,13,10);

            $where_periode = " AND date(PE.tanggal_penjualan)>='$awal' AND date(PE.tanggal_penjualan)<='$akhir'";
        endif;

        if(strtolower($namekedudukan)=="kasir"):
            $where = "PE.id_pelanggan=PL.id_pelanggan AND PE.id_user=U.id_user AND PE.id_user='".$_SESSION['id_user']."' AND DP.id_penjualan=PE.id_penjualan AND DP.kode_barang=B.kode_barang $where_kepemilikan $where_periode";
        else:
            $where = "PE.id_pelanggan=PL.id_pelanggan AND PE.id_user=U.id_user AND DP.id_penjualan=PE.id_penjualan AND DP.kode_barang=B.kode_barang".$where_kepemilikan .$where_periode;
        endif;
        

        $order = "PE.tanggal_penjualan DESC";

        $i = 0;
        $no = 1;
        foreach(parent::select($tabel, $fild, $where, '',$order,$limit) as $data):
            $datas[$i]['no'] = $no++;
            $datas[$i]['id_penjualan'] = $data['id_penjualan'];
            $datas[$i]['nama_pelanggan'] = ucwords($data['nama_pelanggan']);
            $datas[$i]['nama_kasir'] = ucwords($data['nama_lengkap']);
            $datas[$i]['tanggal'] = date("d M Y, H:i", strtotime($data['tanggal_penjualan']));
            $datas[$i]['total'] = "Rp   ".formatRupiah($data['total']);
            $datas[$i]['diskon'] = $data['diskon'];
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    public function dataKasir($periode=null,$kasir=null){
        $tabel = array(
            'penjualan PE',
            'user U',
            'saldo_awal S'
        ); 
        $fild = "DISTINCT date(PE.tanggal_penjualan) as tanggal_penjualan, SUM(PE.total) as total_penjualan, S.saldo_awal_nominal, U.nama_lengkap";
        if($kasir!=null && $periode!=null):
            $awal = substr($periode,0,10);
            $akhir = substr($periode,13,10);
            $where = "PE.id_user=U.id_user AND S.id_user=U.id_user AND date(PE.tanggal_penjualan)=S.tanggal AND U.id_user='$kasir' AND date(PE.tanggal_penjualan)>='$awal' AND date(PE.tanggal_penjualan)<='$akhir'";
        endif;

        $order = "PE.tanggal_penjualan DESC";
        $groupby = "S.saldo_awal_nominal";

        $i = 0;
        $no = 1;
        foreach(parent::select($tabel, $fild, $where, '',$order,$limit, $groupby) as $data):
            $datas[$i]['no'] = $no++;
            $datas[$i]['tanggal'] = date("d M Y", strtotime($data['tanggal_penjualan']));
            $datas[$i]['total'] = $data['total_penjualan'];
            $datas[$i]['saldo'] = $data['saldo_awal_nominal'];
            $datas[$i]['nama_kasir'] = $data['nama_lengkap'];
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    public function data_penjualan_kasir($tanggal, $id_user){
        $date = date("Y-m-d", strtotime($tanggal));
        $tabel = "penjualan";
        $fild = "*";
        $where = "date(tanggal_penjualan) = '$date' AND id_user=$id_user";
        $order = "id_penjualan ASC";

        $i=0;
        $no =1;
        foreach(parent::select($tabel, $fild, $where, '',$order) as $data):
            $datas[$i]['no'] = $no++;
            $datas[$i]['id_penjualan'] = $data['id_penjualan'];
            $datas[$i]['total'] = $data['total'];
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        // print_r($datas);

        return $data;
    }

    public function getDetilPenjualan($id){
        $tabel = array(
            'detil_penjualan D',
            'barang B'
        ); 
        $fild = "*";
        $where = "D.kode_barang=B.kode_barang AND D.id_penjualan='$id'";
        $order = "B.nama_barang ASC";

        $i = 0;
        $no = 1;
        foreach(parent::select($tabel, $fild, $where, '',$order) as $data):
            $total_harga = $data['harga']*$data['jumlah'];
            $total_potongan_per_barang = $data['potongan_per_barang']*$data['jumlah'];
            $datas[$i]['no'] = $no++;
            $datas[$i]['kode_barang'] = $data['kode_barang'];
            $datas[$i]['nama_barang'] = ucwords($data['nama_barang']);
            $datas[$i]['jumlah'] = $data['jumlah'];
            $datas[$i]['harga'] = $data['harga'];
            $datas[$i]['total_harga'] = $total_harga;
            $datas[$i]['potongan_per_barang'] = $data['potongan_per_barang'];
            $datas[$i]['total_potongan_per_barang'] = $total_potongan_per_barang;
            $datas[$i]['subtotal'] = $total_harga-$total_potongan_per_barang;
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    public function SelectBarang(){
        $table = "barang";
        $fild = array(
            'kode_barang',
            'nama_barang'
        );

        $i = 0;
        foreach(parent::select($table, $fild) as $data):
            $datas[$i]['kode_barang'] = $data['kode_barang'];
            $datas[$i]['nama_barang'] = $data['nama_barang'];
            $i++;
        endforeach;
        
        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

}
?>