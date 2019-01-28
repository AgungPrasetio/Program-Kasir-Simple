<?php
require_once "../db.php";
$dbase = new db();
$table = "satuan_barang";

if(!isset($_GET['delete'])):
    $fild = "nama_satuan_barang";
    $nama_satuan_barang = ucwords($_POST['nama_satuan_barang']);


    //count
    $count = $dbase->getCount($table, $fild, $nama_satuan_barang);

    if(isset($_GET['edit'])):
        $nama_satuan_barang_lama = ucwords($_POST['nama_satuan_barang_lama']);

        if($nama_satuan_barang_lama==$nama_satuan_barang):
            $count = 0;
        endif;
    endif;


    $nilai = array(
        'nama_satuan_barang' => $nama_satuan_barang
    );
endif;

if(!isset($_GET['add'])):
    $id = $_POST['key'];
    $where = "id_satuan_barang='$id'";
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