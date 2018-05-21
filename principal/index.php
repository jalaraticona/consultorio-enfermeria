<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id_enf"])){
	header("Location: ../index.php");
}
$u = new usuario();
if($_SESSION["user"] == "superuser"){
	$nombre_user = "superuser";
	$se = 'masculino';
}
else{
	$sql = "SELECT * FROM enfermera as en, usuarios as us WHERE en.id_enfermera = '".$_SESSION["id_enf"]."' and us.id_enfermera = en.id_enfermera ";
	$datos = $u->GetDatosSql($sql);
	$nombre_user = $datos[0]->nombre;
	$se = $datos[0]->sexo;
	$no = $datos[0]->nombre;
	$pa = $datos[0]->paterno;
	$ma = $datos[0]->materno;
	$cn = $datos[0]->ci;
	$fe = $datos[0]->fec_nac;
	$se = $datos[0]->sexo;
	$us = $datos[0]->user;
	$ps = $datos[0]->password;
	$id = $datos[0]->id_enfermera;
}
if(isset($_POST["guardar"])){
	$u->editInformacion();
	header("Location: index.php#closeEdit");
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>..:: Consultorio de Enfermería ::..</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="../assets/css/main.css" />
	<link href="../assets/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">
	<script src="../assets/alertify/alertify.js"></script>
	<link rel="stylesheet" href="../assets/alertify/css/alertify.css">
	<link rel="stylesheet" href="../assets/alertify/css/themes/default.min.css">
	<link rel="stylesheet" href="../assets/alertify/css/themes/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/alertify/css/themes/semantic.css">
	<style>
	.fas:hover{
		box-shadow:0px 0px 10px 2px rgba(0,0,0,.5);
		cursor:pointer;
	}
	</style>
</head>
<body class="landing">
<?php 
$sql = "SELECT ing.id_ingreso, ins.nombre, ins.tipo, ing.fec_exp, ing.cant_disp FROM ingresoinsumos as ing, insumos as ins WHERE ing.id_insumo = ins.id_insumo and ing.estado = 'usable' and ing.fec_exp BETWEEN CURRENT_DATE() and date_add(CURRENT_DATE(), interval 30 day)";
$est = $u->GetDatosSql($sql);
$sw = 0;
if(sizeof($est) > 0) $sw = 1;
?>
<script type="text/javascript">
<?php
if($sw == 1){
	$men = "Los siguientes insumos tienen fecha de caducidad en los siguientes 30 dias, tomar en cuenta....<br><br>";
	$men.= "<table><thead><tr><th>Nro.</th><th>Nombres</th><th>Tipo</th><th> Fecha de expiración</th><th>Stock</th></tr></thead><tbody>";
	foreach($est as $informacion){
		$nom = $informacion->nombre;
		$tip = $informacion->tipo;
		$exp = $informacion->fec_exp;
		$disp = $informacion->cant_disp;
		$id_insumo = $informacion->id_insumo;
		$men.= "<tr><td>".$id_insumo."</td><td>".$nom."</td><td>".$tip."</td><td>".$exp."</td><td>".$disp."</td></tr>";
	}
	$men.= "</tbody></table>";
	echo "alertify.alert('<center>..:: Alerta!!!.. ::..</center>','".$men."');";
}
?>
</script>
<div id="page-wrapper">
<!-- Header -->
	<header id="header" class="alt">
		<h1>UNIVERSIDAD MAYOR DE SAN ANDRÉS - CARRERA DE ENFERMERÍA</h1>
		<nav id="nav">
			<ul>
				
				<li><a><?php 
				if($se == "femenino"){
					echo "Bienvenida <b>".$nombre_user."</b>";
				} 
				else{
					echo "Bienvenido ".$nombre_user;
				}
				?></a></li>
				<li>
					<a href="#" class="fas fa-angle-down">operaciones</a>
					<ul>
					    <li><a href="../paciente/" >Pacientes registrados</a></li>
					    <li><a href="../atencion/" >Real. Atencion</a></li>
					  	<?php 
					  	if($_SESSION["tipo"] == "administrador"){
					  		echo "<li><a href='../enfermera/'' >Personal Enfermero</a></li>";
					  	}
					  	?>
					    <li><a href="../insumos/" >Insumos registrados</a></li>
					    <li><a href="../reportes/" >Reportes</a></li>
					    <li><a href="../estadisticas/" >Estadisticas</a></li>
					    <li><a href="#openEdit">Editar informacion</a></li>
					</ul>
				</li>
				<li><a href="../logout.php" class="button">Cerrar Sesion</a></li>
			</ul>
		</nav>
	</header>

<!-- Banner -->
	<section id="banner">
		<h2>SISTEMA DE GESTIÓN <br> DE INFORMACIÓN CLÍNICA</h2>
	</section>

<!-- Main -->
	<section id="main" class="container">
		<section class="box special">
			<header class="major">
				<h2>El sistema de informacion brinda las operaciones...</h2>
			</header>
		</section>

		<section class="box special features">
			<div class="features-row">
				<section>
					<a href="../paciente" title=""><span class="fa-stack fa-3x"><i class="fas fa-square fa-stack-2x"></i><i class="fas fa-user-plus fa-stack-1x fa-inverse"></i></span></a>
					<a href="../paciente" title=""><h3>Registrar paciente</h3></a>
					<p>Esta opcion nos permite realizar el registro de la información personal del paciente.</p>
				</section>
				<section>
					<?php 
				  	if($_SESSION["tipo"] == "administrador"){
				  	?>
				  	<a href="../servicios" title=""><span class="fa-stack fa-3x"><i class="fas fa-square fa-stack-2x"></i><i class="fas fa-briefcase-medical fa-stack-1x fa-inverse"></i></span></a>
					<a href="../servicios" title=""><h3>Registro de Servicio</h3></a>
					<p>Puede realizar el registro de un nuevo servicio.</p>
				  	<?php
				  	}
				  	else{
				  	?>
					<a href="../atencion/" title=""><span class="fa-stack fa-3x"><i class="fas fa-square fa-stack-2x"></i><i class="fas fa-ambulance fa-stack-1x fa-inverse"></i></span></span></a>
					<a href="../atencion/" title="">
					<h3>Realizar atencion al paciente</h3></a>
					<p>Esta opción nos permite realizar la atencion al paciente.</p>
					<?php 
					}
					?>
				</section>
			</div>
			<div class="features-row">
				<section>
					<a href="../insumos" title=""><span class="fa-stack fa-3x"><i class="fas fa-square fa-stack-2x"></i><i class="fas fa-medkit fa-stack-1x fa-inverse"></i></span></a>
					<a href="../insumos" title=""><h3>Registro y verificacion de Insumos</h3></a>
					<p>Esta opcion permite al operador registrar los insumos adquiridos, tambien permite obtener informacion acerca del stock disponible.</p>
				</section>
				<section>
					<a href="../reportes/" title=""><span class="fa-stack fa-3x"><i class="fas fa-square fa-stack-2x"></i><i class="fas fa-file-pdf fa-stack-1x fa-inverse"></i></span></a>
					<a href="../reportes/"><h3>Reportes Produccion de Servicios</h3></a>
					<p>Esta opcion permite al operador generar reportes sobre la produccion de servicios del consultorio de Enfermería.</p>
				</section>
			</div>
			<div class="features-row">
				<section>
					<a href="../estadisticas" title=""><span class="fa-stack fa-3x"><i class="fas fa-square fa-stack-2x"></i><i class="fas fa-chart-line fa-stack-1x fa-inverse"></i></span></a>
					<a href="../estadisticas" title=""><h3>Estadisticas del servicio</h3></a>
					<p>Esta opcion permite al operador obtener y visualizar las estadisticas que requiere.</p>
				</section>
				<section>
					<?php 
				  	if($_SESSION["tipo"] == "administrador"){
				  	?>
				  	<a href="../enfermera" title=""><span class="fa-stack fa-3x"><i class="fas fa-square fa-stack-2x"></i><i class="fas fa-user-md fa-stack-1x fa-inverse"></i></span></a>
					<a href="../enfermera" title=""><h3>Registro de Personal Enfermero</h3></a>
					<p>Puede visualizar y registrar al personal enfermero.</p>
				  	<?php
				  	}
				  	?>
				</section>
			</div>
			<div class="features-row">
				<section>
					<?php 
				  	if($_SESSION["tipo"] == "administrador"){
				  	?>
				  	<a href="../materiales" title=""><span class="fa-stack fa-3x"><i class="fas fa-square fa-stack-2x"></i><i class="fas fa-user-kit fa-stack-1x fa-inverse"></i></span></a>
					<a href="../materiales" title=""><h3>Registro de materiales</h3></a>
					<p>Puede agregar materiales para la base de datos y asi poder registrar los insumos nuevos.</p>
				  	<?php
				  	}
				  	?>
				</section>
			</div>
		</section>

		<div id="openEdit" class="modalEdit">
			<div>
				<a href="#close" title="Close" class="close">X</a>
				<center><h3>..:: Editar informacion ::..</h3></center>
				<form action="" method="post" accept-charset="utf-8">
					<label>Nombres</label>
					<input type="text" name="nombre" id="nombre" value="<?php echo $no; ?>">
					<label>Apellido Paterno</label>
					<input type="text" name="paterno" id="paterno" value="<?php echo $pa; ?>">
					<label>Apellido Materno</label>
					<input type="text" name="materno" id="materno" value="<?php echo $ma; ?>">
					<label>Fecha de nacimiento</label>
					<input type="text" name="fec_nac" id="fec_nac" value="<?php echo $fe; ?>">
					<label>Sexo</label>
					<input type="text" name="sexo" id="sexo" value="<?php echo $se; ?>">
					<label>C.I.</label>
					<input type="text" name="ci" id="ci" value="<?php echo $cn; ?>">
					<label>Usuario</label>
					<input type="text" name="user" id="user" value="<?php echo $us; ?>">
					<label>Contraseña</label>
					<input type="text" name="password" id="password" value="<?php echo $ps; ?>">
					<input type="hidden" name="guardar" id="guardar" value="<?php echo $id; ?>">
					<center><button type="submit" class="button">Guardar cambios</button></center>
				</form>
			</div>
		</div>
	</section>

<!-- Footer -->
	<footer id="footer">
		<ul class="icons">
			<div style="color:#908C8C">
				<li><a href="http://umsa.bo"><i class="fas fa-database fa-lg"></i></a></li>
				<li><a href="https://es-la.facebook.com/EnfermeriaUMSAFMENT/"><i class="fas fa-facebook-square fa-lg"></i></a></li>
				<li><a href="#"><i class="fas fa-google-plus fa-lg"></i></a></li>
			</div>
		</ul>
		<ul class="copyright">
			<li>&copy; UMSA - Derechos Reservados</li><li>Desarrollo: <a href="https://es-es.facebook.com/jorge.laraticona">MAIDEN</a></li>
		</ul>
	</footer>

</div>

<!-- Scripts -->
	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/jquery.dropotron.min.js"></script>
	<script src="../assets/js/jquery.scrollgress.min.js"></script>
	<script src="../assets/js/skel.min.js"></script>
	<script src="../assets/js/util.js"></script>
	<script src="../assets/js/main.js"></script>

</body>
</html>