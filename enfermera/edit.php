<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id"])){
	header("Location: ../iniciarSesion.php");
}
$u = new usuario();
if(!isset($_GET["ci"]) or !is_numeric($_GET["ci"])){
	die("Error 404");
}
$datos = $u->getDatoPorCiPaciente($_GET["ci"]);
if(sizeof($datos) == 0){
	die("Error 404");
}
$mensaje='';
if(isset($_POST["grabar"])){
	if( filter_var( trim($_POST["nombre"]) ) == false){
		$mensaje.='El campo nombre es obligatorio. <br>';
	}
	if( filter_var( trim($_POST["paterno"]) ) == false){
		$mensaje.='El campo paterno es obligatorio. <br>';
	}
	if( filter_var( trim($_POST["materno"]) ) == false){
		$mensaje.='El campo materno es obligatorio. <br>';
	}
	if( filter_var( trim($_POST["ci"]) ) == false){
		$mensaje.='El campo Cedula de Identidad es obligatorio. <br>';
	}
	if( filter_var( trim($_POST["expedido"]) ) == false){
		$mensaje.='Es necesario seleccionar la ciudad de expedición. <br>';
	}
	if( filter_var( trim($_POST["fec_nac"]) ) == false){
		$mensaje.='El campo Fecha de Naciemiento en obligatorio. <br>';
	}
	if( filter_var( trim($_POST["sexo"]) ) == false){
		$mensaje.='Es necesario seleccionar su genero. <br>';
	}
	if($mensaje == ''){
		$u = new usuario();
		if(isset($_POST["nombre"])){
			$u->updatePaciente();
			header("Location: index.php?m=2");
		}
	}
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>..:: Editar información Pacientes ::..</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="../assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	</head>
	<body>
		<div id="page-wrapper">

			<!-- Header -->
				<header id="header">
					<h1>UNIVERSIDAD MAYOR DE SAN ANDRÉS - CARRERA DE ENFERMERÍA</h1>
					<nav id="nav">
						<ul>
							<li><a href="index.php">Inicio</a></li>
							<li><a href="../paciente/" class="button">Volver Atras</a></li>
						</ul>
					</nav>
				</header>

			<!-- Main -->
				<section id="main" class="container">
					<header>
						<h2>Editar Información Paciente</h2>
					</header>
					<div class="row">
						<div class="12u">

							<!-- Form -->
								<section class="box">
									<h3>Datos Personales</h3>
									<form method="post" action="#">
										<div class="row uniform 50%">
											<div class="12u">
												<input type="text" name="nombre" id="nombre" placeholder="Ingrese Nombre" autofocus="true" required="true" value="<?php echo $datos[0]->nombre ?>" />
											</div>
											<div class="12u">
												<input type="text" name="paterno" id="paterno" placeholder="Ingrese Apellido Paterno" required="true" value="<?php echo $datos[0]->paterno ?>"/>
											</div>
											<div class="12u">
												<input type="text" name="materno" id="materno" placeholder="Ingrese Apellido Materno" required="true" value="<?php echo $datos[0]->materno ?>"/>
											</div>
											<div class="6u 12u(mobilep)">
												<input type="text" name="ci" id="ci" placeholder="Cedula Identidad" required="true" value="<?php echo $datos[0]->ci ?>"/>
											</div>
											<div class="6u 12u(mobilep)">
												<div class="select-wrapper">
													<select name="expedido" id="expedido">
													
														<option value="<?php echo $datos[0]->expedido ?>" ><?php echo $datos[0]->expedido ?></option>
														
														<option value="" >Seleccione.......</option>
														<option value="la paz">La Paz</option>
														<option value="santa cruz">Santa Cruz</option>
														<option value="cochabamba">Cochabamba</option>
														<option value="pando">Pando</option>
														<option value="beni">Beni</option>
														<option value="oruro">Oruro</option>
														<option value="potosi">Potosi</option>
														<option value="chuquisaca">Chuquisaca</option>
														<option value="tarija">Tarija</option>
													</select>
												</div>
											</div>
											<div class="12u">
												<input type="date" name="fec_nac" id="fec_nac" required="true" value="<?php echo $datos[0]->fec_nac ?>"/>
											</div>
										</div>
										<div class="row uniform 50%">
											<div class="12u">
												<div class="select-wrapper">
													<select name="sexo" id="sexo" required="true">
														<option value="" >Seleccione.......</option>
														<option value="masculino" >Masculino</option>
														<option value="femenino" >Femenino</option>
													</select>
												</div>
											</div>
										</div>
										<div class="row uniform">
											<div class="12u">
												<ul class="actions">
													<li><input type="submit" value="Modificar" /></li>
													<li><input type="reset" value="Limpiar Datos" class="alt" /></li>
												</ul>
											</div>
										</div>
									</form>
								</section>
						</div>
					</div>
				</section>
		</div>

		<!-- Scripts -->
			<script src="../public/jquery-1.10.2.js"></script>
			<script src="funciones.js"></script>
			<script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
	        <!-- polyfiller file to detect and load polyfills -->
	        <script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
	        <script>
	          webshims.setOptions('waitReady', false);
	          webshims.setOptions('forms-ext', {types: 'date'});
	          webshims.polyfill('forms forms-ext');
	        </script>
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/jquery.dropotron.min.js"></script>
			<script src="../assets/js/jquery.scrollgress.min.js"></script>
			<script src="../assets/js/skel.min.js"></script>
			<script src="../assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="../assets/js/main.js"></script>
	</body>
</html>