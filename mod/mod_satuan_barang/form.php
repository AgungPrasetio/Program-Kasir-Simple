<?php
require_once "../../__class/SatuanBarangController.php";
$controller = new SatuanBarangController();

if(isset($_GET['add'])):
    $title = "Tambah Satuan Barang";
    $formid = "form-add";
elseif(isset($_GET['edit'])):
    $title = "Ubah Satuan Barang";
    $formid = "form-edit";
else:
    $title = "Hapus Satuan Barang";
    $formid = "form-del";
endif;

//get Data
if(!isset($_GET['add'])):
    $id = $_GET['id'];
    $getSatuan = $controller->getDataByID($id);
    foreach($getSatuan as $G):
        $nama_satuan_barang = $G->nama_satuan_barang;
    endforeach;
endif;

echo '<h2 style="font-size:22px; margin:0px; padding:0px;"><center>'.$title.'</center></h2><hr/>';
?>
<script src="assets/js/jquery/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/validation.min.js"></script>
<script type="text/javascript" src="assets/js/controller/SatuanBarangJS.js"></script>

<div id="info"></div>
<form action="" method="POST" class="form-horizontal form-label-left" id="<?php echo $formid; ?>">
    <div class="form-group">
        <label for="nama_satuan_barang" class="col-sm-4">Nama Satuan Barang</label>
        <div class="col-sm-8">
            <?php
            if(isset($_GET['add'])):
                echo '<input type="text" name="nama_satuan_barang" id="nama_satuan_barang" class="form-control" placeholder="Nama Satuan Barang" />';
            elseif(isset($_GET['edit'])):
                echo '<input type="text" name="nama_satuan_barang" id="nama_satuan_barang" class="form-control" value="'.$nama_satuan_barang.'" />';
            else:
                echo '<input type="text" name="nama_satuan_barang" readonly id="nama_satuan_barang" class="form-control" value="'.$nama_satuan_barang.'" />';
            endif;
            ?>
            <div id="msgnama"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-8 col-sm-offset-4">
            <?php
                if(isset($_GET['add'])):
                    echo "<button type='submit' id='add' class='btn btn-primary'><i class='fa fa-plus'></i> Tambah</button>";
                elseif(isset($_GET['edit'])):
                    echo "<input type='hidden' id='key' name='key' value='$id' />";
                    echo '<input type="hidden" name="nama_satuan_barang_lama" id="nama_satuan_barang_lama" class="form-control" value="'.$nama_satuan_barang.'" />';
                    echo "<button type='submit' id='edit' class='btn btn-primary'><i class='fa fa-pencil'></i> Ubah</button>";
                elseif(isset($_GET['delete'])):
                    echo "<input type='hidden' name='key' id='key' value='$id' />";
                    echo "<button type='submit' id='del' class='btn btn-primary'><i class='fa fa-trash'></i> Hapus</button>";
                endif;
            ?>
            <button type="button" onclick="cancel()" class="btn btn-danger">Batal</button>
        </div>
    </div>
</form>