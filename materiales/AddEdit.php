<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id_enf"])){
	header("Location: ../index.php");
}
$u = new usuario();
$mensaje='';
$nombre = '';
$clave = '';
$tipo = '';
if(isset($_POST["grabar"])){
	$nom = trim($_POST["nombre"]);
	$cla = trim($_POST["clave"]);
	$dos = trim($_POST["tipo"]);
	if(!$u->soloLetras($nom) or $nom == ''){
		$mensaje.='Campo nombre es necesario, debe contener solo letras. <br>';
	}
	if(!$u->soloLetras($cla) or $cla == ''){
		$mensaje.='Campo clave debe ser necesariamente letras y contener una sola palabra. <br>';
	}
	if($mensaje == ''){
		$u = new usuario();
		if(isset($_POST["nombre"])){
			if(isset($_GET["id"])){
				$u->updateMaterial();
				header("Location: index.php?m=2");
			}
			else{
				$u->insertarMaterial();
				header("Location: index.php?m=1");
			}
		}
	}
}
if(isset($_GET["id"])){
	$var = str_replace ( " " , "+" , $_GET["id"] );
	$des = $u->desencriptar($var);
	if(!is_numeric($des)){
		die("Error 404");
	}
	$datos = $u->getDatoPorIdServicio($des);
	if(sizeof($datos) == 0){
		die("Error 404");
	}
	$clave = $datos[0]->clave;
	$nombre = $datos[0]->nombre;
	$tipo = $datos[0]->tipo;
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
				<li><a href="../index.php">Inicio</a></li>
				<li><a href="../materiales/" class="button">Volver Atras</a></li>
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
								<th colspan="2"><center><h3>..:: Datos del Servicio ::..</h3></center></th>
							</thead>
							<tbody>
								<tr>
									<td>Nombre del servicio:(Titulo para el portal) </td>
									<td><input type="text" name="nombre" id="nombre" placeholder="Ingrese Nombre del servicio" value="<?php if(!isset($_GET['id'])){echo set_value_input(array(),'nombre','nombre'); } else{echo $nombre;} ?>" required="true" autofocus="true"  /></td>
								</tr>
								<tr>
									<td>Clave:(Una palabra clave para identificar el servicio)</td>
									<td><input type="text" name="clave" id="clave" placeholder="Ingrese nonbre clave" value="<?php if(!isset($_GET['id'])){echo set_value_input(array(),'clave','clave'); } else{echo $clave;} ?>" required="true" autofocus="true"  /></td>
								</tr>
								<tr>
									<td>Tipo: </td>
									<td>
										<div class="select-wrapper">
										<select name="tipo" id="tipo" required="true">
										<?php $tipoo = ['vacuna','jeringa'];
												for ($i = 0; $i < sizeof($tipoo) ; $i++) {
													$tip = $tipoo[$i];
												 	if($datos[0]->tipo == $tip){
												 		?>
												 		<option value="<?php echo $tip; ?>" selected <?php if(!isset($_GET['id'])){echo set_value_select(array(),'tipo','tipo',$tip);} ?> ><?php echo $tip; ?></option>
												 		<?php
												 	}
												 	else{
												 		?>
												 		<option value="<?php echo $tip; ?>" <?php if(!isset($_GET['id'])){echo set_value_select(array(),'tipo','tipo',$tip);} ?> ><?php echo $tip; ?></option>
												 		<?php
												 	}
												 } ?>
										</select>
										</div>
									</td>	
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