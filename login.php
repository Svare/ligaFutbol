<?php

	session_start();

	if (isset($_SESSION['administrador']) || isset($_SESSION['delegado'])) {
		header('Location: index.php');
	}

	$errores = '';

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$usuario = filter_var(strtolower($_POST['usuario']),FILTER_SANITIZE_STRING);
		$contra = $_POST['contra'];
		$contra	= hash('sha512', $contra);

		try {
			$conexion = new PDO('mysql:host=127.0.0.1;dbname=u862065767_liga','u862065767_root','rosendo');
		} catch (PDOException $e) {
			echo "Error: ".$e->message();
		}

		$statement = $conexion->prepare('SELECT * FROM usuarios WHERE usuario_nombre = :usuario AND usuario_pass = :pass');
		$statement->execute(array(
			'usuario' => $usuario,
			'pass' => $contra
		));

		$resultado = $statement->fetch();

		if ($resultado != false) { // Si no esta vacia
			if ($resultado['usuario_tipo'] == "A") { // Si es tipo administrador
				$_SESSION['administrador'] = $usuario;
				header('Location: index.php');
			} else { // Si no es tipo administrador
				$_SESSION['delegado'] = $usuario;
				header('Location: index.php');
			}
		} else {
			$errores .= '<li>Datos Incorrectos</li>';
		}
	}

	require 'views/login.view.php';

?>