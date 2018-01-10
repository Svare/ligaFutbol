<?php

	session_start();

	if (isset($_SESSION['delegado'])) {
	
		require 'views/eliminarJugador.php';

	} else {
		header('Location: login.php');
	}

?>

