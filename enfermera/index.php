<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id"])){
	header("Location: ../iniciarSesion.php");
}
$u = new usuario();
$cant_por_pagina = 10;
if(isset($_GET["pagina"])){
	if(is_numeric($_GET["pagina"])){
		if($_GET["pagina" == 1]){
			header("Location: index.php");
		}
		else{
			$pagina = $_GET["pagina"];
		}
	}
	else{
		header("Location: index.php");
	}
}
else{
	$pagina = 1;
}
$empezar_desde = ($pagina-1)*$cant_por_pagina;
$sql1 = "select count(*) as cuantos from enfermera;";
$cantidad = $u->getDatosPacienteSql($sql1);
$sql2 = "select pe.* from enfermera as en, persona as pe where en.ci = pe.ci
		limit ".$empezar_desde.",".$cant_por_pagina." ";
$datos = $u->getDatosPacienteSql($sql2);

$total_paginas = ceil($cantidad[0]->cuantos/$cant_por_pagina);
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>..:: Lista de Pacientes ::..</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="../assets/css/main.css" />
</head>
<body>
<div id="page-wrapper">

<!-- Header -->
	<header id="header">
		<h1>UNIVERSIDAD MAYOR DE SAN ANDRÉS - CARRERA DE ENFERMERÍA</h1>
		<nav id="nav">
			<ul>
				<li><a href="../principal/index.php" class="button">Volver Atras</a></li>
			</ul>
		</nav>
	</header>

<!-- Main -->
	<section id="main" class="container">
		<header>
			<h2>Lista de Pacientes Registrados</h2>
		</header>
		<?php
			if(isset($_GET["m"])){
				switch ($_GET["m"]) {
					case '1':
						?>
						<div class="alert alert-success">
							Los datos personales del paciente se han registrado correctamente.
						</div>
						<?php
					break;
					case '2':
						?>
						<div class="alert alert-success">
							Los datos personales del paciente se han modificado correctamente.
						</div>
						<?php
					break;
					case '3':
						?>
						<div class="alert alert-success">
							Se ha eliminado correctamente el resgistro del paciente.
						</div>
						<?php
					break;
				}
			}
		?>
		<div class="row">
			<div class="12u">

			<!-- Text -->
				<section class="box">
					<h4>Enfermer@s registradas: <?php echo $cantidad[0]->cuantos ?> </h4>
					<div class="table-wrapper">
						<table class="alt">
							<thead>
								<tr>
									<th>Nro.</th>
									<th>Nombres_Apellidos</th>
									<th>C.I.</th>
									<th>Fecha de Nacimiento</th>
									<th>Sexo</th>
									<th>Accion</th>
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
										<td><?php echo $dato->nombre." ".$dato->paterno." ".$dato->materno?></td>
										<td><?php echo $dato->ci?> <?php echo $dato->expedido?></td>
										<td><?php echo $dato->fec_nac?></td>
										<td><?php echo $dato->sexo?></td>
										<td><a href="edit.php?ci=<?php echo $dato->ci?>" class="icon fa-pencil">editar</a><br>
										<!--<a href="javascript:void(0);" onclick="eliminar('delete.php?ci=<?php echo $dato->ci?>');" class="icon fa-trash">eliminar</a>--></td>
									</tr>
									<?php
								}
								?>
								<tr>
									<td colspan="9">
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
					<center><a href="add.php" class="button small icon fa-plus" >Agregar Personal</a></center>
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