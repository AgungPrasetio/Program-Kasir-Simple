<?php
require_once "../../__class/PelangganController.php";
$controller = new PelangganController();

if(isset($_GET['add'])):
    $title = "Tambah Pelanggan";
    $formid = "form-add";
elseif(isset($_GET['edit'])):
    $title = "Ubah Pelanggan";
    $formid = "form-edit";
else:
    $title = "Hapus Pelanggan";
    $formid = "form-del";
endif;

//get Data
if(!isset($_GET['add'])):
    $id = $_GET['id'];
    $getPelanggan = $controller->getDataByID($id);
    foreach($getPelanggan as $G):
        $nama_pelanggan = $G->nama;
        $telpon_pelanggan = $G->telpon;
        $alamat_pelanggan = $G->alamat;
        $jk = $G->jk;
    endforeach;
endif;

echo '<h2 style="font-size:22px; margin:0px; padding:0px;"><center>'.$title.'</center></h2><hr/>';
?>
<script src="assets/js/jquery/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/validation.min.js"></script>
<script type="text/javascript" src="assets/js/controller/PelangganJS.js"></script>

<div id="info"></div>
<form action="" method="POST" class="form-horizontal form-label-left" id="<?php echo $formid; ?>">
    <div class="form-group">
        <label for="nama_pelanggan" class="col-sm-3">Nama Pelanggan</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '<input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control" placeholder="Nama Pelanggan" />';
            elseif(isset($_GET['edit'])):
                echo '<input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control" value="'.$nama_pelanggan.'" />';
            else:
                echo '<input type="text" name="nama_pelanggan" readonly id="nama_pelanggan" class="form-control" value="'.$nama_pelanggan.'" />';
            endif;
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="telpon_pelanggan" class="col-sm-3">Telpon Pelanggan</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '<input type="text" name="telpon_pelanggan" id="telpon_pelanggan" class="form-control" placeholder="Telpon Pelanggan" />';
            elseif(isset($_GET['edit'])):
                echo '<input type="text" name="telpon_pelanggan" id="telpon_pelanggan" class="form-control" value="'.$telpon_pelanggan.'" />';
            else:
                echo '<input type="text" name="telpon_pelanggan" readonly id="telpon_pelanggan" class="form-control" value="'.$telpon_pelanggan.'" />';
            endif;
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="alamat_pelanggan" class="col-sm-3">Alamat Pelanggan</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '<input type="text" name="alamat_pelanggan" id="alamat_pelanggan" class="form-control" placeholder="Alamat Pelanggan" />';
            elseif(isset($_GET['edit'])):
                echo '<input type="text" name="alamat_pelanggan" id="alamat_pelanggan" class="form-control" value="'.$alamat_pelanggan.'" />';
            else:
                echo '<input type="text" name="alamat_pelanggan" readonly id="alamat_pelanggan" class="form-control" value="'.$alamat_pelanggan.'" />';
            endif;
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="jenis_kelamin" class="col-sm-3">Jenis Kelamin</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                        <option value="P">Pria</option>
                        <option value="W">Wanita</option>
                    </select>
                ';
            elseif(isset($_GET['edit'])):
                echo '<select name="jenis_kelamin" id="jenis_kelamin" class="form-control">';
                    if($jk=="Pria"):
                        echo '
                            <option value="P" selected>Pria</option>
                            <option value="W">Wanita</option>
                        ';
                    else:
                        echo '
                            <option value="P">Pria</option>
                            <option value="W" selected>Wanita</option>
                        ';
                    endif;
                        
                echo '</select>';
            else:
                echo '<input type="text" name="jenis_kelamin" readonly id="jenis_kelamin" class="form-control" value="'.$jk.'" />';
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