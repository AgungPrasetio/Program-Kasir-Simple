<?php
require_once "../db.php";
$dbase = new db();
$table = "jenis_barang";

if(!isset($_GET['delete'])):
    $fildnamajenis = "nama_jenis_barang";
    $fildidjenis = "id_jenis_barang";
    $id_jenis_barang = $_POST['id_jenis_barang'];
    $nama_jenis_barang = ucwords($_POST['nama_jenis_barang']);
    $kategori = $_POST['kategori'];

    //count
    $countnamajenis = 0;
    $countidjenis = 0;
    $countnamajenis = $dbase->getCount($table, $fildnamajenis, $nama_jenis_barang);
    $countidjenis = $dbase->getCount($table, $fildidjenis, $id_jenis_barang);

    if(isset($_GET['edit'])):
        $id = $_POST['key'];
        $nama_jenis_barang_lama = ucwords($_POST['nama_jenis_barang_lama']);

        if($nama_jenis_barang_lama==$nama_jenis_barang):
            $countnamajenis = 0;
        elseif($id==$id_jenis_barang):
            $countidjenis = 0;
        endif;
    endif;

    $nilai = array(
        'id_jenis_barang' => $id_jenis_barang,
        'nama_jenis_barang' => $nama_jenis_barang,
        'id_kategori' => $kategori
    );
endif;

if(!isset($_GET['add'])):
    $id = $_POST['key'];
    $where = "id_jenis_barang='$id'";
endif;


if(isset($_GET['add'])):
    try{
        if($countnamajenis>0):
            echo "availablenama";
        elseif($countidjenis>0):
            echo "availableid";
        else:
            $dbase->add($table,$nilai);
            echo "ok";
        endif;
    }catch(PDOException $e){
        echo $e->getMessage();
    }
elseif(isset($_GET['edit'])):
    try{
        if($countnamajenis>0):
            echo "availablenama";
        elseif($countidjenis>0):
            echo "availableid";
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