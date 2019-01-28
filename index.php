<?php
session_start();
if(isset($_SESSION['login'])!=""):
  header("Location: main.php");
endif;
?>
<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<title>Login Santi Jaya</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	
    <!-- CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/vendor/icon-sets.css">
	<link rel="stylesheet" href="assets/css/main.min.css">
	<link rel="stylesheet" href="assets/css/demo.css">
	
    <!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	
    <!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">

    <!-- JS -->
    <script src="assets/js/jquery/jquery-2.1.0.min.js"></script>
    <script type="text/javascript" src="assets/js/validation.min.js"></script>
    <script type="text/javascript" src="assets/js/controller/LoginJS.js"></script>
	
	<style>
	body { 
		background: url(img/toserba.png) no-repeat center center fixed; 
		 background-size: 1710px 845px;
	}
	</style>
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<!--<div class="left">-->
						<div class="content">
                            <div id="error"></div>
							<div class="logo text-center"><h2><i class="fa fa-lock" aria-hidden="true"></i> Santi Jaya</h2></div>
							<form class="form-auth-small" action="" method="POST" id="login-form">
								<div class="form-group">
									<label for="username" class="control-label sr-only">Username</label>
									<input type="text" class="form-control" id="username" name="username" value="" placeholder="Username">
								</div>
								<div class="form-group">
									<label for="password" class="control-label sr-only">Password</label>
									<input type="password" class="form-control" name="password" id="password" value="" placeholder="Password">
								</div>
								<button type="submit" name="login" id="login" class="btn btn-primary btn-lg btn-block">LOGIN</button>
							</form>
						</div>
					<!--</div>-->
					
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
    <script src="assets/js/bootstrap/bootstrap.min.js"></script>
</body>

</html>
