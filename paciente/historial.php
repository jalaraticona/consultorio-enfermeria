<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id"])){
	header("Location: ../iniciarSesion.php");
}
if(!isset($_GET["ci"])){
	header("Location: index.php");
}
$u = new usuario();
$sql = "SELECT * FROM persona as pe, paciente as pa WHERE pe.ci = pa.ci and pe.ci = ".$_GET['ci']." ";
$datos = $u->getDatosPacienteSql($sql);
$sql = "SELECT re.fec_reg as fecha1, re.motivo, re.procedencia, re.lugar, re.dosis, se.nombre, se.tipo, pa.fec_reg as fecha2 FROM registrahistoria as re, servicio as se, paciente as pa WHERE re.id_paciente = pa.id_paciente and se.id_servicio = re.id_servicio and pa.ci = ".$_GET['ci']." ";
$datos2 = $u->getDatosPacienteSql($sql);
if(sizeof($datos) == 0){
	header("Location: index.php");
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>..:: Lista de Pacientes ::..</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/main.css" />
		<script src="alertify/alertify.js"></script>
		<link rel="stylesheet" href="alertify/css/alertify.css">
		<link rel="stylesheet" href="alertify/css/themes/default.min.css">
		<link rel="stylesheet" href="alertify/css/themes/bootstrap.min.css">
		<link rel="stylesheet" href="alertify/css/themes/semantic.min.css">
	</head>
	<body>
		<div id="page-wrapper">

			<!-- Header -->
				<header id="header">
					<h1>UNIVERSIDAD MAYOR DE SAN ANDRÉS - CARRERA DE ENFERMERÍA</h1>
					<nav id="nav">
						<ul>
							<li><a href="../principal/index.php">Inicio</a></li>
							<li><a href="../paciente/index.php" class="button">Volver Atras</a></li>
						</ul>
					</nav>
				</header>

			<!-- Main -->
				<section id="main" class="container">
					<header>
						<h2>Resgistro de consultas del paciente</h2>
					</header>
					<div class="row">
						<div class="12u">

							<!-- Text -->
								<section class="box">
									<div class="table-wrapper">
										<table>
											<tr>
												<td colspan="6"><center><h3>..:: Registro de consultas del paciente ::..</h3></center></td>
												<td>Hist. Nro.: <?php echo $datos[0]->id_paciente; ?></td>
											</tr>
											<tr>
												<td>Nombre del paciente:</td>
												<td colspan="4"><?php echo $datos[0]->nombre." ".$datos[0]->paterno." ".$datos[0]->materno; ?></td>
												<td>Numero C.I.: </td>
												<td><?php echo $datos[0]->ci." ".$datos[0]->expedido; ?></td>
											</tr>
											<tr>
												<td>Fecha de registro:</td>
												<td><?php echo $datos[0]->fec_reg; ?></td>
												<td>Fecha de Nacimiento:</td>
												<td><?php echo $datos[0]->fec_nac; ?></td>
												<td>Sexo: </td>
												<td><?php echo $datos[0]->sexo; ?></td>
											</tr>
										</table>
										<hr border="2">
									</div>
									<br>
									<a href="add.php" class="button small icon fa-plus" >Agregar Paciente</a>
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