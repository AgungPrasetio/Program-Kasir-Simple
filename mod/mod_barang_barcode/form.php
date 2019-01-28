<?php
require_once "../../__class/BarangController.php";
$controller = new BarangController();

if(isset($_GET['add'])):
    $title = "Tambah Barang";
    $formid = "form-add";
elseif(isset($_GET['edit'])):
    $title = "Ubah Barang";
    $formid = "form-edit";
else:
    $title = "Hapus Barang";
    $formid = "form-del";
endif;

//get Data
if(!isset($_GET['add'])):
    $id = $_GET['id'];
    $getBarang = $controller->getDataByID($id);
    foreach($getBarang as $G):
        $kode_barang = $G->kode_barang;
        $nama_barang = $G->nama_barang;
        $stok_barang = $G->stok_barang;
        $harga_barang = $G->harga_barang;
        $limit_stok = $G->limit_stok;
        $kode_barang = $G->kode_barang;
        $id_jenis_barang = $G->id_jenis_barang;
        $nama_jenis = $G->nama_jenis_barang;
        $id_merek = $G->id_merek;
        $nama_merek = $G->nama_merek;
        $id_kepemilikan = $G->id_kepemilikan;
        $nama_pemilik = $G->nama_pemilik;
    endforeach;
endif;

echo '<h2 style="font-size:22px; margin:0px; padding:0px;"><center>'.$title.'</center></h2><hr/>';
?>
<script type="text/javascript" src="assets/js/jquery/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/selectize.js"></script>
<script type="text/javascript" src="assets/js/validation.min.js"></script>
<script type="text/javascript" src="assets/js/controller/BarangBarcodeJS.js"></script>

<div id="info"></div>
<form action="" method="POST" class="form-horizontal form-label-left" id="<?php echo $formid; ?>">
    <div class="form-group">
        <label for="nama_jenis_barang" class="col-sm-3">Kode Barang</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '<input type="text" required name="kode_barang" id="kode_barang" class="form-control" placeholder="Kode Barang" />';
            elseif(isset($_GET['edit'])):
                echo '<input type="text" readonly name="kode_barang" id="kode_barang" class="form-control" value="'.$kode_barang.'" />';
            else:
                echo '<input type="text" name="kode_barang" readonly id="kode_barang" class="form-control" value="'.$kode_barang.'" />';
            endif;
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="nama_jenis_barang" class="col-sm-3">Nama Barang</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '<input type="text" required name="nama_barang" id="nama_barang" class="form-control" placeholder="Nama Barang" />';
            elseif(isset($_GET['edit'])):
                echo '<input type="text" name="nama_barang" id="nama_barang" class="form-control" value="'.$nama_barang.'" />';
            else:
                echo '<input type="text" name="nama_barang" readonly id="nama_barang" class="form-control" value="'.$nama_barang.'" />';
            endif;
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="jenis_barang" class="col-sm-3">Jenis Barang</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '<select name="jenis_barang" id="jenis_barang" class="form-control selectize_data">';
                $jenisbarang = $controller->SelectJenisBarang();
                foreach($jenisbarang as $K):
                    echo '<option value="'.$K->id.'">'.$K->nama_jenis_barang.'</option>';
                endforeach;
                echo '</select>';
            elseif(isset($_GET['edit'])):
                echo '<select name="jenis_barang" id="kategori" class="form-control selectize_data">';
                $jenisbarang = $controller->SelectJenisBarang();
                foreach($jenisbarang as $K):
                    if($id_jenis_barang==$K->id):
                        echo '<option value="'.$K->id.'" selected="selected">'.$K->nama_jenis_barang.'</option>';
                    else:
                        echo '<option value="'.$K->id.'">'.$K->nama_jenis_barang.'</option>';
                    endif;
                    
                endforeach;
                echo '</select>';
            else:
                echo '<input type="text" name="jenis_barang" readonly id="jenis_barang" class="form-control" value="'.$nama_jenis.'" />';
            endif;
            ?>
            <div id="msgnama"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="merek" class="col-sm-3">Merek Barang</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '<select name="merek" id="merek" class="form-control selectize_data">';
                $merek = $controller->SelectMerek();
                foreach($merek as $K):
                    echo '<option value="'.$K->id.'">'.$K->nama_merek.'</option>';
                endforeach;
                echo '</select>';
            elseif(isset($_GET['edit'])):
                echo '<select name="merek" id="merek" class="form-control">';
                $merek = $controller->SelectMerek();
                foreach($merek as $K):
                    if($id_merek==$K->id):
                        echo '<option value="'.$K->id.'" selected="selected">'.$K->nama_merek.'</option>';
                    else:
                        echo '<option value="'.$K->id.'">'.$K->nama_merek.'</option>';
                    endif;
                    
                endforeach;
                echo '</select>';
            else:
                echo '<input type="text" name="merek" readonly id="merek" class="form-control" value="'.$nama_merek.'" />';
            endif;
            ?>
            <div id="msgnama"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="merek" class="col-sm-3">Kepemilikan Barang</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '<select name="kepemilikan" id="kepemilikan" class="form-control selectize_data">';
                $kepemilikan = $controller->SelectKepemilikan();
                foreach($kepemilikan as $K):
                    echo '<option value="'.$K->id.'">'.$K->nama.'</option>';
                endforeach;
                echo '</select>';
            elseif(isset($_GET['edit'])):
                echo '<select name="kepemilikan" id="kepemilikan" class="form-control selectize_data">';
                $kepemilikan = $controller->SelectKepemilikan();
                foreach($kepemilikan as $K):
                    if($id_kepemilikan==$K->id):
                        echo '<option value="'.$K->id.'" selected="selected">'.$K->nama.'</option>';
                    else:
                        echo '<option value="'.$K->id.'">'.$K->nama.'</option>';
                    endif;
                    
                endforeach;
                echo '</select>';
            else:
                echo '<input type="text" name="kepemilikan" readonly id="kepemilikan" class="form-control" value="'.$nama_pemilik.'" />';
            endif;
            ?>
            <div id="msgnama"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="stok_barang" class="col-sm-3">Stok Barang</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '<input type="number" name="stok_barang" id="stok_barang" class="form-control" placeholder="Stok Barang" />';
            elseif(isset($_GET['edit'])):
                echo '<input type="number" name="stok_barang" id="stok_barang" class="form-control" value="'.$stok_barang.'" />';
            else:
                echo '<input type="number" name="stok_barang" readonly id="stok_barang" class="form-control" value="'.$stok_barang.'" />';
            endif;
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="limit_stok" class="col-sm-3">Limit Stok Barang</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '<input type="number" name="limit_stok" id="limit_stok" class="form-control" placeholder="Limit Stok Barang" />';
            elseif(isset($_GET['edit'])):
                echo '<input type="number" name="limit_stok" id="limit_stok" class="form-control" value="'.$limit_stok.'" />';
            else:
                echo '<input type="number" name="limit_stok" readonly id="limit_stok" class="form-control" value="'.$limit_stok.'" />';
            endif;
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="harga_barang" class="col-sm-3">Harga Barang</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '<input type="number" name="harga_barang" id="harga_barang" class="form-control" placeholder="Harga Barang" />';
            elseif(isset($_GET['edit'])):
                echo '<input type="number" name="harga_barang" id="harga_barang" class="form-control" value="'.$harga_barang.'" />';
            else:
                echo '<input type="number" name="harga_barang" readonly id="harga_barang" class="form-control" value="'.$harga_barang.'" />';
            endif;
            ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-9 col-sm-offset-3">
            <?php
                if(isset($_GET['add'])):
                    echo "<input type='hidden' id='status_barcode_awal' name='status_barcode_awal' value='1' />";
                    echo "<button type='submit' id='add' class='btn btn-primary'><i class='fa fa-plus'></i> Tambah</button>";
                elseif(isset($_GET['edit'])):
                    echo "<input type='hidden' id='key' name='key' value='$id' />";
                    echo '<input type="hidden" name="nama_barang_lama" id="nama_barang_lama" class="form-control" value="'.$nama_barang.'" />';
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