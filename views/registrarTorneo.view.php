<!DOCTYPE html>
<html lang="es-MX">
<head>
	<meta charset="utf-8">
	<title>Registro Torneo</title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet"> 
	<link rel="stylesheet" href="css/formularios.css">
</head>
<body>
	<h1 id="tituloForm">Registro de Torneos</h1>
	<div class="divForm">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
			<label for="torneo_nombre">Nombre:</label>
				<input type="text" class="formControl" id="torneo_nombre" name="torneo_nombre" placeholder="Escribe el nombre del torneo" value="">
			
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