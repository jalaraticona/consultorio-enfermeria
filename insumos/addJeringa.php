<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id"])){
	header("Location: ../iniciarSesion.php");
}
$mensaje='';
if(isset($_POST["grabar"])){
	if( filter_var( trim($_POST["medida"]) ) == false){
		$mensaje.='Es necesario especificar el nombre de la vacuna. <br>';
	}
	if( filter_var( trim($_POST["comprobante"]) ) == false){
		$mensaje.='Es necesario colocar el numero de comprobante de la jeringa. <br>';
	}
	if( filter_var( trim($_POST["fec_exp"]) ) == false){
		$mensaje.='El campo Fecha de Expiración en obligatorio. <br>';
	}
	if( filter_var( trim($_POST["stock"]) ) == false){
		if(!is_numeric($_POST["stock"]) == false){
			$mensaje.='El campo Stock debe ser numérico. <br>';
		}
		else{
			$mensaje.='El campo Stock es obligatorio. <br>';
		}
	}
	if($mensaje == ''){
		$u = new usuario();
		if(isset($_POST["medida"])){
			$u = new usuario();
			$u->insertarInsumo();
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
				<li><a href="../insumos/" class="button">Volver Atras</a></li>
			</ul>
		</nav>
	</header>

<!-- Main -->
	<section id="main" class="container">
		<header>
			<h2>Registrar Insumo</h2>
		</header>
		<div class="row">
			<div class="12u">
			<!-- Form -->
				<section class="box">
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
						<table>
							<thead>
								<th colspan="2"><center><h3>..:: Registro de datos de Jeringa ::..</h3></center></th>
							</thead>
							<tbody>
								<tr>
									<td>Nro. de comprobante: </td>
									<td><input type="number" name="comprobante" id="comprobante" placeholder="Ingrese numero de comprobante" value="<?php echo set_value_input(array(),'comprobante','comprobante'); ?>" required="true"/></td>
								</tr>
								<tr>
									<td>Lote del insumo: </td>
									<td><input type="text" name="lote" id="lote" placeholder="Ingrese lote de la vacuna" value="<?php echo set_value_input(array(),'lote','lote'); ?>" required="true"/></td>
								</tr>
								<tr>
									<td>Origen: </td>
									<td><div class="select-wrapper">
										<select name="origen" id="origen" required="true">
											<option value="pai" selected>PAI SEDES LA PAZ</option>
											<option value="otro">otro..</option>
										</select>
									</div></td>
								</tr>
								<tr>
									<td>Red: </td>
									<td><div class="select-wrapper">
										<select name="red" id="red" required="true">
											<option value="norte" selected>Nro.3 norte central</option>
											<option value="otro">otro..</option>
										</select>
									</div></td>
								</tr>
								<tr>
									<td>Tamaño jeringa: </td>
									<td>
										<div class="select-wrapper">
											<select name="medida" id="medida" required="true">
												<option value="" selected>..::  Seleccione la medida de la jeringa ::..</option>
												<?php $jeringas = ['27Gx3/8','23Gx1/2','23Gx1','25Gx5/8','22Gx1','22Gx1/2','22Gx5'];
												for ($i = 0; $i < sizeof($jeringas) ; $i++) {
													echo "<option value=".$jeringas[$i].">Jeringa ".$jeringas[$i]."</option>";
												}
												echo "<option value='cajas de bioseguridad'>Cajas de bioseguridad</option>";
												?>
											</select>
										</div>
									</td>
								</tr>
								<tr>
									<td>Fecha de ingreso:</td>
									<td><input type="date" name="fec_ing" id="fec_ing" value="<?php echo set_value_input(array(),'fec_ing','fec_ing'); ?>" required="true"/></td>
								</tr>
								<tr>
									<td>Fecha de expiracion:</td>
									<td><input type="date" name="fec_exp" id="fec_exp" value="<?php echo set_value_input(array(),'fec_exp','fec_exp'); ?>" required="true"/></td>
								</tr>
								<tr>
									<td>Stock:</td>
									<td><input type="number" name="stock" id="stock" placeholder="Stock del insumo" value="<?php echo set_value_input(array(),'stock','stock'); ?>" required="true"/></td>
								</tr>
								<tr>
									<td><input type="hidden" name="tipo" id="tipo" value="jeringa"></td>
									<td><input type="hidden" name="grabar" id="grabar" value="si" /></td>
								</tr>
								<tr>
									<td><center><input type="submit" value="Registrar Jeringa" /></center></td>
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