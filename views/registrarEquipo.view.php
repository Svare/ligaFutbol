

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
	<h1 id="tituloForm">Registro de Equipo</h1>
	<div class="divForm">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

			<label for="equipo_nombre">Nombre:</label>
				<input type="text" class="formControl" id="equipo_nombre" name="equipo_nombre" placeholder="Escribe el nombre de tu equipo" value="">

			<label for="equipo_fuerza">Fuerza:</label>
				<select name="equipo_fuerza" class="formControl" placeholder="Selecciona de que fuerza va a ser tu equipo">
				    <option value="1">PRIMERA ESPECIAL</option>
				    <option value="2">PRIMERA</option>
				    <option value="3">SEGUNDA I</option>
				    <option value="4">SEGUNDA II</option>
				     <option value="5">TERCERA I</option>
				    <option value="6">TERCERA II</option>
				</select>

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