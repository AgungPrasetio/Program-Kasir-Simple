<?php
require_once "../../__class/MerekController.php";
$controller = new MerekController();

if(isset($_GET['add'])):
    $title = "Tambah Merek";
    $formid = "form-add";
elseif(isset($_GET['edit'])):
    $title = "Ubah Merek";
    $formid = "form-edit";
else:
    $title = "Hapus Merek";
    $formid = "form-del";
endif;

//get Data
if(!isset($_GET['add'])):
    $id = $_GET['id'];
    $getMerek = $controller->getDataByID($id);
    foreach($getMerek as $G):
        $nama_merek = $G->nama_merek;
        $id_jenis = $G->id_jenis;
        $nama_jenis = $G->nama_jenis;
    endforeach;
endif;

echo '<h2 style="font-size:22px; margin:0px; padding:0px;"><center>'.$title.'</center></h2><hr/>';
?>
<script src="assets/js/jquery/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/validation.min.js"></script>
<script type="text/javascript" src="assets/js/controller/MerekJS.js"></script>

<div id="info"></div>
<form action="" method="POST" class="form-horizontal form-label-left" id="<?php echo $formid; ?>">
    <div class="form-group">
        <label for="nama_merek" class="col-sm-3">Nama Merek</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '<input type="text" name="nama_merek" id="nama_merek" class="form-control" placeholder="Nama Merek" />';
            elseif(isset($_GET['edit'])):
                echo '<input type="text" name="nama_merek" id="nama_merek" class="form-control" value="'.$nama_merek.'" />';
            else:
                echo '<input type="text" name="nama_merek" readonly id="nama_merek" class="form-control" value="'.$nama_merek.'" />';
            endif;
            ?>
            <div id="msgnama"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="kategori" class="col-sm-3">Jenis Barang</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '<select name="jenis" id="jenis" class="selectize_data">';
                $jenis = $controller->SelectJenis();
                foreach($jenis as $K):
                    echo '<option value="'.$K->id.'">'.$K->nama_jenis_barang.'</option>';
                endforeach;
                echo '</select>';
            elseif(isset($_GET['edit'])):
                echo '<select name="jenis" id="jenis" class="selectize_data">';
                $jenis = $controller->SelectJenis();
                foreach($jenis as $K):
                    if($id_jenis==$K->id):
                        echo '<option value="'.$K->id.'" selected="selected">'.$K->nama_jenis_barang.'</option>';
                    else:
                        echo '<option value="'.$K->id.'">'.$K->nama_jenis_barang.'</option>';
                    endif;
                    
                endforeach;
                echo '</select>';
            else:
                echo '<input type="text" name="jenis" readonly id="jenis" class="form-control" value="'.$nama_jenis.'" />';
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
                    echo '<input type="hidden" name="nama_merek_lama" id="nama_merek_lama" class="form-control" value="'.$nama_merek.'" />';
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