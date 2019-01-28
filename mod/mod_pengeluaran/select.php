<?php
require_once "../../__class/PengeluaranController.php";
$controller = new PengeluaranController();
$namekedudukan = $controller->get_kedudukan_session();

if(isset($_GET['add'])):
    echo '<div class="alert alert-success"> <i class="fa fa-check" aria-hidden="true"></i> &nbsp; Data berhasil di simpan !</div>';
elseif(isset($_GET['edit'])):
    echo '<div class="alert alert-success"> <i class="fa fa-check" aria-hidden="true"></i> &nbsp; Data berhasil di ubah !</div>';
endif;
?>
<table class="table table-bordered table-striped" id="datatable">
    <thead>
        <tr>
            <th>No</th>
            <th>Jenis Pengeluaran</th>
            <th>Keterangan</th>
            <th>Tanggal</th>
            <th>Nominal</th>
            <th>Tindakan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $data = $controller->data();
        foreach($data as $D):
            $id = $D->id;

            echo '
            <tr>
                <td>'.$D->no.'</td>
                <td>'.$D->jenis.'</td>
                <td>'.$D->keterangan.'</td>
                <td>'.$D->tanggal.'</td>
                <td>'.$D->nominal.'</td>
                <td>';
                
                if($namekedudukan=="Administrator"):
                    echo'
                        <button onclick="edit('.$id.')" class="btn btn-sm btn-primary" title="Ubah Data"><i class="fa fa-pencil"></i></button> &nbsp;';
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