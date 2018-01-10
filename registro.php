<?php

	session_start();

	if (isset($_SESSION['administrador']) || isset($_SESSION['delegado'])) {
		header('Location: index.php');
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$usuario = filter_var(strtolower($_POST['usuario']),FILTER_SANITIZE_STRING);

		$contra = $_POST['contra'];
		$contra2 = $_POST['contra2'];

		//echo "$usuario . $contra . $contra2";

		$errores = '';

		if (empty($usuario) or empty($contra) or empty($contra2)) {
			$errores .= '<li>Por favor rellena todos los campos correctamente</li>';
		} else {
			try {
				$conexion = new PDO('mysql:host=127.0.0.1;dbname=u862065767_liga','u862065767_root','rosendo');
			} catch (PDOException $e) {
				echo "Error: ".$e->getMessage();
			}

			// Verificamos que no exista ya un usuario con el mismo nombre

			$statement = $conexion->prepare('SELECT * FROM usuarios WHERE usuario_nombre = :usuario LIMIT 1');
			$statement->execute(array(':usuario' => $usuario));
			$resultado = $statement->fetch();

			if ($resultado != false) {
				$errores .= '<li>El nombre de usuario ya existe</li>';
			}

			// Fin verificacion

			// Verificacion de contraseñas

			$contra = hash('sha512',$contra);
			$contra2 = hash('sha512',$contra2);

			if ($contra != $contra2) {
				$errores .= '<li>Las contraseñas deben ser iguales</li>';
			}

		}

		if ($errores == '') {
			$statement = $conexion->prepare('INSERT INTO usuarios VALUES(null,:usuario,:pass,:tipo,"F")');
			$statement->execute(array(
				':usuario' => $usuario,
				':pass' => $contra,
				':tipo' => "D"
			));

			header('Location: login.php');
		}
	}

	require 'views/registro.view.php';
?> 