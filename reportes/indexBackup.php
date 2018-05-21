<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id_enf"])){
	header("Location: ../index.php");
}
$u = new usuario();
$sql = "SELECT * FROM servicio WHERE tipo = 'vacuna' ";
$vacunas = $u->GetDatosSql($sql);
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>..:: Estadisticas y Reportes ::..</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="../assets/css/main.css" />
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

				<section class="box">
					<center><h2>Reportes de produccion de servicios</h2></center>
					<br>
					<h4>Por favor Seleccione las opciones para poder generar el reporte correspondiente.</h4>
					<br>
					<form action="generarBackup.php" method="post" target="_blank">
					<div class="row uniform 50%">
							<div class="4u 12u(narrower)">
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
							<div class="4u 12u(narrower)">
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
							<div class="4u 12u(narrower)">
								<label for="especificacion">tipo Informe</label>
								<select name="tipo" id="tipo">
									<option value="" selected>..:: Seleccione tipo ::..</option>
									<option value="jeringas">Insumos (Jeringas)</option>
									<?php
									foreach ($vacunas as $dato) {
										?>
										<option value="<?php echo $dato->clave; ?>">Insumos (Vacuna <?php echo $dato->clave; ?>)</option>
										<?php
									}
									?>
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