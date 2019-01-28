<?php
require_once "../db.php";
$dbase = new db();
$table = "user";

if(!isset($_GET['delete'])):
    $fild = "username";
    $nama_lengkap = ucwords($_POST['nama_lengkap']);
    $username = $_POST['username'];
    $kedudukan = $_POST['kedudukan'];
    $status = $_POST['status'];

    $count = $dbase->getCount($table, $fild, $username);

    if(isset($_GET['edit'])):
        $username_lama = $_POST['username_lama'];

        if($username_lama==$username):
            $count = 0;
        endif;
    endif;

    if(isset($_GET['add'])):
        $password = md5($_POST['password']);
        $nilai = array(
            'nama_lengkap' => $nama_lengkap,
            'username' => $username,
            'password' => $password,
            'id_kedudukan' => $kedudukan,
            'status' => $status
        );
    else:
        $nilai = array(
            'nama_lengkap' => $nama_lengkap,
            'username' => $username,
            'id_kedudukan' => $kedudukan,
            'status' => $status
        );
    endif;
    
endif;

if(!isset($_GET['add'])):
    $id = $_POST['key'];
    $where = "id_user='$id'";
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