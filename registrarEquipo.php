<?php

	session_start();

	if (isset($_SESSION['delegado'])) {

// CONECCION A LA BASE DE DATOS

		try {
				$conexion = new PDO('mysql:host=127.0.0.1;dbname=u862065767_liga','u862065767_root','rosendo');
			} catch (PDOException $e) {
				echo "Error: ".$e->getMessage();
			}

// GUARDAMOS LA INFORMACION DEL USUARIO EN $resultado

			$datosUsuario = $conexion->prepare('SELECT * FROM usuarios WHERE usuario_nombre = :usuario');
			$datosUsuario->execute(array(
				':usuario' => $_SESSION['delegado']
			));

			$resultado = $datosUsuario->fetch();

// SI EL USUARIO YA TIENE EQUIPO LO SACAMOS DE LA PAGINA Y LE DECIMOS QUE YA TIENE EQUIPO, SI NO TIENE EQUIPO LO MANDAMOS A REGISTRAR UNO

			if ($resultado['usuario_tiene_equipo'] == 'T') { // SI TIENE EQUIPO
				require 'errores/yaTieneEquipo.php';
			} else { // SI NO TIENE EQUIPO

				// INIICIALIZO MIS REGISTROS DE ERRORES Y EXITO A EMPTY

					$errores = '';
					$enviado = '';

				if ($_SERVER['REQUEST_METHOD'] == 'POST') { // SI YA ENVIE ALGO POR POST

					// GUARDO LO QUE ENVIE EN UNAS VARIABLES PARA TENERLO A LA MANO

					$equipo_nombre = $_POST['equipo_nombre']; 
					$equipo_fuerza = $_POST['equipo_fuerza'];

					// SI RECIBI ALGO EN $equipo_nombre LIMPIO LA INFORMACION

					if (!empty($equipo_nombre)) {
						$equipo_nombre = trim($equipo_nombre);
						$equipo_nombre = filter_var($equipo_nombre,FILTER_SANITIZE_STRING);
						$equipo_nombre = strtolower($equipo_nombre);
					} else {

						// SI NO RECIBI NADA ENTONCES ES UN ERROR Y LO ESCRIBO EN MI VARIABLE ERRORES

						$errores .= 'Ingresa un nombre de equipo<br/>';
					}

					// SI $equipo_fuerza ESTA VACIO ES UN ERROR Y LO AGREGO A MIS ERRORES

					if(empty($equipo_fuerza)){
						$errores .= 'Selecciona en que fuerza quieres que este tu equipo <br/>';
					}

					// VALIDANDO QUE NO EXISTA YA UN EQUIPO CON ESE NOMBRE

					$existeEquipo = $conexion->prepare('SELECT * FROM equipo WHERE equipo_nombre = :nombre');
					$existeEquipo->execute(array(
						':nombre' => $equipo_nombre
					));

					$equipoResultado = $existeEquipo->fetch();

					if ($equipoResultado != false) {
						$errores .= 'El nombre de equipo ya existe<br/>';
					}

					// SI NO HAY ERRORES ENTONCES AHORA SI YA PODEMOS INSERTAR EN LA BASE DE DATOS

					if ($errores == '') {

						// CONVIERTO A ENTEROS MIS DATOS QUE VOY A METER A LA BASE DE DATOS PARA QUE NO HAYA PROBLEMA

						$equipo_fuerza = (integer)$equipo_fuerza;
						$usuario_id = (integer)$resultado['usuario_id'];

						// INSERTO EN LA BASE DE DATOS EL NUEVO EQUIPO

						$insertar = $conexion->prepare('INSERT INTO equipo VALUES(null,:nombre,:fuerza,:delegado)');
						$insertar->execute(array(
							':nombre' => $equipo_nombre,
							':fuerza' => $equipo_fuerza,
							':delegado' => $usuario_id
						));

						// ACTUALIZO LA TABLA DE USUARIOS EN SU CAMPO usuario_tiene_equipo Y LE COLOCO UNA 'T' QUE INDICA QUE YA TIENE EQUIPO

						$actualizaTieneEquipo = $conexion->prepare('UPDATE usuarios SET usuario_tiene_equipo = "T" WHERE usuario_id = :ID');
						$actualizaTieneEquipo->execute(array(
							':ID' => $usuario_id
						));

						// REDIRIGO LA PAGINA A UN REPORTE QUE ME DICE QUE EL REGISTRO SE EFECTUO CORRECTAMENTE

						?>

						<script type="text/javascript">
								alert('Se ha registrado correctamente el equipo');
								location.href='delegado.php';
						</script>

						<?php

						$enviado = true;
					
					} // FIN ERRORES == ''
				} // FIN YA ENVIE ALGO POR POST
				require 'views/registrarEquipo.view.php'; // CARGO PAGINA CORRESPONDIENTE A REGISTRO DE EQUIPO
			} // FIN USUARIO NO TIENE EQUIPO
	} else {
		header('Location: login.php');
	}

?>
