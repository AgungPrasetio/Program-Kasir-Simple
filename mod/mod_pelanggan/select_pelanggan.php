<?php
session_start();
require_once "../../__class/PelangganController.php";
$pelanggancon = new PelangganController();

?>
<select name="pelanggan" id="pelanggan" onchange="changepelanggan()" class="selectize_data">
<?php
    $pelanggan = $pelanggancon->data();
    foreach($pelanggan as $K):
        if(isset($_SESSION['id_pelanggan'])):
            if($_SESSION['id_pelanggan']==$K->id):
                echo '<option value="'.$K->id.'" selected>'.$K->nama.'</option>';
            else:
                echo '<option value="'.$K->id.'">'.$K->nama.'</option>';
            endif;
        else:
            echo '<option value="'.$K->id.'">'.$K->nama.'</option>';
        endif;
    endforeach;
?>
</select>
<!-- <script src="assets/js/selectize.js"></script>
<script src="assets/js/selectizeindex.js"></script> -->
<!-- <script>
$('.selectize_data').selectize({
  sortField: {
    field: 'text',
    direction: 'asc'
  }
});
</script> -->