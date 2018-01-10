

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
	<h1 id="tituloForm">Registro de Jugadores</h1>
	<div class="divForm">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
			<label for="nombreJugador">Nombre:</label>
				<input type="text" class="formControl" id="nombreJugador" name="nombreJugador" placeholder="Escribe el nombre del jugador" value="">
			<label for="apPatJugador">Apellido Paterno:</label>
				<input type="text" class="formControl" id="apPatJugador" name="apPatJugador" placeholder="Escribe el apellido paterno del jugador" value="">
			<label for="apMatJugador">Apellido Materno:</label>
				<input type="text" class="formControl" id="apMatJugador" name="apMatJugador" placeholder="Escribe el apellido materno del jugador" value="">
			<label for="fechaNacJugador">Fecha de Nacimiento:</label>
				<input type="date" class="formControl" id="fechaNacJugador" name="fechaNacJugador" value="">

			<?php if (!empty($errores)): ?>
				<div class="alert error">
					<?php echo $errores; ?>
				</div>
			<?php elseif($enviado): ?>
				<div class="alert success">
					<p>Enviado Correctamente</p>
				</div>
			<?php endif ?>

			<input type="submit" name="submit" id="botonEnviar" class="botonEnviar" value="Enviar">
		</form>
	</div>

</body>
</html>