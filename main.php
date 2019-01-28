<?php
// error_reporting(0);
session_start();
if(!isset($_SESSION['login'])):
	header("Location: index.php");
endif;
require_once "__class/db.php";
$dbase = new db();
$namapgw = $_SESSION['nama'];

$kedudukanpgw = $_SESSION['kedudukan'];
//get nama kedudukan
$namekedudukan = $dbase->kedudukan_session($kedudukanpgw);

?>
<!doctype html>
<html lang="en">

<head>
	<title>Santi Jaya</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/vendor/icon-sets.css">
	<link rel="stylesheet" href="assets/css/main.min.css">
	<link href="assets/css/jquery.dataTables.css" rel="stylesheet">
	<link href="assets/css/dataTables.bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/js/datepicker/datepicker3.css">
  	<link rel="stylesheet" href="assets/js/daterangepicker/daterangepicker.css">
	
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="assets/css/demo.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">

	<script src="assets/js/jquery/jquery-2.1.0.min.js"></script>
	<script src="assets/js/bootstrap/bootstrap.min.js"></script>
	
	<script src="assets/js/chart.min.js"></script>

</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- SIDEBAR -->
		<div class="sidebar">
			<div class="brand">
				<a href="index.html">
					<h2 style="margin:0px; padding:0px; color:white; font-size:24px;">Santi Jaya</h2>
					<!--<img src="assets/img/logo.png" alt="Klorofil Logo" class="img-responsive logo">-->
				</a>
			</div>
			<div class="sidebar-scroll">
				<?php include_once "menu.php"; ?>
			</div>
		</div>
		<!-- END SIDEBAR -->

		<!-- MAIN -->
		<div class="main">
			<!-- NAVBAR -->
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-btn">
						<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
					</div>
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-menu">
							<span class="sr-only">Toggle Navigation</span>
							<i class="fa fa-bars icon-nav"></i>
						</button>
					</div>
					<div id="navbar-menu" class="navbar-collapse collapse">
						<ul class="nav navbar-nav navbar-right">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span><?php echo $namapgw; ?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
								<ul class="dropdown-menu">
									<li><a href="logout.php"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>
			<!-- END NAVBAR -->

			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<?php
					if(empty($_GET['mod'])):
						include'mod/mod_home/default.php'; 
					elseif($_GET['mod']=='user'):
						include'mod/mod_user/default.php';
					elseif($_GET['mod']=='kedudukan'):
						include'mod/mod_kedudukan/default.php';
					elseif($_GET['mod']=='kepemilikan'):
						include'mod/mod_kepemilikan/default.php';
					elseif($_GET['mod']=='merek'):
						include'mod/mod_merek/default.php';
					elseif($_GET['mod']=='kategori'): 
						include'mod/mod_kategori/default.php';
					elseif($_GET['mod']=='jenis_barang'): 
						include'mod/mod_jenis_barang/default.php';
					elseif($_GET['mod']=='pelanggan'): 
						include'mod/mod_pelanggan/default.php';
					elseif($_GET['mod']=='barang'): 
						include'mod/mod_barang/default.php';
					elseif($_GET['mod']=='barang_barcode'): 
						include'mod/mod_barang_barcode/default.php';
					elseif($_GET['mod']=='satuan_barang'): 
						include'mod/mod_satuan_barang/default.php';
					elseif($_GET['mod']=='pemasok'): 
						include'mod/mod_pemasok/default.php';
					elseif($_GET['mod']=='penjualan'): 
						include'mod/mod_penjualan/default.php';
					elseif($_GET['mod']=='history_penjualan'): 
						include'mod/mod_history_penjualan/default.php';
					elseif($_GET['mod']=='pembelian'): 
						include'mod/mod_pembelian/default.php';
					elseif($_GET['mod']=='history_pembelian'): 
						include'mod/mod_history_pembelian/default.php';
					elseif($_GET['mod']=='laba_rugi'): 
						include'mod/mod_laba_rugi/default.php';
					elseif($_GET['mod']=='laba_bersih'): 
						include'mod/mod_laba_bersih/default.php';
					elseif($_GET['mod']=='pengeluaran'): 
						include'mod/mod_pengeluaran/default.php';
					elseif($_GET['mod']=='lap_penjualan'): 
						include'mod/mod_lap_penjualan/default.php';
					elseif($_GET['mod']=='stok_barang_habis'): 
						include'mod/mod_stok_barang_habis/default.php';
					elseif($_GET['mod']=='keuntungan_barang'): 
						include'mod/mod_keuntungan_barang/default.php';
					else:
						include'mod/mod_home/default.php';
					endif;
					?>
				</div>
			</div>
			<!-- END MAIN CONTENT -->
			<footer>
				<div class="container-fluid">
					<p class="copyright">&copy; 2017. Santi Jaya</a></p>
				</div>
			</footer>
		</div>
		<!-- END MAIN -->
	</div>
	<!-- END WRAPPER -->
	
	<?php
	// Script Function js
	include "scriptjs.php";
	?>
	<!-- Javascript -->
	<script src="assets/js/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/js/plugins/jquery-easypiechart/jquery.easypiechart.min.js"></script>
	<script src="assets/js/plugins/chartist/chartist.min.js"></script>
	<script src="assets/js/klorofil.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
	<script src="assets/js/daterangepicker/daterangepicker.js"></script>
	<script src="assets/js/datepicker/bootstrap-datepicker.js"></script>
	<script>
	$('#tanggal_trans').daterangepicker({
		locale: {
			format: 'YYYY-MM-DD'
		}
	});

	$("#bulan").datepicker({
		format: "mm-yyyy",
		viewMode: "months", 
		minViewMode: "months"
	});

	$("#tahun").datepicker({
		format: "yyyy",
		viewMode: "years", 
		minViewMode: "years"
	});
	</script>
	
</body>

</html>