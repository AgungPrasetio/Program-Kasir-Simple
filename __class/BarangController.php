<?php
// session_start();
error_reporting(0);
require_once "db.php";
require_once "JenisBarangController.php";
require_once "MerekController.php";
require_once "KepemilikanController.php";

class BarangController extends db{
    
    public function data($orderby=null){
        if($orderby==null):
            $orderby = "DESC";
        endif;

        $tabel = array(
            'barang B',
            'jenis_barang JB',
            'kategori K',
            'merek M'
        ); 
        $fild = "*";
        $where = "JB.id_jenis_barang=B.id_jenis_barang AND K.id_kategori=JB.id_kategori AND B.id_merek=M.id_merek AND B.status_barcode_awal=0";
        $order = "B.kode_barang $orderby";
        $i = 0;
        $no = 1;
        foreach(parent::select($tabel, $fild, $where, '',$order) as $data):
            $datas[$i]['no'] = $no++;
            $datas[$i]['kode_barang'] = $data['kode_barang'];
            $datas[$i]['nama_barang'] = $data['nama_barang'];
            $datas[$i]['harga_barang'] = $data['harga_barang'];
            $datas[$i]['stok_barang'] = $data['stok_barang'];
            $datas[$i]['nama_jenis_barang'] = $data['nama_jenis_barang'];
            $datas[$i]['nama_merek'] = $data['nama_merek'];
            $datas[$i]['nama_kategori'] = $data['nama_kategori'];
            $datas[$i]['limit_stok'] = $data['limit_stok'];
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    public function data_stok_barang_habis($orderby=null, $limit=null, $kepemilikan="all"){
        if($orderby==null):
            $orderby = "DESC";
        endif;

        $wherekepemilikan = "";
        if($kepemilikan!="all"){
            $wherekepemilikan = " AND B.id_kepemilikan='$kepemilikan'";
        }

        $tabel = array(
            'barang B',
            'jenis_barang JB',
            'kategori K',
            'merek M'
        ); 
        $fild = "*";
        $where = "JB.id_jenis_barang=B.id_jenis_barang AND K.id_kategori=JB.id_kategori AND B.id_merek=M.id_merek $wherekepemilikan";
        $order = "B.kode_barang $orderby";
        $i = 0;
        $no = 1;
        foreach(parent::select($tabel, $fild, $where, '', $order, $limit) as $data):
            $datas[$i]['no'] = $no++;
            $datas[$i]['kode_barang'] = $data['kode_barang'];
            $datas[$i]['nama_barang'] = $data['nama_barang'];
            $datas[$i]['harga_barang'] = $data['harga_barang'];
            $datas[$i]['stok_barang'] = $data['stok_barang'];
            $datas[$i]['nama_jenis_barang'] = $data['nama_jenis_barang'];
            $datas[$i]['nama_merek'] = $data['nama_merek'];
            $datas[$i]['nama_kategori'] = $data['nama_kategori'];
            $datas[$i]['limit_stok'] = $data['limit_stok'];
            $datas[$i]['kepemilikan'] = $this->get_kepemilikan_barang($data['id_kepemilikan']);
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }


    public function data_barang_laba($kepemilikan="all", $bulan='', $tahun=''){
        $barang = $this->data_stok_barang_habis('ASC','',$kepemilikan);
        $html = "";
        if(count($barang) > 0):
            foreach($barang as $d):
                $html .= '
                    <tr>
                        <td>'.$d->no.'</td>
                        <td>'.$d->nama_barang.'</td>
                        <td>'.$d->kepemilikan.'</td>
                    </tr>
                ';
            endforeach;
        endif;

        return $html;
    }

    public function get_penjualan_per_barang($kode_barang, $m, $y){
        $tabel = array(
            'penjualan P',
            'detil_penjualan DP'
        );
        $fild = array(
            'P.'
        );
    }

    public function databarcode($orderby=null){
        if($orderby==null):
            $orderby = "DESC";
        endif;

        $tabel = array(
            'barang B',
            'jenis_barang JB',
            'kategori K',
            'merek M'
        ); 
        $fild = "*";
        $where = "JB.id_jenis_barang=B.id_jenis_barang AND K.id_kategori=JB.id_kategori AND B.id_merek=M.id_merek AND B.status_barcode_awal=1";
        $order = "B.kode_barang $orderby";
        $i = 0;
        $no = 1;
        foreach(parent::select($tabel, $fild, $where, '',$order) as $data):
            $datas[$i]['no'] = $no++;
            $datas[$i]['kode_barang'] = $data['kode_barang'];
            $datas[$i]['nama_barang'] = $data['nama_barang'];
            $datas[$i]['harga_barang'] = $data['harga_barang'];
            $datas[$i]['stok_barang'] = $data['stok_barang'];
            $datas[$i]['nama_jenis_barang'] = $data['nama_jenis_barang'];
            $datas[$i]['nama_merek'] = $data['nama_merek'];
            $datas[$i]['nama_kategori'] = $data['nama_kategori'];
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }
	
	public function dataBarangBeli($orderby=null){
        if($orderby==null):
            $orderby = "DESC";
        endif;

        $tabel = array(
            'barang B',
            'jenis_barang JB',
            'kategori K',
            'merek M'
        ); 
        $fild = "*";
        $where = "JB.id_jenis_barang=B.id_jenis_barang AND K.id_kategori=JB.id_kategori AND B.id_merek=M.id_merek";
        $order = "B.kode_barang $orderby";
        $i = 0;
        $no = 1;
        foreach(parent::select($tabel, $fild, $where, '',$order) as $data):
            $datas[$i]['no'] = $no++;
            $datas[$i]['kode_barang'] = $data['kode_barang'];
            $datas[$i]['nama_barang'] = $data['nama_barang'];
            $datas[$i]['harga_barang'] = $data['harga_barang'];
            $datas[$i]['stok_barang'] = $data['stok_barang'];
            $datas[$i]['nama_jenis_barang'] = $data['nama_jenis_barang'];
            $datas[$i]['nama_merek'] = $data['nama_merek'];
            $datas[$i]['nama_kategori'] = $data['nama_kategori'];
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    public function getDataByID($id){
        $tabel = array(
            'barang B',
            'jenis_barang JB',
            'merek M',
            'kepemilikan_barang K'
        ); 
        $fild = "*";
        $where = "JB.id_jenis_barang=B.id_jenis_barang AND M.id_merek=B.id_merek AND B.id_kepemilikan=K.id_kepemilikan AND B.kode_barang='$id'";
        $order = "B.kode_barang DESC";
        $i = 0;

        foreach(parent::select($tabel, $fild, $where) as $data):
            $datas[$i]['kode_barang'] = $data['kode_barang'];
            $datas[$i]['nama_barang'] = $data['nama_barang'];
            $datas[$i]['stok_barang'] = $data['stok_barang'];
            $datas[$i]['harga_barang'] = $data['harga_barang'];
            $datas[$i]['limit_stok'] = $data['limit_stok'];
            $datas[$i]['id_jenis_barang'] = $data['id_jenis_barang'];
            $datas[$i]['nama_jenis_barang'] = $data['nama_jenis_barang'];
            $datas[$i]['id_merek'] = $data['id_merek'];
            $datas[$i]['nama_merek'] = $data['nama_merek'];
            $datas[$i]['id_kepemilikan'] = $data['id_kepemilikan'];
            $datas[$i]['nama_pemilik'] = $data['nama_pemilik'];
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    //count relation of kategori
    public function count($id){
        $tbr = "detil_penjualan";
        $rowname = "kode_barang";
        $count = parent::getCount($tbr, $rowname, $id);

        return $count;
    }

    public function SelectJenisBarang(){
        $JenisCon = new JenisBarangController();
        $orderby = "ASC";
        $data = $JenisCon->data($orderby);

        return $data;
    }

    public function SelectMerek(){
        $MerekCon = new MerekController();
        $orderby = "ASC";
        $data = $MerekCon->data($orderby);

        return $data;
    }

    public function SelectKepemilikan(){
        $Con = new KepemilikanController();
        $orderby = "ASC";
        $data = $Con->data($orderby);

        return $data;
    }

    protected function procedNumberUrut($angka){
        if($angka < 10):
            $result = "0000".$angka;
        elseif($angka < 100):
            $result = "000".$angka;
        elseif($angka < 1000):
            $result = "00".$angka;
        elseif($angka < 10000):
            $result = "0".$angka;
        else:
            $result = $angka;
        endif;

        return $result;
    }

    public function SetKodeBarang($kode_jenis_barang){
        //check max kode SetKodeBarang
        $tabel = "barang";
        $fild = "IFNULL(MAX(SUBSTR(kode_barang,8,5)),0)+1 as max";
        $where = "SUBSTR(kode_barang,4,4)='$kode_jenis_barang'";

        foreach(parent::select($tabel, $fild, $where) as $datamax):
            $max = $datamax['max'];
        endforeach;

        $kodenegara = "899";
        $kodemanufaktur = $kode_jenis_barang;
        $nourutproduk = $this->procedNumberUrut($max);

        $digit = $kodenegara.$kodemanufaktur.$nourutproduk;
        $hasilkali=0;
        
        for($i=0;$i<strlen($digit);$i++):
            if($i%2==1):
                $angka = substr($digit,$i,1)*3;
            else:
                $angka = substr($digit,$i,1)*1;
            endif;
            
            $hasilkali+=$angka;
        endfor;

        $modulus = $hasilkali%10;

        if($modulus==0):
            $modulus = 10;
        endif;

        $checkdigit = 10-$modulus;

        $kodebarang = $digit.$checkdigit;

        return $kodebarang; 
    }


    public function set_hpp($kode_barang){
        $bulan_now = date("m");

        //get data pembelian
        $tabel = array(
            'pembelian P',
            'detil_pembelian DP'
        );
        $fild = "*";
        
        $where = "P.id_pembelian=DP.id_pembelian AND DP.kode_barang='$kode_barang' AND month(tanggal_pembelian)='$bulan_now'";
        

        //get count data
        $count = parent::getCount($tabel, '','',$where);
        $i=0;
        $hpp=0;
        if($count==0):
            $bulan_now = $bulan_now-1;
            $where = "P.id_pembelian=DP.id_pembelian AND DP.kode_barang='$kode_barang' AND month(tanggal_pembelian)='$bulan_now'";
        endif;

        $count_data = parent::getCount($tabel, '','',$where);

        if($count_data!=0){
            foreach(parent::select($tabel, $fild, $where) as $data):
                $harga_beli = $data['harga_beli'];
                $jumlah_beli = $data['jumlah_beli'];
                $jumlah_persatuan = $data['jumlah_persatuan'];
                $sub_total = $harga_beli*$jumlah_beli;
                // $hpp+=$harga_beli;
                $harga_persatu = $harga_beli/$jumlah_persatuan;
                $hpp += $harga_persatu+($harga_persatu*0.25);
                $i+=1;
            endforeach;
            $harga_akhir = round($hpp/$i,0);
        }else{
            $harga_akhir = $this->get_harga_barang($kode_barang);
        }
        
        return $harga_akhir;
    }

    public function set_harga_jual($kode_barang){
        //get data pembelian
        $tabel = array(
            'pembelian P',
            'detil_pembelian DP'
        );
        $fild = "*";
        
        $where = "P.id_pembelian=DP.id_pembelian AND DP.kode_barang='$kode_barang'";
        $order_by = "P.tanggal_pembelian DESC";
        $limit = "0,1";

        $count = parent::getCount($tabel, '','',$where);
        if($count>0):
            $harga_persatu = 0;
            foreach(parent::select($tabel, $fild, $where, '', $order_by, $limit) as $data):
                $harga_beli = $data['harga_beli'];
                $jumlah_beli = $data['jumlah_beli'];
                $jumlah_persatuan = $data['jumlah_persatuan'];
                $laba = $data['laba'];
                $harga_jual = $harga_beli/$jumlah_persatuan;
                $harga_jual = $harga_jual+($harga_jual*($laba/100));
            endforeach;
            $harga_akhir = $harga_jual;
        else:
            $harga_akhir = $this->get_harga_barang($kode_barang);
        endif;

        return $harga_akhir;
    }

    public function get_harga_barang($kode_barang){
        $table = "barang";
        $fild = "harga_barang";
        $where = "kode_barang='$kode_barang'";

        foreach(parent::select($table, $fild, $where) as $data):
        endforeach;

        return $data['harga_barang'];
    }

    public function get_kedudukan_session(){
        $kedudukan = $_SESSION['kedudukan'];

        $name_kedudukan = parent::kedudukan_session($kedudukan);
        return $name_kedudukan;
    }


    public function get_stok_akhir($id){
        $table = "barang as a";
        $fild = "(a.stok_barang+(SELECT ifnull(sum(c.jumlah_persatuan*c.jumlah_beli),0) FROM detil_pembelian AS c WHERE kode_barang='$id' )-(SELECT ifnull(sum(b.jumlah),0) FROM detil_penjualan AS b WHERE kode_barang='$id')) as stok_akhir";
        $where = "kode_barang='$id'";

        foreach(parent::select($table, $fild, $where) as $data):
        endforeach;

        return $data['stok_akhir'];
        // return "asdasd";
    }
    

    public function get_kepemilikan_barang($id){
        $tabel = "kepemilikan_barang";
        $fild = "nama_pemilik";
        $where = "id_kepemilikan=$id";

        foreach(parent::select($tabel, $fild, $where) as $data):
        endforeach;

        return $data['nama_pemilik'];
    }

    public function get_nama_barang($kode_barang){
        $table = "barang";
        $fild = "nama_barang";
        $where = "kode_barang='$kode_barang'";

        foreach(parent::select($table, $fild, $where) as $data):
        endforeach;

        return $data['nama_barang'];
    }
}
?>