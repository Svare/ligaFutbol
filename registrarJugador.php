<?php

	session_start();

	if (isset($_SESSION['delegado'])) {

		try {
				$conexion = new PDO('mysql:host=127.0.0.1;dbname=u862065767_liga','u862065767_root','rosendo');
			} catch (PDOException $e) {
				echo "Error: ".$e->getMessage();
			}


			$statement = $conexion->prepare('SELECT * FROM usuarios WHERE usuario_nombre = :usuario');
			$statement->execute(array(
				':usuario' => $_SESSION['delegado']
			));

			$resultado = $statement->fetch();

			if ($resultado['usuario_tiene_equipo'] == 'F') {
				require 'errores/noTieneEquipo.php';
			} else { // Si no tiene equipo
				$errores = ''; // Va guardado los errores
				$enviado = ''; // Cuando todo es correcto se pone en true
				
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$nombreJugador = $_POST['nombreJugador'];
					$apPatJugador = $_POST['apPatJugador'];
					$apMatJugador = $_POST['apMatJugador'];
					$fechaNacJugador = $_POST['fechaNacJugador'];
				
					if (!empty($nombreJugador)) { // Si en nombre del jugador no esta vacio
						$nombreJugador = trim($nombreJugador);
						$nombreJugador = filter_var($nombreJugador,FILTER_SANITIZE_STRING);
						$nombreJugador = strtolower($nombreJugador);
					} else {
						$errores .= "Por favor ingresar un nombre <br/>";
					}

					if (!empty($apPatJugador)) { // Si el apellido paterno no esta vacio
						$apPatJugador = trim($apPatJugador);
						$apPatJugador = filter_var($apPatJugador,FILTER_SANITIZE_STRING);
						$apPatJugador = strtolower($apPatJugador);
					} else {
						$errores .= "Por favor ingresar apellido paterno <br/>";
					}

					if (!empty($apMatJugador)) { // Si el apellido materno no esta vacio
						$apMatJugador = trim($apMatJugador);
						$apMatJugador = filter_var($apMatJugador,FILTER_SANITIZE_STRING);
						$apMatJugador = strtolower($apMatJugador);
					} else {
						$errores .= "Por favor ingresar apellido materno <br/>";
					}

					if (empty($fechaNacJugador)) { // Si la fecha de nacimiento esta vacia
						$errores .= "Por favor ingresar fecha de nacimiento <br/>";
					}

					// VALIDAR QUE EL JUGADOR NO EXISTA YA

					$checarJugador = $conexion->prepare('SELECT * FROM jugador 
															WHERE jugador_nombre = :nombre AND
															jugador_ap_pat = :apPat AND
															jugador_ap_mat = :apMat');
					$checarJugador->execute(array(
						':nombre' => $nombreJugador,
						':apPat' => $apPatJugador,
						':apMat' => $apMatJugador
					));

					$existeJugador = $checarJugador->fetch();

					if ($existeJugador != false) {
						$errores .= 'El jugador ya fue registrado anteriormente<br/>';
					}

					if ($errores == '') {

						$usuario_equipo = $conexion->prepare('SELECT e.equipo_id FROM usuarios u 
																JOIN equipo e ON u.usuario_id = e.equipo_delegado 
																WHERE u.usuario_nombre = :usuario');
						$usuario_equipo->execute(array(
							':usuario' => $_SESSION['delegado']
						));

						$equipo = $usuario_equipo->fetch(); // EN $equipo['equipo_id'] se guarda el equipo del jugador

						$equipo = (integer)$equipo['equipo_id'];

						$insertarJugador = $conexion->prepare('INSERT INTO jugador VALUES(null,:nombre,:apPat,:apMat,:fecha,:equipo)');
						$insertarJugador->execute(array(
							':nombre' => $nombreJugador,
							':apPat' => $apPatJugador,
							':apMat' => $apMatJugador,
							':fecha' => $fechaNacJugador,
							':equipo' => $equipo
						));

						?>

						<script type="text/javascript">
								alert('Se ha registrado correctamente el jugador');
								location.href='delegado.php';
						</script>

						<?php
					}
				}
				require 'views/registrarJugador.view.php';
			}
	} else {
		header('Location: login.php');
	}
?>