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
    require_once "__class/KepemilikanController.php";
    $dbase = new db();
    $pemilikCon = new KepemilikanController();

    $key = $_POST['key'];
    $periode = $_POST['tanggal'];
    $awal = date("d M Y", strtotime(substr($periode,0,10)));
    $akhir = date("d M Y", strtotime(substr($periode,13,10)));
    $pemilik = $_POST['kepemilikan'];
    if(!empty($pemilik)){
        $nama_pemilik = $pemilikCon->get_nama_pemilik($pemilik);

        $kepemilikan = "<h3>Kepemilikan Barang : ".$nama_pemilik."</h3>";
    }

    if($key==1):
        if($periode==""):
            $judul = "Laporan Penjualan";
        else:
            $judul = "Laporan Penjualan $awal s/d $akhir";
        endif;

        $nama_file = "Laporan Penjualan";
        $nama_file_download = "Laporan_Penjualan.pdf";
    else:
        if($periode==""):
            $judul = "Laporan Pembelian";
        else:
            $judul = "Laporan Pembelian $awal s/d $akhir";
        endif;

        $nama_file = "Laporan Pembelian";
        $nama_file_download = "Laporan_Pembelian.pdf";
    endif;
    
    
    
    // $stylesheet = file_get_contents('http://localhost/santijaya/pdf.css');

    $html = '
       <h2>TOSERBA SANTI JAYA</h2>
        <p>Jalan Raya Sukodono RT 1 RW 1</p>
        <p>Nomor Telpon: +6231 8830792</p>
        '.$kepemilikan.'
        <h3 class="center">'.$judul.'</h3>
    ';

    if($key==1):
        $html .= '
            <table width="100%" cellpadding="2" cellspacing="2">
                <tr>
                    <td width="13%">Nomor Transaksi</td>
                    <td width="13%">Pelanggan</td>
                    <td width="12%">Kasir</td>
                    <td width="10%">Tanggal</td>
                    <td>Detil Transaksi</td>
                    <td width="10%">Grand Total</td>
                </tr>
        ';

        $tabel = array(
            'penjualan PE',
            'pelanggan PL',
            'user U',
            'detil_penjualan DP',
            'barang B'
        ); 
        $fild = "*";

        $where_periode = "";
        $where_kepemilikan = "";
        if($periode!=null || !empty($periode)):
            $awal = substr($periode,0,10);
            $akhir = substr($periode,13,10);
            $where_periode = "AND date(PE.tanggal_penjualan)>='$awal' AND date(PE.tanggal_penjualan)<='$akhir'";
        endif;

        if($pemilik!='all'):
            $where_kepemilikan = " AND B.id_kepemilikan='$pemilik'";
        elseif(!empty($pemilik)):
            $where_kepemilikan = " AND B.id_kepemilikan='$pemilik'";
        endif;
        
        $where = "PE.id_pelanggan=PL.id_pelanggan AND PE.id_user=U.id_user AND DP.id_penjualan=PE.id_penjualan AND DP.kode_barang=B.kode_barang $where_periode $where_kepemilikan";
        $order = "PE.tanggal_penjualan DESC";

        $total_penjualan = 0;
        foreach($dbase->select($tabel, $fild, $where, '',$order,$limit) as $data):
            $id = $data['id_penjualan'];
            $html .= '
                <tr>
                    <td>'.$id.'</td>
                    <td>'.ucwords($data['nama_pelanggan']).'</td>
                    <td>'.ucwords($data['nama_lengkap']).'</td>
                    <td>'.date('d M Y', strtotime($data['tanggal_penjualan'])).'</td>
                    <td>
                        <table width="100%">
                            <tr>
                                <td width="37%">Nama Barang</td>
                                <td width="28%">Harga Barang</td>
                                <td width="15%">Jumlah</td>
                                <td width="20%">Sub Total</td>
                            </tr>
            ';
                            $tdetil = array(
                                'detil_penjualan D',
                                'barang B'
                            ); 
                            $fdetil = "*";
                            $wdetil = "D.kode_barang=B.kode_barang AND D.id_penjualan='$id' $where_kepemilikan";
                            $odetil = "B.nama_barang ASC";

                            $i = 0;
                            $no = 1;
                            $tot = 0;
                            foreach($dbase->select($tdetil, $fdetil, $wdetil, '',$odetil) as $ddetil):
                            $tot += $ddetil['jumlah']*$ddetil['harga'];
                            $html .= '
                                <tr>
                                    <td>'.ucwords($ddetil['nama_barang']).'</td>
                                    <td>Rp '.number_format($ddetil['harga']).'</td>
                                    <td>'.$ddetil['jumlah'].'</td>
                                    <td>Rp '.number_format($ddetil['jumlah']*$ddetil['harga']).'</td>
                                </tr>
                            ';
                            endforeach;
                            $html .= '
                                <tr>
                                    <td colspan="3" align="right">Total</td>
                                    <td>Rp '.number_format($tot,0).'</td>
                                </tr>
                            ';
                            $total_penjualan+=$data['total'];
            $html .='
                        </table>
                    </td>
                    <td>Rp '.number_format($data['total'],0).'</td>
                </tr>
            ';
        endforeach;

        $html .= '
                <tr>
                    <td colspan="5" style="text-align:right;">Total Penjualan</td>
                    <td>Rp '.number_format($total_penjualan,0).'</td>
                </tr>
        ';
    else:
        $html .= '
            <table width="100%" cellpadding="2" cellspacing="2">
                <tr>
                    <td width="13%">Nomor Transaksi</td>
                    <td width="13%">Pemasok</td>
                    <td width="12%">Petugas</td>
                    <td width="10%">Tanggal</td>
                    <td>Detil Transaksi</td>
                    <td width="10%">Grand Total</td>
                </tr>
        ';

        $tabel = array(
            'pembelian PE',
            'pemasok PM',
            'user U'
        ); 
        $fild = "*";
        if($periode==null):
            $where = "PE.id_pemasok=PM.id_pemasok AND PE.id_user=U.id_user";
        else:
            $awal = substr($periode,0,10);
            $akhir = substr($periode,13,10);
            $where = "PE.id_pemasok=PM.id_pemasok AND PE.id_user=U.id_user AND date(PE.tanggal_pembelian)>='$awal' AND date(PE.tanggal_pembelian)<='$akhir'";
        endif;
        $order = "PE.tanggal_pembelian DESC";
        $total_pembelian = 0;
        foreach($dbase->select($tabel, $fild, $where, '',$order,$limit) as $data):
            $id = $data['id_pembelian'];
            $html .= '
                <tr>
                    <td>'.$id.'</td>
                    <td>'.ucwords($data['nama_pemasok']).'</td>
                    <td>'.ucwords($data['nama_lengkap']).'</td>
                    <td>'.date('d M Y', strtotime($data['tanggal_pembelian'])).'</td>
                    <td>
                        <table width="100%">
                            <tr>
                                <td width="37%">Nama Barang</td>
                                <td width="37%">Kepemilikan</td>
                                <td width="28%">Harga Barang</td>
                                <td width="15%">Jumlah</td>
                                <td width="20%">Sub Total</td>
                            </tr>
            ';
                            $tdetil = array(
                                'detil_pembelian D',
                                'barang B'
                            ); 
                            $fdetil = "*";
                            $wdetil = "D.kode_barang=B.kode_barang AND D.id_pembelian='$id'";
                            $odetil = "B.nama_barang ASC";

                            $i = 0;
                            $no = 1;
                            $tot = 0;
                            foreach($dbase->select($tdetil, $fdetil, $wdetil, '',$odetil) as $ddetil):
                            $tot += $ddetil['jumlah_beli']*$ddetil['harga_beli'];
                            $kepemilikan = $pemilikCon->get_nama_pemilik($ddetil['id_kepemilikan']);
                            $html .= '
                                <tr>
                                    <td>'.ucwords($ddetil['nama_barang']).'</td>
                                    <td>'.$kepemilikan.'</td>
                                    <td>Rp '.number_format($ddetil['harga_beli']).'</td>
                                    <td>'.$ddetil['jumlah_beli'].'</td>
                                    <td>Rp '.number_format($ddetil['jumlah_beli']*$ddetil['harga_beli']).'</td>
                                </tr>
                            ';
                            endforeach;
                            $html .= '
                                <tr>
                                    <td colspan="4" align="right">Total</td>
                                    <td>Rp '.number_format($tot,0).'</td>
                                </tr>
                            ';
                            $total_pembelian+=$data['total_pembelian'];
            $html .='
                        </table>
                    </td>
                    <td>Rp '.number_format($data['total_pembelian'],0).'</td>
                </tr>
            ';
        endforeach;
        $html .= '
                <tr>
                    <td colspan="5" style="text-align:right;">Total Pembelian</td>
                    <td>Rp '.number_format($total_pembelian,0).'</td>
                </tr>
        ';
    endif;
        


    $html .= '
        </table>
    ';

    $mpdf = new mPDF('utf-8', 'A4-L', 0, '',10,10,10,1,1,1,'');
    $mpdf->SetTitle($nama_file);
    $mpdf->WriteHTML($html,2);
    $mpdf->Output($nama_file_download,'I');
endif;
?>