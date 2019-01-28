<?php
require_once "../../__class/BarangController.php";
$controller = new BarangController();
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
            <th width="10px">No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Stok</th>
            <th>Harga Barang</th>
            <th>Jenis Barang</th>
            <th>Merek</th>
            <th width="135px">Tindakan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $data = $controller->data();
        foreach($data as $D):
            $id = $D->kode_barang;

            //count relation of $kategori
            $count = $controller->count($id);

            //harga barang sesuai hpp
            $harga = $controller->set_harga_jual($id);
            if(is_nan($harga)){
                $harga = $D->harga_barang;
            }

            echo '
            <tr>
                <td>'.$D->no.'</td>
                <td>'.$id.'</td>
                <td>'.$D->nama_barang.'</td>
                <td>'.$controller->get_stok_akhir($id).'</td>
                <td>Rp '.number_format($harga,0).'</td>
                <td>'.$D->nama_jenis_barang.'</td>
                <td>'.$D->nama_merek.'</td>
                <td>
            ';

            if($namekedudukan!="Administrator"):
                echo '
                    <a href="cetakbarcode.php?kode='.$id.'" target="_blank" class="btn btn-sm btn-default"><i class="fa fa-barcode" aria-hidden="true"></i> </a>';
            else:
                echo'
                        <button onclick="edit('.$id.')" class="btn btn-sm btn-primary" title="Ubah Data"><i class="fa fa-pencil"></i></button>&nbsp;';
                    if($count<=0):
                        echo '<button onclick="del('.$id.')" class="btn btn-sm btn-danger" title="Hapus Data"><i class="fa fa-trash"></i></button>&nbsp;';
                        
                    endif;
                    echo '
                        <a href="cetakbarcode.php?kode='.$id.'" target="_blank" class="btn btn-sm btn-default"><i class="fa fa-barcode" aria-hidden="true"></i> </a>';
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