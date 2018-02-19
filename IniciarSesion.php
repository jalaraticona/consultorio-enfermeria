<?php 
require_once("public/usuario.php");
if(isset($_POST["user"])){
	$u = new usuario();
	$mensaje='';
	$datos = $u->getLogin($_POST["user"], $_POST["password"]);
	if(sizeof($datos) == 0){
		$mensaje.='Los datos ingresados son incorrectos';
	}
	else{
		$estado = $datos[0]->estado;
		if($estado == "activo"){
			$_SESSION["id"] = $datos[0]->id_usuario;
			$_SESSION["user"] = $datos[0]->user;
			$_SESSION["tipo"] = $datos[0]->tipo;
			$_SESSION["id_enf"] = $datos[0]->id_enf;
			header("Location: principal/");
		}
		else{
			$mensaje.='El usuario ya no esta activo actualmente ingrese un usuario actívo';
		}
	}
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>..:: Iniciar Sesion ::..</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	</head>
	<body>
		<div id="page-wrapper">

			<!-- Header -->
				<header id="header">
					<h1>UNIVERSIDAD MAYOR DE SAN ANDRES - CARRERA DE ENFERMERIA</h1>
					<nav id="nav">
						<ul>
							<li><a href="#" class="button">Volver atras</a></li>
						</ul>
					</nav>
				</header>

			<!-- Main -->
				<section id="main" class="container 75%">
					<header>
						<h2>INICIAR SESION</h2>
						<p>Por favor introdusca el usuario y contraseña asignado por el supervisor</p>
					</header>
					<?php
					if(!empty($mensaje)){
						?>
						<div class="alert alert-danger">
							<center><h3><?php echo $mensaje; ?></h3></center>
						</div>
						<?php
					}
					?>
					<div class="box">
						<form action="" method="post" accept-charset="utf-8">
							<div class="row uniform 50%">
								<div class="12u">
									<input type="text" name="user" id="user" value="<?php echo helpers::set_value_input(array(),'user','user') ?>" placeholder="Introdusca el usuario" autofocus="true" />
								</div>
							</div>
							<div class="row uniform 50%">
								<div class="12u">
									<input type="password" name="password" id="password" value="<?php echo helpers::set_value_input(array(),'password','password') ?>" placeholder="Introdusca su contraseña" />
								</div>
							</div>
							<div class="row uniform 50%">
								<div class="6u 12u(mobilep)">
									<center><input type="reset" value="Limpiar"/></center>
								</div>
								<div class="6u 12u(mobilep)">
									<center><input type="submit" value="Ingresar"/></center>
								</div>
							</div>
						</form>
					</div>
				</section>
		</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/jquery.scrollgress.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html>