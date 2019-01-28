<?php
// session_start();
error_reporting(0);
require_once "db.php";
require_once "BarangController.php";

class LabaRugiController extends db{
    
    public function laba_rugi($bulan, $tahun){
        //get data penjualan
        $penjualan = "penjualan";
        $fpenjualan = "sum(total) AS total_penjualan";
        $total_penjualan = "";

        //get data pembelian
        $pembelian = "pembelian";
        $fpembelian = "sum(total_pembelian) AS total_pembelian";
        $total_pembelian = "";

        if($bulan!=""){
            $m = substr($bulan, 0,2);
            $y = substr($bulan, -4);
            
            //penjualan
            $wpenjualan = "month(tanggal_penjualan)=$m AND year(tanggal_penjualan)=$y";

            //pembelian
            $wpembelian = "month(tanggal_pembelian)=$m AND year(tanggal_pembelian)=$y";
        }
        if($tahun!=""){
            //penjualan
            $wpenjualan = "year(tanggal_penjualan)=$tahun";

            //pembelian
            $wpembelian = "year(tanggal_pembelian)=$tahun";
        }

        foreach(parent::select($penjualan, $fpenjualan, $wpenjualan) as $dpenjualan):
        endforeach;
        $total_penjualan = $dpenjualan['total_penjualan'];

        foreach(parent::select($pembelian, $fpembelian, $wpembelian) as $dpembelian):
        endforeach;
        $total_pembelian = $dpembelian['total_pembelian'];

        if($total_penjualan==""){
            $total_penjualan = 0;
        }
        if($total_pembelian==""){
            $total_pembelian = 0;
        }
        
        $labarugi = $total_penjualan-$total_pembelian;
        $tipe = "Laba";
        if($labarugi<0){
            $tipe = "Rugi";
            $labarugi = abs($labarugi);
        }
        $datas['total_penjualan'] = $total_penjualan;
        $datas['total_pembelian'] = $total_pembelian;
        $datas['labarugi'] = $labarugi;
        $datas['tipe'] = $tipe;

        return $datas;
    }
    

    public function lap_laba_rugi_kasir($bulan){
        $m = substr($bulan, 0,2);
        $y = substr($bulan, -4);

        $tpenjualan = array(
            'penjualan P',
            'user U'
        );
        $fpenjualan = "DISTINCT (P.id_user), U.nama_lengkap, P.id_user";
        $wpenjualan = "month(P.tanggal_penjualan)='$m' AND year(P.tanggal_penjualan)='$y' AND P.id_user=U.id_user";
        
        $i = 0;
        foreach(parent::select($tpenjualan, $fpenjualan, $wpenjualan) as $dpenjualan):
            $datas[$i]['nama_kasir'] = $dpenjualan['nama_lengkap'];
            $datas[$i]['id_user'] = $dpenjualan['id_user'];
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    public function lap_laba_rugi_per_tanggal($id_user, $bulan){
        $m = substr($bulan, 0,2);
        $y = substr($bulan, -4);

        $table = array(
            'penjualan PE',
            'pelanggan P'
        );
        $fild = array(
            'DISTINCT date(PE.tanggal_penjualan) as tanggal_penjualan',
            'P.nama_pelanggan',
            'P.id_pelanggan',
            'PE.id_user',
        );
        $where = "PE.id_pelanggan=P.id_pelanggan AND PE.id_user='$id_user' AND month(PE.tanggal_penjualan)='$m' AND year(PE.tanggal_penjualan)='$y'";


        $i = 0;
        foreach(parent::select($table, $fild, $where) as $data):
            $datas[$i]['nama_pelanggan'] = $data['nama_pelanggan'];
            $datas[$i]['tanggal_penjualan'] = $data['tanggal_penjualan'];
            $datas[$i]['id_pelanggan'] = $data['id_pelanggan'];
            $i++;
        endforeach;


        $json = json_encode($datas);
        $data = json_decode($json);

        // print_r($data);

        return $data;
    }

    public function lap_laba_rugi_detil($tanggal, $id_pelanggan, $id_user){
        $table = array(
            'detil_penjualan DP',
            'penjualan PE',
            'barang B'
        );
        $fild = array(
            'SUM(DP.jumlah) as jumlah_unit',
            'DP.kode_barang',
            'b.nama_barang',
            'DP.harga'
        );
        $where = "PE.id_penjualan=DP.id_penjualan AND b.kode_barang=DP.kode_barang AND date(PE.tanggal_penjualan)='$tanggal' AND PE.id_pelanggan=$id_pelanggan AND PE.id_user=$id_user";
        $groupby = "DP.kode_barang, b.nama_barang";

        $i = 0;
        foreach(parent::select($table, $fild, $where, '','','',$groupby) as $data):
            $datas[$i]['jumlah_unit'] = $data['jumlah_unit'];
            $datas[$i]['nama_barang'] = $data['nama_barang'];
            $datas[$i]['kode_barang'] = $data['kode_barang'];
            $datas[$i]['harga_barang'] = $data['harga'];
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        // print_r($data);

        return $data;
    }

    public function lap_laba_rugi1($bulan, $kode_barang){
        $barang_con = new BarangController();
        $tbarang = "barang";
        $fbarang = "*";
        $wbarang = "kode_barang='$kode_barang'";
        
        $i=0;
        foreach(parent::select($tbarang, $fbarang, $wbarang) as $data):
            $kode_barang = $data['kode_barang'];
            $check_pembelian_barang = $this->check_pembelian_barang($bulan, $kode_barang);

            $jumlah_stok_beli = $check_pembelian_barang['jumlah'];
            if(empty($jumlah_stok_beli)){
                $jumlah_stok_beli = 0;
            }

            if($jumlah_stok_beli!=0){
                $harga_pembelian = $check_pembelian_barang['harga']/$jumlah_stok_beli;
                $pembelian = $harga_pembelian*$jumlah_stok_beli;
            }else{
                $harga_pembelian = 0;
                $pembelian = 0;
            }
            

            $stok_awal = $barang_con->get_stok_akhir($kode_barang);
            $stok_akhir = $stok_awal-$jumlah_stok_beli;
            $harga_barang = $data['harga_barang'];

            $persediaan_awal = $harga_barang*$stok_akhir;

            $harga_jual = $this->harga_jual($persediaan_awal,$pembelian,$kode_barang, $bulan);
            
            //penjualan
            $check_penjualan_barang = $this->check_penjualan_barang($bulan, $kode_barang);
            $jumlah_jual = $check_penjualan_barang['jumlah'];
            if(empty($jumlah_jual)){
                $jumlah_jual = 0;
            }

            //persediaan akhir
            $persediaan_akhir_sisa_stok = floor($stok_akhir*$harga_jual);
            $persediaan_akhir_stok_jual = floor($jumlah_jual*$harga_jual);


            $hpp_akhir = $persediaan_awal+$pembelian-$persediaan_akhir_stok_jual;

            $laba_kotor = $persediaan_akhir_stok_jual - $hpp_akhir;


            $datas[$i]['kode'] = $kode_barang;
            $datas[$i]['nama'] = $data['nama_barang'];
            $datas[$i]['harga'] = $harga_barang;
            $datas[$i]['jumlah_stok_beli'] = $jumlah_stok_beli;
            $datas[$i]['stok_awal'] = $stok_akhir;
            $datas[$i]['persediaan_awal'] = $persediaan_awal;
            $datas[$i]['pembelian'] = $pembelian;
            $datas[$i]['harga_jual'] = floor($harga_jual);
            $datas[$i]['jumlah_jual'] = $jumlah_jual;
            $datas[$i]['persediaan_akhir_sisa_stok'] = $persediaan_akhir_sisa_stok;
            $datas[$i]['persediaan_akhir_stok_jual'] = $persediaan_akhir_stok_jual;
            $datas[$i]['hpp_akhir'] = $hpp_akhir;
            $datas[$i]['laba_kotor'] = $laba_kotor;
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    public function get_harga_pokok($kode_barang, $bulan){
        $m = substr($bulan, 0,2);
        $y = substr($bulan, -4);

        $tpembelian = array(
            'pembelian PE',
            'detil_pembelian DP'
        );
        $fpembelian = "DP.harga_beli/DP.jumlah_persatuan";
        $wpembelian = "month(PE.tanggal_pembelian)='$m' AND year(PE.tanggal_pembelian)='$y' AND DP.kode_barang='$kode_barang'";
        $orderby = "tanggal_pembelian DESC";
        $limit = "0,1";

        foreach(parent::select($tpembelian, $fpembelian, $wpembelian, '', $order, $limit) as $data):
        endforeach;

        $harga_pokok = $data['harga_beli'];

        if($harga_pokok==""){
            $tbarang = "barang";
            $fbarang = "harga_barang";
            $wbarang = "kode_barang='$kode_barang'";

            foreach(parent::select($tbarang, $fbarang, $wbarang) as $dbarang):
            endforeach;

            $harga_pokok = $dbarang['harga_barang'];
        }

        return $harga_pokok;
    }
    

    public function lap_laba_rugi($bulan){
        $barang_con = new BarangController();
        $tbarang = "barang";
        $fbarang = "*";
        
        $i=0;
        foreach(parent::select($tbarang, $fbarang) as $data):
            $kode_barang = $data['kode_barang'];
            $check_pembelian_barang = $this->check_pembelian_barang($bulan, $kode_barang);

            $jumlah_stok_beli = $check_pembelian_barang['jumlah'];
            if(empty($jumlah_stok_beli)){
                $jumlah_stok_beli = 0;
            }

            if($jumlah_stok_beli!=0){
                $harga_pembelian = $check_pembelian_barang['harga']/$jumlah_stok_beli;
                $pembelian = $harga_pembelian*$jumlah_stok_beli;
            }else{
                $harga_pembelian = 0;
                $pembelian = 0;
            }
            

            $stok_awal = $barang_con->get_stok_akhir($kode_barang);
            $stok_akhir = $stok_awal-$jumlah_stok_beli;
            $harga_barang = $data['harga_barang'];

            $persediaan_awal = $harga_barang*$stok_akhir;

            $harga_jual = $this->harga_jual($persediaan_awal,$pembelian,$kode_barang, $bulan);
            
            //penjualan
            $check_penjualan_barang = $this->check_penjualan_barang($bulan, $kode_barang);
            $jumlah_jual = $check_penjualan_barang['jumlah'];
            if(empty($jumlah_jual)){
                $jumlah_jual = 0;
            }

            //persediaan akhir
            $persediaan_akhir_sisa_stok = floor($stok_akhir*$harga_jual);
            $persediaan_akhir_stok_jual = floor($jumlah_jual*$harga_jual);


            $hpp_akhir = $persediaan_awal+$pembelian-$persediaan_akhir_stok_jual;

            $laba_kotor = $persediaan_akhir_stok_jual - $hpp_akhir;


            $datas[$i]['kode'] = $kode_barang;
            $datas[$i]['nama'] = $data['nama_barang'];
            $datas[$i]['harga'] = $harga_barang;
            $datas[$i]['jumlah_stok_beli'] = $jumlah_stok_beli;
            $datas[$i]['stok_awal'] = $stok_akhir;
            $datas[$i]['persediaan_awal'] = $persediaan_awal;
            $datas[$i]['pembelian'] = $pembelian;
            $datas[$i]['harga_jual'] = floor($harga_jual);
            $datas[$i]['jumlah_jual'] = $jumlah_jual;
            $datas[$i]['persediaan_akhir_sisa_stok'] = $persediaan_akhir_sisa_stok;
            $datas[$i]['persediaan_akhir_stok_jual'] = $persediaan_akhir_stok_jual;
            $datas[$i]['hpp_akhir'] = $hpp_akhir;
            $datas[$i]['laba_kotor'] = $laba_kotor;
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    protected function hpp_akhir(){

    }

    public function get_laba_barang($kode_barang, $bulan){
        $m = substr($bulan, 0,2);
        $y = substr($bulan, -4);

        $table = array(
            'pembelian P',
            'detil_pembelian DP'
        );
        $fild = 'DP.laba';
        $where = "DP.kode_barang='$kode_barang' AND P.id_pembelian=DP.id_pembelian AND month(P.tanggal_pembelian)='$m' AND year(P.tanggal_pembelian)='$y'";
        $orderby = "DP.id_pembelian DESC";
        $limit = "0,1";

        foreach(parent::select($table, $fild, $where, '', $orderby, $limit) as $data):
        endforeach;

        $laba = $data['laba'];

        if(empty($laba)){
            $laba = 25;
        }

        return $laba/100;
    }

    protected function harga_jual($persediaan_awal, $pembelian, $kode_barang, $bulan){
        $barang_con = new BarangController();
        $stok_akhir = $barang_con->get_stok_akhir($kode_barang);

        $total_per_pem = $persediaan_awal+$pembelian;
        $avg = $total_per_pem/$stok_akhir;

        $laba = $this->get_laba_barang($kode_barang, $bulan);

        $harga_jual = ($avg*$laba)+$avg;
        return $harga_jual."<br/>";
    }

    protected function check_pembelian_barang($bulan, $kode_barang){
        $m = substr($bulan, 0,2);
        $y = substr($bulan, -4);
        $table = array(
            'pembelian as P',
            'detil_pembelian as DP'
        );
        $fild = "SUM(jumlah_persatuan*jumlah_beli) as jumlah_beli_satuan, sum(harga_beli) as harga_beli";
        $where = "P.id_pembelian=DP.id_pembelian AND month(P.tanggal_pembelian)='$m' AND year(P.tanggal_pembelian)='$y' AND DP.kode_barang='$kode_barang'";

        foreach(parent::select($table, $fild, $where) as $data):
        endforeach;

        $datas['jumlah'] = $data['jumlah_beli_satuan'];
        $datas['harga'] = $data['harga_beli'];
        return $datas;
    }

    protected function check_penjualan_barang($bulan, $kode_barang){
        $m = substr($bulan, 0,2);
        $y = substr($bulan, -4);
        $table = array(
            'penjualan as P',
            'detil_penjualan as DP'
        );
        $fild = "SUM(DP.jumlah) as jumlah_jual";
        $where = "P.id_penjualan=DP.id_penjualan AND month(P.tanggal_penjualan)='$m' AND year(P.tanggal_penjualan)='$y' AND DP.kode_barang='$kode_barang'";

        foreach(parent::select($table, $fild, $where) as $data):
        endforeach;

        $datas['jumlah'] = $data['jumlah_jual'];
        return $datas;
    }

    public function pengeluaran($bulan, $tahun){
        $tpengeluaran = "pengeluaran";
        $fpengeluaran = "*";
        if($bulan!=""):
            $m = substr($bulan, 0,2);
            $y = substr($bulan, -4);

            $wpengeluaran = "month(tanggal)=$m AND year(tanggal)=$y";
        endif;

        if($tahun!=""):
            $wpengeluaran = "year(tanggal)=$tahun";
        endif;

        $i = 0;
        foreach(parent::select($tpengeluaran, $fpengeluaran, $wpengeluaran) as $dpengeluaran):
            $datas[$i]['jenis_pengeluaran'] = $dpengeluaran['jenis_pengeluaran'];
            $datas[$i]['nominal'] = $dpengeluaran['nominal'];
            $i++;
        endforeach;

        $json = json_encode($datas);
        $data = json_decode($json);

        return $data;
    }

    public function total_pengeluaran($bulan, $tahun){
        //get data penjualan
        $penjualan = "penjualan";
        $fpenjualan = "sum(total) AS total_penjualan";
        $total_penjualan = "";

        $pembelian = "pembelian";
        $fpembelian = "sum(total_pembelian) AS total_pembelian";
        $total_pembelian = "";

        $tpengeluaran = "pengeluaran";
        $fpengeluaran = "sum(nominal) AS total_keluar";
        $total_pengeluaran = "";

        if($bulan!=""):
            $m = substr($bulan, 0,2);
            $y = substr($bulan, -4);

            $wpenjualan = "month(tanggal_penjualan)=$m AND year(tanggal_penjualan)=$y";
            $wpengeluaran = "month(tanggal)=$m AND year(tanggal)=$y";
            $wpembelian = "month(tanggal_pembelian)=$m AND year(tanggal_pembelian)=$y";
        endif;

        if($tahun!=""):
            $wpenjualan = "year(tanggal_penjualan)=$tahun";
            $wpengeluaran = "year(tanggal)=$tahun";
            $wpembelian = "year(tanggal_pembelian)=$tahun";
        endif;

        foreach(parent::select($penjualan, $fpenjualan, $wpenjualan) as $dpenjualan):
        endforeach;
        $total_penjualan = $dpenjualan['total_penjualan'];

        foreach(parent::select($pembelian, $fpembelian, $wpembelian) as $dpembelian):
        endforeach;
        $total_pembelian = $dpembelian['total_pembelian'];

        foreach(parent::select($tpengeluaran, $fpengeluaran, $wpengeluaran) as $dpengeluaran):
        endforeach;
        $total_keluaran = $dpengeluaran['total_keluar'];

        $total_pengeluaran_bersih = $total_pembelian+$total_keluaran;
        $datas['total_pengeluaran'] = $total_pengeluaran_bersih;
        

        $labarugi = $total_penjualan-$total_pengeluaran_bersih;
        $tipe = "Laba";
        if($labarugi<0){
            $tipe = "Rugi";
            $labarugi = abs($labarugi);
        }
        $datas['labarugi'] = $labarugi;
        $datas['tipe'] = $tipe;

        return $datas;
    }


    public function get_kedudukan_session(){
        $kedudukan = $_SESSION['kedudukan'];

        $name_kedudukan = parent::kedudukan_session($kedudukan);
        return $name_kedudukan;
    }
}
?>