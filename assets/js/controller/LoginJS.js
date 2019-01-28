$('document').ready(function()
{
  /* validation */
  $("#login-form").validate({
    rules:
    {
      password: {
        required: true,
      },
      username: {
        required: true,
      },
    },
    messages:
    {
      password:{
        required: "<p style='color:red; font-size:11px; margin:0px; padding:0px;'> Silahkan masukkan kata sandi</p>"
      },
      username: "<p style='color:red; font-size:11px; margin:0px; padding:0px;'>Silahkan masukkan NIP pegawai</p>",
    },
    submitHandler: submitForm
  });
  /* validation */

  /* login submit */
  function submitForm()
  {
    var data = $("#login-form").serialize();

    $.ajax({
      type : 'POST',
      url  : '__class/LoginController.php',
      data : data,
      beforeSend: function()
      {
        $("#error").fadeOut();
        $("#login").html('<i class="fa fa-exchange" aria-hidden="true"></i> &nbsp;mengirimkan ...');
      },
      success :  function(response)
      {
        if(response=="ok"){
          $("#login").html('<i class="fa fa-spinner fa-spin "></i> &nbsp; Sedang menunggu ...');
          setTimeout(' window.location.href = "main.php"; ',1000);
        }else{
          $("#error").fadeIn(300, function(){
            $("#error").html('<div class="alert alert-danger"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i> &nbsp; '+response+' !</div>');
            $("#login").html('LOGIN');
          });
        }
      }
    });

    return false;
  }
  /* login submit */
});
