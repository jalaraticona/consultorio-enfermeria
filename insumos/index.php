<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id_enf"])){
	header("Location: ../index.php");
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
$sql1 = "SELECT count(*) AS cuantos FROM ingresoinsumos;";
$cantidad = $u->GetDatosSql($sql1);
$sql2 = "SELECT * FROM ingresoinsumos as ing, insumos as ins
		WHERE ing.id_insumo = ins.id_insumo
		LIMIT ".$empezar_desde.",".$cant_por_pagina." ";
$datos = $u->GetDatosSql($sql2);

$total_paginas = ceil($cantidad[0]->cuantos/$cant_por_pagina);

$sql = "SELECT * FROM ingresoinsumos as ing, insumos as ins WHERE ing.id_insumo = ins.id_insumo and ins.tipo = 'vacuna' ORDER BY (fec_exp) ASC";
$vacunas = $u->GetDatosSql($sql);
$sql = "SELECT * FROM ingresoinsumos as ing, insumos as ins WHERE ing.id_insumo = ins.id_insumo and ins.tipo = 'jeringa' ORDER BY (fec_exp) ASC";
$jeringas = $u->GetDatosSql($sql);

if(isset($_POST["guardar1"])){
	$u->insertarDesechoVacuna();
	header("Location: index.php?m=3#closeEdit");
}
if(isset($_POST["guardar2"])){
	$u->insertarDesechoJeringa();
	header("Location: index.php?m=3#closeEdit");
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>..:: Lista de Insumos ::..</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../assets/css/main.css" />
		<script src="../assets/alertify/alertify.js"></script>
		<link rel="stylesheet" href="../assets/alertify/css/alertify.css">
		<link rel="stylesheet" href="../assets/alertify/css/themes/default.min.css">
		<link rel="stylesheet" href="../assets/alertify/css/themes/bootstrap.min.css">
		<link rel="stylesheet" href="../assets/alertify/css/themes/semantic.css">
	</head>
	<body>
		<script type="text/javascript">
		a = <?php echo $_GET["m"];?>;
		if(a == 1){
			alertify.success('Insumo registrado correctamente.');
		}
		if(a == 2){
			alertify.warning('Insumo modificado correctamente.');
		}
		if(a == 3){
			alertify.warning('Registro de desechos exitoso.');
		}
		if(a == 4){
			alertify.warning('No se tiene registro de uso del insumo.');
		}
		</script>
		<div id="page-wrapper">

			<!-- Header -->
				<header id="header">
					<h1>UNIVERSIDAD MAYOR DE SAN ANDRÉS - CARRERA DE ENFERMERÍA</h1>
					<nav id="nav">
						<ul>
							<li><a href="../principal/index.php">Inicio</a></li>
							<li>
								<a href="#" class="icon fa-angle-down">Desechar</a>
								<ul>
									<li><a href="#openEdit">vacuna</a></li>
									<li><a href="#openEdit1">jeringa</a></li>
								</ul>
							</li>
							<li><a href="../principal/index.php" class="button">Volver Atras</a></li>
						</ul>
					</nav>
				</header>

			<!-- Main -->
				<section id="main" class="container">
					<header>
						<h2>Insumos Registrados</h2>
					</header>
					<div class="row">
						<div class="12u">

							<!-- Text -->
								<section class="box">
									<h4>Cantidad de insumos registrados registrados: <?php echo $cantidad[0]->cuantos ?> insumos</h4>
									<div class="table-wrapper">
										<table class="alt">
											<thead>
												<tr>
													<th>Comp.</th>
													<th>Lote</th>
													<th>Insumo</th>
													<th>Origen</th>
													<th>Coordinacion red</th>
													<th>Fec. Ing</th>
													<th>Fec. Exp.</th>
													<th>Cant. disp.</th>
													<th>Estado</th>
													<th>Accion</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$cont = 0;
												foreach($datos as $dato){
													$cont++;
													$enc = $u->encriptar($dato->id_ingreso);
													?>
													<tr>
														<td><?php echo $dato->comprobante?></td>
														<td><?php echo $dato->lote?></td>
														<td><?php echo $dato->nombre?></td>
														<td><?php echo $dato->origen?></td>
														<td><?php echo $dato->red?></td>
														<td><?php echo $dato->fec_ing?></td>
														<td><?php echo $dato->fec_exp?></td>
														<td><?php echo $dato->cant_disp?></td>
														<td><?php echo $dato->estado?></td>
														<td><a href="usos.php?id=<?php echo $enc;?>" class="icon fa-pencil">Ver Uso</a></td>
													</tr>
													<?php
												}
												?>
												<tr>
													<td colspan="11">
														<center>
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
														</center>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<br>
									<center><a href="addVacuna.php" class="button small icon fa-plus" >Agregar VACUNA</a>
									<a href="addJeringa.php" class="button small icon fa-plus" >Agregar JERINGAS</a></center>
								</section>
						
						</div>
					</div>

					<div id="openEdit" class="modalEdit">
						<div>
							<a href="#close" title="Close" class="close">X</a>
							<center><h3>..:: Reg vacunas desechadas ::..</h3></center>
							<form action="" method="post" accept-charset="utf-8">
								<label>F.A.:(frasco abierto)</label>
								<input type="text" name="fa" id="fa" placeholder="Ingrese cantidad">
								<label>F.R.:(frasco roto)</label>
								<input type="text" name="fr" id="fr" placeholder="Ingrese cantidad">
								<label>F.M.:(factor manipuleo)</label>
								<input type="text" name="fm" id="fm" placeholder="Ingrese cantidad">
								<label>F.E.:(factor expiracion)</label>
								<input type="text" name="fe" id="fe" placeholder="Ingrese cantidad">
								<label>Lote de vacuna</label>
								<div class="select-wrapper">
									<select name="lotevacunas" id="lotevacunas" >
										<option value="" selected>..:: Selecciones el lote de vacuna ::..</option>
										<?php
										foreach ($vacunas as $data) {
											$id_v = $data->id_insumo;
										 	$nombre = $data->nombre." - ".$data->lote." - ".$data->cant_disp;
										 	$estado = $data->estado;
										 	if($estado == 'usable'){
										 		echo "<option value=".$id_v.">".$nombre."</option>";
										 	}
										} 
										?>
									</select>
								</div>
								<br>
								<input type="hidden" name="guardar1" id="guardar1" value="si">
								<center><button type="submit" class="button">Guardar cambios</button></center>
							</form>
						</div>
					</div>

					<div id="openEdit1" class="modalEdit">
						<div>
							<a href="#close" title="Close" class="close">X</a>
							<center><h3>..:: Reg jeringas desechadas ::..</h3></center>
							<form action="" method="post" accept-charset="utf-8">
								<label>Cantidad:</label>
								<input type="text" name="cantidad" id="cantidad" placeholder="" ="Ingrese cantidad">
								<label>Lote de vacuna</label>
								<div class="select-wrapper">
									<select name="lotejeringas" id="lotejeringas" >
										<option value="" selected>..:: Selecciones el lote de jeringas a usar ::..</option>
										<?php
										foreach ($jeringas as $data) {
											$id_j = $data->id_insumo;
										 	$nombre = $data->nombre." - ".$data->medida." - ".$data->lote." - ".$data->cant_disp;
										 	$estado = $data->estado;
										 	if($estado == 'usable'){
										 		echo "<option value=".$id_j.">".$nombre."</option>";
										 	}
										} 
										?>
									</select>
								</div>
								<br>
								<input type="hidden" name="guardar2" id="guardar2" value="si">
								<center><button type="submit" class="button">Guardar cambios</button></center>
							</form>
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
			<script src="funciones.js"></script>
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/jquery.dropotron.min.js"></script>
			<script src="../assets/js/jquery.scrollgress.min.js"></script>
			<script src="../assets/js/skel.min.js"></script>
			<script src="../assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="../assets/js/main.js"></script>

	</body>
</html>