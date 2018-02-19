<?php
require_once("public/usuario.php");
if (isset($_SESSION["id"])){
    header('Location: principal/');
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
		<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Log In</h4>
					</div>
					<div class="modal-body">
						<h1>Texto #manosenelcódigo</h1>
					</div>
					<div class="modal-footer">
						<h4>pie de página</h4>
					</div>
				</div>
			</div>
		</div>
		<div id="page-wrapper">
			<!-- Header -->
				<header id="header" class="alt">
					<h1>UNIVERSIDAD MAYOR DE SAN ANDRÉS - CARRERA DE ENFERMERÍA</h1>
					<nav id="nav">
						<ul>
							<li>
								<a href="#" class="icon fa-angle-down">Acerca de</a>
							</li>
							<li><a href="IniciarSesion.php" class="button">Iniciar Sesion</a></li>
							<li><a href="javascript:void(0);" data-toggle="modal" data-target="#modal">Normal</a></li>
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
										<span class="image featured"><img src="images/pic02.jpg" alt="" /></span>
										<h3>Sed lorem adipiscing</h3>
										<p>Integer volutpat ante et accumsan commophasellus sed aliquam feugiat lorem aliquet ut enim rutrum phasellus iaculis accumsan dolore magna aliquam veroeros.</p>
										<ul class="actions">
											<li><a href="#" class="button alt">Learn More</a></li>
										</ul>
									</section>

								</div>
								<div class="6u 12u(narrower)">

									<section class="box special">
										<span class="image featured"><img src="images/pic03.jpg" alt="" /></span>
										<h3>Accumsan integer</h3>
										<p>Integer volutpat ante et accumsan commophasellus sed aliquam feugiat lorem aliquet ut enim rutrum phasellus iaculis accumsan dolore magna aliquam veroeros.</p>
										<ul class="actions">
											<li><a href="#" class="button alt">Learn More</a></li>
										</ul>
									</section>

								</div>
							</div>
							</section>
						</div>
					</div>

				</section>

			<!-- CTA -->
				

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