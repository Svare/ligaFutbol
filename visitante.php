<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no,
	 initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	<link rel="stylesheet" href="css/visitante.css">
	<title>Visitante</title>
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

			if (empty($partidos)) {
				?>

				<h1 class="encabezado part_rol">NO SE HA REGISTRADO NINGUN PARTIDO</h1>

				<?php
			} else { // SI SI HAY PARTIDOS

				?>

				<h1 class="encabezado part_rol">ROL DE JUEGOS</h1>

				<?php

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

				?>
					<div class="contenedor">
						<table>
							<thead class="thead_rol">
								<tr>
									<th>JORNADA</th>
									<th>FECHA</th>
									<th>LUGAR</th>
									<th>LOCAL</th>
									<th>VISIITANTE</th>
								</tr>
							</thead>

							<tbody>
								<?php foreach ($nombres as $fila): ?>
									<tr>
										<td class="td_rol"><?php echo strtoupper($fila[0]); ?></td>
										<td class="td_rol"><?php echo strtoupper($fila[1]); ?></td>
										<td class="td_rol"><?php echo strtoupper($fila[2]); ?></td>
										<td class="td_rol"><?php echo strtoupper($fila[3]); ?></td>
										<td class="td_rol"><?php echo strtoupper($fila[4]); ?></td>
									</tr>
								<?php endforeach ?>
							</tbody>

							<tfoot>
							</tfoot>
						</table>						
					</div>
					
					<a href="generarRolPDF.php" class="btnOpcion btn3">Generar PDF</a> 					
				<?php

			}
	?>

	<?php 

		$consultaEquipos = $conexion->prepare('SELECT * FROM equipo');
		$consultaEquipos->execute(array());

		$hayEquipos = $consultaEquipos->fetchAll();

		if ($hayEquipos == false) {
			?>

			<h1 class="encabezado equipos">NO SE HAN REGISTRADO EQUIPOS</h1>

			<?php
		} else { // SI SI HAY EQUIPOS

			?>

			<h1 class="encabezado equipos">EQUIPOS</h1>

			<?php

				$equipo = $conexion->prepare('SELECT e.equipo_nombre, f.fuerza_nombre 
												FROM equipo e JOIN fuerza f ON e.equipo_fuerza = f.fuerza_id
												ORDER BY f.fuerza_id');
				$equipo->execute(array());
				$equipos = $equipo->fetchAll();

			?>
					<div class="contenedor">
						<table>
							<thead class="thead_equipos">
								<tr>
									<th>EQUIPO</th>
									<th>FUERZA</th>
								</tr>
							</thead>

							<tbody>
								<?php foreach ($equipos as $fila): ?>
									<tr>
										<td class="td_equipos"><?php echo strtoupper($fila['equipo_nombre']); ?></td>
										<td class="td_equipos"><?php echo strtoupper($fila['fuerza_nombre']); ?></td>
									</tr>
								<?php endforeach ?>
							</tbody>

							<tfoot>
							</tfoot>
						</table>
					</div>
					

				<?php
		}

	?>


</body>
</html>