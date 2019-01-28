$('document').ready(function () {
    /* validation add */
    $("#form-add").validate({
        rules: {
            jenis_pengeluaran:{
                required: true,
                minlength: 4,
                maxlength: 60,
            },
            tanggal: {
                required: true,
            },
            nominal: {
                required: true,
                number:true,
            }
        },
        submitHandler: formAdd
    });
    /* validation add */

    /* Add */
    function formAdd() {
        var data = $("#form-add").serialize();

        // alert(data);

        $.ajax({
            type : 'POST',
            url  : '__class/action/ActionPengeluaran.php?add',
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
                }else{
                    $("#info").fadeIn(1000, function(){
                        $("#info").html('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> &nbsp; '+response+' !</div>');
                        $("#add").html('<i class="fa fa-plus"></i> Tambah');
                    });
                }
            }
        });

        return false;
    }

    function addSuccess(){
        $("#form").load("mod/mod_pengeluaran/form.php?add");
        $("#select").load("mod/mod_pengeluaran/select.php?add");
    }


    /* validation edit */
    $("#form-edit").validate({
        rules: {
            jenis_pengeluaran:{
                required: true,
                minlength: 4,
                maxlength: 60,
            },
            tanggal: {
                required: true,
            },
            nominal: {
                required: true,
                number:true,
            }
        },
        submitHandler: formEdit
    });
    /* validation add */

    /* Edit */
    function formEdit() {
        var data = $("#form-edit").serialize();

        $.ajax({
            type : 'POST',
            url  : '__class/action/ActionPengeluaran.php?edit',
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
                }else{
                    $("#info").fadeIn(1000, function(){
                        $("#info").html('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> &nbsp; '+response+' !</div>');
                        $("#edit").html('<i class="fa fa-pencil"></i> Ubah');
                    });
                }
            }
        });

        return false;
    }

    function editSuccess(){
        $("#form").load("mod/mod_pengeluaran/form.php?add");
        $("#select").load("mod/mod_pengeluaran/select.php?edit");
    }

    // $("#form-del").validate({
    //     submitHandler: formDelete
    // });

    /* Edit */
    // function formDelete() {
    //     var data = $("#form-del").serialize();

    //     $.ajax({
    //         type : 'POST',
    //         url  : '__class/action/ActionJenisBarang.php?delete',
    //         data : data,
    //         beforeSend: function()
    //         {
    //             $("#info").fadeOut();
    //             $("#del").html('<i class="fa fa-exchange" aria-hidden="true"></i> &nbsp;mengirimkan ...');
    //         },
    //         success :  function(response)
    //         {
    //             if(response=="ok"){
    //                 $("#del").html('<i class="fa fa-spinner fa-spin "></i> &nbsp; Sedang menunggu ...');
                    
    //                 deleteSuccess();
    //             }else{
    //                 $("#info").fadeIn(1000, function(){
    //                     $("#info").html('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> &nbsp; '+response+' !</div>');
    //                     $("#del").html('<i class="fa fa-trash"></i> Hapus');
    //                 });
    //             }
    //         }
    //     });

    //     return false; 
    // }

    // function deleteSuccess(){
    //     $("#form").load("mod/mod_jenis_barang/form.php?add");
    //     $("#select").load("mod/mod_jenis_barang/select.php?del");
    // }

});