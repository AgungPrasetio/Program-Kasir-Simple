<?php
require_once "__class/PenjualanController.php";
require_once "__class/UserController.php";
require "__class/system/currency.php";
$controller = new PenjualanController();
$kasirCon = new UserController();
?>
<h3 class="page-title">Laporan Penjualan Tiap Kasir</h3>
<!-- OVERVIEW -->
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-headline">
            <div class="panel-body">
                <!-- FORM -->
                <h2 style="font-size:22px; margin:0px; padding:0px;"><center>Pencarian Laporan Penjualan</center></h2><hr/>
                <div id="info"></div>
                <form action="" method="POST" class="form-horizontal form-label-left" id="form-search">
                    <div class="form-group">
                        <label for="kode_barang" class="col-sm-3">Nama Kasir</label>
                        <div class="col-sm-9">
                            <select name="kasir" id="kasir" class="selectize_data">
                                <?php
                                    $kasir = $kasirCon->SelectKasir();
                                    foreach($kasir as $K):
                                        if(isset($_POST['kasir'])):
                                            if($_POST['kasir']==$K->id):
                                                echo '<option value="'.$K->id.'" selected>'.$K->nama_lengkap.'</option>';
                                            else:
                                                echo '<option value="'.$K->id.'">'.$K->nama_lengkap.'</option>';
                                            endif;
                                        else:
                                            echo '<option value="'.$K->id.'">'.$K->nama_lengkap.'</option>';
                                        endif;
                                    endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_trans" class="col-sm-3">Tanggal Transaksi</label>
                        <div class="col-sm-9">
                            <input type="text" name="tanggal_trans" id="tanggal_trans" class="form-control" placeholder="Pilih Tanggal Transaksi" value="<?php if(isset($_POST['tanggal_trans'])): echo $_POST['tanggal_trans']; endif; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button type="submit" id="search" name="search" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-headline">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title">Data History Penjualan</h3>
            </div>
            <div class="col-md-2 col-md-offset-4" style="display:none;">
                <form action="cetak_laporan.php" method="POST" target="blank">
                    <input type="hidden" name="key" value="1" />
                    <input type="hidden" name="tanggal" value="<?php if(isset($_POST['tanggal_trans'])){ echo $_POST['tanggal_trans']; } ?>" />
                    <input type="submit" class="btn btn-md btn-warning" value="Cetak Laporan" name="cetak" />
                </form>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <!-- Data-->
                <table class="table table-bordered table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th width="10px">No</th>
                            <th>Tanggal</th>
                            <th>Saldo Awal</th>
                            <th>Hasil Penjualan</th>
                            <th>Total Hasil Penjualan</th>
                            <th width="200px">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(isset($_POST['search'])):
                            $tanggal_trans = $_POST['tanggal_trans'];
                            $kasir = $_POST['kasir'];
                            
                            $data = $controller->dataKasir($tanggal_trans, $kasir);

                            foreach($data as $D):
                                $id = $D->id_penjualan;
                                $no = $D->no;
                                $tanggal_trans = $D->tanggal;
                                $total = $D->total;
                                $saldo = $D->saldo;
                                $total_hasil_penjualan = $total+$saldo;
                                echo '
                                <tr>
                                    <td>'.$no.'</td>
                                    <td>'.$D->tanggal.'</td>
                                    <td>Rp '.number_format($D->saldo).'</td>
                                    <td>Rp '.number_format($D->total).'</td>
                                    <td>Rp '.number_format($total_hasil_penjualan).'</td>
                                    <td>
                                        <button data-toggle="modal" data-target="#penjualan'.$no.'" class="btn btn-sm btn-primary" title="Detail Transaksi" style="float:left; margin-right:10px;">Detail</button>

                                        <form action="cetak_laporan_kasir.php" method="POST" target="blank" style="">
                                            <input type="hidden" name="key" value="2" />
                                            <input type="hidden" name="id_kasir" value="'.$kasir.'" />
                                            <input type="hidden" name="kasir" value="'.$D->nama_kasir.'" />
                                            <input type="hidden" name="tanggal" value="'.$D->tanggal.'" />
                                            <input type="hidden" name="saldo" value="'.$D->saldo.'" />
                                            <input type="submit" class="btn btn-sm btn-success" value="Cetak Laporan" name="cetak" style="float:left;" />
                                        </form>
                                        <div class="clear"></div>

                                        <div class="modal fade" id="penjualan'.$no.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <center><h3 class="modal-title" id="myModalLabel">Detail Transaksi Penjualan - Tanggal : '.$D->tanggal.'</h3></center>
                                                </div>
                                                <div class="modal-body">
                                                    <h4 style="margin:0px; padding:0px">Nama Kasir : '.$D->nama_kasir.'</h4>
                                                    <h4 style="margin:0px; padding:0px">Saldo Awal : Rp '.number_format($D->saldo).'</h4><hr/>
                                ';
                                                $datapenjualankasir = $controller->data_penjualan_kasir($tanggal_trans, $kasir);

                                                foreach($datapenjualankasir as $dj):
                                                    $id_penjualan = $dj->id_penjualan;
                                                    echo '
                                                    <h5>ID Penjualan: '.$id_penjualan.'</h5>
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th width="10px">No</th>
                                                                <th>Kode Barang</th>
                                                                <th>Nama Barang</th>
                                                                <th>Jumlah</th>
                                                                <th>Harga</th>
                                                                <th>Sub Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                    ';
                                                            $detilpenjualan = $controller->getDetilPenjualan($id_penjualan);
                                                            $total = 0;
                                                            foreach($detilpenjualan as $DP):
                                                                echo '
                                                                <tr>
                                                                    <td>'.$DP->no.'</td>
                                                                    <td>'.$DP->kode_barang.'</td>
                                                                    <td>'.$DP->nama_barang.'</td>
                                                                    <td>'.$DP->jumlah.'</td>
                                                                    <td>Rp '.formatRupiah($DP->harga).'</td>
                                                                    <td>Rp '.formatRupiah($DP->subtotal).'</td>
                                                                </tr>
                                                                ';
                                                                
                                                                $total+=$DP->subtotal;
                                                            endforeach;
                                                    echo ' 

                                                        </tbody>
                                                        <tfooter>
                                                            <tr>
                                                                <td colspan="5" align="right">Total</td>
                                                                <td>Rp '.formatRupiah($total).'</td>
                                                            </tr>
                                                        </tfooter>
                                                    </table>

                                                    
                                                    ';

                                                endforeach;
                               
                                echo '
                                                    <h4>Rekap Penjualan</h4>
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th width="10px">No</th>
                                                                <th>ID Penjualan</th>
                                                                <th>Total Penjualan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                ';
                                                        $total_rekap = 0;
                                                        foreach($datapenjualankasir as $dj):
                                                            $total_rekap+=$dj->total;
                                                        echo '
                                                            <tr>
                                                                <td>'.$dj->no.'</td>
                                                                <td>'.$dj->id_penjualan.'</td>
                                                                <td>Rp '.number_format($dj->total,0).'</td>
                                                            </tr>
                                                        ';
                                                        endforeach;
                                echo '
                                                        </tbody>
                                                        <tfooter>
                                                            <tr>
                                                                <td colspan="2" style="text-align:right;">Total</td>
                                                                <td>Rp '.number_format($total_rekap).'</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="text-align:right;">Saldo Awal</td>
                                                                <td>Rp '.number_format($D->saldo).'</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="text-align:right;">Total Penjualan Tanggal '.$tanggal_trans.'</td>
                                                                <td>Rp '.number_format($total_rekap+$D->saldo).'</td>
                                                            </tr>
                                                        </tfooter>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                ';
                            endforeach;
                        endif;

                        
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- END OVERVIEW -->

<script type="text/javascript" src="assets/js/validation.min.js"></script>
<?php include_once "datatablejs.php"; ?>
<script src="assets/js/selectize.js"></script>
<script src="assets/js/selectizeindex.js"></script>
<script>
$('.selectize_data').selectize({
  sortField: {
    field: 'text',
    direction: 'asc'
  }
});
</script>
