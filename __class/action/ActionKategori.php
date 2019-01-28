<?php
require_once "../db.php";
$dbase = new db();
$table = "kategori";

if(!isset($_GET['delete'])):
    $fild = "nama_kategori";
    $nama_kategori = ucwords($_POST['nama_kategori']);


    //count
    $count = $dbase->getCount($table, $fild, $nama_kategori);

    if(isset($_GET['edit'])):
        $nama_kategori_lama = ucwords($_POST['nama_kategori_lama']);

        if($nama_kategori_lama==$nama_kategori):
            $count = 0;
        endif;
    endif;


    $nilai = array(
        'nama_kategori' => $nama_kategori
    );
endif;

if(!isset($_GET['add'])):
    $id = $_POST['key'];
    $where = "id_kategori='$id'";
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