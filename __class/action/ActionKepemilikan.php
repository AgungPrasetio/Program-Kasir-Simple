<?php
require_once "../db.php";
$dbase = new db();
$table = "kepemilikan_barang";

if(!isset($_GET['delete'])):
    $fild = "nama_pemilik";
    $nama_pemilik = ucwords($_POST['nama_pemilik']);

    //count
    $count = $dbase->getCount($table, $fild, $nama_pemilik);

    if(isset($_GET['edit'])):
        $nama_pemilik_lama = ucwords($_POST['nama_pemilik_lama']);

        if($nama_pemilik_lama==$nama_pemilik):
            $count = 0;
        endif;
    endif;


    $nilai = array(
        'nama_pemilik' => $nama_pemilik
    );
endif;

if(!isset($_GET['add'])):
    $id = $_POST['key'];
    $where = "id_kepemilikan='$id'";
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