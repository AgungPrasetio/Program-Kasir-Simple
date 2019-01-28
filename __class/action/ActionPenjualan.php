<?php
error_reporting(0);
session_start();
date_default_timezone_set('Asia/Jakarta');
$now = date("Y-m-d g:i:s");

$user = $_SESSION['id_user'];
require_once "../db.php";
require_once "../PenjualanController.php";
require_once "../BarangController.php";
$controller = new PenjualanController();
$barangcon = new BarangController();
$dbase = new db();

if(isset($_GET['addSession'])):
    try{
        $kode = $_POST['kode_barang'];
        $nama_barang = $_POST['nama_barang'];

        if(!empty($nama_barang)){
            $kode = $nama_barang;
        }
        //check apakah kode barang yang discan ada pada database
        $fcheck = "kode_barang";
        $tcheck = "barang";
        $checkdata = $dbase->getCount($tcheck, $fcheck, $kode);

        if($checkdata==0):
            echo "notavailable";
        else:
            $msg = 0;

            if(isset($_SESSION['nilai'])){
                for($j=0; $j<=$_SESSION['nilai']; $j++):
                    if(@$_SESSION['isi'][$j][0]!=''):
                        if($kode==$_SESSION['isi'][$j][0]):
                            $msg = 1;
                        endif;
                    endif;
                endfor;
            }

            if($msg==0):
                if(empty($_SESSION['nilai'])==true):
                    $_SESSION['nilai']=1;
                else:
                    $_SESSION['nilai']++;
                endif;

                @$kodebarang = $_POST['kode_barang'];
                $nama_barang = $_POST['nama_barang'];
                if(!empty($nama_barang)){
                    @$kodebarang = $nama_barang;
                }
                $getDataBarang = $barangcon->getDataByID($kodebarang);
                foreach($getDataBarang as $G):
                    @$nama_barang = $G->nama_barang;
                    // @$harga_barang = $G->harga_barang;
                endforeach;
                @$harga_barang = $barangcon->set_harga_jual($kodebarang);

                $qty = 1;
                $potongan = 0;
                $_SESSION['totbayar']+=@$harga_barang;
                $_SESSION['isi'][$_SESSION['nilai']]=array($kodebarang,$nama_barang,$harga_barang,$qty,$potongan);
                echo "ok";
            else:
                echo "available";
            endif;
        endif;

        // echo $kode;
    }catch(PDOException $e){
        echo $e->getMessage();
    }

elseif(isset($_GET['delSession'])):
    $baris = $_POST['l'];
    $harga = $_POST['hargal'];
    $qty = $_SESSION['isi'][$baris][3];
    $totskrg = $_SESSION['totbayar'];
    $updatetot = $totskrg-($qty*$harga);
    $_SESSION['totbayar'] = $updatetot;
    unset($_SESSION['isi'][$baris]);

elseif(isset($_GET['updateQty'])):
    $k = explode(",",$_POST['k']);
    $qty = explode(",",$_POST['qty']);
    $total = $_POST['total'];

    $_SESSION['totbayar'] = $total;

    for($i=0;$i<count($qty);$i++):
        $_SESSION['isi'][$k[$i]][3]=$qty[$i];
    endfor;

    echo "ok";

elseif(isset($_GET['updatePotongan'])):
    $k = explode(",",$_POST['k']);
    $potongan = explode(",",$_POST['potongan']);
    $total = $_POST['total'];

    $_SESSION['totbayar'] = $total;

    for($i=0;$i<count($potongan);$i++):
        $_SESSION['isi'][$k[$i]][4]=$potongan[$i];
    endfor;

    echo "ok";

elseif(isset($_GET['changePelanggan'])):
    $pelanggan = $_POST['pelanggan'];

    $_SESSION['id_pelanggan'] = $pelanggan;

elseif(isset($_GET['simpanTransaksi'])):
    try{
        $id_penjualan = $controller->SetIdPenjualan();
        $pelanggan = $_POST['pelanggan'];
        $totbayar = $_POST['total_after_diskon'];
        $nominalbayar = $_POST['nominalbayar'];
        $diskon = $_POST['diskon'];


        if($nominalbayar>=$totbayar):
            $table = "penjualan";
            $tdetil = "detil_penjualan";

            $penjualan = array(
                'id_penjualan' => $id_penjualan,
                'id_pelanggan' => $pelanggan,
                'id_user' => $user,
                'tanggal_penjualan' => $now,
                'total' => $totbayar,
                'bayar' => $nominalbayar,
                'diskon' => $diskon
            );

            $dbase->add($table,$penjualan);

            for($j=0; $j<=$_SESSION['nilai']; $j++):
                if(@$_SESSION['isi'][$j][0]!=''):
                    $detilpenjualan = array(
                        'id_penjualan' => $id_penjualan,
                        'kode_barang' => @$_SESSION['isi'][$j][0],
                        'harga' => @$_SESSION['isi'][$j][2],
                        'jumlah' => @$_SESSION['isi'][$j][3],
                        'potongan_per_barang' => @$_SESSION['isi'][$j][4],
                    );
                    $dbase->add($tdetil,$detilpenjualan);
                endif;
            endfor;
            
            //unset session
            unset($_SESSION['isi']);
            unset($_SESSION['id_pelanggan']);
            unset($_SESSION['totbayar']);
            unset($_SESSION['nilai']);
            
            $return['status'] = "ok";
            $return['id_penjualan'] = $id_penjualan;
        else:
            $return['status'] = "notok";
        endif;

        echo json_encode($return);
        
    }catch(PDOException $e){
        echo $e->getMessage();
    }
elseif(isset($_GET['addSaldoAwal'])):
    try{
        $saldo = $_POST['saldo_awal'];
        $today = date("Y-m-d");
        $tsaldo = "saldo_awal";
        $fsaldo = array(
            'tanggal' => $today,
            'saldo_awal_nominal' => $saldo,
            'id_user' => $_SESSION['id_user']
        );

        $dbase->add($tsaldo,$fsaldo);
        echo "ok";
    }catch(PDOException $e){
        echo $e->getMessage();
    }
    
endif;
?>