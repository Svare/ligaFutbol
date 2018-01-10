

<!DOCTYPE html>
<html lang="es-MX">
<head>
	<meta charset="utf-8">
	<title>Eliminar Partido</title>
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

			$consulta = $conexion->prepare('SELECT * FROM partido');
			$consulta->execute(array());

			$partidos = $consulta->fetchAll();

			if (empty($partidos)) {
				?>

				<script type="text/javascript">
								alert('No hay partidos registrados');
								location.href='administrador.php';
				</script>

				<?php
			}


			$equiposI = $conexion->prepare('SELECT p.partido_id, e.equipo_nombre FROM partido p JOIN equipo e ON p.partido_equipo_local = e.equipo_id');
			$equiposI->execute(array());

			$datosEquiposI = $equiposI->fetchAll();

			$equiposII = $conexion->prepare('SELECT p.partido_id, e.equipo_nombre FROM partido p JOIN equipo e ON p.partido_equipo_visita = e.equipo_id');
			$equiposII->execute(array());

			$datosEquiposII = $equiposII->fetchAll();

			$nombres = array();

			$i = 0;

			foreach ($datosEquiposI as $datos) {
				$nombres[$i] = array($datos['partido_id'],$datos['equipo_nombre']);
				$i++;
			}

			$i = 0;

			foreach ($datosEquiposII as $datosII) {
				$nombres[$i][2] = $datosII['equipo_nombre'];
				$i++;
			}

			// EN $nombres HAY  $partido_id, $equipo_nombre_local, $equipo_nombre_visita
	?>


	<h1 id="tituloForm">Eliminar Partido</h1>
	<div class="divForm">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

			<label for="partido_id">Selecciona el partido que deseas eliminar:</label>
				<select name="partido_id" class="formControl">

					<?php foreach ($nombres as $contenido): ?>
						<option value="<?php echo $contenido[0]; ?>"><?php echo strtoupper($contenido[1]).' VS '.strtoupper($contenido[2]); ?></option>
					<?php endforeach ?>

				</select>

			<?php if (!empty($errores)): ?>
				<div class="alert error">
					<?php echo $errores; ?>
				</div>
			<?php endif ?>

			<input type="submit" name="submit" id="botonEnviar" class="botonEnviar" value="Borrar">
		</form>
	</div>

</body>
</html>