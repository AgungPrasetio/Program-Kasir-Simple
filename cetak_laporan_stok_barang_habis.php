<?php
session_start();
if(!isset($_SESSION['login'])):
    header("Location: index.php");
endif;

if(!isset($_POST['cetak'])):
    echo "<script>document.location.href='main.php'</script>";
else:
    require_once("__class/mpdf60/mpdf.php");

    require_once "__class/db.php";
    require_once "__class/BarangController.php";
    $controller = new BarangController();

    $kepemilikan = $_POST['kepemilikan'];
    if(empty($kepemilikan)){
        $kepemilikan = "all";
    }
    $wherekepemilikan = "";
    $sub_title = "Kepemilikan Barang : Semua";
    if($kepemilikan!="all"){
        $wherekepemilikan = " AND B.id_kepemilikan='$kepemilikan'";
        $nama_pemilik = $controller->get_kepemilikan_barang($kepemilikan);
        $sub_title = "Kepemilikan Barang : $nama_pemilik";
    }

    $nama_file = "Laporan Stok Barang Habis";
    $nama_file_download = "Laporan_Stok_Barang_Habis.pdf";
    $judul = "Laporan Stok Barang Habis";

    $html = '
        <h2>TOSERBA SANTI JAYA</h2>
        <p>Jalan Kalijaten RT 15 RW 03 No. 31 Taman Sidoarjo</p>
        <p>Nomor Telpon: +62 361 7676767</p>
        <h3 class="center" style="margin:15px 0 0 0;">'.$judul.'</h3>
        <h4 class="center" style="margin:0 0 15px 0">'.$sub_title.'</h4>
    ';

    $html .= '
        <table width="100%" cellpadding="2" cellspacing="2">
            <tr>
                <td width="10px">No</td>
                <td>Kode Barang</td>
                <td>Nama Barang</td>
                <td>Kepemilikan Barang</td>
                <td>Stok Minimum</td>
                <td>Stok Saat Ini</td>
            </tr>
    ';
        $data = $controller->data_stok_barang_habis('','',$kepemilikan);
        $i=1;
        foreach($data as $D):
            $id = $D->kode_barang;
            $stok_now = $controller->get_stok_akhir($id);
            $stok_minimum = $D->limit_stok;

            if($stok_now < $stok_minimum):
                //count relation of $kategori
                $count = $controller->count($id);
                //harga barang sesuai hpp
                $harga = $controller->set_harga_jual($id);
                if(is_nan($harga)):
                    $harga = $D->harga_barang;
                endif;

                $html .= '
                <tr>
                    <td>'.$i++.'</td>
                    <td>'.$id.'</td>
                    <td>'.$D->nama_barang.'</td>
                    <td>'.$D->kepemilikan.'</td>
                    <td>'.$D->limit_stok.'</td>
                    <td>'.$stok_now.'</td>
                </tr>
                ';
            endif;
        endforeach;
    $html .= '
        </table>
    ';

    $mpdf = new mPDF('utf-8', 'A4-P', 0, '',10,10,10,1,1,1,'');
    $mpdf->SetTitle($nama_file);
    $mpdf->WriteHTML($html,2);
    $mpdf->Output($nama_file_download,'I');
endif;
?>