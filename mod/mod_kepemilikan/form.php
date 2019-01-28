<?php
require_once "../../__class/KepemilikanController.php";
$controller = new KepemilikanController();

if(isset($_GET['add'])):
    $title = "Tambah Kepemilikan";
    $formid = "form-add";
elseif(isset($_GET['edit'])):
    $title = "Ubah Kepemilikan";
    $formid = "form-edit";
else:
    $title = "Hapus Kepemilikan";
    $formid = "form-del";
endif;

//get Data
if(!isset($_GET['add'])):
    $id = $_GET['id'];
    $getData = $controller->getDataByID($id);
    foreach($getData as $G):
        $nama_pemilik = $G->nama;
    endforeach;
endif;

echo '<h2 style="font-size:22px; margin:0px; padding:0px;"><center>'.$title.'</center></h2><hr/>';
?>
<script src="assets/js/jquery/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/validation.min.js"></script>
<script type="text/javascript" src="assets/js/controller/KepemilikanJS.js"></script>

<div id="info"></div>
<form action="" method="POST" class="form-horizontal form-label-left" id="<?php echo $formid; ?>">
    <div class="form-group">
        <label for="nama_kedudukan" class="col-sm-3">Nama Pemilik</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '<input type="text" name="nama_pemilik" id="nama_pemilik" class="form-control" placeholder="Nama Pemilik" />';
            elseif(isset($_GET['edit'])):
                echo '<input type="text" name="nama_pemilik" id="nama_pemilik" class="form-control" value="'.$nama_pemilik.'" />';
            else:
                echo '<input type="text" name="nama_pemilik" readonly id="nama_pemilik" class="form-control" value="'.$nama_pemilik.'" />';
            endif;
            ?>
            <div id="msgnama"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-9 col-sm-offset-3">
            <?php
                if(isset($_GET['add'])):
                    echo "<button type='submit' id='add' class='btn btn-primary'><i class='fa fa-plus'></i> Tambah</button>";
                elseif(isset($_GET['edit'])):
                    echo "<input type='hidden' id='key' name='key' value='$id' />";
                    echo '<input type="hidden" name="nama_pemilik_lama" id="nama_pemilik_lama" class="form-control" value="'.$nama_pemilik.'" />';
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