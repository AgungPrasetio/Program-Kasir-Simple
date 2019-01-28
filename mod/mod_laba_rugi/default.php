<?php
require_once "__class/LabaRugiController.php";
require "__class/system/currency.php";
require "__class/system/event-date.php";
$controller = new LabaRugiController();
?>
<h3 class="page-title">Laporan Laba Kotor</h3>
<!-- OVERVIEW -->
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-headline">
            <div class="panel-body">
                <!-- FORM -->
                <h2 style="font-size:22px; margin:0px; padding:0px;"><center>Laporan Laba Kotor</center></h2><hr/>
                <div id="info"></div>
                <form action="" method="POST" class="form-horizontal form-label-left" id="form-search">
                    <div class="form-group">
                        <label for="tanggal_trans" class="col-sm-3">Pencarian Bulan</label>
                        <div class="col-sm-9">
                            <input type="text" name="bulan" id="bulan" readonly class="form-control" placeholder="Pencarian Berdasarkan Bulan" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button type="submit" id="search" name="search" class="btn btn-primary"><i class="fa fa-search"></i> Cari Laporan</button>
                            <button type="reset" name="reset" id="reset" class="btn btn-danger">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_POST['search'])):
    $bulan = $_POST['bulan'];
?>
<div class="panel panel-headline">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
            <h3 class="panel-title">Laporan Laba Kotor</h3>
                
            </div>
            <div class="col-md-2 col-md-offset-4">
                <form action="cetak_laporan_laba_rugi.php" method="POST" target="blank">
                    <input type="hidden" name="key" value="<?php echo $jenis_laporan; ?>" />
                    <input type="hidden" name="bulan" value="<?php echo $bulan; ?>" />
                    <input type="submit" class="btn btn-md btn-warning" value="Cetak Laporan" name="cetak" />
                </form>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <?php
                    $m = getBulan(substr($bulan, 0,2));
                    $y = substr($bulan, -4);
                    echo '
                        <center><h3>Laporan Laba Kotor Per Kasir<br/> Periode '.$m.' '.$y.' <br/>General</h3></center><hr/>
                    ';
                    
                    $datapenjualankasir = $controller->lap_laba_rugi_kasir($bulan);

                    $total_penjualan_seluruh_kasir = 0;
                    $total_harga_pokok_seluruh_kasir = 0;
                    $total_laba_rugi_kotor_seluruh_kasir = 0;

                    foreach($datapenjualankasir as $dk):
                        $id_user = $dk->id_user;
                        echo "
                        
                        <h3>Kasir: $dk->nama_kasir</h3>
                        ";

                        $datapenjualanpertanggal = $controller->lap_laba_rugi_per_tanggal($id_user, $bulan);

                        $totalpenjualankasir = 0;
                        $totalhargapokokkasir = 0;
                        $labarugikotokasir = 0;

                        foreach($datapenjualanpertanggal as $dt):
                            $id_pelanggan = $dt->id_pelanggan;
                            $tanggal = $dt->tanggal_penjualan;
                            echo "
                                <h4 style='float:left;'>Tanggal: ".date("d F Y", strtotime($dt->tanggal_penjualan))."</h4>
                                <h4 style='float:right;'>Nama Pelanggan: ".$dt->nama_pelanggan."</h4>
                                <div style='clear:both;'></div>
                            ";
                ?>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <!-- <th>Keterangan</th>
                                        <th>Jumlah Unit</th>
                                        <th>Harga Jual</th>
                                        <th>Total Penjualan</th>
                                        <th>Harga Pokok</th>
                                        <th>Total Harga Pokok</th>
                                        <th>Laba / Rugi Kotor</th> -->
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Harga Jual</th>
                                        <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
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
                                        echo'
                                        <tr>
                                            <td>'.$DJ->nama_barang.'</td>
                                            <td>'.$DJ->jumlah_unit.'</td>
                                            <td>Rp '.number_format($harga_jual).'</td>
                                            <td>RP '.number_format($total_penjualan).'</td>
                                        </tr>
                                        ';
                                        // echo'
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
                                    endforeach;

                                    
                                    ?>
                                </tbody>
                                <tfooter>
                                    <!-- <tr style="font-weight:bold;">
                                        <td>Total: </td>
                                        <td><?php echo $total_unit; ?></td>
                                        <td></td>
                                        <td><?php echo "Rp ".number_format($total_seluruh_penjualan); ?></td>
                                        <td></td>
                                        <td><?php echo "Rp ".number_format($total_harga_pokok); ?></td>
                                        <td>
                                            <?php
                                               $laba_rugi_kotor = $total_seluruh_penjualan-$total_harga_pokok; 
                                               echo 'Rp '.number_format($laba_rugi_kotor);
                                            ?>
                                        </td>
                                    </tr> -->
                                    <tr style="font-weight:bold;">
                                        <td>Total: </td>
                                        <td><?php echo $total_unit; ?></td>
                                        <td></td>
                                        <td><?php echo "Rp ".number_format($total_seluruh_penjualan); ?></td>
                                    </tr>
                                </tfooter>
                            </table>
                <?php
                            $totalpenjualankasir+=$total_seluruh_penjualan;
                            $totalhargapokokkasir+=$total_harga_pokok;
                            $labarugikotokasir+=$laba_rugi_kotor;
                        endforeach;

                        // echo '
                        //     <hr/>
                        //     <table>
                        //         <tr>
                        //             <td coslpan="2" width="360px"><h4>Total Kasir '.$dk->nama_kasir.'</h4></td>
                        //             <td></td>
                        //             <td width="285px">Rp '.number_format($totalpenjualankasir).'</td>
                        //             <td></td>
                        //             <td width="180px">Rp '.number_format($totalhargapokokkasir).'</td>
                        //             <td></td>
                        //             <td>Rp '.number_format($labarugikotokasir).'</td>
                        //         </tr>
                        //     </table>
                        //     <hr/>
                        // ';
                        echo '
                            <hr/>
                            <table>
                                <tr>
                                    <td coslpan="2" width="360px"><h4>Total Kasir '.$dk->nama_kasir.'</h4></td>
                                    <td></td>
                                    <td width="285px">Rp '.number_format($totalpenjualankasir).'</td>
                                    <td></td>
                                    <td width="180px">Rp '.number_format($totalhargapokokkasir).'</td>
                                    <td></td>
                                </tr>
                            </table>
                            <hr/>
                        ';

                        $total_penjualan_seluruh_kasir+=$totalpenjualankasir;
                        $total_harga_pokok_seluruh_kasir+=$totalhargapokokkasir;
                        $total_laba_rugi_kotor_seluruh_kasir+=$labarugikotokasir;

                    endforeach;

                    // echo '
                    //     <hr/>
                    //     <table>
                    //         <tr>
                    //             <td coslpan="2" width="360px"><h3>Total Seluruh Kasir</h3></td>
                    //             <td></td>
                    //             <td width="285px"><h3>Rp '.number_format($total_penjualan_seluruh_kasir).'</h3></td>
                    //             <td></td>
                    //             <td width="180px"><h3>Rp '.number_format($total_harga_pokok_seluruh_kasir).'</h3></td>
                    //             <td></td>
                    //             <td><h3>Rp '.number_format($total_laba_rugi_kotor_seluruh_kasir).'</h3></td>
                    //         </tr>
                    //     </table>
                    //     <hr/>
                    // ';

                    echo '
                        <hr/>
                        <table>
                            <tr>
                                <td coslpan="2" width="360px"><h3>Total Seluruh Kasir</h3></td>
                                <td></td>
                                <td width="285px"><h3>Rp '.number_format($total_penjualan_seluruh_kasir).'</h3></td>
                                <td></td>
                                <td width="180px"><h3>Rp '.number_format($total_harga_pokok_seluruh_kasir).'</h3></td>
                                <td></td>
                            </tr>
                        </table>
                        <hr/>
                    ';

                    // $data = $controller->lap_laba_rugi($bulan);
                ?>
                <!-- Data-->
                <!-- <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Stok Awal</th>
                            <th>Persediaan Awal</th>
                            <th>Jumlah Beli</th>
                            <th>Pembelian</th>
                            <th>Harga Jual</th>
                            <th>Jumlah Jual</th>
                            <th>Persediaan Akhir Stok</th>
                            <th>Persediaan Akhir Jual</th>
                            <th>Jumlah Jual</th>
                            <th>Laba Kotor</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // foreach($data as $getd):
                    //     echo '
                    //     <tr>
                    //         <td>'.$getd->kode.'</td>
                    //         <td>'.$getd->nama.'</td>
                    //         <td>'.$getd->harga.'</td>
                    //         <td>'.$getd->stok_awal.'</td>
                    //         <td>'.$getd->persediaan_awal.'</td>
                    //         <td>'.$getd->jumlah_stok_beli.'</td>
                    //         <td>'.$getd->pembelian.'</td>
                    //         <td>'.$getd->harga_jual.'</td>
                    //         <td>'.$getd->jumlah_jual.'</td>
                    //         <td>'.$getd->persediaan_akhir_sisa_stok.'</td>
                    //         <td>'.$getd->persediaan_akhir_stok_jual.'</td>
                    //         <td>'.$getd->hpp_akhir.'</td>
                    //         <td>'.$getd->laba_kotor.'</td>
                    //     </tr>
                    //     ';
                    // endforeach;
                    ?>
                    </tbody>
                </table> -->
            </div>
        </div>
    </div>
</div>
<?php
endif;
?>
<!-- END OVERVIEW -->
<script type="text/javascript" src="assets/js/validation.min.js"></script>

<script>
$('#bulan').change(function(){
    $('#tahun').attr('disabled', 'true');
});

$('#tahun').change(function(){
    $('#bulan').attr('disabled', 'true');
});

$('#reset').click(function(){
    $('#bulan').removeAttr('disabled');
    $('#tahun').removeAttr('disabled');
});
</script>
<?php include_once "datatablejs.php"; ?>