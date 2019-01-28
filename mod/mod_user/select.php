<?php
require_once "../../__class/UserController.php";
$controller = new UserController();

if(isset($_GET['add'])):
    echo '<div class="alert alert-success"> <i class="fa fa-check" aria-hidden="true"></i> &nbsp; Data berhasil di simpan !</div>';
elseif(isset($_GET['edit'])):
    echo '<div class="alert alert-success"> <i class="fa fa-check" aria-hidden="true"></i> &nbsp; Data berhasil di ubah !</div>';
elseif(isset($_GET['del'])):
    echo '<div class="alert alert-success"> <i class="fa fa-check" aria-hidden="true"></i> &nbsp; Data berhasil di hapus !</div>';
endif;
?>
<table class="table table-bordered table-striped" id="datatable">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Lengkap</th>
            <th>Username</th>
            <th>Kedudukan</th>
            <th>Status</th>
            <th>Tindakan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $data = $controller->data();
        foreach($data as $D):
            $id = $D->id;

            //count relation of kedudukan
            // $count = $controller->count($id);

            echo '
            <tr>
                <td>'.$D->no.'</td>
                <td>'.$D->nama_lengkap.'</td>
                <td>'.$D->username.'</td>
                <td>'.$D->kedudukan.'</td>
                <td>'.$D->status.'</td>
                <td>
                    <button onclick="edit('.$id.')" class="btn btn-sm btn-primary" title="Ubah Data"><i class="fa fa-pencil"></i></button>
            ';
                // if($count<=0):
                    echo '<button onclick="del('.$id.')" class="btn btn-sm btn-danger" title="Hapus Data"><i class="fa fa-trash"></i></button>';
                // endif;
                    
            echo '
                </td>
            </tr>
            ';
        endforeach;
        ?>
    </tbody>
</table>
<?php
include_once "../../datatablejs.php";
?>