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

			$borrarJugador = $conexion->prepare('DELETE FROM torneo WHERE torneo_id = :ID');
			$borrarJugador->execute(array(
				':ID' => $_POST['torneo_id']
			));

			?>
				<script type="text/javascript">
								alert('Se ha eliminado el torneo exitosamente');
								location.href='administrador.php';
				</script>

			<?php

		} // FIN REQUEST_METHOD == POST
	
		require 'views/eliminarTorneo.view.php'; // FIN IS SET $_SESSION['administrador']

	} else {
		header('Location: login.php');
	}

?>

