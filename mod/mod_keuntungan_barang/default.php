<?php
require_once "__class/BarangController.php";
require "__class/system/currency.php";
require "__class/system/event-date.php";
require_once "__class/KepemilikanController.php";
$controller = new BarangController();
$pemilikCon = new KepemilikanController();
?>
<h3 class="page-title">Laporan Laba Per Barang</h3>
<!-- OVERVIEW -->
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-headline">
            <div class="panel-body">
                <!-- FORM -->
                <h2 style="font-size:22px; margin:0px; padding:0px;"><center>Laporan Laba Per Barang</center></h2><hr/>
                <div id="info"></div>
                <form action="" method="POST" class="form-horizontal form-label-left" id="form-search">
                    <div class="form-group">
                        <label for="tanggal_trans" class="col-sm-3">Pencarian Bulan</label>
                        <div class="col-sm-9">
                            <input type="text" name="bulan" id="bulan" readonly class="form-control" placeholder="Pencarian Berdasarkan Bulan" />
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
    $month = substr($post, 0,2);
    $m = getBulan(substr($post, 0,2));
    $y = substr($post, -4);
    $pemilik = $_POST['pemilik'];
    if($pemilik!="all"){
        $nama_pemilik = $pemilikCon->get_nama_pemilik($pemilik);
    }else{
        $nama_pemilik = "Semua Pemilik";
    }

?>
    <div class="row">
        <div class="col-md-12">
            <h3 style="font-size:16px; text-align:center; font-weight:bold;">Laporan Laba Per Barang Pada Bulan <?php echo $m." tahun ".$y ?></h3>
            <?php
            if(!empty($nama_pemilik)){
                echo '<h3 style="font-size:16px; text-align:center; font-weight:bold;">Nama Pemilik: '.$nama_pemilik.'</h3>';
            }
            ?>
        </div>
        <?php 
            $barang_laba = $controller->data_barang_laba($pemilik, $month, $y);
            if(!empty($barang_laba)):
        ?>
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Kepemilikan</th>
                    <th>Jumlah</th>
                    <th>Harga Pokok</th>
                    <th>Harga Jual</th>
                    <th>Sub Total Harga Pokok</th>
                    <th>Sub Total Harga Jual</th>
                    <th>Laba / Rugi</th>
                </tr>
                <?php echo $barang_laba; ?>
            </table>
        </div>
        <?php endif; ?>
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