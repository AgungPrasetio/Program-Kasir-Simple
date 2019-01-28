<html>
	<head>
		<title>CTRL + P, Lalu Enter</title>
		
		<style type="text/css">
			#printable { display: none; }

			@media print
			{
				#non-printable { display: none; }
				#printable { display: block; }
			}
			.boldtable, .boldtable TD
			{
				font-size:10pt;
			}
		</style>
	</head>
	<body onload="">
		<script type="text/javascript">
			window.onload = function(){
			  window.print();
			//   window.setTimeout("history.back();", 100);
			};
		</script>
        <?php
            // require_once("__class/mpdf60/mpdf.php");

            require_once "__class/db.php";
            require_once "__class/BarangController.php";
            $dbase = new db();
            $barangcon = new BarangController();

            $id_penjualan = $_GET['id_penjualan'];

            $nama_file = "Struk Penjualan - $id_penjualan";
            $nama_file_download = "Struk_Penjualan_$id_penjualan.pdf";

            $judul = "Nota Penjualan - $id_penjualan";
            
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
            $diskon = $data['diskon'];

            ?>
            <center>
                <h4 style="margin:0px;padding:0px; font-size:14px; ">TOSERBA SANTI JAYA</h4>
                <p style="font-size:8px;">Jalan Raya Sukodono RT 1 RW 1 </p>
                <p style="font-size:8px;">Nomor Telpon: +6231 8830792</p>
                <hr style="margin:5px 0 0 0;padding:0px;">

                <?php
                    echo '
                    <h4 style="margin:10px 0 0 0; padding:0px; font-size:10px; " class="center">'.$judul.'</h4>
                    <h5 style="margin:0px 0 10px 0; padding:0px; font-size:8px; font-weight:300; " class="center">Tanggal: '.$tanggal_penjualan.'</h5>';
                ?>

                <table width="100%" style="font-size:10px;">
                    <tr style="border:none;">
                        <td width="37%">Barang</td>
                        <td>Qty</td>
                        <td>Harga</td>
                        <td>Total</td>
                    </tr>
            <?php
                    $tdetil = array(
                        'detil_penjualan D',
                        'barang B'
                    );
                    $fdetil = "*";
                    $wdetil = "D.id_penjualan='$id_penjualan' AND B.kode_barang=D.kode_barang";
                    $no = 1;
                    $total = 0;
                    $total_seluruh_potongan = 0;
                    foreach($dbase->select($tdetil,$fdetil,$wdetil) as $ddetil):
                        $kode_barang = $ddetil['kode_barang'];
                        $nama_barang = $ddetil['nama_barang'];
                        $jumlah = $ddetil['jumlah'];
                        $potongan_per_barang = $ddetil['potongan_per_barang'];

                        $total_potongan_per_barang = $jumlah*$potongan_per_barang;

                        $total_seluruh_potongan+=$total_potongan_per_barang;
                        $harga = $barangcon->set_harga_jual($kode_barang);
                        $subtotal = $jumlah*$harga;
                        $total+=$subtotal;
                        echo '
                        <tr>
                            <td>'.$nama_barang.'</td>
                            <td>'.$jumlah.'</td>
                            <td>'.number_format($harga).'</td>
                            <td>'.number_format($subtotal).'</td>
                        </tr>
                        ';
                    endforeach;

                    $total_harga_setelah_potongan = $total-$total_seluruh_potongan;
                    $total_harga_setelah_diskon = $total_harga_setelah_potongan-($total_harga_setelah_potongan*($diskon/100));
            echo '
                    <tr>
                        <td colspan="3" style="text-align:right;">Total Potongan</td>
                        <td>'.number_format($total_seluruh_potongan).'</td>  
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align:right;">Total Harga Setelah Potongan</td>
                        <td>'.number_format($total_harga_setelah_potongan).'</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align:right;">Diskon</td>
                        <td>'.$diskon.'%</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align:right;">Total Transaksi</td>
                        <td>'.number_format($total_harga_setelah_diskon).'</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align:right;">Bayar</td>
                        <td>'.number_format($bayar).'</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align:right;">Kembalian</td>
                        <td>'.number_format($bayar-$total_harga_setelah_diskon).'</td>
                    </tr>
                </table>  
				<p></p>
				<p></p>
				<h4 style="margin:0px;padding:0px; font-size:14px; ">TERIMA KASIH</h4>
				<p style="font-size:8px;">NB : barang yang sudah di beli tidak boleh di tukar / di kembalikan</p>
            ';


            $mpdf = new mPDF('utf-8', 'A8', 0, '',3,3,2,1,1,1,'');
            $mpdf->SetTitle($nama_file);
            $mpdf->WriteHTML($html,2);
            $mpdf->Output($nama_file_download,'I');
        ?>
    </body>
</html>