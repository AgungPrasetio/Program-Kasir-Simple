<?php
session_start();
$user = $_SESSION['id_user'];
require_once "../db.php";
require_once "../BarangController.php";
$controller = new BarangController();

$dbase = new db();
$table = "barang";

if(!isset($_GET['delete'])):
    $fild = "nama_barang";
    $kode = $_POST['kode_barang'];
    $nama_barang = ucwords($_POST['nama_barang']);
    $jenis_barang = $_POST['jenis_barang'];
    $merek = $_POST['merek'];
    $stok_barang = $_POST['stok_barang'];
    $limit_stok = $_POST['limit_stok'];
    $harga_barang = $_POST['harga_barang'];
    $kode_barang = $controller->SetKodeBarang($jenis_barang);
    $status_barcode_awal = $_POST['status_barcode_awal'];
    $kepemilikan = $_POST['kepemilikan'];

    //count
    $count = $dbase->getCount($table, $fild, $nama_barang);

    if(isset($_GET['edit'])):
        $nama_barang_lama = ucwords($_POST['nama_barang_lama']);

        if($nama_barang_lama==$nama_barang):
            $count = 0;
        endif;
    endif;

    if(isset($_GET['edit'])):
        $nilai = array(
            'nama_barang' => $nama_barang,
            'id_jenis_barang' => $jenis_barang,
            'id_merek' => $merek,
            'id_kepemilikan' => $kepemilikan,
            'id_user' => $user,
            'stok_barang' => $stok_barang,
            'limit_stok' => $limit_stok,
            'harga_barang' => $harga_barang
        );
    else:
        if($kode==""){
            $kode_barang = $kode_barang;
        }else{
            $kode_barang = $kode;
        }
        $nilai = array(
            'kode_barang' => $kode_barang,
            'nama_barang' => $nama_barang,
            'id_jenis_barang' => $jenis_barang,
            'id_merek' => $merek,
            'id_kepemilikan' => $kepemilikan,
            'id_user' => $user,
            'stok_barang' => $stok_barang,
            'limit_stok' => $limit_stok,
            'harga_barang' => $harga_barang,
            'status_barcode_awal' => $status_barcode_awal
        );
    endif;
endif;

if(!isset($_GET['add'])):
    $id = $_POST['key'];
    $where = "kode_barang='$id'";
endif;


if(isset($_GET['add'])):
    try{
        if($count>0):
            echo "available";
        else:
            $dbase->add($table,$nilai);
            echo "ok";
        endif;
    }catch(PDOException $e){
        echo $e->getMessage();
    }
elseif(isset($_GET['edit'])):
    try{
        if($count>0):
            echo "available";
        else:
            $dbase->update($table,$nilai,$where);
            echo "ok";
        endif;
    }catch(PDOException $e){
        echo $e->getMessage();
    }
elseif(isset($_GET['delete'])):
    try{
        $dbase->delete($table,$where);
        echo "ok";
    }catch(PDOException $e){
        echo $e->getMessage();
    }
endif;
?>