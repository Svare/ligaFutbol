<?php

	session_start();

	if (isset($_SESSION['administrador'])) {
		require 'views/administrador.view.php';
	} else {
		header('Location: login.php');
	}

?>