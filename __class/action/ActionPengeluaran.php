<?php
// session_start();

require_once "../db.php";
require_once "../PengeluaranController.php";
$controller = new PengeluaranController();
$user = $_SESSION['id_user'];

$dbase = new db();
$table = "pengeluaran";

if(!isset($_GET['delete'])):
    $jenis_pengeluaran = ucwords($_POST['jenis_pengeluaran']);
    $keterangan = $_POST['keterangan'];
    $tanggal = date("Y-m-d", strtotime($_POST['tanggal']));
    $nominal = $_POST['nominal'];

    if(isset($_GET['edit'])):
        $nama_barang_lama = ucwords($_POST['nama_barang_lama']);

        if($nama_barang_lama==$nama_barang):
            $count = 0;
        endif;
    endif;

    if(isset($_GET['edit'])):
        $nilai = array(
            'jenis_pengeluaran' => $jenis_pengeluaran,
            'keterangan' => $keterangan,
            'tanggal' => $tanggal,
            'id_user' => $user,
            'nominal' => $nominal,
        );
    else:
        $nilai = array(
            'jenis_pengeluaran' => $jenis_pengeluaran,
            'keterangan' => $keterangan,
            'tanggal' => $tanggal,
            'id_user' => $user,
            'nominal' => $nominal,
        );
    endif;
endif;

if(!isset($_GET['add'])):
    $id = $_POST['key'];
    $where = "id_pengeluaran='$id'";
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
        if($count>0):
            echo "available";
        else:
            $dbase->update($table,$nilai,$where);
            echo "ok";
        endif;
    }catch(PDOException $e){
        echo $e->getMessage();
    }
// elseif(isset($_GET['delete'])):
//     try{
//         $dbase->delete($table,$where);
//         echo "ok";
//     }catch(PDOException $e){
//         echo $e->getMessage();
//     }
endif;
?>