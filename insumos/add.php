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
		$u = new usuario();
		if(isset($_POST["nombre"])){
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
								<h3>Se pide por favor llenar el Nombre de los insumos bajo la siguiente lista:</h3>
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
												<th><h3>Datos del insumo</h3></th>
											</thead>
											<tbody>
												<tr>
													<td>Nombre Insumo:</td>
													<td><input type="text" name="nombre" id="nombre" placeholder="Ingrese Nombre" value="<?php echo set_value_input(array(),'nombre','nombre'); ?>" required="true" autofocus="true"  /></td>
												</tr>
												<tr>
													<td>Tipo:</td>
													<td><select name="tipo" id="tipo" required="true">
														<option value="" <?php echo set_value_select(array(),'tipo','tipo',''); ?>>Seleccione.......</option>
														<option value="jeringa" <?php echo set_value_select(array(),'tipo','tipo','jeringa'); ?>>Jeringa</option>
														<option value="vacuna" <?php echo set_value_select(array(),'tipo','tipo','vacuna'); ?>>Vacuna</option>
														<option value="inyectable" <?php echo set_value_select(array(),'tipo','tipo','inyectable'); ?>>Inyectable</option>
														<option value="guantes" <?php echo set_value_select(array(),'tipo','tipo','guantes'); ?>>Guantes</option>
													</select></td>
												</tr>
												<tr>
													<td>Detalle</td>
													<td><textarea name="detalle" id="detalle" placeholder="Ingresa las observaciones o detalles del producto" rows="6"></textarea></td>
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
													<td><input type="hidden" name="grabar" id="grabar" value="si" /></td>
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