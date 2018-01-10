<?php 

	session_start();

	if (isset($_SESSION['administrador'])) {
		header('Location: administrador.php');
	} elseif (isset($_SESSION['delegado'])) {
		header('Location: delegado.php');
	} else {
		header('Location: registro.php');
	}
	
?>