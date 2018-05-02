<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id_enf"])){
	header("Location: ../index.php");
}
$u = new usuario();
if(isset($_POST["mes"])){
	$m = $_POST["mes"];
	$an = $_POST["anio"];
	if($m > 0){
		$cantidad = array();
		$porce = array();
		$mensual = array(array('Año','Inyectable', 'curacion pequeña', 'curacion mediana', 'oxigenoterapia', 'nebulizacion', 'retiro de puntos', 'difteria', 'tetanos', 'hepatitis b'));
		array_push($cantidad, 'Numero');
		for($i= 1; $i < 10; $i++){
			$sql = "SELECT count(*) as cant FROM registrahistoria WHERE YEAR(fec_reg) = ".$an." and MONTH(fec_reg) = ".$m." and id_servicio = ".$i." ";
			$datos = $u->GetDatosSql($sql);
			array_push($cantidad, (int) $datos[0]->cant);
			array_push($porce, (int) $datos[0]->cant);
		}
		array_push($mensual, $cantidad);
		$mensual = json_encode($mensual);
	}
	else
	{
		$cant = array();
		$meses = array();
		$mensual = array(array('Año','Inyectable', 'curacion pequeña', 'curacion mediana', 'oxigenoterapia', 'nebulizacion', 'retiro de puntos', 'difteria', 'tetanos', 'hepatitis b'));
		$meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
		if($an == date('Y')) { $mee = date('m'); }
		else { $mee = 12; }
		for ($j=0; $j < $mee ; $j++) { 
			$cant = array();
			$porce = array();
			array_push($cant, $meses[$j]);
			for($i= 1; $i < 10; $i++){
				$a = $j+1;
			  $sql = "SELECT count(*) as cant FROM registrahistoria WHERE YEAR(fec_reg) = ".$an." and MONTH(fec_reg) = ".$a." and id_servicio = ".$i." ";
			  $datos = $u->GetDatosSql($sql);
			  array_push($cant, (int) $datos[0]->cant);
			  array_push($porce, (int) $datos[0]->cant);
			}
			array_push($mensual, $cant);
			array_push($meses, $porce);
		}
		$mensual = json_encode($mensual);
	}
}
else{
	$an = date('Y');
	$cant = array();
	$tot = array();
	$mensual = array(array('Año','Inyectable', 'curacion pequeña', 'curacion mediana', 'oxigenoterapia', 'nebulizacion', 'retiro de puntos', 'difteria', 'tetanos', 'hepatitis b'));
	$meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
	if($an == date('Y')) { $mee = date('m'); }
	else { $mee = 12; }
	for ($j=0; $j < $mee ; $j++) { 
		$cant = array();
		$porce = array();
		array_push($cant, $meses[$j]);
		$total = 0;
		for($i= 1; $i < 10; $i++){
			$a = $j+1;
		  $sql = "SELECT count(*) as cant FROM registrahistoria WHERE YEAR(fec_reg) = ".$an." and MONTH(fec_reg) = ".$a." and id_servicio = ".$i." ";
		  $datos = $u->GetDatosSql($sql);
		  array_push($cant, (int) $datos[0]->cant);
		  array_push($porce, (int) $datos[0]->cant);
		  $total+= (int) $datos[0]->cant;
		}
		array_push($mensual, $cant);
		array_push($meses, $porce);
		array_push($tot, $total);
	}
	$mensual = json_encode($mensual);
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>..:: Estadisticas y Reportes ::..</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="../assets/css/main.css" />
	<script src="../public/ChartJS/Chart.bundle.js"></script>
	<script src="../public/ChartJS/samples/utils.js"></script>
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
				<div id="container" style="width: 100%;">
					<canvas id="canvas"></canvas>
				</div>
				<script>
					<?php $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
						$color = ['window.chartColors.red', 'window.chartColors.blue', 'window.chartColors.yellow', 'window.chartColors.grey', 'window.chartColors.orange', 'window.chartColors.green', 'window.chartColors.purple', 'window.chartColors.red', 'window.chartColors.blue', 'window.chartColors.orange', 'window.chartColors.yellow', 'window.chartColors.grey']; ?>
					var MONTHS = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
					var color = Chart.helpers.color;
					var barChartData = {
						labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
						datasets: [
						<?php 
						for($i = 0; $i < 12; $i++){
							?>
							{
								label: '<?php echo $meses[$i]; ?>',
								backgroundColor: color(<?php echo $color[$i]; ?>).alpha(0.5).rgbString(),
								borderColor: <?php echo $color[$i]; ?>,
								borderWidth: 2,
								data: [
									randomScalingFactor(),
									randomScalingFactor(),
									randomScalingFactor(),
									randomScalingFactor(),
									randomScalingFactor(),
									randomScalingFactor(),
									randomScalingFactor()
								],fill: false,
							},
						<?php
						}
						?>
						{
							label: 'Difteria',
							backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
							borderColor: window.chartColors.red,
							borderWidth: 2,
							data: [
								randomScalingFactor(),
								randomScalingFactor(),
								randomScalingFactor(),
								randomScalingFactor(),
								randomScalingFactor(),
								randomScalingFactor(),
								randomScalingFactor()
							],fill: false,
						}
						]
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