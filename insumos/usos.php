<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id_enf"])){
	header("Location: ../index.php");
}
$u = new usuario();
$var = str_replace ( " " , "+" , $_GET["id"] );
$des = $u->desencriptar($var);
if(!isset($_GET["id"]) or !is_numeric($des)){
	header("Location: index.php");
}
$sql = "SELECT * FROM insumos AS ins, ingresoinsumos AS ing WHERE ing.id_insumo = ins.id_insumo AND ing.id_ingreso = ".$des." ";
$datos = $u->GetDatosSql($sql);
$sql = "SELECT * FROM ingresoinsumos AS ing, salidainsumos AS sal WHERE ing.id_ingreso = sal.id_ingreso AND ing.id_ingreso = ".$des." ";
$datos2 = $u->GetDatosSql($sql);
if(sizeof($datos2) == 0){
	header("Location: index.php?m=4");
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>..:: Lista de Pacientes ::..</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="../assets/css/main.css" />
	<style type="text/css" media="screen">
	#div1{	
		overflow-y:scroll;
 		height:500px;
 		width:auto;
	}
	</style>
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
				<li><a href="../insumos/index.php" class="button">Volver Atras</a></li>
			</ul>
		</nav>
	</header>

<!-- Main -->
	<section id="main" class="container">
		<div class="row">
			<div class="12u">

			<!-- Text -->
				<section class="box">
					<div class="table-wrapper">
						<table>
							<tr>
								<td colspan="7"><center><h3>..:: Registro de uso de Insumos ::..</h3></center></td>
								<td>Nro.: <?php echo $datos[0]->id_ingreso; ?></td>
							</tr>
							<tr>
								<td colspan="8"></td>
							</tr>
							<tr>
								<td>Nombre del insumo:</td>
								<td colspan="3"><?php echo $datos[0]->nombre; ?></td>
								<td>Red: </td>
								<td><?php echo $datos[0]->red; ?></td>
								<td>Clave: </td>
								<td><?php echo $datos[0]->clave; ?></td>
							</tr>
							<tr>
								<td>Fecha de registro:</td>
								<td><?php echo $datos[0]->fec_ing; ?></td>
								<td>Stock:</td>
								<td><?php echo $datos[0]->stock; ?></td>
								<td>Stock Disponible:</td>
								<td><?php echo $datos[0]->cant_disp; ?></td>
								<td>Tipo: </td>
								<td><?php echo $datos[0]->tipo; ?></td>
							</tr>
							<tr>
								<td>Nro de comprobante:</td>
								<td><?php echo $datos[0]->comprobante; ?></td>
								<td>Lote:</td>
								<td colspan="2"><?php echo $datos[0]->lote; ?></td>
								<td>Origen: </td>
								<td colspan="2"><?php echo $datos[0]->origen; ?></td>
							</tr>
						</table>
						<hr border="2">
						<div id="div1">
						<table class="alt">
							<thead>
								<tr>
									<th>Nro.</th>
									<th>Fecha de registro</th>
									<th>Destino</th>
									<th>Cant. Disp.</th>
									<th>Cant. Usada</th>
									<th>Cant. Per.</th>
									<th>Saldo</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								$vac = "Vacunacion";
								foreach ($datos2 as $info) {
									$fecha = $info->fec_reg;
									$saldo = $info->saldo;
									$disp = $info->cant_disp;
									$egre = $info->cant_egre;
									$per = $info->cant_per;
									?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $fecha; ?></td>
										<td><?php echo $vac; ?></td>
										<td><?php echo $disp; ?></td>
										<td><?php echo $egre; ?></td>
										<td><?php echo $per; ?></td>
										<td><?php echo $saldo; ?></td>
									</tr>
									<?php
									$i++;
								}
								?>
							</tbody>
						</table>
						</div>
					</div>
				</section>
			</div>
		</div>
	</section>

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