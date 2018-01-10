<?php

	session_start();

	if (isset($_SESSION['administrador'])) {

		$errores = '';

		try {
				$conexion = new PDO('mysql:host=127.0.0.1;dbname=u862065767_liga','u862065767_root','rosendo');
			} catch (PDOException $e) {
				echo "Error: ".$e->getMessage();
			}

		if ($_SERVER['REQUEST_METHOD'] == 'POST') { // REQUEST_METHOD == POST

			$partido_fecha = $_POST['partido_fecha'];
			$partido_lugar = $_POST['partido_lugar'];
			$partido_jornada = $_POST['partido_jornada'];
			$partido_equipo_local = $_POST['partido_equipo_local'];
			$partido_equipo_visita = $_POST['partido_equipo_visita'];
			$partido_torneo = $_POST['partido_torneo'];

			// VALIDAR QUE NO ESTE EL PARTIDO YA REGISTRADO

			$consulta = $conexion->prepare('SELECT * FROM partido 
											WHERE (partido_equipo_local = :local AND partido_equipo_visita = :visita) OR 
											(partido_equipo_local = :visita AND partido_equipo_visita = :local)');
			$consulta->execute(array(
				':local' => $partido_equipo_local,
				':visita' => $partido_equipo_visita
			));

			$existePartido = $consulta->fetch();

			if ($existePartido != false) {
				$errores .= 'El encuentro ya ha sido registado<br/>';
			}

			if (empty($partido_fecha)) {
				$errores .= 'Por favor ingresar una fecha<br/>';
			}

			if (!empty($partido_lugar)) {
				$partido_lugar = trim($partido_lugar);
				$partido_lugar = filter_var($partido_lugar,FILTER_SANITIZE_STRING);
				$partido_lugar = mb_strtolower($partido_lugar);
			} else {
				$errores .= 'Por favor ingresar un lugar<br/>';
			}

			if ($partido_equipo_local == $partido_equipo_visita) {
				$errores .= 'No puedes jugar contra tu mismo<br/>';
			}

			if ($errores == '') {
				$partido_jornada = (integer)$partido_jornada;
				$partido_equipo_local = (integer)$partido_equipo_local;
				$partido_equipo_visita = (integer)$partido_equipo_visita;
				$partido_torneo = (integer)$partido_torneo;

				$insertarPartido = $conexion->prepare('INSERT INTO partido VALUES(null,:fecha,:lugar,:jorn,:local,:visita,:torneo)');
				$insertarPartido->execute(array(
					':fecha' => $partido_fecha,
					':lugar' => $partido_lugar,
					':jorn' => $partido_jornada,
					':local' => $partido_equipo_local,
					':visita' => $partido_equipo_visita,
					':torneo' => $partido_torneo
				));

				?>

				<script type="text/javascript">
								alert('Se ha ingresado el partido exitosamente');
								location.href='administrador.php';
				</script>

				<?php
			}

		} // FIN REQUEST_METHOD == POST
	
		require 'views/registrarPartido.view.php'; // FIN IS SET $_SESSION['administrador']

	} else {
		header('Location: login.php');
	}

?>

