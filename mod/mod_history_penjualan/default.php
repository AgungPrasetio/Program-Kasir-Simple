<?php
require_once "__class/PenjualanController.php";
require "__class/system/currency.php";
require_once "__class/KepemilikanController.php";
$controller = new PenjualanController();
$pemilikCon = new KepemilikanController();
?>
<h3 class="page-title">History Penjualan</h3>
<!-- OVERVIEW -->
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-headline">
            <div class="panel-body">
                <!-- FORM -->
                <h2 style="font-size:22px; margin:0px; padding:0px;"><center>Pencarian Data Penjualan</center></h2><hr/>
                <div id="info"></div>
                <form action="" method="POST" class="form-horizontal form-label-left" id="form-search">
                    <div class="form-group">
                        <label for="tanggal_trans" class="col-sm-3">Tanggal Transaksi</label>
                        <div class="col-sm-9">
                            <input type="text" name="tanggal_trans" id="tanggal_trans" class="form-control" placeholder="Pilih Tanggal Transaksi" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kode_barang" class="col-sm-3">Kepemilikan Barang</label>
                        <div class="col-sm-9">
                            <select name="pemilik" id="pemilik" class="selectize_data">
                                <option value="all">Semua Pemilik</option>
                                <?php
                                    $pemilik = $pemilikCon->SelectPemilik();
                                    foreach($pemilik as $K):
                                        if(isset($_POST['pemilik'])):
                                            if($_POST['pemilik']==$K->id):
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
            <div class="col-md-2 col-md-offset-4">
                <form action="cetak_laporan.php" method="POST" target="blank">
                    <input type="hidden" name="key" value="1" />
                    <input type="hidden" name="tanggal" value="<?php if(isset($_POST['tanggal_trans'])){ echo $_POST['tanggal_trans']; } ?>" />
                    <input type="hidden" name="kepemilikan" value="<?php if(isset($_POST['pemilik'])){ echo $_POST['pemilik']; } ?>" />
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
                            <th width="10px">#</th>
                            <th>ID Penjualan</th>
                            <th>Pelanggan</th>
                            <th>Kasir</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $data = $controller->data();
                        if(isset($_POST['search'])):
                            $tanggal_trans = $_POST['tanggal_trans'];
                            $kepemilikan = $_POST['pemilik'];
                            $data = $controller->data($tanggal_trans, '', $kepemilikan);
                        endif;

                        foreach($data as $D):
                            $id = $D->id_penjualan;
                            $no = $D->no;
                            $diskon = $D->diskon;
                            echo '
                            <tr>
                                <td>'.$no.'</td>
                                <td>'.$D->id_penjualan.'</td>
                                <td>'.$D->nama_pelanggan.'</td>
                                <td>'.$D->nama_kasir.'</td>
                                <td>'.$D->tanggal.'</td>
                                <td>'.$D->total.'</td>
                                <td>
                                    <button data-toggle="modal" data-target="#penjualan'.$no.'" class="btn btn-sm btn-primary" title="Detail Transaksi"><i class="fa fa-eye"></i></button>

                                    <a href="cetaknota.php?id_penjualan='.$id.'" target="_blank" class="btn btn-sm btn-success">Cetak Nota</a>

                                    <div class="modal fade" id="penjualan'.$no.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <center><h3 class="modal-title" id="myModalLabel">Detail Transaksi Penjualan - '.$id.'</h3></center>
                                            </div>
                                            <div class="modal-body">
                                                <h4 style="margin:0px; padding:0px">Nama Pelanggan : '.$D->nama_pelanggan.'</h4>
                                                <h4 style="margin:0px; padding:0px">Nama Kasir : '.$D->nama_kasir.'</h4><br/>
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th width="10px">Np</th>
                                                            <th>Kode Barang</th>
                                                            <th>Nama Barang</th>
                                                            <th>Jumlah</th>
                                                            <th>Harga</th>
                                                            <th>Total</th>
                                                            <th width="80px">Potongan Per Barang</th>
                                                            <th width="100px">Total Potongan</th>
                                                            <th>Sub Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                            ';
                                                        $detilpenjualan = $controller->getDetilPenjualan($id);
                                                        $total = 0;
                                                        foreach($detilpenjualan as $DP):
                                                            echo '
                                                            <tr>
                                                                <td>'.$DP->no.'</td>
                                                                <td>'.$DP->kode_barang.'</td>
                                                                <td>'.$DP->nama_barang.'</td>   
                                                                <td>'.$DP->jumlah.'</td>
                                                                <td>Rp '.formatRupiah($DP->harga).'</td>
                                                                <td>Rp '.formatRupiah($DP->total_harga).'</td>
                                                                <td>Rp '.formatRupiah($DP->potongan_per_barang).'</td>
                                                                <td>Rp '.formatRupiah($DP->total_potongan_per_barang).'</td>
                                                                <td>Rp '.formatRupiah($DP->subtotal).'</td>
                                                            </tr>
                                                            ';
                                                            $total+=$DP->subtotal;
                                                        endforeach;
                            echo ' 

                                                    </tbody>
                                                    <tfooter>
                                                        <tr>
                                                            <td colspan="8" align="right">Total</td>
                                                            <td>Rp '.formatRupiah($total).'</td>
                                                        </tr>
                            ';
                                                        if(!empty($diskon)):
                                                            $total_after_diskon = $total-($total*($diskon/100));
                                                            echo '
                                                            <tr>
                                                                <td colspan="8" align="right">Diskon</td>
                                                                <td>'.$diskon.'%</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="8" align="right">Total Setelah Diskon</td>
                                                                <td>Rp '.formatRupiah($total_after_diskon).'</td>
                                                            </tr>
                                                            ';
                                                        endif;
                            echo '
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