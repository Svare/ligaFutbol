

<!DOCTYPE html>
<html lang="es-MX">
<head>
	<meta charset="utf-8">
	<title>Registro de Jugador</title>
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

			$consulta = $conexion->prepare('SELECT j.jugador_id, j.jugador_nombre, j.jugador_ap_pat, j.jugador_ap_mat 
											FROM jugador j JOIN equipo e ON j.jugador_equipo = e.equipo_id
											JOIN usuarios u ON u.usuario_id = e.equipo_delegado
											WHERE u.usuario_nombre = :nombre');
			$consulta->execute(array(
				':nombre' => $_SESSION['delegado']
			));

			$jugadores = $consulta->fetchAll();

			if (empty($jugadores)) {
				?>

				<script type="text/javascript">
								alert('No hay jugadores registrados');
								location.href='delegado.php';
				</script>

				<?php
			}
	?>


	<h1 id="tituloForm">Eliminar Jugador</h1>
	<div class="divForm">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

			<label for="jugador">Selecciona el jugador que deseas eliminar:</label>
				<select name="jugador" class="formControl">

					 <?php foreach ($jugadores as $jugador) { ?>

						<option value="<?php echo $jugador['jugador_id'];?>">
							<?php echo strtoupper($jugador['jugador_nombre']).' '
							.strtoupper($jugador['jugador_ap_pat']).' '
							.strtoupper($jugador['jugador_ap_mat']); ?></option>

					<?php } ?>

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