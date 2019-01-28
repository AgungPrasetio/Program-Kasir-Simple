<?php
error_reporting(0);
session_start();
require_once 'db.php';
$dbase = new db();

if(isset($_POST['login'])):
    $FUSER = trim($_POST['username']);
    $user_password = trim($_POST['password']);

    $FPASS = md5($user_password);

    try
    {
        $table = "user";
        $fild = "*";
        $where = "username='$FUSER'";

        foreach($dbase->select($table, $fild, $where) as $data):
        endforeach;
        $TPASS = $data['password'];
        
        if($TPASS==$FPASS):
            if($data['status']=="T"):
                echo "Username di block, silahkan hubungi administrator.";
            else:
                $_SESSION['id_user'] = $data['id_user'];
                $_SESSION['nama'] = $data['nama_lengkap'];
                $_SESSION['login'] = true;
                $_SESSION['username'] = $data['username'];
                $_SESSION['kedudukan'] = $data['id_kedudukan'];
                echo "ok"; // log in
            endif;
        else:
            echo "Username atau Kata Sandi Tidak Terdaftar."; // wrong details
        endif;

    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
endif;
?>
