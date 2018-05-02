<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id_enf"])){
	header("Location: ../index.php");
}
$u = new usuario();
$var = str_replace ( " " , "+" , $_GET["ci"] );
$des = $u->desencriptar($var);
if(!isset($_GET["ci"]) and !is_numeric($des)){
	die("Error 404");
}
$datos = $u->getDatoPorCiEnfermera($des);
if(sizeof($datos) == 0){
	die("Error 404 ");
} 
$mensaje='';
if(isset($_POST["grabar"])){
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
			$u->updateEnfermera();
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
					<form method="post" action="">
					<table>
						<thead>
							<th colspan="3"><center><h3>..:: Datos del Personal Enfermero ::..</h3></center></th>
						</thead>
						<tbody>
							<tr>
								<td>Nombres: </td>
								<td colspan="2"><input type="text" name="nombre" id="nombre" placeholder="Ingrese Nombre" minlength="5" maxlength="40" pattern="[a-zA-Z[:space:] áéíóúÁÉÍÓÚñÑ]" value="<?php echo $datos[0]->nombre ?>" required="true" autofocus="true"  /></td>
							</tr>
							<tr>
								<td>Apellido paterno: </td>
								<td colspan="2"><input type="text" name="paterno" id="paterno" placeholder="Ingrese Nombre" value="<?php echo $datos[0]->paterno ?>" required="true" autofocus="true"  /></td>
							</tr>
							<tr>
								<td>Apellido materno: </td>
								<td colspan="2"><input type="text" name="materno" id="materno" placeholder="Ingrese Nombre" value="<?php echo $datos[0]->materno ?>" required="true" autofocus="true"  /></td>
							</tr>
							<tr>
								<td>Numero C.I.: </td>
								<td><input type="number" name="ci" id="ci" min="50000" max="50000000" placeholder="Cedula Identidad" value="<?php echo $datos[0]->ci ?>" required="true"/>
								</td>
								<td>
								<div class="select-wrapper">	
								<select name="expedido" id="expedido" required="true">
									<option value="<?php echo $datos[0]->expedido ?>"><?php echo $datos[0]->expedido ?></option>
									<?php  $ciudades = ['LPZ','BNI','CHQ','CBA','ORU','PND','PSI','SCZ','TJA' ];
									for ($i = 0; $i < sizeof($ciudades) ; $i++) {
										if($datos[0]->expedido != $ciudades[$i]){
										?>
										<option value="<?php echo $ciudades[$i];?>"  <?php echo set_value_select(array(),'expedido','expedido',$ciudades[$i]);?> ><?php echo $ciudades[$i];?></option>
									 	<?php
										}
									} 
									?>
								</select></td>
								</div>
							</tr>
							<tr>
								<td>Fecha de Nacimiento:</td>
								<td colspan="2"><input type="date" name="fec_nac" id="fec_nac" value="<?php echo $datos[0]->fec_nac ?>" required="true"/></td>
							</tr>
							<tr>
								<td>Sexo: </td>
								<td colspan="2">
								<div class="select-wrapper">
								<select name="sexo" id="sexo" required="true">
									<option value="<?php echo $datos[0]->sexo ?>"><?php echo $datos[0]->sexo ?></option>
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
									<option value="<?php echo $datos[0]->tipo ?>" selected><?php echo $datos[0]->tipo ?></option>
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
								<td colspan="3"><center><input type="submit" value="Guardar" /></center></td>
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