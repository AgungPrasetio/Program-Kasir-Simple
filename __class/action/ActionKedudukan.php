<?php
require_once "../db.php";
$dbase = new db();
$table = "kedudukan";

if(!isset($_GET['delete'])):
    $fild = "nama_kedudukan";
    $nama_kedudukan = ucwords($_POST['nama_kedudukan']);


    //count
    $count = $dbase->getCount($table, $fild, $nama_kedudukan);

    if(isset($_GET['edit'])):
        $nama_kedudukan_lama = ucwords($_POST['nama_kedudukan_lama']);

        if($nama_kedudukan_lama==$nama_kedudukan):
            $count = 0;
        endif;
    endif;


    $nilai = array(
        'nama_kedudukan' => $nama_kedudukan
    );
endif;

if(!isset($_GET['add'])):
    $id = $_POST['key'];
    $where = "id_kedudukan='$id'";
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