<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id"])){
	header("Location: ../iniciarSesion.php");
}
if(!isset($_GET["ci"])){
	header("Location: index.php");
}
$u = new usuario();
$sql = "SELECT rh.fec_reg, pe.ci, pe.nombre, pe.paterno, pe.materno, pe.fec_nac, pe.sexo, pa.id_paciente, se.nombre as servicio, se.tipo FROM registrahistoria as rh, persona as pe, paciente as pa, servicio as se WHERE pe.ci = pa.ci and pa.ci = ".$_GET['ci']." and rh.id_paciente = pa.id_paciente and se.id_servicio = rh.id_servicio ";
$datos = $u->getDatosPacienteSql($sql);
if(sizeof($datos) == 0){
	header("Location: index.php")
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>..:: Lista de Pacientes ::..</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/main.css" />
		<script src="alertify/alertify.js"></script>
		<link rel="stylesheet" href="alertify/css/alertify.css">
		<link rel="stylesheet" href="alertify/css/themes/default.min.css">
		<link rel="stylesheet" href="alertify/css/themes/bootstrap.min.css">
		<link rel="stylesheet" href="alertify/css/themes/semantic.min.css">
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
						<h2>Lista de Pacientes Registrados</h2>
					</header>
					<div class="row">
						<div class="12u">

							<!-- Text -->
								<section class="box">
									<h4>Historia Clínica</h4>
									<a href="add.php" class="button small icon fa-plus" >Agregar Paciente</a>
									<div class="table-wrapper">
										<table class="alt">
											<thead>
												<tr>
													<th>Nro.</th>
													<th>Nombres</th>
													<th>Apellido Paterno</th>
													<th>Apellido Materno</th>
													<th>C.I.</th>
													<th>Fecha de Nacimiento</th>
													<th>Sexo</th>
													<th>Accion</th>
													<th>Realizar Atención</th>
													<th>Historia clinica</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$cont = 0;
												foreach($datos as $dato){
													$cont++;
													?>
													<tr>
														<td><?php echo $cont ?></td>
														<td><?php echo $dato->nombre?></td>
														<td><?php echo $dato->paterno?></td>
														<td><?php echo $dato->materno?></td>
														<td><?php echo $dato->ci?> <?php echo $dato->expedido?></td>
														<td><?php echo $dato->fec_nac?></td>
														<td><?php echo $dato->sexo?></td>
														<td><a href="edit.php?ci=<?php echo $dato->ci?>" class="icon fa-pencil">editar</a><br>
														<!--<a href="javascript:void(0);" onclick="eliminar('delete.php?ci=<?php echo $dato->ci?>');" class="icon fa-trash">eliminar</a>--></td>
														<td><a href="../atencion/historia.php?ci=<?php echo $dato->ci?>" class="icon fa-user"></a></td>
														<td>
														<a href="historial.php?ci=<?php echo $dato->ci?>" class="icon fa-file"></a>
														</td>
													</tr>
													<?php
												}
												?>
												<tr>
													<td colspan="10">
														<div class="pull-right">
															<ul class="pagination">
															    <li><a href="index.php">Primera Página</a></li>
															    <?php 
															    if($pagina == 1){
															    	?>
															    	<li class="disabled"><a href="javascript:void(0);" title="">Anterior</a></li>
															    	<?php
															    }
															    else{
															    	$anterior = $pagina-1;
															    	?>
															    	<li><a href="index.php?pagina=<?php echo $anterior ?>">Anterior</a></li>
															    	<?php
															    }
															    ?>

															    <?php
															    for($i=1; $i<$total_paginas; $i++){
															    	?>
															    	<li <?php if($pagina==$i){ echo 'class="active"'; } ?>><a href="index.php?pagina=<?php echo $i;?>"><?php echo $i; ?></a></li>
															    	<?php
															    }
															    ?>

															    <?php
															    if($cont == $cant_por_pagina and $pagina < $total_paginas){
															    	$proximo = $pagina+1;
															    	?>
															    	<li><a href="index.php?pagina=<?php echo $proximo ?>">Siguiente</a></li>
															    	<?php
															    }
															    else{
															    	?>
															    	<li class="disabled"><a href="javascript:void(0);">Siguiente</a></li>
															    	<?php
															    }
															    ?>
															    <li><a href="index.php?pagina=<?php echo $total_paginas; ?>">Ultima Pagina</a></li>
															</ul>
														</div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
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
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/jquery.dropotron.min.js"></script>
			<script src="../assets/js/jquery.scrollgress.min.js"></script>
			<script src="../assets/js/skel.min.js"></script>
			<script src="../assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="../assets/js/main.js"></script>

	</body>
</html>