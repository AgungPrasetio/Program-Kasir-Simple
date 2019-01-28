<?php
require_once "../../__class/SatuanBarangController.php";
$controller = new SatuanBarangController();
$namekedudukan = $controller->get_kedudukan_session();

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
            <th>Nama Satuan barang</th>
            <th>Tindakan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $data = $controller->data();
        foreach($data as $D):
            $id = $D->id;

            //count relation of $kategori
            $count = $controller->count($id);

            echo '
            <tr>
                <td>'.$D->no.'</td>
                <td>'.$D->nama_satuan_barang.'</td>
                <td>';
                
                if($namekedudukan=="Administrator"):
                    echo'
                        <button onclick="edit('.$id.')" class="btn btn-sm btn-primary" title="Ubah Data"><i class="fa fa-pencil"></i></button> &nbsp;';
                    if($count<=0):
                        echo '<button onclick="del('.$id.')" class="btn btn-sm btn-danger" title="Hapus Data"><i class="fa fa-trash"></i></button>';
                    endif;
                else:
                    echo "-";
                endif;
                    
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