<?php
error_reporting(0);
session_start();
date_default_timezone_set('Asia/Jakarta');
$now = date("Y-m-d g:i:s");

$user = $_SESSION['id_user'];
require_once "../db.php";
require_once "../PembelianController.php";
require_once "../BarangController.php";
$controller = new PembelianController();
$barangcon = new BarangController();
$dbase = new db();

if(isset($_GET['addSession'])):
    try{
        $barang = $_POST['barang'];
        $msg = 0;

        if(isset($_SESSION['nilaipembelian'])){
            for($j=0; $j<=$_SESSION['nilaipembelian']; $j++):
                if(@$_SESSION['isipembelian'][$j][0]!=''):
                    if($barang==$_SESSION['isipembelian'][$j][0]):
                        $msg = 1;
                    else:
                        $msg = 0;
                    endif;
                endif;
            endfor;
        }

        if($msg==0):
            if(empty($_SESSION['nilaipembelian'])==true):
                $_SESSION['nilaipembelian']=1;
            else:
                $_SESSION['nilaipembelian']++;
            endif;

            @$satuan = $_POST['satuan'];
            @$jumlahisi = $_POST['jumlah_isi'];
            @$barang = $_POST['barang'];
            @$hargabarang = $_POST['nominalharga'];
            $getDataBarang = $barangcon->getDataByID($barang);
            foreach($getDataBarang as $G):
                @$nama_barang = $G->nama_barang;
            endforeach;

            $qty = 1;
            @$laba = $_POST['laba'];
            $_SESSION['totbayarpembelian']+=@$hargabarang;
            $_SESSION['isipembelian'][$_SESSION['nilaipembelian']]=array($barang,$nama_barang,$hargabarang,$qty,$satuan,$jumlahisi, $laba);
            echo "ok";
        else:
            echo "available";
        endif;

        // echo $kode;
    }catch(PDOException $e){
        echo $e->getMessage();
    }

elseif(isset($_GET['delSession'])):
    $baris = $_POST['l'];
    $harga = $_POST['hargal'];
    $qty = $_SESSION['isipembelian'][$baris][3];
    $totskrg = $_SESSION['totbayarpembelian'];
    $updatetot = $totskrg-($qty*$harga);
    $_SESSION['totbayarpembelian'] = $updatetot;
    unset($_SESSION['isipembelian'][$baris]);

elseif(isset($_GET['updateQty'])):
    $k = explode(",",$_POST['k']);
    $qty = explode(",",$_POST['qty']);
    $total = $_POST['total'];

    $_SESSION['totbayarpembelian'] = $total;

    for($i=0;$i<count($qty);$i++):
        $_SESSION['isipembelian'][$k[$i]][3]=$qty[$i];
    endfor;

    echo "ok";

elseif(isset($_GET['changePemasok'])):
    $pemasok = $_POST['pemasok'];

    $_SESSION['id_pemasok'] = $pemasok;

elseif(isset($_GET['simpanTransaksi'])):
    try{
        $id_pembelian = $controller->SetIdPembelian();
        $pemasok = $_POST['pemasok'];
        $totbayar = $_POST['totbayar'];

        $table = "pembelian";
        $tdetil = "detil_pembelian";

        $pembelian = array(
            'id_pembelian' => $id_pembelian,
            'id_pemasok' => $pemasok,
            'id_user' => $user,
            'tanggal_pembelian' => $now,
            'total_pembelian' => $totbayar,
        );

        $dbase->add($table,$pembelian);

        for($j=0; $j<=$_SESSION['nilaipembelian']; $j++):
            if(@$_SESSION['isipembelian'][$j][0]!=''):
                $detilpembelian = array(
                    'id_pembelian' => $id_pembelian,
                    'kode_barang' => @$_SESSION['isipembelian'][$j][0],
                    'harga_beli' => @$_SESSION['isipembelian'][$j][2],
                    'jumlah_beli' => @$_SESSION['isipembelian'][$j][3],
                    'id_satuan_barang' => @$_SESSION['isipembelian'][$j][4],
                    'jumlah_persatuan' => @$_SESSION['isipembelian'][$j][5],
                    'laba' => @$_SESSION['isipembelian'][$j][6],
                );
                $dbase->add($tdetil,$detilpembelian);
            endif;
        endfor;
        
        //unset session
        unset($_SESSION['isipembelian']);
        unset($_SESSION['id_pemasok']);
        unset($_SESSION['totbayarpembelian']);
        unset($_SESSION['nilaipembelian']);
        
        echo "ok";
        
    }catch(PDOException $e){
        echo $e->getMessage();
    }
endif;
?>