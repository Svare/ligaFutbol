<?php 

	session_start();

	if (isset($_SESSION['administrador'])) {

		$errores = '';
		$enviado = '';

		if ($_SERVER['REQUEST_METHOD'] == 'POST') { // REQUEST_METHOD == POST

			$torneo_nombre = $_POST['torneo_nombre'];

			// VALIDANDO QUE EXISTA NOMBRE DE TORNEO

			if (empty($torneo_nombre)) {
				$errores .= 'Porfavor ingresa un nombre para el torneo<br/>';
			} else {
				$torneo_nombre = trim($torneo_nombre);
				$torneo_nombre = filter_var($torneo_nombre,FILTER_SANITIZE_STRING);
				$torneo_nombre = strtolower($torneo_nombre);
			}

			// VALIDANDO QUE NO EXISTA UN NOMBRE DE TORNEO IGUAL

			try {
					$conexion = new PDO('mysql:host=127.0.0.1;dbname=u862065767_liga','u862065767_root','rosendo');
				} catch (PDOException $e) {
					echo "Error: ".$e->getMessage();
				}

			// GUARDAMOS LA INFORMACION DEL TORNEO EN $existeTorneo

				$consulta = $conexion->prepare('SELECT * FROM torneo WHERE torneo_nombre = :torneo');
				$consulta->execute(array(
					':torneo' => $torneo_nombre
				));

				$existeTorneo = $consulta->fetch();

				if ($existeTorneo != false) {
					$errores .= 'Ya existe un torneo con este nombre<br/>';
				}

				if ($errores == '') {

					$insertar = $conexion->prepare('INSERT INTO torneo VALUES(null,:torneo)');
					$insertar->execute(array(
						':torneo' => $torneo_nombre
					));

					?>
						<script type="text/javascript">
								alert('Se ha registrado correctamente el torneo');
								location.href='administrador.php';
						</script>

					<?php
					
				}

			
			} // FIN REQUEST_METHOD == POST
		require 'views/registrarTorneo.view.php'; // SI $_SESSION['administrador'] TIENE ALGUN VALOR
	}  else {
		header('Location: registro.php');
	}
	
?>