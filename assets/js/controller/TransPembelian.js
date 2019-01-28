$('document').ready(function () {
    $('#select-pemasok').load("mod/mod_pemasok/select_pemasok.php");
    var hargabeli = [];
    var qty = [];

    $("input[name='qty']").each(function(){
        qty.push(this.value);
    });

    $("input[name='hargabeli']").each(function(){
        hargabeli.push(this.value);
    });

    var subtotal = [];
    var total = 0;
    
    for(var i=0;i<qty.length;i++){
        subtotal[i] = qty[i]*hargabeli[i];
        $("#subtotal"+i).html("<p style='text-align:right'>Rp  "+formatRupiah(subtotal[i])+"</p>");
        total+=subtotal[i];
    }

    
    $("#total").html("<p style='text-align:right'>Rp "+formatRupiah(total)+"</p>");
    $("#totaltrans").html("Rp "+formatRupiah(total));


    //for handling transaksi
    $("#form-pembelian").validate({
        submitHandler: formAddTrans
    });

    /* Add */
    function formAddTrans() {
        var data = $("#form-pembelian").serialize();
        // alert(data);

        $.ajax({
            type : 'POST',
            url  : '__class/action/ActionPembelian.php?simpanTransaksi',
            data : data,
            beforeSend: function()
            {
                $("#infotrans").fadeOut();
                $("#simpantrans").html('<i class="fa fa-exchange" aria-hidden="true"></i> &nbsp;mengirimkan ...');
            },
            success :  function(response)
            {
                if(response=="ok"){
                    $("#simpantrans").html('<i class="fa fa-spinner fa-spin "></i> &nbsp; Sedang menunggu ...');
                    addSuccess();
                 }else{
                    // alert(response);
                    $("#infotrans").fadeIn(300, function(){
                        $("html, body").animate({
                            scrollTop: 0
                        }, "fast");
                        $("#infotrans").html('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> &nbsp; '+response+' !</div>');
                        $("#simpantrans").html('Simpan Transaksi');
                    });
                }
            }
        });

        return false;
    }
});


function change(){
    var qty = [];
    var hargabeli = [];
    var k = [];

    $("input[name='qty']").each(function(){
        qty.push(this.value);
    });

    $("input[name='hargabeli']").each(function(){
        hargabeli.push(this.value);
    });

    $("input[name='k']").each(function(){
        k.push(this.value);
    });

    var subtotal = [];
    var total = 0;

    for(var i=0;i<qty.length;i++){
        subtotal[i] = qty[i]*hargabeli[i];
        $("#subtotal"+i).html("<p style='text-align:right'>Rp  "+formatRupiah(subtotal[i])+"</p>");
        total+=subtotal[i];
    }
    
    $("#total").html("<p style='text-align:right'>Rp "+formatRupiah(total)+"</p>");
    $("#totaltrans").html("Rp "+formatRupiah(total));

    var data = "qty="+qty+"&k="+k+"&total="+total;

    // alert(data);

    $.ajax({
        type : 'POST',
        url  : '__class/action/ActionPembelian.php?updateQty',
        data : data,
        success :  function(response){}
    });

    document.getElementById("totbayar").value=total;

    setHarga();
}

function setHarga(){
    var harga = hideCharacter($('#harga').val());

    document.getElementById("nominalharga").value = harga;
}

function hapus(i){
    var l = $('#l'+i).val();
    var hargal = $('#hargal'+i).val();
    var datas = "l="+l+"&hargal="+hargal;
    // alert(datas);
    $.ajax({
        type: "POST",
        url: "__class/action/ActionPembelian.php?delSession",
        data: datas
    }).done(function(data){
        load();
    });
}

function addSuccess(){
    loadPemasok();
    $("#form").load("mod/mod_pembelian/form.php");
    $("#select").load("mod/mod_pembelian/select.php?addSuccess");
}

function load(){
    $("#select").load("mod/mod_pembelian/select.php");
}

function changepemasok(){
    var pemasok = $('#pemasok').val();
    var datas = "pemasok="+pemasok;

    $.ajax({
        type: "POST",
        url: "__class/action/ActionPembelian.php?changePemasok",
        data: datas
    }).done(function(data){
        loadPemasok();
    });

}

function loadPemasok(){
    $("#select-pemasok").load("mod/mod_pemasok/select_pemasok.php");
}


