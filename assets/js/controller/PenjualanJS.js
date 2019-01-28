$('document').ready(function () {
    /* validation add */
    $("#form-add").validate({
        submitHandler: formAdd
    });
    /* validation add */

    /* Add */
    function formAdd() {
        var data = $("#form-add").serialize();

        console.log(data);

        $.ajax({
            type : 'POST',
            url  : '__class/action/ActionPenjualan.php?addSession',
            data : data,
            beforeSend: function()
            {
                $("#info").fadeOut();
                $("#add").html('<i class="fa fa-exchange" aria-hidden="true"></i> &nbsp;mengirimkan ...');
            },
            success :  function(response)
            {
                console.log(response);
                if(response=="ok"){
                    $("#add").html('<i class="fa fa-spinner fa-spin "></i> &nbsp; Sedang menunggu ...');
                    
                    addSuccess();
                }else if(response=="available"){
                    // alert("sudah ada");
                    document.forms['transaksi'].elements['kode_barang'].value="";
                    $("#info").fadeIn(300, function(){
                        $("html, body").animate({
                            scrollTop: 0
                        }, "fast");
                        $("#info").html('<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <i class="fa fa-exclamation-circle" aria-hidden="true"></i> &nbsp; Barang sudah ada pada transaksi!</div>');
                        $("#add").html('<i class="fa fa-plus"></i> Tambah');
                    });
                }else if(response=="notavailable"){
                    // alert("sudah ada");
                    document.forms['transaksi'].elements['kode_barang'].value="";
                    $("#info").fadeIn(300, function(){
                        $("html, body").animate({
                            scrollTop: 0
                        }, "fast");
                        $("#info").html('<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <i class="fa fa-exclamation-circle" aria-hidden="true"></i> &nbsp; Kode barang tidak ditemukan!</div>');
                        $("#add").html('<i class="fa fa-plus"></i> Tambah');
                    });
                }else{
                    // alert(response);
                    $("#info").fadeIn(300, function(){
                        $("html, body").animate({
                            scrollTop: 0
                        }, "fast");
                        $("#info").html('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> &nbsp; '+response+' !</div>');
                        $("#add").html('<i class="fa fa-plus"></i> Tambah');
                    });
                }
            }
        });

        return false;
    }

    function addSuccess(){
        // document.forms['transaksi'].elements['kode_barang'].focus();
        $("html, body").animate({ scrollTop: $(document).height() }, 300);
        $("#form").load("mod/mod_penjualan/form.php");
        $("#select").load("mod/mod_penjualan/select.php");
    }

});