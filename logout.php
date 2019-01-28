<?php
	session_start();
	unset($_SESSION['login']);

	if(session_destroy()):
		header("Location: index.php");
	endif;
?>
