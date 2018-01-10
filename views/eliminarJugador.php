<?php

//	session_start();

	if (isset($_SESSION['delegado'])) {

		$errores = '';

		try {
				$conexion = new PDO('mysql:host=127.0.0.1;dbname=u862065767_liga','u862065767_root','rosendo');
			} catch (PDOException $e) {
				echo "Error: ".$e->getMessage();
			}

		if ($_SERVER['REQUEST_METHOD'] == 'POST') { // REQUEST_METHOD == POST

			$borrarJugador = $conexion->prepare('DELETE FROM jugador WHERE jugador_id = :ID');
			$borrarJugador->execute(array(
				':ID' => $_POST['jugador']
			));

			?>
				<script type="text/javascript">
								alert('Se ha eliminado el jugador exitosamente');
								location.href='delegado.php';
				</script>

			<?php

		} // FIN REQUEST_METHOD == POST
	
		require 'views/eliminarJugador.view.php'; // FIN IS SET $_SESSION['delegado']

	} else {
		header('Location: login.php');
	}

?>

