<!DOCTYPE html>
<html>
<head>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no,
	 initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	<link rel="stylesheet" href="css/registro.css">

	<title>Registro</title>
	
</head>
<body>

	<div class="contenedor">
		<h1>Liga Regional de Fútbol de Jilotepec</h1>
		<h2>REGISTRO</h2>
		<div id="formulario">
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="fomulario" name="login">
				<input type="text" id="usuario" name="usuario" placeholder="Nombre de usuario">
				<input type="password" id="contra" name="contra" placeholder="Contraseña">
				<input type="password" id="contra2" name="contra2" placeholder="Repite tu constraseña">
				<input type="submit" name="submit" id="botonEnviar" class="botonEnviar" value="Enviar">

				<?php if(!empty($errores)): ?>
					<div class="error">
						<ul>
							<?php echo $errores; ?>
						</ul>
					</div>
				<?php endif; ?>

			</form>
			
			<p class="texto-registrate">
				¿Ya tienes cuenta?<br/>
			</p>
			
			<a href="login.php" class="btnIndex btnLog">Iniciar Sesión</a>
			<a href="visitante.php" class="btnIndex btnGuest">Entrar como Invitado</a>
			
		</div>
	</div>

</body>
</html>