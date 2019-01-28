<?php
require_once "../db.php";
$dbase = new db();
$table = "merek";

if(!isset($_GET['delete'])):
    $fild = "nama_merek";
    $nama_merek = ucwords($_POST['nama_merek']);


    //count
    $count = $dbase->getCount($table, $fild, $nama_merek);

    if(isset($_GET['edit'])):
        $nama_merek_lama = ucwords($_POST['nama_merek_lama']);

        if($nama_merek_lama==$nama_merek):
            $count = 0;
        endif;
    endif;


    $nilai = array(
        'nama_merek' => $nama_merek
    );
endif;

if(!isset($_GET['add'])):
    $id = $_POST['key'];
    $where = "id_merek='$id'";
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