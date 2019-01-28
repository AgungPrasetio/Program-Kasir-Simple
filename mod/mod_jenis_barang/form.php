<?php
require_once "../../__class/JenisBarangController.php";
$controller = new JenisBarangController();

if(isset($_GET['add'])):
    $title = "Tambah Jenis Barang";
    $formid = "form-add";
elseif(isset($_GET['edit'])):
    $title = "Ubah Jenis Barang";
    $formid = "form-edit";
else:
    $title = "Hapus Jenis Barang";
    $formid = "form-del";
endif;

//get Data
if(!isset($_GET['add'])):
    $id = $_GET['id'];
    $getJenisBarang = $controller->getDataByID($id);
    foreach($getJenisBarang as $G):
        $nama_jenis_barang = $G->nama_jenis_barang;
        $id_kategori = $G->kategori;
        $nama_kategori = $G->nama_kategori;
    endforeach;
endif;

echo '<h2 style="font-size:22px; margin:0px; padding:0px;"><center>'.$title.'</center></h2><hr/>';
?>
<script type="text/javascript" src="assets/js/jquery/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/selectize.js"></script>
<script type="text/javascript" src="assets/js/validation.min.js"></script>
<script type="text/javascript" src="assets/js/controller/JenisBarangJS.js"></script>

<div id="info"></div>
<form action="" method="POST" class="form-horizontal form-label-left" id="<?php echo $formid; ?>">
    <div class="form-group">
        <label for="id_jenis_barang" class="col-sm-4">Kode Jenis Barang</label>
        <div class="col-sm-8">
            <?php
            if(isset($_GET['add'])):
                echo '<input type="text" name="id_jenis_barang" id="id_jenis_barang" class="form-control" value="'.$controller->SetKodeJenis().'" readonly />';
            elseif(isset($_GET['edit'])):
                echo '<input type="text" name="id_jenis_barang" id="id_jenis_barang" readonly class="form-control" value="'.$id.'" />';
            else:
                echo '<input type="text" name="id_jenis_barang" readonly id="id_jenis_barang" class="form-control" value="'.$id.'" />';
            endif;
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="nama_jenis_barang" class="col-sm-4">Nama Jenis Barang</label>
        <div class="col-sm-8">
            <?php
            if(isset($_GET['add'])):
                echo '<input type="text" name="nama_jenis_barang" id="nama_jenis_barang" class="form-control" placeholder="Nama Jenis Barang" />';
            elseif(isset($_GET['edit'])):
                echo '<input type="text" name="nama_jenis_barang" id="nama_jenis_barang" class="form-control" value="'.$nama_jenis_barang.'" />';
            else:
                echo '<input type="text" name="nama_jenis_barang" readonly id="nama_jenis_barang" class="form-control" value="'.$nama_jenis_barang.'" />';
            endif;
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="kategori" class="col-sm-4">Kategori</label>
        <div class="col-sm-8">
            <?php
            if(isset($_GET['add'])):
                $kategori = $controller->SelectKategori();
                echo '<select name="kategori" id="kategori" class="selectize_data">';
                foreach($kategori as $K):
                    echo '<option value="'.$K->id.'">'.$K->nama_kategori.'</option>';
                endforeach;
                echo '</select>';
            elseif(isset($_GET['edit'])):
                echo '<select name="kategori" id="kategori" class="selectize_data">';
                $kategori = $controller->SelectKategori();
                foreach($kategori as $K):
                    if($id_kategori==$K->id):
                        echo '<option value="'.$K->id.'" selected="selected">'.$K->nama_kategori.'</option>';
                    else:
                        echo '<option value="'.$K->id.'">'.$K->nama_kategori.'</option>';
                    endif;
                    
                endforeach;
                echo '</select>';
            else:
                echo '<input type="text" name="kategori" readonly id="kategori" class="form-control" value="'.$nama_kategori.'" />';
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
                    echo '<input type="hidden" name="nama_jenis_barang_lama" id="nama_jenis_barang_lama" class="form-control" value="'.$nama_jenis_barang.'" />';
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
<script src="assets/js/selectizeindex.js"></script>
<script>
$('.selectize_data').selectize({
  sortField: {
    field: 'text',
    direction: 'asc'
  }
});
</script>