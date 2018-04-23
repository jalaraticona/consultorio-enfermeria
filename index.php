<?php
require_once("public/usuario.php");
if (isset($_SESSION["id"])){
    header('Location: principal/');
}
if(isset($_POST["user"])){
	$u = new usuario();
	$mensaje='';
	if($_POST["user"] == "superuser" and $_POST["password"] == "cenfermeria"){
		$_SESSION["id_enf"] = 0;
		$_SESSION["user"] = "superuser";
		$_SESSION["tipo"] = "administrador";
		header("Location: principal/");
	}
	$datos = $u->getLogin($_POST["user"], $_POST["password"]);
	if(sizeof($datos) == 0){
		$mensaje.='Usuario incorrecto';
	}
	else{
		$estado = $datos[0]->estado;
		if($estado == "activo"){
			$_SESSION["id_enf"] = $datos[0]->id_enfermera;
			$_SESSION["user"] = $datos[0]->user;
			$_SESSION["tipo"] = $datos[0]->tipo;
			header("Location: principal/");
		}
		else{
			$mensaje.='usuario inactivo';
		}
	}
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>..:: Consultorio de Enfermería ::..</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<style>
		.icon:hover{
			box-shadow:0px 0px 10px 2px rgba(0,0,0,.5);
			cursor:pointer;
		}
		</style>
	</head>
	<body class="landing">
		<div id="page-wrapper">
			<!-- Header -->
				<header id="header" class="alt">
					<h1>UNIVERSIDAD MAYOR DE SAN ANDRÉS - CARRERA DE ENFERMERÍA</h1>
					<nav id="nav">
						<ul>
							<li>
								<a href="#" class="icon fa-angle-down">Acerca de</a>
								<ul>
								    <li><a href="">Facebook Enfermería</a></li>
								    <li><a href="">Web Enfermería</a></li>
								    <li><a href="">Acerca del sistema</a></li>
								</ul>
							</li>
							<li><a href="#openModal" class="button">Iniciar Sesion</a></li>
						</ul>
					</nav>
				</header>

			<!-- Banner -->
				<section id="banner">
					<h3>SISTEMA DE GESTIÓN DE INFORMACIÓN CLÍNICA</h3>
				</section>

			<!-- Main -->
				<section id="main" class="container">

					<section class="box special">
						<header class="major">
							<h2>Consultorio de la Carrera de ENFERMERÍA</h2>
							<p>El consultorio de la carrera de Enfermería pone en funcionamiento <br> sus servicios desde la gestion 2009 y brinda los siguientes servicios</p>
						</header>
						<span class="image featured"><img src="images/pic01.jpg" alt="" /></span>
					</section>

					<!--MODAL-->
					<div id="openModal" class="modalDialog">
						<div>
							<a href="#close" title="Close" class="close">X</a>
							<center><h2>LOGIN</h2></center>
							<p>Bienvenido, por favor ingrese sus datos para ingresar al sistema.</p>
							<?php
							if(!empty($mensaje)){
								?>
								<div class="alert alert-danger">
									<h4><span class="icon fa-ban">&nbsp;<?php echo $mensaje; ?></span></h4>
								</div>
								<?php
							}
							?>
							<form action="" method="post" accept-charset="utf-8">
								<input type="text" name="user" id="user" placeholder="Ingrese Usuario">
								<br>
								<input type="password" name="password" id="password" placeholder="Ingrese contraseña">
								<br>
								<center><button type="submit" class="button">Iniciar sesion</button></center>
							</form>
						</div>
					</div> 

					<div class="row">
						<div class="12u">
							<!-- Text -->
							<section class="box">
							<center><h3>Acerca de los servicios del consultorio</h3></center>
							<h4>Horario de atencion: </h4>
							<h4>Mañana: de 09:30 a 12:30
							<br>Tarde: de 13:00 a 16:30</h4>
							<h4>Lugar de Atencion: Piso 10–Carrera de Enfermería </h4>
							<br>
							<table>
								<thead>
									<tr>
										<th><center>Nro.</center></th>
										<th><center>Servicio</center></th>
										<th><center>Costo en Bs.</center></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>1</td>
										<td>Inyectables</td>
										<td>5.00</td>
									</tr>
									<tr>
										<td>2</td>
										<td>Curaciones Pequeñas</td>
										<td>5.00</td>
									</tr>
									<tr>
										<td>3</td>
										<td>Curaciones Medianas</td>
										<td>10.00</td>
									</tr>
									<tr>
										<td>4</td>
										<td>Oxigenoterapia (por cada 10 min)</td>
										<td>15.00</td>
									</tr>
									<tr>
										<td>5</td>
										<td>Nebulizaciones</td>
										<td>10.00</td>
									</tr>
									<tr>
										<td>6</td>
										<td>Retiro de puntos</td>
										<td>10.00</td>
									</tr>
									<tr>
										<td>7</td>
										<td>Administración de vacunas (Difteria y Tétanos, Antihepatis B e Influenza Estacional).</td>
										<td>Gratuito</td>
									</tr>
									<tr>
										<td>8</td>
										<td>Evaluación crecimiento y desarrollo</td>
										<td>Gratuito</td>
									</tr>
								</tbody>
							</table>
							<p><h4>La atención de los estudiantes Universitarios de nuestra Casa Superior de Estudios son de carácter gratuito, previa presentación  de la matricula universitaria. </h4></p>
							<p><h4>Lugar de pago: Caja Recaudadora – Facultad de Medicina </h4></p>
						</section>

						<section class="box">
							<div class="row">
								<div class="6u 12u(narrower)">

									<section class="box special">
										<span class="image featured"><img src="images/banner.jpg" alt="" /></span>
										<h3>Consultorio de la carrera</h3>
										<p>Foto consultorio de Enfermería.</p>
										<ul class="actions">
											<li><a href="#" class="button alt">Más información</a></li>
										</ul>
									</section>

								</div>
								<div class="6u 12u(narrower)">

									<section class="box special">
										<span class="image featured"><img src="images/banner.jpg" alt="" /></span>
										<h3>Inauguración carrera</h3>
										<p>Dia de inauguración por parte de autoridades de la carrera de Enfermería.</p>
										<ul class="actions">
											<li><a href="#" class="button alt">Más información</a></li>
										</ul>
									</section>

								</div>
							</div>
							</section>
						</div>
					</div>

				</section>

			<!-- Footer -->
				<footer id="footer">
					<ul class="icons">
						<li><a href="http://umsa.bo" class="icon fa-database"><span class="label">Twitter</span></a></li>
						<li><a href="https://es-la.facebook.com/EnfermeriaUMSAFMENT/" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon fa-google-plus"><span class="label">Google+</span></a></li>
					</ul>
					<ul class="copyright">
						<li>&copy; UMSA - FMNENT - ENFERMERIA</li><li>Desarrollo: <a href="http://www.facebook.com/laraticona.jorge">MAIDEN</a></li>
					</ul>
				</footer>

		</div>

		<!-- Scripts -->
			<script src="assets/js/jquery-1.10.2.js"></script>
		    <script src="assets/js/bootstrap.js"></script>
		    <script src="assets/js/funciones.js"></script>
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/jquery.scrollgress.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>