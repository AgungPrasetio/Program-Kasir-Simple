<?php
session_start();
require_once "../../__class/PemasokController.php";
$pemasokcon = new PemasokController();

?>
<select name="pemasok" id="pemasok" onchange="changepemasok()" class="selectize_data">
<?php
    $pemasok = $pemasokcon->data();
    foreach($pemasok as $K):
        if(isset($_SESSION['id_pemasok'])):
            if($_SESSION['id_pemasok']==$K->id):
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