<?php		
	session_start();
	session_destroy();
	session_unset();
	session_unset();
	header("Location:index.php");
	die();	
?>