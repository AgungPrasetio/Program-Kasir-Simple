$('document').ready(function () {

    $('.required').change(function(){
		$(this).css("border", "1px solid #eaeaea");
	});

    $("form[name='search']").submit(function(){
        var error = false;
        $('form[name=search] .required').each(function(){
			var val = $(this).val();
			if(val==''){
				error = true;
				$(this).css("border","1px solid red");
			}else{
				$(this).css("border", "1px solid #eaeaea");
			}
		});
        // alert("ok");

        if(error){
            return false;
        }else{
            return true;
        }
    });
});