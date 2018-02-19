<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id"])){
	header("Location: ../iniciarSesion.php");
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
		if(!is_numeric($_POST["ci"]) == false){
			$mensaje.='El campo Cedula de Identidad debe ser numérico. <br>';
		}
		else{
			$mensaje.='El campo Cedula de Identidad es obligatorio. <br>';
		}
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
			$u = new usuario();
			$u->insertarEnfermera();
			header("Location: index.php?m=1");
		}
	}
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>..:: Lista de Pacientes ::..</title>
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
							<li><a href="../paciente" class="button">Volver Atras</a></li>
						</ul>
					</nav>
				</header>

			<!-- Main -->
				<section id="main" class="container">
					<header>
						<h2>Registrar Paciente</h2>
					</header>
					<div class="row">
						<div class="12u">

							<!-- Form -->
								<section class="box">
									<h3>Datos Personales</h3>
									<form method="post" action="">
										<?php 
										if($mensaje != ''){
											?>
											<div class="alert alert-danger">
												<?php echo $mensaje; ?>
											</div>
											<?php
										}
										?>
										<div class="row uniform 50%">
											<div class="12u">
												<input type="text" name="nombre" id="nombre" placeholder="Ingrese Nombre" value="<?php echo set_value_input(array(),'nombre','nombre'); ?>" required="true" autofocus="true"  />
											</div>
											<div class="12u">
												<input type="text" name="paterno" id="paterno" placeholder="Ingrese Apellido Paterno" value="<?php echo set_value_input(array(),'paterno','paterno'); ?>" required="true"/>
											</div>
											<div class="12u">
												<input type="text" name="materno" id="materno" placeholder="Ingrese Apellido Materno" value="<?php echo set_value_input(array(),'materno','materno'); ?>" required="true"/>
											</div>
											<div class="6u 12u(mobilep)">
												<input type="number" name="ci" id="ci" placeholder="Cedula Identidad" value="<?php echo set_value_input(array(),'ci','ci'); ?>" required="true"/>
											</div>
											<div class="6u 12u(mobilep)">
												<div class="select-wrapper">
													<select name="expedido" id="expedido" required="true">
														<option value="" <?php echo set_value_select(array(),'expedido','expedido',''); ?>>Seleccione.......</option>
														<option value="la paz"<?php echo set_value_select(array(),'expedido','expedido','la paz'); ?>>La Paz</option>
														<option value="santa cruz"<?php echo set_value_select(array(),'expedido','expedido','santa cruz'); ?>>Santa Cruz</option>
														<option value="cochabamba"<?php echo set_value_select(array(),'expedido','expedido','cochabamba'); ?>>Cochabamba</option>
														<option value="pando"<?php echo set_value_select(array(),'expedido','expedido','pando'); ?>>Pando</option>
														<option value="beni"<?php echo set_value_select(array(),'expedido','expedido','beni'); ?>>Beni</option>
														<option value="oruro"<?php echo set_value_select(array(),'expedido','expedido','oruro'); ?>>Oruro</option>
														<option value="potosi"<?php echo set_value_select(array(),'expedido','expedido','potosi'); ?>>Potosi</option>
														<option value="chuquisaca"<?php echo set_value_select(array(),'expedido','expedido','chuquisaca'); ?>>Chuquisaca</option>
														<option value="tarija"<?php echo set_value_select(array(),'expedido','expedido','tarija'); ?>>Tarija</option>
													</select>
												</div>
											</div>
											<div class="12u">
												<input type="date" name="fec_nac" id="fec_nac" value="<?php echo set_value_input(array(),'fec_nac','fec_nac'); ?>" required="true"/>
											</div>
										</div>
										<div class="row uniform 50%">
											<div class="12u">
												<div class="select-wrapper">
													<select name="sexo" id="sexo" required="true">
														<option value="" <?php echo set_value_select(array(),'sexo','sexo',''); ?>>Seleccione.......</option>
														<option value="masculino" <?php echo set_value_select(array(),'sexo','sexo','masculino'); ?>>Masculino</option>
														<option value="femenino" <?php echo set_value_select(array(),'sexo','sexo','femenino'); ?>>Femenino</option>
													</select>
												</div>
											</div>
										</div>
										<div class="row uniform">
											<div class="12u">
												<ul class="actions">
													<li><input type="submit" value="Registrar" /></li>
													<li><input type="reset" value="Limpiar Datos" class="alt" /></li>
												</ul>
											</div>
										</div>
										<div class="row uniform 50%">
											<div class="12u">
												<input type="hidden" name="grabar" id="grabar" value="si" />
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