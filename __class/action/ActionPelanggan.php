<?php
require_once "../db.php";
$dbase = new db();
$table = "pelanggan";

if(!isset($_GET['delete'])):
    $nama_pelanggan = ucwords($_POST['nama_pelanggan']);
    $alamat_pelanggan = $_POST['alamat_pelanggan'];
    $telpon_pelanggan = $_POST['telpon_pelanggan'];
    $jenis_kelamin = $_POST['jenis_kelamin'];


    $nilai = array(
        'nama_pelanggan' => $nama_pelanggan,
        'alamat_pelanggan' => $alamat_pelanggan,
        'telpon_pelanggan' => $telpon_pelanggan,
        'jenis_kelamin' => $jenis_kelamin
    );
endif;

if(!isset($_GET['add'])):
    $id = $_POST['key'];
    $where = "id_pelanggan='$id'";
endif;


if(isset($_GET['add'])):
    try{
        $dbase->add($table,$nilai);
        echo "ok";
    }catch(PDOException $e){
        echo $e->getMessage();
    }
elseif(isset($_GET['edit'])):
    try{
        $dbase->update($table,$nilai,$where);
        echo "ok";
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