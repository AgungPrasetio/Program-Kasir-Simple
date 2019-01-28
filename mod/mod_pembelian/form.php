<?php
require_once "../../__class/PembelianController.php";
$controller = new PembelianController();

$title = "Tambah Transaksi Pembelian";

echo '<h2 style="font-size:22px; margin:0px; padding:0px;"><center>'.$title.'</center></h2><hr/>';
?>
<script src="assets/js/jquery/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/validation.min.js"></script>
<script src="assets/js/system.js"></script>
<script type="text/javascript" src="assets/js/jquery/jquery.maskMoney.min.js"></script>
<script type="text/javascript" src="assets/js/controller/PembelianJS.js"></script>

<div id="info"></div>
<form name="transaksi" action="" method="POST" class="form-horizontal form-label-left" id="form-add">
    <div class="form-group">
        <label for="kode_barang" class="col-sm-4">Barang</label>
        <div class="col-sm-8">
            <select name="barang" id="barang" class="selectize_barang">
                <?php
                    $barang = $controller->SelectBarang();
                    foreach($barang as $B):
                        echo '<option value="'.$B->kode_barang.'">'.$B->kode_barang.' - '.$B->nama_barang.'</option>';
                    endforeach;
                ?>
            </select>
        </div>
    </div>
    <!--<div class="form-group">
        <label for="harga" class="col-sm-4">Jumlah Beli Barang</label>
        <div class="col-sm-8">
            <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="Jumlah Beli Barang" />
        </div>
    </div>-->
    <div class="form-group">
        <label for="harga" class="col-sm-4">Satuan Beli Barang</label>
        <div class="col-sm-8">
            <select name="satuan" id="satuan" class="selectize_barang">
                <?php
                    $satuan = $controller->SelectSatuanBarang();
                    foreach($satuan as $s):
                        echo '<option value="'.$s->id.'">'.$s->nama_satuan_barang.'</option>';
                    endforeach;
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="harga" class="col-sm-4">Jumlah Isi Per Satuan</label>
        <div class="col-sm-8">
            <input type="text" name="jumlah_isi" id="jumlah_isi" onkeypress="return event.charCode >= 48" class="form-control" placeholder="Jumlah Isi Per Satuan Barang" />
        </div>
    </div>
    <div class="form-group">
        <label for="harga" class="col-sm-4">Harga Beli</label>
        <div class="col-sm-8">
            <input type="text" name="harga" id="harga" onkeypress="return event.charCode >= 48" onkeyup="setHarga()" class="form-control" placeholder="Harga Beli Barang" />
            <input type="hidden" name="nominalharga" id="nominalharga" />
        </div>
    </div>
    <div class="form-group">
        <label for="harga" class="col-sm-4">Laba (Persentase)</label>
        <div class="col-sm-8">
            <input type="text" name="laba" id="laba" onkeypress="return event.charCode >= 48" class="form-control" placeholder="Laba yang diinginkan" style="width:200px;float:left" /><span style="float:left; margin-top:7px;">%</span>
            <div clas="clear"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-8 col-sm-offset-4">
            <button type='submit' id='add' class='btn btn-primary'><i class='fa fa-plus'></i> Tambah</button>
        </div>
    </div>
</form>

<script src="assets/js/selectize.js"></script>
<script src="assets/js/selectizeindex.js"></script>
<script>
$('.selectize_barang').selectize({
  sortField: {
    field: 'text',
    direction: 'asc'
  }
});

$('.selectize_satuan_barang').selectize({
  sortField: {
    field: 'text',
    direction: 'asc'
  }
});
</script>