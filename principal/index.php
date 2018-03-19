<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id"])){
	header("Location: ../iniciarSesion.php");
}
$u = new usuario();
$sql = "SELECT pe.* FROM persona as pe, enfermera as en WHERE en.id_enf = ".$_SESSION["id_enf"]." and en.ci = pe.ci";
$datos = $u->getDatosInsumosSql($sql);
$nombre_user = $datos[0]->nombre;
$se = $datos[0]->sexo;
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>..:: Consultorio de Enfermería ::..</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/main.css" />
		<script src="alertify/alertify.js"></script>
		<link rel="stylesheet" href="alertify/css/alertify.css">
		<link rel="stylesheet" href="alertify/css/themes/default.min.css">
		<link rel="stylesheet" href="alertify/css/themes/bootstrap.min.css">
		<link rel="stylesheet" href="alertify/css/themes/semantic.min.css">
		<style>
		.icon:hover{
			box-shadow:0px 0px 10px 2px rgba(0,0,0,.5);
			cursor:pointer;
		}
		</style>
	</head>
	<body class="landing">
		<?php 
		$sql = "SELECT * FROM insumos WHERE estado='usable'";
		$est = $u->getDatosInsumosSql($sql);
		$sw = 0;
		foreach($est as $info){
			$fec_exp = $info->fec_exp;
			$fecha = date("m") - date('m', strtotime($fec_exp));
			if($fecha == 0){
				$sw = 1;
			}
		}
		?>
		<script type="text/javascript">
		<?php
		if($sw == 1){
			$men = "Los siguientes insumos tienen fecha de caducidad en los siguientes 30 dias, tomar en cuenta....<br><br>";
			$men.= "<table><thead><tr><th>Nro.</th><th>Nombres</th><th>Tipo</th><th> Fecha de expiración</th><th>Stock</th></tr></thead><tbody>";
			foreach($est as $informacion){
				$nombre = $informacion->nombre;
				$tipo = $informacion->tipo;
				$fec_exp = $informacion->fec_exp;
				$fecha = date("m") - date('m', strtotime($fec_exp));
				$stock = $informacion->stock;
				$id_insumo = $informacion->id_insumo;
				$dias = (strtotime(date("m/d/y"))-strtotime($fec_exp))/86400;
				$dias = abs($dias);
				$dias = floor($dias);
				if($dias < 31){
					$men.= "<tr><td>".$id_insumo."</td><td>".$nombre."</td><td>".$tipo."</td><td>".$fec_exp."</td><td>".$stock."</td></tr>";
				}
			}
			$men.= "</tbody></table>";
			echo "alertify.alert('..:: Alerta!!!..... ::..','".$men."');";
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
								echo "Bienvenida ".$nombre_user;
							} 
							else{
								echo "Bienvenido ".$nombre_user;
							}
							?></a></li>
							<li><a href="index.php">Inicio</a></li>
							<li>
								<a href="#" class="icon fa-angle-down">operaciones</a>
								<ul>
								    <li><a href="../enfermera/" >Usuarios Enfermeria</a></li>
								    <li><a href="../enfermera/add.php" >Registrar Enfermera</a></li>
								  	<?php 
								  	if($_SESSION["tipo"] == "administrador"){
								  		echo "<li><a href='../reportes/'' >Reportes anuales</a>";
								  	}
								  	?>
								    </li>
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
								<a href="../paciente" title=""><span class="icon major fa-users accent3"></span></a>
								<a href="../paciente" title=""><h3>Registrar paciente</h3></a>
								<p>Esta opcion nos permite realizar el registro de la información personal del paciente.</p>
							</section>
							<section>
								<a href="../atencion/" title="">
								<span class="icon major fa-heartbeat accent2"></span></a>
								<a href="../atencion/" title="">
								<h3>Realizar atencion al paciente</h3></a>
								<p>Esta opción nos permite realizar la atencion al paciente.</p>
							</section>
						</div>
						<div class="features-row">
							<section>
								<a href="../insumos" title=""><span class="icon major fa-copy accent4"></span></a>
								<a href="../insumos" title=""><h3>Registro y verificacion de Insumos</h3></a>
								<p>Esta opcion permite al operador registrar los insumos adquiridos, tambien permite obtener informacion acerca del stock disponible.</p>
							</section>
							<section>
								<a href="../reportes/" title=""><span class="icon major fa-paste accent5"></a></span>
								<a href="../reportes/"><h3>Reportes Produccion de Servicios</h3></a>
								<p>Esta opcion permite al operador generar reportes sobre la produccion de servicios del consultorio de Enfermería.</p>
							</section>
						</div>
					</section>

				</section>

			<!-- Footer -->
				<footer id="footer">
					<ul class="icons">
						<li><a href="http://umsa.bo" class="icon fa-database"><span class="label">Twitter</span></a></li>
						<li><a href="https://es-la.facebook.com/EnfermeriaUMSAFMENT/" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon fa-google-plus" target="_blank"><span class="label">Google+</span></a></li>
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