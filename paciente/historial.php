<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id"])){
	header("Location: ../iniciarSesion.php");
}
$u = new usuario();
$var = str_replace ( " " , "+" , $_GET["ci"] );
$des = $u->desencriptar($var);
if(!isset($_GET["ci"]) or !is_numeric($des)){
	header("Location: index.php");
}
$sql = "SELECT pe.*, pa.id_paciente, pa.residencia, pa.fec_reg, pa.categoria, pa.carrera_cargo FROM persona as pe, paciente as pa WHERE pe.ci = pa.ci and pe.ci = ".$des." ";
$datos = $u->GetDatosSql($sql);
$sql = "SELECT re.fec_reg, re.motivo, re.lugar, re.dosis, se.nombre, se.tipo FROM registrahistoria as re, servicio as se, paciente as pa WHERE re.id_paciente = pa.id_paciente and se.id_servicio = re.id_servicio and pa.ci = ".$des." ";
$datos2 = $u->GetDatosSql($sql);
if(sizeof($datos2) == 0){
	header("Location: index.php");
}
$enc = $u->encriptar($datos[0]->ci);
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>..:: Lista de Pacientes ::..</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/main.css" />
		<style type="text/css" media="screen">
		#div1{	
			overflow-y:scroll;
     		height:500px;
     		width:auto;
		}
		</style>
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
												<td colspan="7"><center><h3>..:: Registro de consultas del paciente ::..</h3></center></td>
												<td>Nro.: <?php echo $datos[0]->id_paciente; ?></td>
											</tr>
											<tr>
												<td colspan="8"></td>
											</tr>
											<tr>
												<td>Nombre del paciente:</td>
												<td colspan="5"><?php echo $datos[0]->nombre." ".$datos[0]->paterno." ".$datos[0]->materno; ?></td>
												<td>Numero C.I.: </td>
												<td><?php echo $datos[0]->ci." ".$datos[0]->expedido; ?></td>
											</tr>
											<tr>
												<td>Fecha de registro:</td>
												<td><?php echo $datos[0]->fec_reg; ?></td>
												<td>Fecha de Nacimiento:</td>
												<td><?php echo $datos[0]->fec_nac; ?></td>
												<td>Edad:</td>
												<td><?php echo $u->edad($datos[0]->fec_nac); ?> años</td>
												<td>Sexo: </td>
												<td><?php echo $datos[0]->sexo; ?></td>
											</tr>
											<tr>
												<td colspan="2">Municipio residencia:</td>
												<td><?php echo $datos[0]->residencia; ?></td>
												<td>Categoria:</td>
												<td><?php echo $datos[0]->categoria; ?></td>
												<td>Carrera o Cargo: </td>
												<td colspan="2"><?php echo $datos[0]->carrera_cargo; ?></td>
											</tr>
										</table>
										<hr border="2">
										<div id="div1">
										<table class="alt">
											<thead>
												<tr>
													<th>Nro.</th>
													<th>Fecha de registro</th>
													<th>Motivo de consulta</th>
													<th>Servicio</th>
													<th>Lugar</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$i = 1;
												foreach ($datos2 as $info) {
													$fecha = $info->fec_reg;
													$motivo = $info->motivo;
													if($info->tipo == "vacuna"){
														$servicio = $info->nombre." ".$info->dosis." dosis";
													}
													else{
														$servicio = $info->nombre;
													}
													$lugar = $info->lugar." del consultorio";
													?>
													<tr>
														<td><?php echo $i; ?></td>
														<td><?php echo $fecha; ?></td>
														<td><?php echo $motivo; ?></td>
														<td><?php echo $servicio; ?></td>
														<td><?php echo $lugar; ?></td>
													</tr>
													<?php
													$i++;
												}
												?>
											</tbody>
										</table>
										</div>
									</div>
									<br>
									<center><a href="../atencion/RegistraHistoria.php?ci=<?php echo $enc;?>" class="button special small icon fa-plus" >Realizar Proc. Enfermero</a> &nbsp; <a href="../atencion/RegistraVacunacion.php?ci=<?php echo $enc;?>" class="button special small icon fa-plus" >Realizar Vacunacion</a></center>
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