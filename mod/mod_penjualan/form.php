<?php
require_once "../../__class/PenjualanController.php";
$controller = new PenjualanController();

$title = "Tambah Transaksi Penjualan";

echo '<h2 style="font-size:22px; margin:0px; padding:0px;"><center>'.$title.'</center></h2><hr/>';
?>
<script type="text/javascript" src="assets/js/jquery/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/selectize.js"></script>
<script type="text/javascript" src="assets/js/validation.min.js"></script>
<script type="text/javascript" src="assets/js/controller/PenjualanJS.js"></script>

<div id="info"></div>
<form name="transaksi" action="" method="POST" class="form-horizontal form-label-left" id="form-add">
    <div class="form-group">
        <label for="kode_barang" class="col-sm-3">Kode Barang</label>
        <div class="col-sm-9">
            <input type="text" name="kode_barang" id="kode_barang" class="form-control" placeholder="Kode Barang" />
        </div>
    </div>
    <div class="form-group">
        <label for="kode_barang" class="col-sm-3">Nama Barang</label>
        <div class="col-sm-9">
            <select name="nama_barang" id="barang" class="selectize_data1">
                <option value="">Pilih Barang</option>
                <?php
                    $barangs = $controller->SelectBarang();
                    foreach($barangs as $d):
                        echo '<option value="'.$d->kode_barang.'">'.$d->nama_barang.'</option>';
                    endforeach
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-9 col-sm-offset-3">
            <button type='submit' id='add' class='btn btn-primary'><i class='fa fa-plus'></i> Tambah</button>
            <!--<button type="button" onclick="cancel()" class="btn btn-danger">Batal</button>-->
        </div>
    </div>
</form>
<script src="assets/js/selectizeindex.js"></script>
<script>
$('.selectize_data1').selectize({
  sortField: {
    field: 'text',
    direction: 'asc'
  }
});
</script>
<script type="text/javascript">
document.forms['transaksi'].elements['kode_barang'].focus();
</script>
