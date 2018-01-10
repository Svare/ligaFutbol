<?php

	session_start();

	if (isset($_SESSION['delegado'])) {
		require 'views/delegado.view.php';
	} else {
		header('Location: login.php');
	}

?>

