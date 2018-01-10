
<!DOCTYPE html>
<html lang="es-MX">
<head>
	<meta charset="utf-8">
	<title>Registro de Partido</title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet"> 
	<link rel="stylesheet" href="css/formularios.css">
</head>
<body>

	<?php

		try {
				$conexion = new PDO('mysql:host=127.0.0.1;dbname=u862065767_liga','u862065767_root','rosendo');
			} catch (PDOException $e) {
				echo "Error: ".$e->getMessage();
			}

			$consulta = $conexion->prepare('SELECT * FROM torneo');
			$consulta->execute(array());

			$torneos = $consulta->fetchAll();

			if (empty($torneos)) {
				?>

				<script type="text/javascript">
								alert('No hay torneos registrados!');
								location.href='administrador.php';
				</script>

				<?php
			}

			$consultaEquipos = $conexion->prepare('SELECT COUNT(equipo_id) AS equipos FROM equipo');
			$consultaEquipos->execute(array());

			$numEquipos = $consultaEquipos->fetch();
			$numEquipos = (integer)$numEquipos['equipos']; // ALMACENAMOS EN $numEquipos EL NUMERO DE EQUIPOS REGISTRADOS (COMO ENTERO)

			if ($numEquipos < 2) { ?>

				<script type="text/javascript">
								alert('Deben existir almenos dos equipos registrados!');
								location.href='administrador.php';
				</script>

				<?php
			}

			$tablaEquipos = $conexion->prepare('SELECT equipo_id, equipo_nombre FROM equipo');
			$tablaEquipos->execute(array());

			$equipos = $tablaEquipos->fetchAll();

			$tablaEquiposII = $conexion->prepare('SELECT equipo_id, equipo_nombre FROM equipo');
			$tablaEquiposII->execute(array());

			$equiposII = $tablaEquiposII->fetchAll();

	?>

	<h1 id="tituloForm">Registro de Partidos</h1>
	<div class="divForm">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

			<label for="partido_fecha">Fecha del Encuentro:</label>
				<input type="date" class="formControl" id="partido_fecha" name="partido_fecha" value="">

			<label for="partido_lugar">Lugar:</label>
				<input type="text" class="formControl" id="partido_lugar" name="partido_lugar" placeholder="Escribe el lugar del encuentro" value="">

			<label for="partido_jornada">Jornada:</label>
			<select name="partido_jornada" class="formControl">

				<?php for($i=1;$i<=20;$i++) { ?>

					<option value="<?php echo $i; ?>"><?php echo 'Jornada '.$i; ?></option>

				<?php } ?>

			</select>

			<label for="partido_equipo_local">Equipo Local:</label>
			<select name="partido_equipo_local" class="formControl">
				
				<?php foreach ($equipos as $equipo): ?>
					<option value="<?php echo $equipo['equipo_id']; ?>"><?php echo strtoupper($equipo['equipo_nombre']); ?></option>
				<?php endforeach ?>

			</select>

			<label for="partido_equipo_visita">Equipo Visitante:</label>
			<select name="partido_equipo_visita" class="formControl">
				
				<?php foreach ($equiposII as $equipoII): ?>
					<option value="<?php echo $equipoII['equipo_id']; ?>"><?php echo strtoupper($equipoII['equipo_nombre']); ?></option>
				<?php endforeach ?>

			</select>

			<label for="partido_torneo">Torneo:</label>
			<select name="partido_torneo" class="formControl">
				
				<?php foreach ($torneos as $torneo): ?>
					<option value="<?php echo $torneo['torneo_id']; ?>"><?php echo strtoupper($torneo['torneo_nombre']); ?></option>
				<?php endforeach ?>

			</select>		

			<?php if (!empty($errores)): ?>
				<div class="alert error">
					<?php echo $errores; ?>
				</div>
			<?php endif ?>

			<input type="submit" name="submit" id="botonEnviar" class="botonEnviar" value="Enviar">
		</form>
	</div>

</body>
</html>