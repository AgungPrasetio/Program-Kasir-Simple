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
    require_once "__class/system/event-date.php";
    require_once "__class/LabaRugiController.php";
    $dbase = new db();
    $controller = new LabaRugiController();

    $key = $_POST['key'];
    $bulan = $_POST['bulan'];
    $m = getBulan(substr($bulan,1,2));
    $y = substr($bulan,-4);


    $judul = "Laporan Laba Kotor Per Kasir <br/> Periode $m $y <br/> General";
    $nama_file = "Laporan Laba Kotor";
    $nama_file_download = "Laporan_Laba_Rugi_Kotor.pdf";

    
    
    // $stylesheet = file_get_contents('http://localhost/santijaya/pdf.css');

    $html = '
        
        <h2>TOSERBA SANTI JAYA</h2>
        <p>Jalan Raya Sukodono RT 1 RW 1</p>
        <p>Nomor Telpon: +6231 8830792</p>
        <hr/>
        <h3 style="text-align:center;">'.$judul.'</h3>
        <hr/>
    ';

    $datapenjualankasir = $controller->lap_laba_rugi_kasir($bulan);

    $total_penjualan_seluruh_kasir = 0;
    $total_harga_pokok_seluruh_kasir = 0;
    $total_laba_rugi_kotor_seluruh_kasir = 0;

    foreach($datapenjualankasir as $dk):
        $id_user = $dk->id_user;
        $html .= "<h3>Kasir: $dk->nama_kasir</h3>";

        $datapenjualanpertanggal = $controller->lap_laba_rugi_per_tanggal($id_user, $bulan);

        $totalpenjualankasir = 0;
        $totalhargapokokkasir = 0;
        $labarugikotokasir = 0;

        foreach($datapenjualanpertanggal as $dt):
            $id_pelanggan = $dt->id_pelanggan;
            $tanggal = $dt->tanggal_penjualan;

            // $html .= '
            // <table>
            //     <thead>
            //         <tr>
            //             <td colspan="4"><b>Tanggal: '.date("d F Y", strtotime($dt->tanggal_penjualan)).'</b></td>
            //             <td colspan="3"><b>Nama Pelanggan: '.$dt->nama_pelanggan.'</b></td>
            //         </tr>
            //         <tr>
            //             <td>Keterangan</td>
            //             <td>Jumlah Unit</td>
            //             <td>Harga Jual</td>
            //             <td>Total Penjualan</td>
            //             <td>Harga Pokok</td>
            //             <td>Total Harga Pokok</td>
            //             <td>Laba / Rugi Kotor</td>
            //         </tr>
            //     </thead>
            //     <tbody>
            // ';

            $html .= '
            <table width="100%">
                <thead>
                    <tr>
                        <td colspan="2"><b>Tanggal: '.date("d F Y", strtotime($dt->tanggal_penjualan)).'</b></td>
                        <td colspan="2"><b>Nama Pelanggan: '.$dt->nama_pelanggan.'</b></td>
                    </tr>
                    <tr>
                        <td>Nama Barang</td>
                        <td>Jumlah Unit</td>
                        <td>Harga Jual</td>
                        <td>Sub Total</td>
                    </tr>
                </thead>
                <tbody>
            ';
                $datadetilpenjualan = $controller->lap_laba_rugi_detil($tanggal, $id_pelanggan, $id_user);
                                
                $total_unit = 0;
                $total_seluruh_penjualan = 0;
                $total_harga_pokok = 0;
                foreach($datadetilpenjualan as $DJ):
                    $kode_barang = $DJ->kode_barang;

                    // $getlbr = $controller->lap_laba_rugi1($bulan, $kode_barang);
                    // foreach($getlbr as $dG):
                    //     $harga_jual = $dG->harga_jual;
                    // endforeach;
                    $harga_jual = $DJ->harga_barang;

                    $gethp = $controller->get_harga_pokok($kode_barang, $bulan);

                    $total_penjualan = $DJ->jumlah_unit*$harga_jual;
                    $labarugikotor = $total_penjualan-$gethp;

                    $total_unit+=$DJ->jumlah_unit;

                    $total_seluruh_penjualan+=$total_penjualan;
                    $total_harga_pokok+=$gethp*$DJ->jumlah_unit;

                    // $html .= '
                    // <tr>
                    //     <td>'.$DJ->nama_barang.'</td>
                    //     <td>'.$DJ->jumlah_unit.'</td>
                    //     <td>Rp '.number_format($harga_jual).'</td>
                    //     <td>RP '.number_format($total_penjualan).'</td>
                    //     <td>Rp '.number_format($gethp).'</td>
                    //     <td>Rp '.number_format($gethp).'</td>
                    //     <td>Rp '.number_format($labarugikotor).'</td>
                    // </tr>
                    // ';

                    $html .= '
                    <tr>
                        <td>'.$DJ->nama_barang.'</td>
                        <td>'.$DJ->jumlah_unit.'</td>
                        <td>Rp '.number_format($harga_jual).'</td>
                        <td>RP '.number_format($total_penjualan).'</td>
                    </tr>
                    ';
                endforeach;

                $laba_rugi_kotor = $total_seluruh_penjualan-$total_harga_pokok; 

            // $html .='
            //     </tbody>
            //     <tfooter>
            //         <tr style="font-weight:bold;">
            //             <td>Total: </td>
            //             <td>'.$total_unit.'</td>
            //             <td></td>
            //             <td>Rp '.number_format($total_seluruh_penjualan).'</td>
            //             <td></td>
            //             <td>Rp '.number_format($total_harga_pokok).'</td>
            //             <td>Rp '.number_format($laba_rugi_kotor).'</td>
            //         </tr>
            //     </tfooter>
            // </table>
            // ';

            $html .='
                </tbody>
                <tfooter>
                    <tr style="font-weight:bold;">
                        <td>Total: </td>
                        <td>'.$total_unit.'</td>
                        <td></td>
                        <td>Rp '.number_format($total_seluruh_penjualan).'</td>
                    </tr>
                </tfooter>
            </table>
            ';
            $totalpenjualankasir+=$total_seluruh_penjualan;
        
        endforeach;
        $totalhargapokokkasir+=$total_harga_pokok;
        $labarugikotokasir+=$laba_rugi_kotor;

        // $html .= '
        //     <table>
        //         <tr>
        //             <td coslpan="2" width="310px"><h4>Total Kasir '.$dk->nama_kasir.'</h4></td>
        //             <td></td>
        //             <td width="135px">Rp '.number_format($totalpenjualankasir).'</td>
        //             <td width="120px"></td>
        //             <td coslpan="2" width="140px">Rp '.number_format($totalhargapokokkasir).'</td>
        //             <td width="125px">Rp '.number_format($labarugikotokasir).'</td>
        //         </tr>
        //     </table>
        // ';

        $html .= '
            <table>
                <tr>
                    <td width="525px"><h4>Total Kasir '.$dk->nama_kasir.'</h4></td>
                    <td width="190px">Rp '.number_format($totalpenjualankasir).'</td>
                </tr>
            </table>
        ';

        $total_penjualan_seluruh_kasir+=$totalpenjualankasir;
        $total_harga_pokok_seluruh_kasir+=$totalhargapokokkasir;
        $total_laba_rugi_kotor_seluruh_kasir+=$labarugikotokasir;

    endforeach;

    // $html .= '
    //     <hr/>
    //     <table>
    //         <tr>
    //             <td coslpan="2" width="310px"><h3>Total Seluruh Kasir</h3></td>
    //             <td></td>
    //             <td width="135px"><h3>Rp '.number_format($total_penjualan_seluruh_kasir).'</h3></td>
    //             <td width="120px"></td>
    //             <td coslpan="2" width="140px"><h3>Rp '.number_format($total_harga_pokok_seluruh_kasir).'</h3></td>
    //             <td width="125px"><h3>Rp '.number_format($total_laba_rugi_kotor_seluruh_kasir).'</h3></td>
    //         </tr>
    //     </table>
    // ';

    $html .= '
        <hr/>
        <table width="100%">
            <tr>
                <td width="50%"><h3>Total Seluruh Kasir</h3></td>
                <td width="50%"><h3>Rp '.number_format($total_penjualan_seluruh_kasir).'</h3></td>
            </tr>
        </table>
    ';


        
    $mpdf = new mPDF('utf-8', 'A4', 0, '',10,10,10,1,1,1,'');
    $mpdf->SetTitle($nama_file);
    $mpdf->WriteHTML($html,2);
    $mpdf->Output($nama_file_download,'I');
endif;
?>