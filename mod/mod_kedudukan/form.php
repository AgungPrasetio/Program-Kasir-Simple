<?php
require_once "../../__class/KedudukanController.php";
$controller = new KedudukanController();

if(isset($_GET['add'])):
    $title = "Tambah Kedudukan";
    $formid = "form-add";
elseif(isset($_GET['edit'])):
    $title = "Ubah Kedudukan";
    $formid = "form-edit";
else:
    $title = "Hapus Kedudukan";
    $formid = "form-del";
endif;

//get Data
if(!isset($_GET['add'])):
    $id = $_GET['id'];
    $getKedudukan = $controller->getDataByID($id);
    foreach($getKedudukan as $G):
        $nama_kedudukan = $G->nama_kedudukan;
    endforeach;
endif;

echo '<h2 style="font-size:22px; margin:0px; padding:0px;"><center>'.$title.'</center></h2><hr/>';
?>
<script src="assets/js/jquery/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/validation.min.js"></script>
<script type="text/javascript" src="assets/js/controller/KedudukanJS.js"></script>

<div id="info"></div>
<form action="" method="POST" class="form-horizontal form-label-left" id="<?php echo $formid; ?>">
    <div class="form-group">
        <label for="nama_kedudukan" class="col-sm-3">Nama Kedudukan</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '<input type="text" name="nama_kedudukan" id="nama_kedudukan" class="form-control" placeholder="Nama Kedudukan" />';
            elseif(isset($_GET['edit'])):
                echo '<input type="text" name="nama_kedudukan" id="nama_kedudukan" class="form-control" value="'.$nama_kedudukan.'" />';
            else:
                echo '<input type="text" name="nama_kedudukan" readonly id="nama_kedudukan" class="form-control" value="'.$nama_kedudukan.'" />';
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
                    echo '<input type="hidden" name="nama_kedudukan_lama" id="nama_kedudukan_lama" class="form-control" value="'.$nama_kedudukan.'" />';
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