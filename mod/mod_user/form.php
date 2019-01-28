<?php
require_once "../../__class/UserController.php";
$controller = new UserController();

if(isset($_GET['add'])):
    $title = "Tambah User";
    $formid = "form-add";
elseif(isset($_GET['edit'])):
    $title = "Ubah User";
    $formid = "form-edit";
else:
    $title = "Hapus User";
    $formid = "form-del";
endif;

//get Data
if(!isset($_GET['add'])):
    $id = $_GET['id'];
    $getUser = $controller->getDataByID($id);
    foreach($getUser as $G):
        $nama_lengkap = $G->nama_lengkap;
        $username = $G->username;
        $status = $G->status;
        $nama_kedudukan = $G->kedudukan;
        $id_kedudukan = $G->id_kedudukan;
    endforeach;
endif;

echo '<h2 style="font-size:22px; margin:0px; padding:0px;"><center>'.$title.'</center></h2><hr/>';
?>
<script src="assets/js/jquery/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/validation.min.js"></script>
<script type="text/javascript" src="assets/js/controller/UserJS.js"></script>

<div id="info"></div>
<form action="" method="POST" class="form-horizontal form-label-left" id="<?php echo $formid; ?>">
    <div class="form-group">
        <label for="nama_lengkap" class="col-sm-3">Nama Lengkap</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '<input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" placeholder="Nama Lengkap" />';
            elseif(isset($_GET['edit'])):
                echo '<input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="'.$nama_lengkap.'" />';
            else:
                echo '<input type="text" name="nama_lengkap" readonly id="nama_lengkap" class="form-control" value="'.$nama_lengkap.'" />';
            endif;
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="username" class="col-sm-3">Username</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '<input type="text" name="username" id="username" class="form-control" placeholder="Username" />';
            elseif(isset($_GET['edit'])):
                echo '<input type="text" name="username" id="username" class="form-control" value="'.$username.'" />';
            else:
                echo '<input type="text" name="username" readonly id="username" class="form-control" value="'.$username.'" />';
            endif;
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="merek" class="col-sm-3">Kedudukan</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '<select name="kedudukan" id="kedudukan" class="form-control">';
                $kedudukan = $controller->SelectKedudukan();
                foreach($kedudukan as $K):
                    echo '<option value="'.$K->id.'">'.$K->nama_kedudukan.'</option>';
                endforeach;
                echo '</select>';
            elseif(isset($_GET['edit'])):
                echo '<select name="kedudukan" id="kedudukan" class="form-control">';
                $kedudukan = $controller->SelectKedudukan();
                foreach($kedudukan as $K):
                    if($id_kedudukan==$K->id):
                        echo '<option value="'.$K->id.'" selected="selected">'.$K->nama_kedudukan.'</option>';
                    else:
                        echo '<option value="'.$K->id.'">'.$K->nama_kedudukan.'</option>';
                    endif;
                    
                endforeach;
                echo '</select>';
            else:
                echo '<input type="text" name="kedudukan" readonly id="kedudukan" class="form-control" value="'.$nama_kedudukan.'" />';
            endif;
            ?>
            <div id="msgnama"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="status" class="col-sm-3">Status</label>
        <div class="col-sm-9">
            <?php
            if(isset($_GET['add'])):
                echo '
                    <select name="status" class="form-control">
                        <option value="A">Aktif</option>
                        <option value="T">Tidak Aktif</option>
                    </select>
                ';
            elseif(isset($_GET['edit'])):
                echo '<select name="status" class="form-control">';
                    if($status=="Aktif"):
                    echo '
                        <option value="A" selected>Aktif</option>
                        <option value="T">Tidak Aktif</option>';
                    else:
                    echo '
                        <option value="A">Aktif</option>
                        <option value="T" selected>Tidak Aktif</option>';
                    endif;
                echo '</select>';
            else:
                echo '<input type="text" name="status" readonly id="status" class="form-control" value="'.$status.'" />';
            endif;
            ?>
        </div>
    </div>
    <?php if(isset($_GET['add'])): ?>
    <div class="form-group">
        <label for="password" class="col-sm-3">Password</label>
        <div class="col-sm-9">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" />
        </div>
    </div>
    <?php endif; ?>
    <div class="form-group">
        <div class="col-sm-9 col-sm-offset-3">
            <?php
                if(isset($_GET['add'])):
                    echo "<button type='submit' id='add' class='btn btn-primary'><i class='fa fa-plus'></i> Tambah</button>";
                elseif(isset($_GET['edit'])):
                    echo "<input type='hidden' id='key' name='key' value='$id' />";
                    echo "<input type='hidden' id='username_lama' name='username_lama' value='$username' />";
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