<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id_enf"])){
	header("Location: ../index.php");
}
$u = new usuario();
$sql = "SELECT * FROM servicio";
$datos = $u->GetDatosSql($sql);
$serv = array();
foreach ($datos as $dato) {
	array_push($serv, $dato->clave);
}
if(isset($_POST["mes"])){
	$m = $_POST["mes"];
	$an = $_POST["anio"];
	if($m > 0){
		$meses = array();
		$totales = array();
		$mensual = array();
		if($an == date('Y')) { $mee = date('m'); }
		else { $mee = 12; }
		$sql = "SELECT count(*) as total FROM registrahistoria WHERE YEAR(fec_reg) = ".$an." ";
		$datos = $u->GetDatosSql($sql);
		$total = (float) $datos[0]->total;
		for($i = 1; $i <= sizeof($serv); $i++){
			$cant = array();
			$porce = array();
			$sql = "SELECT count(*) as cant FROM registrahistoria WHERE YEAR(fec_reg) = ".$an." and MONTH(fec_reg) = ".$m." and id_servicio = ".$i." ";
			$datos = $u->GetDatosSql($sql);
			$cantidad = $datos[0]->cant;
			array_push($cant, (int) $cantidad);
			$porcentajes = (float) $cantidad/$total;
			array_push($porce, (float) $porcentajes);
			array_push($mensual, $cant);
			array_push($totales, $porce);
		}
	}
	else
	{
		$meses = array();
		$totales = array();
		$mensual = array();
		if($an == date('Y')) { $mee = date('m'); }
		else { $mee = 12; }
		$sql = "SELECT count(*) as total FROM registrahistoria WHERE YEAR(fec_reg) = ".$an." ";
		$datos = $u->GetDatosSql($sql);
		$total = (float) $datos[0]->total;

		if($an == date('Y')) { $mee = date('m'); }
		else { $mee = 12; }
		for($i = 1; $i <= sizeof($serv); $i++){
			$cant = array();
			$porce = array();
			for ($j = 0; $j < $mee; $j++) {
				$a = $j+1;
				$sql = "SELECT count(*) as cant FROM registrahistoria WHERE YEAR(fec_reg) = ".$an." and MONTH(fec_reg) = ".$a." and id_servicio = ".$i." ";
				$datos = $u->GetDatosSql($sql);
				$cantidad = $datos[0]->cant;
				array_push($cant, (int) $cantidad);
				$porcentajes = (float) $cantidad/$total;
				array_push($porce, (float) $porcentajes);
			}
			array_push($mensual, $cant);
			array_push($totales, $porce);
		}
	}
}
else{
	$an = date('Y');
	$mensual = array();
	$totales = array();
	if($an == date('Y')) { $mee = date('m'); }
	else { $mee = 12; }
	$sql = "SELECT count(*) as total FROM registrahistoria WHERE YEAR(fec_reg) = ".$an." ";
	$datos = $u->GetDatosSql($sql);
	$total = (float) $datos[0]->total;
	for($i = 1; $i <= sizeof($serv); $i++){
		$cant = array();
		$porce = array();
		for ($j = 0; $j < $mee; $j++) {
			$a = $j+1;
			$sql = "SELECT count(*) as cant FROM registrahistoria WHERE YEAR(fec_reg) = ".$an." and MONTH(fec_reg) = ".$a." and id_servicio = ".$i." ";
			$datos = $u->GetDatosSql($sql);
			$cantidad = $datos[0]->cant;
			array_push($cant, (int) $cantidad);
			$porcentajes = (float) $cantidad/$total;
			array_push($porce, (float) $porcentajes);
		}
		array_push($mensual, $cant);
		array_push($totales, $porce);
	}
	//$mensual = json_encode($mensual);
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>..:: Estadisticas y Reportes ::..</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="../assets/css/main.css" />
	<script src="../assets/ChartJS/Chart.bundle.js"></script>
	<script src="../assets/ChartJS/samples/utils.js"></script>
</head>
<body>
<header id="header">
	<h1>UNIVERSIDAD MAYOR DE SAN ANDRÉS - CARRERA DE ENFERMERÍA</h1>
	<nav id="nav">
		<ul>
			<li><a href="../principal/index.php">Inicio</a></li>
			<li>
				<a href="#" class="icon fa-angle-down">Operaciones</a>
				<ul>
					<li><a href="#">Agregar</a></li>
					<li><a href="#">Contact</a></li>
					<li><a href="#">Elements</a></li>
				</ul>
			</li>
			<li><a href="../principal/index.php" class="button">Volver Atras</a></li>
		</ul>
	</nav>
</header>

<!-- Main -->
<section id="main" class="container">
	<header>
		<h2>Produccion de servicios</h2>
	</header>
	<div class="row">
		<div class="12u">
		<!-- Text -->
			<section class="box">
				<form action="" method="post" accept-charset="utf-8">
					<div class="row uniform 50%">
						<div class="4u 12u">
							<label for="mes">Selecciona el Mes</label>
							<select name="mes" >
							<option value="0" selected>Todos los meses</option>
							<?php 
							$meses = array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','noviembre','diciembre');
							$max = sizeof($meses);
							$i = 0;
							foreach ($meses as $val) {
								$a = $i + 1;
							    echo "<option value=".$a.">".$val."</option>";
							    $i++;
							}
							?>
							</select>
						</div>
						<div class="4u 12u">
							<label for="gestion">Selecciona la Gestión</label>
							<select name="anio" >
							<?php 
							for ($i=2010; $i <= date("Y"); $i++) { 
								if($i == date("Y")){
									echo "<option value=".$i." selected>".$i."</option>";
								}
								else{
									echo "<option value=".$i.">".$i."</option>";
								}
							}
							?>
							</select>
						</div>
						<div class="4u 12u">
							<label for="generar">.</label>
							<button type="submit" class="button">Mostrar Estadisticas</button>
						</div>
					</div>
				</form>
				<div id="container" style="width: 100%;">
					<canvas id="canvas"></canvas>
				</div>
				<script>
					<?php 
					$color = ['window.chartColors.red', 'window.chartColors.blue', 'window.chartColors.yellow', 'window.chartColors.grey', 'window.chartColors.orange', 'window.chartColors.green', 'window.chartColors.purple', 'window.chartColors.red', 'window.chartColors.blue', 'window.chartColors.orange', 'window.chartColors.yellow', 'window.chartColors.grey']; ?>
					var MONTHS = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
					var color = Chart.helpers.color;
					var barChartData = {
						labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
						datasets: [
						<?php 
						for($i = 0; $i < sizeof($serv); $i++){
							$a = $i+1;
							$arr = $mensual[$i];
							if($a == sizeof($serv)){
							?>
							{
								label: '<?php echo $serv[$i]; ?>',
								backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
								borderColor: window.chartColors.red,
								borderWidth: 2,
								data: [ <?php
									for($k = 0; $k < sizeof($arr); $k++){
										$z = $k+1;
										if($z == sizeof($arr)){ echo $arr[$k]; }
										else{ echo $arr[$k].","; }
									}
									?>
								],fill: false,
							}
							]
							<?php
							}
							else{
							?>
							{
								label: '<?php echo $serv[$i]; ?>',
								backgroundColor: color(<?php echo $color[$i]; ?>).alpha(0.5).rgbString(),
								borderColor: <?php echo $color[$i]; ?>,
								borderWidth: 2,
								data: [	<?php
										for($k = 0; $k < sizeof($arr); $k++){
											$z = $k+1;
											if($z == sizeof($arr)){ echo $arr[$k]; }
											else{ echo $arr[$k].","; }
										}
										?>
								],fill: false,
							},
						<?php
							}
						}
						?>
					};

					var config = {
						type: 'doughnut',
						data: {
							datasets: [{
								data: [
									<?php
									$arr = $mensual[0];
									for($k = 0; $k < sizeof($arr); $k++){
										echo $arr[$k].",";
									}
									?>
								],
								backgroundColor: [
									window.chartColors.red,
									window.chartColors.orange,
									window.chartColors.yellow,
									window.chartColors.green,
									window.chartColors.blue,
								],
								label: 'Dataset 1'
							}],
							labels: [
								'asdf',
								'Orange',
								'Yellow',
								'Green',
								'Blue'
							]
						},
						options: {
							responsive: true,
							legend: {
								position: 'top',
							},
							title: {
								display: true,
								text: 'Datos'
							},
							animation: {
								animateScale: true,
								animateRotate: true
							}
						}
					};

					window.onload = function() {
						var ctx = document.getElementById('canvas').getContext('2d');
						
						window.myBar = new Chart(ctx, {
							type: 'line',
							data: barChartData,
							options: {
								responsive: true,
								legend: {
									position: 'top',
								},
								title: {
									display: true,
									text: 'Estadisticas de los servicios ofrecidos por el consultorio'
								}
							}
						});
					};
				</script>
				<br>
				<table>
					<thead>
						<tr>
							<th colspan="13"><center><h3>Porcentajes de atenciones</h3></center></th>
						</tr>
						<tr>
							<th>Servicio</th>
							<th>Ene</th>
							<th>Feb</th>
							<th>Mar</th>
							<th>Abr</th>
							<th>May</th>
							<th>Jun</th>
							<th>Jul</th>
							<th>Ago</th>
							<th>Sep</th>
							<th>Oct</th>
							<th>Nov</th>
							<th>Dic</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						for($i = 1; $i <= sizeof($serv); $i++){
							$a = $i-1;
							$arr = $totales[$a];
							?>
						<tr>
							<td><?php echo $serv[$a]; ?></td>
							<?php 
							for ($j = 0; $j < sizeof($arr); $j++) {
								?>
								<td><?php echo $arr[$j]; ?></td>
								<?php
							}
							?>
						</tr>
							<?php
						}
						?>
					</tbody>
				</table>
			</section>
		</div>
	</div>
</section>

<!-- Footer -->
<footer id="footer">
	<ul class="icons">
		<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
		<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
		<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
		<li><a href="#" class="icon fa-github"><span class="label">Github</span></a></li>
		<li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
		<li><a href="#" class="icon fa-google-plus"><span class="label">Google+</span></a></li>
	</ul>
</footer>


<!-- Scripts -->
	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/jquery.dropotron.min.js"></script>
	<script src="../assets/js/jquery.scrollgress.min.js"></script>
	<script src="../assets/js/skel.min.js"></script>
	<script src="../assets/js/util.js"></script>
	<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
	<script src="../assets/js/main.js"></script>
</body>
</html>