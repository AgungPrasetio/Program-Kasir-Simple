$('document').ready(function () {
    /* validation add */
    $("#form-add").validate({
        rules: {
            nama_pemasok: {
                required: true,
                minlength: 3,
                maxlength: 100,
            },
            telpon_pemasok: {
                required: true,
                digits: true,
                minlength: 9,
                maxlength: 15,
            },
            alamat_pemasok: {
                minlength: 3,
                maxlength: 150,
            },
        },
        submitHandler: formAdd
    });
    /* validation add */

    /* Add */
    function formAdd() {
        var data = $("#form-add").serialize();

        $.ajax({
            type : 'POST',
            url  : '__class/action/ActionPemasok.php?add',
            data : data,
            beforeSend: function()
            {
                $("#info").fadeOut();
                $("#add").html('<i class="fa fa-exchange" aria-hidden="true"></i> &nbsp;mengirimkan ...');
            },
            success :  function(response)
            {
                if(response=="ok"){
                    $("#add").html('<i class="fa fa-spinner fa-spin "></i> &nbsp; Sedang menunggu ...');
                    
                    addSuccess();
                }else if(response=="available"){
                    $("#info").fadeIn(300, function(){
                        $("html, body").animate({
                            scrollTop: 0
                        }, "fast");
                        $("#info").html('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> &nbsp; Data sudah ada pada database!</div>');
                        $("#add").html('<i class="fa fa-plus"></i> Tambah');
                    });
                }else{
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
        $("#form").load("mod/mod_pemasok/form.php?add");
        $("#select").load("mod/mod_pemasok/select.php?add");
    }


    /* validation edit */
    $("#form-edit").validate({
        rules: {
            nama_pemasok: {
                required: true,
                minlength: 3,
                maxlength: 100,
            },
            telpon_pemasok: {
                required: true,
                digits: true,
                minlength: 9,
                maxlength: 15,
            },
            alamat_pemasok: {
                minlength: 3,
                maxlength: 150,
            },
        },
        submitHandler: formEdit
    });
    /* validation add */

    /* Edit */
    function formEdit() {
        var data = $("#form-edit").serialize();

        $.ajax({
            type : 'POST',
            url  : '__class/action/ActionPemasok.php?edit',
            data : data,
            beforeSend: function()
            {
                $("#info").fadeOut();
                $("#edit").html('<i class="fa fa-exchange" aria-hidden="true"></i> &nbsp;mengirimkan ...');
            },
            success :  function(response)
            {
                if(response=="ok"){
                    $("#edit").html('<i class="fa fa-spinner fa-spin "></i> &nbsp; Sedang menunggu ...');
                    
                    editSuccess();
                }else if(response=="available"){
                    $("#info").fadeIn(300, function(){
                        $("html, body").animate({
                            scrollTop: 0
                        }, "fast");
                        $("#info").html('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> &nbsp; Data sudah ada pada database!</div>');
                        $("#edit").html('<i class="fa fa-pencil"></i> Ubah');
                    });
                }else{
                    $("#info").fadeIn(300, function(){
                        $("html, body").animate({
                            scrollTop: 0
                        }, "fast");
                        $("#info").html('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> &nbsp; '+response+' !</div>');
                        $("#edit").html('<i class="fa fa-pencil"></i> Ubah');
                    });
                }
            }
        });

        return false;
    }

    function editSuccess(){
        $("#form").load("mod/mod_pemasok/form.php?add");
        $("#select").load("mod/mod_pemasok/select.php?edit");
    }

    $("#form-del").validate({
        submitHandler: formDelete
    });

    /* Edit */
    function formDelete() {
        var data = $("#form-del").serialize();

        $.ajax({
            type : 'POST',
            url  : '__class/action/ActionPemasok.php?delete',
            data : data,
            beforeSend: function()
            {
                $("#info").fadeOut();
                $("#del").html('<i class="fa fa-exchange" aria-hidden="true"></i> &nbsp;mengirimkan ...');
            },
            success :  function(response)
            {
                if(response=="ok"){
                    $("#del").html('<i class="fa fa-spinner fa-spin "></i> &nbsp; Sedang menunggu ...');
                    
                    deleteSuccess();
                }else{
                    $("#info").fadeIn(300, function(){
                        $("html, body").animate({
                            scrollTop: 0
                        }, "fast");
                        $("#info").html('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> &nbsp; '+response+' !</div>');
                        $("#del").html('<i class="fa fa-trash"></i> Hapus');
                    });
                }
            }
        });

        return false;      
    }

    function deleteSuccess(){
        $("#form").load("mod/mod_pemasok/form.php?add");
        $("#select").load("mod/mod_pemasok/select.php?del");
    }

});