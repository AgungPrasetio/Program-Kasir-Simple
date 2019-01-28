$('document').ready(function () {
    $('#select-pelanggan').load("mod/mod_pelanggan/select_pelanggan.php");

    $('#bayar').maskMoney({prefix:'Rp ', thousands:'.', decimal:',', precision:0});

    var harga = [];
    var qty = [];
    var potongan = [];

    $("#kembali").html("<p style='text-align:right'>Rp 0</p>");

    $("input[name='qty']").each(function(){
        qty.push(this.value);
    });

    $("input[name='harga']").each(function(){
        harga.push(this.value);
    });

    $("input[name='potongan']").each(function(){
        potongan.push(this.value);
    });

    var total_harga = [];
    var total = 0;
    var total_potongan = [];

    var sub_total = [];
    
    for(var i=0;i<qty.length;i++){
        total_harga[i] = qty[i]*harga[i];
        total_potongan[i] = qty[i]*potongan[i];
        sub_total[i] = total_harga[i]-total_potongan[i];

        $("#total_harga"+i).html("<p style='text-align:right'>Rp  "+formatRupiah(total_harga[i])+"</p>");
        $("#total_potongan"+i).html("<p style='text-align:right'>Rp  "+formatRupiah(total_potongan[i])+"</p>");
        $("#sub_total"+i).html("<p style='text-align:right'>Rp  "+formatRupiah(sub_total[i])+"</p>");

        total+=sub_total[i];
    }

    
    $("#total").html("<p style='text-align:right'>Rp "+formatRupiah(total)+"</p>");
    $("#total_after_diskon").html("<p style='text-align:right'>Rp "+formatRupiah(total)+"</p>");
    $("#totaltrans").html("Rp "+formatRupiah(total));
    $("[name=total_after_diskon]").val(total);


    //for handling transaksi
    $("#form-transaksi").validate({
        rules: {
            bayar: {
                required: true,
            },
        },
        submitHandler: formAddTrans
    });

    /* Add */
    function formAddTrans() {
        var data = $("#form-transaksi").serialize();
        // alert(data);

        console.log(data);

        $.ajax({
            type : 'POST',
            url  : '__class/action/ActionPenjualan.php?simpanTransaksi',
            data : data,
            beforeSend: function()
            {
                $("#infotrans").fadeOut();
                $("#simpantrans").html('<i class="fa fa-exchange" aria-hidden="true"></i> &nbsp;mengirimkan ...');
            },
            success :  function(response)
            {
                var res = $.parseJSON(response);

                // console.log(res);
                if(res.status=="ok"){
                    $("#simpantrans").html('<i class="fa fa-spinner fa-spin "></i> &nbsp; Sedang menunggu ...');
                    var id_penjualan = res.id_penjualan;
                    addSuccess(id_penjualan);
                }else if(res.status=="notok"){
                    // alert("sudah ada");
                    document.forms['transaksi'].elements['kode_barang'].value="";
                    $("#infotrans").fadeIn(300, function(){
                        $("html, body").animate({
                            scrollTop: 0
                        }, "fast");
                        $("#infotrans").html('<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <i class="fa fa-exclamation-circle" aria-hidden="true"></i> &nbsp; Nominal bayar tidak valid!</div>');
                        $("#simpantrans").html('Simpan Transaksi');
                    });
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


function change_potongan(){
    var potongan = [];
    var harga = [];
    var qty = [];
    var k = [];

    $("input[name='potongan']").each(function(){
        potongan.push(this.value);
    });

    $("input[name='harga']").each(function(){
        harga.push(this.value);
    });

    $("input[name='qty']").each(function(){
        qty.push(this.value);
    });

    $("input[name='k']").each(function(){
        k.push(this.value);
    });

    var total_potongan = [];
    var total_harga = [];
    var sub_total = [];
    var total = 0;

    for(var i=0;i<potongan.length;i++){
        total_harga[i] = qty[i]*harga[i];
        total_potongan[i] = qty[i]*potongan[i];
        sub_total[i] = total_harga[i]-total_potongan[i];
        $("#total_potongan"+i).html("<p style='text-align:right'>Rp  "+formatRupiah(total_potongan[i])+"</p>");
        $("#sub_total"+i).html("<p style='text-align:right'>Rp  "+formatRupiah(sub_total[i])+"</p>");
        total+=sub_total[i];
    }

    var diskon = $('[name=diskon]').val();
    var total_after_diskon = total-(total*(diskon/100));
    
    $("#total").html("<p style='text-align:right'>Rp "+formatRupiah(total)+"</p>");
    $("#total_after_diskon").html("<p style='text-align:right'>Rp "+formatRupiah(total_after_diskon)+"</p>");
    $("#totaltrans").html("Rp "+formatRupiah(total_after_diskon));
    $("[name=total_after_diskon]").val(total_after_diskon);

    var data = "qty="+qty+"&k="+k+"&potongan="+potongan+"&total="+total;

    $.ajax({
        type : 'POST',
        url  : '__class/action/ActionPenjualan.php?updatePotongan',
        data : data,
        success :  function(response){}
    });

    document.getElementById("totbayar").value=total;
    
    bayarr();
}


function change(){
    var qty = [];
    var k = [];
    var harga = [];
    var potongan = [];

    $("input[name='qty']").each(function(){
        qty.push(this.value);
    });

    $("input[name='harga']").each(function(){
        harga.push(this.value);
    });

    $("input[name='k']").each(function(){
        k.push(this.value);
    });

    $("input[name='potongan']").each(function(){
        potongan.push(this.value);
    });

    var total_potongan = [];
    var total_harga = [];
    var sub_total = [];
    var total = 0;

    for(var i=0;i<qty.length;i++){
        total_harga[i] = qty[i]*harga[i];
        total_potongan[i] = qty[i]*potongan[i];
        sub_total[i] = total_harga[i]-total_potongan[i];
        console.log(sub_total[i]);
        $("#total_harga"+i).html("<p style='text-align:right'>Rp  "+formatRupiah(total_harga[i])+"</p>");
        $("#total_potongan"+i).html("<p style='text-align:right'>Rp  "+formatRupiah(total_potongan[i])+"</p>");
        $("#sub_total"+i).html("<p style='text-align:right'>Rp  "+formatRupiah(sub_total[i])+"</p>");
        total+=sub_total[i];
    }

    var diskon = $('[name=diskon]').val();
    var total_after_diskon = total-(total*(diskon/100));
    
    $("#total").html("<p style='text-align:right'>Rp "+formatRupiah(total)+"</p>");
    $("#total_after_diskon").html("<p style='text-align:right'>Rp "+formatRupiah(total_after_diskon)+"</p>");
    $("#totaltrans").html("Rp "+formatRupiah(total_after_diskon));
    $("[name=total_after_diskon]").val(total_after_diskon);

    var data = "qty="+qty+"&k="+k+"&total="+total;

    // alert(data);

    $.ajax({
        type : 'POST',
        url  : '__class/action/ActionPenjualan.php?updateQty',
        data : data,
        success :  function(response){}
    });

    document.getElementById("totbayar").value=total;

    bayarr();
}

function bayarr(){
    var bayar = hideCharacter($('#bayar').val());
    var total = $('[name=total_after_diskon]').val();
    var kembali = bayar-total;
    if(bayar=="" || total==""){
        kembali = 0;
    }

    document.getElementById("nominalbayar").value = bayar;

    $("#kembali").html("<p style='text-align:right'>Rp "+formatRupiah(kembali)+"</p>");
}

function change_diskon(){
    var totbayar = $('[name=totbayar]').val();
    var diskon = $('[name=diskon]').val();

    var total_after_diskon = totbayar-(totbayar*(diskon/100));
    $('#total_after_diskon').html("<p style='text-align:right'>Rp "+formatRupiah(total_after_diskon)+"</p>");
    $("#totaltrans").html("Rp "+formatRupiah(total_after_diskon));
    $("[name=total_after_diskon]").val(total_after_diskon);

    var total_after_diskon = $("[name=total_after_diskon]").val();
    var bayar = hideCharacter($('#bayar').val());

    if(bayar!=""){
        var kembali = bayar-total_after_diskon;
        $("#kembali").html("<p style='text-align:right'>Rp "+formatRupiah(kembali)+"</p>");
    }
}



function hapus(i){
    var l = $('#l'+i).val();
    var hargal = $('#hargal'+i).val();
    var datas = "l="+l+"&hargal="+hargal;
    // alert(datas);
    $.ajax({
        type: "POST",
        url: "__class/action/ActionPenjualan.php?delSession",
        data: datas
    }).done(function(data){
        load();
    });
}

function addSuccess(id_penjualan){
    loadPelanggan();
    $("#form").load("mod/mod_penjualan/form.php");
    $("#select").load("mod/mod_penjualan/select.php?addSuccess&id_penjualan="+id_penjualan);
}

function load(){
    $("#select").load("mod/mod_penjualan/select.php");
}

function changepelanggan(){
    var pelanggan = $('#pelanggan').val();
    var datas = "pelanggan="+pelanggan;

    $.ajax({
        type: "POST",
        url: "__class/action/ActionPenjualan.php?changePelanggan",
        data: datas
    }).done(function(data){
        loadPelanggan();
    });

}

function loadPelanggan(){
    $("#select-pelanggan").load("mod/mod_pelanggan/select_pelanggan.php");
}


