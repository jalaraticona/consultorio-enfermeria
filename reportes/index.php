<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id_enf"])){
	header("Location: ../index.php");
}
$u = new usuario();
$sql = "SELECT * FROM insumos WHERE tipo = 'vacuna' ";
$vacunas = $u->GetDatosSql($sql);
$sql = "SELECT * FROM insumos WHERE tipo = 'jeringa' ";
$jeringas = $u->GetDatosSql($sql);
$sql = "SELECT * FROM servicio WHERE tipo = 'vacuna' ";
$serv_vac = $u->GetDatosSql($sql);
$sql = "SELECT * FROM servicio WHERE tipo = 'proceso enfermero' ";
$serv_jer = $u->GetDatosSql($sql);
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
		
		<div class="row">
			<div class="12u">

				<section class="box">
					<center><h2>Reportes de produccion de servicios</h2></center>
					<form action="generar.php" method="post" target="_blank">
					<div class="table-wrapper">
						<table>
							<thead>
								<tr>
									<th colspan="4"><center><h4>Por favor Seleccione las opciones para poder generar el reporte correspondiente.</h4></center></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Fecha de inicio:</td>
									<td><input type="date" name="inicio" id="inicio" ></td>
									<td>Fecha de Final:</td>
									<td><input type="date" name="final" id="final" ></td>
								</tr>
								<tr>
									<td>Tipo de reporte:</td>
									<td colspan="3">
										<div class="select-wrapper">
											<select name="tipo" id="tipo">
												<option value="">..:: Sel. Opción ::..</option>
												<option value="servicios">Reporte de Produccion de Servicios</option>
												<option value="vacunas">Reporte de Estado de Vacunas</option>
												<option value="jeringas">Reporte de Estado de Jeringas</option>
											</select>
										</div>
									</td>
								</tr>
								<tr>
									<td>Tipo de Servicio: </td>
									<td colspan="3">
										<div id="servicios">
											<?php 
											$sql = "SELECT clave, nombre FROM servicio WHERE tipo = 'vacuna' ";
											$datos = $u->GetDatosSql($sql);
											foreach ($datos as $dato) {
											 	?>
											 	<h5><input type="checkbox" name="servi[]" id="servi[]" value="<?php echo $dato->clave; ?>"><?php echo $dato->nombre; ?></h5><br>
											 	<?php
											} 
											?>
										</div>
									</td>
										
								</tr>
								<tr>
									<td>Tipo de Vacuna:</td>
									<td colspan="3">
									<div class="select-wrapper">
										<div id="vacunas">
											<select name="vac" id="vac">
												<?php 
												foreach ($vacunas as $dato) {
												?>
												<option value="<?php echo $dato->id_insumo; ?>"><?php echo $dato->nombre; ?></option>
												<?php
												}
												?>
											</select>
										</div>
									</td>
									</div>
								</tr>
								<tr>
									<td>Tipo de Jeringa:</td>
									<td colspan="3">
									<div id="jeringas">
										<div class="select-wrapper">
											<select name="jer" id="jer">
												<?php 
												foreach ($jeringas as $dato) {
												?>
												<option value="<?php echo $dato->id_insumo; ?>"><?php echo $dato->nombre; ?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<center><button type="submit" class="button">Generar Reporte</button></center>
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