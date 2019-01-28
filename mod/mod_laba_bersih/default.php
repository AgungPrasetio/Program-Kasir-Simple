<?php
require_once "__class/LabaBersihController.php";
require "__class/system/currency.php";
require "__class/system/event-date.php";
$controller = new LabaBersihController();
?>
<h3 class="page-title">Laporan Laba Bersih</h3>
<!-- OVERVIEW -->
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-headline">
            <div class="panel-body">
                <!-- FORM -->
                <h2 style="font-size:22px; margin:0px; padding:0px;"><center>Laporan Laba Bersih</center></h2><hr/>
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
    $post = $_POST['bulan'];
    $m = getBulan(substr($post, 0,2));
    $y = substr($post, -4);

    $laporan = $controller->data_laporan($post);

    $pengeluaran = $controller->get_data_pengeluaran($post);
    $count_pengeluaran = count($pengeluaran);

?>
    <div class="row">
        <div class="col-md-12">
            <h3 style="font-size:16px; text-align:center; font-weight:bold;">Laporan Laba Bersih Pada Bulan <?php echo $m." tahun ".$y ?></h3>
        </div>
        <div class="col-md-12">

            <!-- LIST PENJUALAN -->
            <?php
            $list_penjualan = $controller->list_penjualan($post);
            $count_list_penjualan = count($list_penjualan);
            if($count_list_penjualan>0):
            ?>
                <h5 style="font-weight:bold;">DATA PENJUALAN</h5>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="10px">No</th>
                            <th>ID Penjualan</th>
                            <th>Pelanggan</th>
                            <th>Kasir</th>
                            <th>Tanggal</th>
                            <td>Detil Transaksi</td>
                            <th>Grand Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $total_penjualan = 0;
                            foreach($list_penjualan as $D):
                                $no = $D->no;
                                $id = $D->id_penjualan;
                                $total = $D->total;
                                $total_penjualan+=$total;
                                echo '
                                <tr>
                                    <td>'.$no.'</td>
                                    <td>'.$D->id_penjualan.'</td>
                                    <td>'.$D->nama_pelanggan.'</td>
                                    <td>'.$D->nama_kasir.'</td>
                                    <td>'.$D->tanggal.'</td>
                                    <td>
                                        '.$controller->list_detil_penjualan($id).'
                                    </td>
                                    <td>Rp '.number_format($total,0).'</td>
                                </tr>';
                            endforeach;
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6" style="text-align:right;">TOTAL PENJUALAN</th>
                            <th><?php echo 'Rp '.number_format($total_penjualan,0); ?></th>
                        </tr>
                    </tfoot>
                </table>
            <?php endif; ?>
            <!-- END LIST PENJUALAN -->

            <!-- LIST PEMBELIAN -->
            <?php
            $list_pembelian = $controller->list_pembelian($post);
            $count_list_pembelian = count($list_pembelian);
            if($count_list_pembelian>0):
            ?>
                <h5 style="font-weight:bold;">DATA PEMBELIAN</h5>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="10px">#</th>
                            <th>ID Pembelian</th>
                            <th>Pemasok</th>
                            <th>Petugas</th>
                            <th>Tanggal</th>
                            <th>Detil Transaksi</th>
                            <th>Grand Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $total_pembelian = 0;
                            foreach($list_pembelian as $D):
                                $no = $D->no;
                                $id = $D->id_pembelian;
                                $total = $D->total;
                                $total_pembelian+=$total;
                                echo '
                                <tr>
                                    <td>'.$no.'</td>
                                    <td>'.$id.'</td>
                                    <td>'.$D->nama_pemasok.'</td>
                                    <td>'.$D->nama_petugas.'</td>
                                    <td>'.$D->tanggal.'</td>
                                    <td>
                                        '.$controller->list_detil_pembelian($id).'
                                    </td>
                                    <td>Rp '.number_format($total,0).'</td>
                                </tr>';
                            endforeach;
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6" style="text-align:right;">TOTAL PEMBELIAN</th>
                            <th><?php echo 'Rp '.number_format($total_pembelian,0); ?></th>
                        </tr>
                    </tfoot>
                </table>
            <?php endif; ?>
            <!-- END LIST PEMBELIAN -->


            <table class="table table-bordered table-striped">
                <tr>
                    <td colspan="2"><b>TOTAL PENJUALAN</b></td>
                    <td>: Rp <?php echo formatRupiah($laporan['total_penjualan']); ?></td>
                </tr>
                <tr>
                    <td colspan="2"><b>TOTAL PEMBELIAN</b></td>
                    <td>: Rp <?php echo formatRupiah($laporan['total_pembelian']); ?></td>
                </tr>
                <tr>
                    <td colspan="3"><b>PENGELUARAN</b></td>
                </tr>
                <?php
                $total_pengeluaran = 0;
                if($count_pengeluaran>0):
                    $no=1; 
                    foreach($pengeluaran as $d):  ?>
                    <tr>
                        <td width="10%"><?php echo $no++; ?></td>
                        <td width="55%"><?php echo $d->jenis_pengeluaran ?></td>
                        <td width="35%">: Rp <?php echo formatRupiah($d->nominal) ?></td>
                    </tr>
                <?php 
                    $total_pengeluaran+=$d->nominal;
                    endforeach; 
                ?>
                <tr>
                    <td colspan="2" style="text-align:right;">Total Pengeluaran</td>
                    <td>: Rp <?php echo formatRupiah($total_pengeluaran); ?></td>
                </tr>
                <?php 
                endif; 
                ?>
                <tr>
                    <td colspan="2"></td>
                    <td></td>
                </tr>
                <?php
                    $laba_rugi_bersih = $laporan['total_penjualan']-($laporan['total_pembelian']+$total_pengeluaran);
                    $text_laporan = "LABA BERSIH";
                    if($laba_rugi_bersih<0):
                        $text_laporan = "RUGI";
                        $laba_rugi_bersih = abs($laba_rugi_bersih);
                    endif;
                ?>
                <tr>
                    <td colspan="2" style="text-align:right;"><b><?php echo $text_laporan; ?></b></td>
                    <td><b>: Rp <?php echo formatRupiah($laba_rugi_bersih); ?></b></td>
                </tr>
            </table>
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