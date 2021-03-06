<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id_enf"])){
	header("Location: ../index.php");
}
$u = new usuario();
$var = str_replace ( " " , "+" , $_GET["id_insumo"] );
$des = $u->desencriptar($var);
if(!isset($_GET["id_insumo"]) or !is_numeric($des)){
	die("Error 404");
}
$datos = $u->getDatoPorId($des);
if(sizeof($datos) == 0){
	die("Error 404");
}
$mensaje='';
if(isset($_POST["grabar"])){
	if( filter_var( trim($_POST["nombre"]) ) == false){
		$mensaje.='El campo nombre es obligatorio. <br>';
	}
	if( filter_var( trim($_POST["tipo"]) ) == false){
		$mensaje.='Es necesario seleccionar la el tipo de insumo. <br>';
	}
	if( filter_var( trim($_POST["fec_exp"]) ) == false){
		$mensaje.='El campo Fecha de Expiración en obligatorio. <br>';
	}
	if( filter_var( trim($_POST["stock"]) ) == false){
		if(!is_numeric($_POST["stock"]) == false){
			$mensaje.='El campo Cedula de Identidad debe ser numérico. <br>';
		}
		else{
			$mensaje.='El campo Cedula de Identidad es obligatorio. <br>';
		}
	}
	if($mensaje == ''){
		if(isset($_POST["nombre"])){
			$u->updateInsumo();
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
				<li><a href="../insumos/" class="button">Volver Atras</a></li>
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
					<form method="post" action="#">
						<table>
							<thead>
								<th><h3>Editar Datos del insumo</h3></th>
							</thead>
							<tbody>
								<tr>
									<td>Nombre Insumo:</td>
									<td><input type="text" name="nombre" id="nombre" value="<?php echo $datos[0]->nombre ?>" required="true" autofocus="true"  /></td>
								</tr>
								<tr>
									<td>Tipo:</td>
									<td><select name="tipo" id="tipo" required="true">
										<option value="">Seleccione tipo......</option>
										<option value="jeringa">Jeringa</option>
										<option value="vacuna">Vacuna</option>
										<option value="inyectable">Inyectable</option>
										<option value="guantes">Guantes</option>
									</select></td>
								</tr>
								<tr>
									<td>Detalle</td>
									<td><input type="text" name="detalle" id="detalle" value="<?php echo $datos[0]->detalle ?>" ></td>
								</tr>
								<tr>
									<td>Fecha de ingreso:</td>
									<td><input type="date" name="fec_ing" id="fec_ing" value="<?php echo $datos[0]->fec_ing ?>" required="true"/></td>
								</tr>
								<tr>
									<td>Fecha de expiracion:</td>
									<td><input type="date" name="fec_exp" id="fec_exp" value="<?php echo $datos[0]->fec_exp ?>" required="true"/></td>
								</tr>
								<tr>
									<td>Stock:</td>
									<td><input type="number" name="stock" id="stock" value="<?php echo $datos[0]->stock ?>" required="true"/></td>
								</tr>
								<tr>
									<td>Estado:</td>
									<td><input type="text" name="estado" id="estado" value="<?php echo $datos[0]->estado ?>" required="true"/></td>
								</tr>
								<tr>
									<td>
									<input type="hidden" name="id_insumo" id="id_insumo" value="<?php echo $datos[0]->id_insumo ?>">
									<input type="hidden" name="grabar" id="grabar" value="si" /></td>
								</tr>
								<tr>
									<td><center><input type="submit" value="Registrar" /></center></td>
									<td><center><input type="reset" value="Limpiar Datos" class="alt" /></center></td>
								</tr>
							</tbody>
						</table>
						<br>
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