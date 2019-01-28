<?php
session_start();
if(!isset($_SESSION['login'])):
    header("Location: index.php");
endif;

    require_once("__class/mpdf60/mpdf.php");

    require_once "__class/db.php";
    require_once "__class/BarangController.php";
    $dbase = new db();
    $barangcon = new BarangController();

    $id_penjualan = $_GET['id_penjualan'];

    $nama_file = "Struk Penjualan - $id_penjualan";
    $nama_file_download = "Struk_Penjualan_$id_penjualan.pdf";

    $judul = "Nota Penjualan - $id_penjualan";
    
    
    
    // $stylesheet = file_get_contents('http://localhost/santijaya/pdf.css');

    $table = "penjualan";
    $fild = array(
        'tanggal_penjualan',
        'bayar',
        'diskon',
    );
    $where = "id_penjualan='$id_penjualan'";
    foreach($dbase->select($table, $fild, $where) as $data):
    endforeach;
    
    $tanggal_penjualan = date("d F Y H:i:s", strtotime($data['tanggal_penjualan']));
    $bayar = $data['bayar'];

    $html = '
        <h3 style="margin:0px;padding:0px; font-size:13px;">TOSERBA SANTI JAYA</h3>
        <p style="font-size:10px;">Jalan Kalijaten RT 15 RW 03 No. 31 Taman Sidoarjo</p>
        <p style="font-size:10px;">Nomor Telpon: +62 361 7676767</p>
        <hr style="margin:5px 0 0 0;padding:0px;">

        <h4 style="margin:10px 0 0 0; padding:0px; font-size:11px;" class="center">'.$judul.'</h4>
        <h5 style="margin:0px 0 10px 0; padding:0px; font-size:10px" class="center">Tanggal: '.$tanggal_penjualan.'</h5>

        <table width="100%" style="font-size:10px;">
            <tr>
                <td>No</td>
                <td>Barang</td>
                <td>Jumlah</td>
                <td>Harga</td>
                <td>Sub Total</td>
            </tr>
    ';
            $tdetil = array(
                'detil_penjualan D',
                'barang B'
            );
            $fdetil = "*";
            $wdetil = "D.id_penjualan='$id_penjualan' AND B.kode_barang=D.kode_barang";
            $no = 1;
            $total = 0;
            foreach($dbase->select($tdetil,$fdetil,$wdetil) as $ddetil):
                $kode_barang = $ddetil['kode_barang'];
                $nama_barang = $ddetil['nama_barang'];
                $jumlah = $ddetil['jumlah'];
                $harga = $barangcon->set_harga_jual($kode_barang);
                $subtotal = $jumlah*$harga;
                $total+=$subtotal;
                $html .='
                <tr>
                    <td>'.$no++.'</td>
                    <td>'.$nama_barang.'</td>
                    <td>'.$jumlah.'</td>
                    <td>Rp '.number_format($harga).'</td>
                    <td>Rp '.number_format($subtotal).'</td>
                </tr>
                ';
            endforeach;
    $html .='
            <tr>
                <td colspan="4" style="text-align:right;">Total</td>
                <td>Rp '.number_format($total).'</td>
            </tr>
    ';
            
    $diskon = $data['diskon'];
    if(!empty($diskon)):
        $total = $total-($total*($diskon/100));
        $html .= '
        <tr>
            <td colspan="4" align="right">Diskon</td>
            <td>'.$diskon.'%</td>
        </tr>
        <tr>
            <td colspan="4" align="right">Total Setelah Diskon</td>
            <td>Rp '.number_format($total).'</td>
        </tr>
        ';
    endif;

    $html .= '
            <tr>
                <td colspan="4" style="text-align:right;">Bayar</td>
                <td>Rp '.number_format($bayar).'</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:right;">Kembalian</td>
                <td>Rp '.number_format($bayar-$total).'</td>
            </tr>
        </table>  
    ';


    $mpdf = new mPDF('utf-8', 'A7', 0, '',2,2,2,1,1,1,'');
    $mpdf->SetTitle($nama_file);
    $mpdf->WriteHTML($html,2);
    $mpdf->Output($nama_file_download,'I');
?>