

<!DOCTYPE html>
<html lang="es-MX">
<head>
	<meta charset="utf-8">
	<title>Eliminar Torneo</title>
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
								alert('No hay torneos registrados');
								location.href='administrador.php';
				</script>

				<?php
			}
	?>


	<h1 id="tituloForm">Eliminar Torneo</h1>
	<div class="divForm">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

			<label for="torneo_id">Selecciona el torneo que deseas eliminar:</label>
				<select name="torneo_id" class="formControl">

					 <?php foreach ($torneos as $torneo) { ?>

						<option value="<?php echo $torneo['torneo_id'];?>"><?php echo strtoupper($torneo['torneo_nombre']); ?></option>

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