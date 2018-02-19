<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id"])){
	header("Location: ../iniciarSesion.php");
}
$u = new usuario();
$cantidad = array();
$data = array(array('Año','Inyectable', 'curacion pequeña', 'curacion mediana', 'oxigenoterapia', 'nebulizacion', 'retiro de puntos', 'difteria', 'tetanos', 'hepatitis b'));
array_push($cantidad, 'Numero');
for($i= 1; $i < 10; $i++){
  $sql = "SELECT count(*) as cant FROM registrahistoria WHERE YEAR(fec_reg) = YEAR(CURRENT_DATE) and id_servicio = ".$i."";
  $datos = $u->getDatosPacienteSql($sql);
  array_push($cantidad, (int) $datos[0]->cant);
}
array_push($data, $cantidad);
$data = json_encode($data);
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
        var data = google.visualization.arrayToDataTable(<?php echo $data; ?>);

	    var options = {
	      title : 'Pacientes atendidos por servicio',
	      vAxis: {title: 'Cantidad Pacientes'},
	      hAxis: {title: 'mensual'},
	      seriesType: 'bars',
	      series: {10: {type: 'line'}}
	    };

	    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
	    chart.draw(data, options);
	  }

	  //google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Vacunas', 'Curaciones', 'Nebulizaciones'],
          ['Enero',  1000,      400,500],
          ['Febrero',  1170,      460,500],
          ['Marzo',  660,       1120,500],
          ['Abril',  760,       120,500],
          ['Mayo',  160,       110,500],
          ['Junio',  460,       220,500],
          ['Julio',  600,       420,500],
          ['Agosto',  400,       190,500],
          ['Septiembre',  60,       820,500],
          ['Octubre',  210,       870,500],
          ['Noviembre',  100,       650,500],
          ['Diciembre',  1030,      760,500]
        ]);

        var options = {
          title: 'Consultorio de la carrera de Enfermería',
          hAxis: {title: 'Mes',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
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
									<br>
									<input type="button" value="Mensual" class="button" onclick="drawVisualization();">
									<input type="button" value="Anual" class="button" onclick="drawChart();">
									<div id="chart_div" style="width: 900px; height: 500px;"></div>
								</section>
								<section class="box">
									<center><h2>Reportes de produccion de servicios</h2></center>
									<br>
									<h4>Por favor Seleccione las opciones para poder generar el reporte correspondiente.</h4>
									<br>
									<form action="generar.php" method="post" target="_blank">
									<div class="row uniform 50%">
											<div class="4u 12u(narrower)">
												<label for="gestion">Gestión</label>
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
											<div class="4u 12u(narrower)">
												<label for="mes">Mes</label>
												<select name="mes" >
												<option value="0" selected>Toda la Gestión</option>
												<?php 
												$meses = array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','noviembre','diciembre');
												$max = sizeof($meses);
												$i = 0;
												foreach ($meses as $val) {
													$a = $i + 1;
												    echo "<option value=".$a.">".$meses[$i]."</option>";
												    $i++;
												}
												?>
												</select>
											</div>
											<div class="4u 12u(narrower)">
												<label for="especificacion">tipo Informe</label>
												<select name="tipo">
													<option value="todo" selected>Todos los informes</option>
													<option value="insumos">Estado de insumos</option>
													<option value="servicios">Produccion de Servicios</option>
												</select>
											</div>
										</div>
										<br>
									<button type="submit" class="button">Generar Reporte</button>
									</form>
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