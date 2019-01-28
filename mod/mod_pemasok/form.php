<?php
require_once "../../__class/PemasokController.php";
$controller = new PemasokController();

if(isset($_GET['add'])):
    $title = "Tambah Pemasok";
    $formid = "form-add";
elseif(isset($_GET['edit'])):
    $title = "Ubah Pemasok";
    $formid = "form-edit";
else:
    $title = "Hapus Pemasok";
    $formid = "form-del";
endif;

//get Data
if(!isset($_GET['add'])):
    $id = $_GET['id'];
    $getPemasok = $controller->getDataByID($id);
    foreach($getPemasok as $G):
        $nama = $G->nama;
        $telpon = $G->telpon;
        $alamat = $G->alamat;
    endforeach;
endif;

echo '<h2 style="font-size:22px; margin:0px; padding:0px;"><center>'.$title.'</center></h2><hr/>';
?>
<script src="assets/js/jquery/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/validation.min.js"></script>
<script type="text/javascript" src="assets/js/controller/PemasokJS.js"></script>

<div id="info"></div>
<form action="" method="POST" class="form-horizontal form-label-left" id="<?php echo $formid; ?>">
    <div class="form-group">
        <label for="nama_pemasok" class="col-sm-3">Nama Pemasok</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '<input type="text" name="nama_pemasok" id="nama_pemasok" class="form-control" placeholder="Nama Pemasok" />';
            elseif(isset($_GET['edit'])):
                echo '<input type="text" name="nama_pemasok" id="nama_pemasok" class="form-control" value="'.$nama.'" />';
            else:
                echo '<input type="text" name="nama_pemasok" readonly id="nama_pemasok" class="form-control" value="'.$nama.'" />';
            endif;
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="telpon_pemasok" class="col-sm-3">Telpon Pemasok</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '<input type="text" name="telpon_pemasok" id="telpon_pemasok" class="form-control" placeholder="Telpon Pemasok" />';
            elseif(isset($_GET['edit'])):
                echo '<input type="text" name="telpon_pemasok" id="telpon_pemasok" class="form-control" value="'.$telpon.'" />';
            else:
                echo '<input type="text" name="telpon_pemasok" readonly id="telpon_pemasok" class="form-control" value="'.$telpon.'" />';
            endif;
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="alamat_pemasok" class="col-sm-3">Alamat Pemasok</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '<input type="text" name="alamat_pemasok" id="alamat_pemasok" class="form-control" placeholder="Alamat Pemasok" />';
            elseif(isset($_GET['edit'])):
                echo '<input type="text" name="alamat_pemasok" id="alamat_pemasok" class="form-control" value="'.$alamat.'" />';
            else:
                echo '<input type="text" name="alamat_pemasok" readonly id="alamat_pemasok" class="form-control" value="'.$alamat.'" />';
            endif;
            ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-9 col-sm-offset-3">
            <?php
                if(isset($_GET['add'])):
                    echo "<button type='submit' id='add' class='btn btn-primary'><i class='fa fa-plus'></i> Tambah</button>";
                elseif(isset($_GET['edit'])):
                    echo "<input type='hidden' id='key' name='key' value='$id' />";
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