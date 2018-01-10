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

			$borrarPartido = $conexion->prepare('DELETE FROM partido WHERE partido_id = :ID');
			$borrarPartido->execute(array(
				':ID' => $_POST['partido_id']
			));

			?>
				<script type="text/javascript">
								alert('Se ha eliminado el partido exitosamente');
								location.href='administrador.php';
				</script>

			<?php

		} // FIN REQUEST_METHOD == POST
	
		require 'views/eliminarPartido.view.php'; // FIN IS SET $_SESSION['administrador']

	} else {
		header('Location: login.php');
	}

?>

