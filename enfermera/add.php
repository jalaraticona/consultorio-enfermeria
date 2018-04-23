<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id"])){
	header("Location: ../index.php");
}
$mensaje='';
if(isset($_POST["grabar"])){
	$u = new usuario();
	$nom = trim($_POST["nombre"]);
	$pat = trim($_POST["paterno"]);
	$mat = trim($_POST["materno"]);
	$ci = trim($_POST["ci"]);
	$fec = $_POST["fec_nac"];
	$sex = $_POST["sexo"];
	if(!$u->soloLetras($nom) or $nom == ''){
		$mensaje.='Campo nombre es necesario, debe contener solo letras. <br>';
	}
	if(!$u->soloLetras($pat) or $pat == ''){
		$mensaje.='Campo apellido paterno es necesario, debe contener solo letras. <br>';
	}
	if(!$u->soloLetras($mat) or $mat == ''){
		$mensaje.='Campo apellido materno es necesario, debe contener solo letras. <br>';
	}
	if(!$u->soloNumero($ci) and ($ci > 50000 and $ci < 50000000)){
		$mensaje.='Ci debe ser numerico, debe ser mayor a 50000 y menor a 50000000. <br>';
	}
	if(!$u->validaFecha($fec)){
		$mensaje.='La fecha de nacimiento no puede ser posterior a la actual. <br>';
	}
	if($mensaje == ''){
		if(isset($_POST["nombre"])){
			$u->insertarEnfermera();
			header("Location: index.php?m=1");
		}
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>..:: Registro Personal ::..</title>
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
		<div class="row">
			<div class="12u">
			<!-- Form -->
				<section class="box">
					<form method="post" action="">
					<table>
						<thead>
							<th colspan="3"><center><h3>..:: Datos del paciente ::..</h3></center></th>
						</thead>
						<tbody>
							<tr>
								<td>Nombres: </td>
								<td colspan="2"><input type="text" name="nombre" id="nombre" placeholder="Ingrese Nombre" minlength="5" maxlength="40" pattern="[a-zA-Z[:space:] áéíóúÁÉÍÓÚñÑ]" value="<?php echo set_value_input(array(),'nombre','nombre'); ?>" required="true" autofocus="true"  /></td>
							</tr>
							<tr>
								<td>Apellido paterno: </td>
								<td colspan="2"><input type="text" name="paterno" id="paterno" placeholder="Ingrese Nombre" value="<?php echo set_value_input(array(),'paterno','paterno'); ?>" required="true" autofocus="true"  /></td>
							</tr>
							<tr>
								<td>Apellido materno: </td>
								<td colspan="2"><input type="text" name="materno" id="materno" placeholder="Ingrese Nombre" value="<?php echo set_value_input(array(),'materno','materno'); ?>" required="true" autofocus="true"  /></td>
							</tr>
							<tr>
								<td>Numero C.I.: </td>
								<td><input type="number" name="ci" id="ci" min="50000" max="50000000" placeholder="Cedula Identidad" value="<?php echo set_value_input(array(),'ci','ci'); ?>" required="true"/>
								</td>
								<td>
								<div class="select-wrapper">	
								<select name="expedido" id="expedido" required="true">
									<option value="" <?php echo set_value_select(array(),'expedido','expedido',''); ?>>Seleccione.......</option>
									<option value="la paz" <?php echo set_value_select(array(),'expedido','expedido','la paz'); ?>>La Paz</option>
									<option value="santa cruz"<?php echo set_value_select(array(),'expedido','expedido','santa cruz'); ?>>Santa Cruz</option>
									<option value="cochabamba"<?php echo set_value_select(array(),'expedido','expedido','cochabamba'); ?>>Cochabamba</option>
									<option value="pando"<?php echo set_value_select(array(),'expedido','expedido','pando'); ?>>Pando</option>
									<option value="beni"<?php echo set_value_select(array(),'expedido','expedido','beni'); ?>>Beni</option>
									<option value="oruro"<?php echo set_value_select(array(),'expedido','expedido','oruro'); ?>>Oruro</option>
									<option value="potosi"<?php echo set_value_select(array(),'expedido','expedido','potosi'); ?>>Potosi</option>
									<option value="chuquisaca"<?php echo set_value_select(array(),'expedido','expedido','chuquisaca'); ?>>Chuquisaca</option>
									<option value="tarija"<?php echo set_value_select(array(),'expedido','expedido','tarija'); ?>>Tarija</option>
								</select></td>
								</div>
							</tr>
							<tr>
								<td>Fecha de Nacimiento:</td>
								<td colspan="2"><input type="date" name="fec_nac" id="fec_nac" value="<?php echo set_value_input(array(),'fec_nac','fec_nac'); ?>" required="true"/></td>
							</tr>
							<tr>
								<td>Sexo: </td>
								<td colspan="2">
								<div class="select-wrapper">
								<select name="sexo" id="sexo" required="true">
									<option value="" <?php echo set_value_select(array(),'sexo','sexo',''); ?>>Seleccione.......</option>
									<option value="masculino" <?php echo set_value_select(array(),'sexo','sexo','masculino'); ?>>Masculino</option>
									<option value="femenino" <?php echo set_value_select(array(),'sexo','sexo','femenino'); ?>>Femenino</option>
								</select>
								</div>
								</td>
							</tr>
							<tr>
								<td>Tipo de usuario: </td>
								<td colspan="2">
								<div class="select-wrapper">
								<select name="tipo" id="tipo" required="true">
									<option value="estandar" <?php echo set_value_select(array(),'tipo','tipo',''); ?> selected="true" >administrador del consultorio</option>
									<option value="administrador" <?php echo set_value_select(array(),'tipo','tipo','masculino'); ?>>Supervisor del consultorio</option>
								</select>
								</div>
								</td>
							</tr>
							<tr>
								<td><input type="hidden" name="grabar" id="grabar" value="si" /></td>
							</tr>
							<tr>
								<td colspan="3"><center><input type="submit" value="Registrar" /></center></td>
							</tr>
						</tbody>
					</table>
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