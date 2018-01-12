<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no,
	 initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	<title>Tabla PDF</title>
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
			
			$equiposI = $conexion->prepare('SELECT p.partido_jornada, p.partido_fecha, p.partido_lugar, e.equipo_nombre FROM partido p JOIN equipo e 
													ON p.partido_equipo_local = e.equipo_id
													ORDER BY p.partido_jornada');
			$equiposI->execute(array());
			$datosEquiposI = $equiposI->fetchAll();

			$equiposII = $conexion->prepare('SELECT e.equipo_nombre FROM partido p JOIN equipo e 
												ON p.partido_equipo_visita = e.equipo_id
												ORDER BY p.partido_jornada');
			$equiposII->execute(array());
			$datosEquiposII = $equiposII->fetchAll();

			$nombres = array();

			$i = 0;

			foreach ($datosEquiposI as $datos) {
				$nombres[$i] = array($datos['partido_jornada'], $datos['partido_fecha'], $datos['partido_lugar'], $datos['equipo_nombre'] );
				$i++;
			}

			$i = 0;

			foreach ($datosEquiposII as $datosII) {
				$nombres[$i][4] = $datosII['equipo_nombre'];
				$i++;
			}
			
			// Vamos Bien
			
			
			
			?>
			
			<style type="text/css">
				table {
					border: solid 2px #3F92BF;
					margin: 20px 0 0 40px;
					
				}
				
				div {
					margin: auto;
				}
				
				td {
					padding: 10px;
					border: solid 2px #3F92BF;
					text-align: center;
				}
				
				h1{
					text-weight: 900;
					text-align: center;
					color: #053A56;
				}
			</style>
			
				<h1>ROL DE JUEGOS JILOTEPEC</h1>
			
				<div>
					<table>
						<tr>
							<td>JORNADA</td>
							<td>FECHA</td>
							<td>LUGAR</td>
							<td>LOCAL</td>
							<td>VISITANTE</td>
						</tr>
						<?php foreach ($nombres as $fila): ?>
							<tr>
								<td><?php echo strtoupper($fila[0]); ?></td>
								<td><?php echo strtoupper($fila[1]); ?></td>
								<td><?php echo strtoupper($fila[2]); ?></td>
								<td><?php echo strtoupper($fila[3]); ?></td>
								<td><?php echo strtoupper($fila[4]); ?></td>
							</tr>
						<?php endforeach ?>
						
					</table>						
				</div>
				
			<?php
	?>

</body>
</html>