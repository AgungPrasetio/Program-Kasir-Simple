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
    require_once "__class/PenjualanController.php";
    $dbase = new db();

    $controller = new PenjualanController();

    $key = $_POST['key'];
    $tanggal = date("d M Y", strtotime($_POST['tanggal']));
    $kasir = $_POST['kasir'];
    $id_kasir = $_POST['id_kasir'];
    $saldo = $_POST['saldo'];

    if($key==1):
    
        $nama_file = "Laporan Penjualan";
        $nama_file_download = "Laporan_Penjualan.pdf";
    else:
        $judul = "Laporan Penjualan Tanggal $tanggal";

        $nama_file = "Laporan Penjualan ";
        $nama_file_download = "Laporan_Pembelian.pdf";
    endif;
    
    
    
    // $stylesheet = file_get_contents('http://localhost/santijaya/pdf.css');

    $html = '
        <h2>TOSERBA SANTI JAYA</h2>
        <p>Jalan Raya Sukodono RT 1 RW 1</p>
        <p>Nomor Telpon: +6231 8830792</p>

        <h3 class="center">'.$judul.'</h3>
    ';

    if($key==1):

    else:
    
        $html .= '
            <h4 style="margin:0px; padding:0px;">Nama Kasir: '.$kasir.'</h4>
            <h4 style="margin:0px; padding:0px;">Saldo Awal: '.$saldo.'</h4>
        ';
        $datapenjualankasir = $controller->data_penjualan_kasir($tanggal, $id_kasir);
        foreach($datapenjualankasir as $dj):
            $id_penjualan = $dj->id_penjualan;
            $html .= '
            <h5 style="margin:0px; padding:0px;">ID Penjualan: '.$id_penjualan.'</h5>
            <table width="100%" cellpadding="2" cellspacing="2">
                <thead>
                    <tr>
                        <td width="10px">No</td>
                        <td>Kode Barang</td>
                        <td>Nama Barang</td>
                        <td>Jumlah</td>
                        <td>Harga</td>
                        <td>Sub Total</td>
                    </tr>
                </thead>
                <tbody>
            ';
                    $detilpenjualan = $controller->getDetilPenjualan($id_penjualan);
                    $total = 0;
                    foreach($detilpenjualan as $DP):
                        $html .='
                        <tr>
                            <td>'.$DP->no.'</td>
                            <td>'.$DP->kode_barang.'</td>
                            <td>'.$DP->nama_barang.'</td>
                            <td>'.$DP->jumlah.'</td>
                            <td>Rp '.number_format($DP->harga).'</td>
                            <td>Rp '.number_format($DP->subtotal).'</td>
                        </tr>
                        ';
                        
                        $total+=$DP->subtotal;
                    endforeach;
            $html .='

                </tbody>
                <tfooter>
                    <tr>
                        <td colspan="5" align="right">Total</td>
                        <td>Rp '.number_format($total).'</td>
                    </tr>
                </tfooter>
            </table>
            ';

        endforeach;

        $html .='
            <h4>Rekap Penjualan</h4>
            <table class="table table-bordered table-striped" width="100%">
                <thead>
                    <tr>
                        <td width="10px">No</td>
                        <td>ID Penjualan</td>
                        <td>Total Penjualan</td>
                    </tr>
                </thead>
                <tbody>
        ';
                $total_rekap = 0;
                foreach($datapenjualankasir as $dj):
                    $total_rekap+=$dj->total;
                    $html .='
                        <tr>
                            <td>'.$dj->no.'</td>
                            <td>'.$dj->id_penjualan.'</td>
                            <td>Rp '.number_format($dj->total,0).'</td>
                        </tr>
                    ';
                endforeach;
        $html .= '
                </tbody>
                <tfooter>
                    <tr>
                        <td colspan="2" style="text-align:right;">Total</td>
                        <td>Rp '.number_format($total_rekap).'</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:right;">Saldo Awal</td>
                        <td>Rp '.number_format($saldo).'</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:right;">Total Penjualan Tanggal '.$tanggal.'</td>
                        <td>Rp '.number_format($saldo+$total_rekap).'</td>
                    </tr>
                </tfooter>
            </table>
        ';

        
    endif;

    $mpdf = new mPDF('utf-8', 'A4-L', 0, '',10,10,10,1,1,1,'');
    $mpdf->SetTitle($nama_file);
    $mpdf->WriteHTML($html,2);
    $mpdf->Output($nama_file_download,'I');
endif;
?>