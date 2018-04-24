<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id_enf"])){
	header("Location: ../index.php");
}
$u = new usuario();
$mensaje='';
if(isset($_POST["grabar"])){
	$com = trim($_POST["comprobante"]);
	$lot = trim($_POST["lote"]);
	$ori = trim($_POST["origen"]);
	$red = trim($_POST["red"]);
	$med = trim($_POST["medida"]);
	$feci = trim($_POST["fec_ing"]);
	$fece = trim($_POST["fec_exp"]);
	$sto = trim($_POST["stock"]);
	if(!$u->soloNumero($com) and $com < 500){
		$mensaje.='Nro de comprobante debe ser numerico y debe ser menor a 500. <br>';
	}
	if($lot == ''){
		$mensaje.='ingrese el lote del insumo. <br>';
	}
	if(!$u->validaFechaInsumo($feci)){
		$mensaje.='El insumo solo puede ser registrado posterior al dia actual o un plazo maximo de dos dias. <br>';
	}
	if(!$u->validaFechaM($fece)){
		$mensaje.='No se admite fecha de expiracion pasadas, minimamente fecha de expiracion debe tener 10 dias. <br>';
	}
	if(!$u->soloNumero($sto) and ($sto > 20 and $sto < 1000)){
		$mensaje.='el stock no puede ser gigantesco solo se acepta como maximo 1000. <br>';
	}
	if($mensaje == ''){
		if(isset($_POST["medida"])){
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
											<option value="pai" <?php echo set_value_select(array(),'origen','origen','pai'); ?> selected>PAI SEDES LA PAZ</option>
											<option value="otro" <?php echo set_value_select(array(),'origen','origen','otro'); ?>>otro..</option>
										</select>
									</div></td>
								</tr>
								<tr>
									<td>Red: </td>
									<td><div class="select-wrapper">
										<select name="red" id="red" required="true">
											<option value="norte" <?php echo set_value_select(array(),'red','red','norte'); ?> selected>Nro.3 norte central</option>
											<option value="otro" <?php echo set_value_select(array(),'red','red','otro'); ?>>otro..</option>
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
													?>
													<option value="<?php echo $jeringas[$i]; ?>" <?php echo set_value_select(array(),'medida','medida',$jeringas[$i]); ?> >Jeringa <?php echo $jeringas[$i]; ?></option>
													<?php
												}
												?>
												<option value='cajas de bioseguridad' <?php echo set_value_select(array(),'medida','medida','cajas de bioseguridad'); ?>>Cajas de bioseguridad</option>
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