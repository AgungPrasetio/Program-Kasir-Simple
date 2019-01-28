<?php
require_once "__class/BarangController.php";
require_once "__class/KepemilikanController.php";
$controller = new BarangController();
$pemilikCon = new KepemilikanController();
?>
<h3 class="page-title">Stok Barang Hampir Habis</h3>
<!-- OVERVIEW -->
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-headline">
            <div class="panel-body">
                <!-- FORM -->
                <h2 style="font-size:22px; margin:0px; padding:0px;"><center>Pencarian Data Stok Barang Habis</center></h2><hr/>
                <div id="info"></div>
                <form action="" method="POST" class="form-horizontal form-label-left" id="form-search">
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
                <h3 class="panel-title">Data Stok Barang</h3>
            </div>
            <div class="col-md-2 col-md-offset-4">
                <form action="cetak_laporan_stok_barang_habis.php" method="POST" target="blank">
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
                            <th width="10px">No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Kepemilikan Barang</th>
                            <th>Stok Minimum</th>
                            <th>Stok Saat Ini</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data = $controller->data_stok_barang_habis();
                        if(isset($_POST['search'])):
                            $kepemilikan = $_POST['pemilik'];
                            $data = $controller->data_stok_barang_habis('', '', $kepemilikan);
                        endif;
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
                                echo '
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