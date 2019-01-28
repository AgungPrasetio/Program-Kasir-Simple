<?php
if(isset($_GET['mod'])){
    $mod = "mod_".$_GET['mod'];
}else{
    $mod = "mod_home";
}
?>
<script>
$(document).ready(function () {
    $("#form").load("mod/<?php echo $mod; ?>/form.php?add");
    $("#select").load("mod/<?php echo $mod; ?>/select.php");
});

function edit(id) {
    $("html, body").animate({
        scrollTop: 0
    }, "fast");
    $("#form").show();
    $("#form").load("mod/<?php echo $mod; ?>/form.php?edit&id=" + id);
}

function del(id) {
    $("html, body").animate({
        scrollTop: 0
    }, "fast");
    $("#form").show();
    $("#form").load("mod/<?php echo $mod; ?>/form.php?delete&id=" + id);
}

function cancel() {
    $("html, body").animate({
        scrollTop: 0
    }, "fast");
    $("#form").load("mod/<?php echo $mod; ?>/form.php?add");
    $("#select").load("mod/<?php echo $mod; ?>/select.php");
}
</script>