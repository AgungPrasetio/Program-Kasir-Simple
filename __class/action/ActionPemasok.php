<?php
require_once "../db.php";
$dbase = new db();
$table = "pemasok";

if(!isset($_GET['delete'])):
    $nama = ucwords($_POST['nama_pemasok']);
    $alamat = $_POST['alamat_pemasok'];
    $telpon = $_POST['telpon_pemasok'];


    $nilai = array(
        'nama_pemasok' => $nama,
        'alamat_pemasok' => $alamat,
        'telpon_pemasok' => $telpon,
    );
endif;

if(!isset($_GET['add'])):
    $id = $_POST['key'];
    $where = "id_pemasok='$id'";
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