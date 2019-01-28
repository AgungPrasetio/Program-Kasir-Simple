<?php
require_once "../../__class/PengeluaranController.php";
$controller = new PengeluaranController();

if(isset($_GET['add'])):
    $title = "Tambah Pengeluaran";
    $formid = "form-add";
elseif(isset($_GET['edit'])):
    $title = "Ubah Pengeluaran";
    $formid = "form-edit";
endif;

//get Data
if(!isset($_GET['add'])):
    $id = $_GET['id'];
    $getPengeluaran = $controller->getDataByID($id);
    foreach($getPengeluaran as $G):
        $jenis_pengeluaran = $G->jenis;
        $keterangan = $G->keterangan;
        $tanggal = $G->tanggal;
        $nominal = $G->nominal;
    endforeach;
endif;

echo '<h2 style="font-size:22px; margin:0px; padding:0px;"><center>'.$title.'</center></h2><hr/>';
?>
<script type="text/javascript" src="assets/js/jquery/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/controller/PengeluaranJS.js"></script>

<div id="info"></div>
<form action="" method="POST" class="form-horizontal form-label-left" id="<?php echo $formid; ?>">
    <div class="form-group">
        <label for="id_jenis_barang" class="col-sm-4">Jenis Pengeluaran</label>
        <div class="col-sm-8">
            <?php
            if(isset($_GET['add'])):
                echo '<input type="text" name="jenis_pengeluaran" id="jenis_pengeluaran" class="form-control" placeholder="Jenis Pengeluaran" value="" />';
            elseif(isset($_GET['edit'])):
                echo '<input type="text" name="jenis_pengeluaran" id="jenis_pengeluaran" class="form-control" value="'.$jenis_pengeluaran.'" />';
            endif;
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="nama_jenis_barang" class="col-sm-4">Keterangan</label>
        <div class="col-sm-8">
            <?php
            if(isset($_GET['add'])):
                echo '<textarea rows="5" name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan"></textarea>';
            elseif(isset($_GET['edit'])):
                echo '<textarea rows="5" name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan">'.$keterangan.'</textarea>';
            endif;
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="id_jenis_barang" class="col-sm-4">Tanggal</label>
        <div class="col-sm-8">
            <?php
            if(isset($_GET['add'])):
                echo '<input type="text" name="tanggal" id="tanggal_pengeluaran" placeholder="Tanggal Pengeluaran" class="form-control" value="" />';
            elseif(isset($_GET['edit'])):
                echo '<input type="text" name="tanggal" id="tanggal_pengeluaran" class="form-control" value="'.$tanggal.'" />';
            endif;
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="id_jenis_barang" class="col-sm-4">Nominal</label>
        <div class="col-sm-8">
            <?php
            if(isset($_GET['add'])):
                echo '<input type="number" name="nominal" id="nominal" placeholder="Nominal Pengeluaran" class="form-control" value="" />';
            elseif(isset($_GET['edit'])):
                echo '<input type="number" name="nominal" id="nominal" class="form-control" value="'.$nominal.'" />';
            endif;
            ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-8 col-sm-offset-4">
            <?php
                if(isset($_GET['add'])):
                    echo "<button type='submit' id='add' class='btn btn-primary'><i class='fa fa-plus'></i> Tambah</button>";
                elseif(isset($_GET['edit'])):
                    echo "<input type='hidden' id='key' name='key' value='$id' />";
                    echo '<input type="hidden" name="nama_jenis_barang_lama" id="nama_jenis_barang_lama" class="form-control" value="'.$nama_jenis_barang.'" />';
                    echo "<button type='submit' id='edit' class='btn btn-primary'><i class='fa fa-pencil'></i> Ubah</button>";
                endif;
            ?>
            <button type="button" onclick="cancel()" class="btn btn-danger">Batal</button>
        </div>
    </div>
</form>

<script type="text/javascript" src="assets/js/validation.min.js"></script>
<script src="assets/js/datepicker/bootstrap-datepicker.js"></script>
<script>
var dateToday = Date.now();
$("#tanggal_pengeluaran").datepicker({
    format: "dd-mm-yyyy",
    viewMode: "months",
    maxDateNow: true,
});
</script>