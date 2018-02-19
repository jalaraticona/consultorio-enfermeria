<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id"])){
	header("Location: ../iniciarSesion.php");
}
$u = new usuario();
if(isset($_POST["busqueda"])){
	$u->insertarHistoria();
	header("Location: index.php?m=1");
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>..:: Lista de Pacientes ::..</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/main.css" />
		<script type="text/javascript">
			function cambiaMayuscula(elemento){
				elemento.value = elemento.value.toUpperCase();
			}
		</script>
	</head>
	<body>
		<div id="page-wrapper">

			<!-- Header -->
				<header id="header">
					<h1>UNIVERSIDAD MAYOR DE SAN ANDRÉS - CARRERA DE ENFERMERÍA</h1>
					<nav id="nav">
						<ul>
							<li><a href="../principal/index.php">Inicio</a></li>
							<li>
								<a href="#" class="icon fa-angle-down">Operaciones</a>
								<ul>
									<li><a href="#">Agregar</a></li>
									<li><a href="#">Contact</a></li>
									<li><a href="#">Elements</a></li>
								</ul>
							</li>
							<li><a href="../principal/index.php" class="button">Volver Atras</a></li>
						</ul>
					</nav>
				</header>

			<!-- Main -->
				<section id="main" class="container">
					<header>
						<h2>Busqueda del paciente</h2>
					</header>
					<div class="row">
						<div class="12u">
							<!-- Text -->
								<section class="box">
									<h4>Puede realizar la busqueda ingresando el C.I. o ingrese el nombre</h4>
									<input type="text" name="busqueda" id="busqueda" placeholder="Buscar a partir del Numero de Carnet de Identidad o escriba el nombre" />
									<br>
									<div class="table-wrapper">
										<table id="resultado" class="alt"></table>
									</div>
									<table id="resultado"></table>
								</section>
						
						</div>
					</div>
				</section>

			<!-- Footer -->
				<footer id="footer">
					<ul class="icons">
						<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="#" class="icon fa-github"><span class="label">Github</span></a></li>
						<li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
						<li><a href="#" class="icon fa-google-plus"><span class="label">Google+</span></a></li>
					</ul>
				</footer>

		</div>

		<!-- Scripts -->
			<script src="../paciente/funciones.js"></script>
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/jquery.dropotron.min.js"></script>
			<script src="../assets/js/jquery.scrollgress.min.js"></script>
			<script src="../assets/js/skel.min.js"></script>
			<script src="../assets/js/util.js"></script>
			<script src="../assets/js/main.js"></script>

	</body>
</html>