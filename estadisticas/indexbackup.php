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
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawVisualization);

  function drawVisualization() {
    // Some raw data (not necessarily accurate)
    var data = google.visualization.arrayToDataTable(<?php echo $mensual; ?>);

    var options = {
      title : 'Grafica mensual de atenciones por servicio',
      vAxis: {title: 'Cantidad atendida'},
      hAxis: {title: 'meses'},
      seriesType: 'bars',
      series: {10: {type: 'line'}}
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }

  //google.charts.setOnLoadCallback(drawChart);

  /*function drawChart() {
    var data = google.visualization.arrayToDataTable(<?php echo $anual; ?>);

    var options = {
      title: 'grafica anual de atenciones por servicio',
      hAxis: {title: 'Año <?php echo "20".date("y"); ?>',  titleTextStyle: {color: '#333'}},
      vAxis: {tittle: 'Cantidad atendida',minValue: 0}
    };

    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }*/
</script>
</head>
<body>
<div id="page-wrapper">
<!-- Header -->
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
				<center><h2>Estadisticas de atencion de pacientes por servicio</h2></center>
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
						<label for="generar">Generar</label>
						<button type="submit" class="button">Mostrar Estadisticas</button>
					</div>
				</div>
				</form>
				<center><h3><?php if(isset($_POST["mes"])){
					if($m == 1) echo "Mes: enero ";
					if($m == 2) echo "Mes: febrero ";
					if($m == 3) echo "Mes: marzo ";
					if($m == 4) echo "Mes: abril ";
					if($m == 5) echo "Mes: mayo ";
					if($m == 6) echo "Mes: junio ";
					if($m == 7) echo "Mes: julio ";
					if($m == 8) echo "Mes: agosto ";
					if($m == 9) echo "Mes: septiembre ";
					if($m == 10) echo "Mes: octubre ";
					if($m == 11) echo "Mes: noviembre ";
					if($m == 12) echo "Mes: diciembre ";
				} ?>Gestion: <?php echo $an; ?></h3></center>
				<div id="chart_div" style="width: 900px; height: 500px;"></div>
				<?php
				if(isset($_POST["mes"]) and $_POST["mes"] > 0){
					?>
					<table>
						<thead>
							<tr>
								<th>MES</th>
								<th>MES</th>
								<th>MES</th>
								<th>MES</th>
								<th>MES</th>
								<th>MES</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>data</td>
							</tr>
						</tbody>
					</table>
					<?php
				}
				else{
					?>
					<table>
						<thead>
							<tr>
								<th>MES</th>
								<th>MES</th>
								<th>MES</th>
								<th>MES</th>
								<th>MES</th>
								<th>MES</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>ENERO</td>
							</tr>
						</tbody>
					</table>
					<?php
				}
				?>
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

</div>

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