<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id"])){
	header("Location: ../iniciarSesion.php");
}
$u = new usuario();
$var = str_replace ( " " , "+" , $_GET["ci"] );
$des = $u->desencriptar($var);
if(!isset($_GET["ci"]) or !is_numeric($des)){
	die("Error 404");
}
$mensaje='';
if(isset($_GET["ci"]) and is_numeric($des)){
	$sql = "select pe.*, pa.id_paciente, pa.residencia, pa.categoria, pa.carrera_cargo from persona as pe, paciente as pa where pe.ci = pa.ci and pa.ci = ".$des."";
	$datop = $u->getDatosPacienteSql($sql);
	$id_pac = $datop[0]->id_paciente;
	$nombre = $datop[0]->nombre." ".$datop[0]->paterno." ".$datop[0]->materno;
	$fecha = $datop[0]->fec_nac;
	$edad = $u->edad($datop[0]->fec_nac);
	$sexo = $datop[0]->sexo;
	$residencia = $datop[0]->residencia;
	$categoria = $datop[0]->categoria;
	if($categoria == "universitario"){
		$categoria.= " de ".$datop[0]->carrera_cargo;	
	}
	$ci = $datop[0]->ci;
	$sql1 = "select * from servicio";
	$datose = $u->getDatosPacienteSql($sql1);
	$id_serv = $datose[0]->id_servicio;
	$servicio = $datose[0]->nombre;
	$detalle = $datose[0]->detalle;
	$costo = $datose[0]->costo;
	$tipo = $datose[0]->tipo;

	$sql = "SELECT * FROM insumos WHERE tipo = 'vacuna' ORDER BY (fec_exp) ASC";
	$vacunas = $u->getDatosPacienteSql($sql);
	$sql = "SELECT * FROM insumos WHERE tipo = 'jeringa' ORDER BY (fec_exp) ASC";
	$jeringas = $u->getDatosPacienteSql($sql);
}
if (isset($_POST["id_pac"])) {
	$u->insertarVacunacion();
	header("Location: index.php");
}
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
				<li><a href="../principal">Inicio</a></li>
				<li><a href="index.php" class="button">Volver Atras</a></li>
			</ul>
		</nav>
	</header>

<!-- Main -->
	<section id="main" class="container">
		<header>
			<h2>Registro Historia Clinica</h2>
		</header>
		<div class="row">
			<div class="12u">
			<!-- Form -->
				<section class="box">
					<table class="alt">
						<tbody>
							<tr>
								<td colspan="4"><center><h3>..:: DATOS DEL PACIENTE ::..</h3></center></td>
							</tr>
							<tr>
								<td colspan="3">Nombre: <?php echo $nombre; ?></td>
								<td>C.I.: <?php echo $ci; ?></td>
							</tr>
							<tr>
								<td colspan="2">Fecha de Nacimiento: <?php echo $fecha; ?></td>
								<td>Edad: <?php echo $edad; ?></td>
								<td>Sexo: <?php echo $sexo; ?></td>
							</tr>
							<tr>
								<td colspan="2">Municipio de residencia: <?php echo $residencia; ?></td>
								<td colspan="2">Categoria: <?php echo $categoria;?></td>
							</tr>
						</tbody>
					</table><br>
					<div class="table-wrapper">
						<form name="form" action="#" method="post">
							<table class="alt">
								<tr>
									<td colspan="2"><center><h3>..:: REGISTRO DE VACUNACION ::..</h3></center></td>
								</tr>
								<tr>
									<td>Lugar en que realiza el servicio: </td>
									<td>
									<div class="select-wrapper">
									<select name="lugar" id="lugar">
										<option value="" selected>..:: Seleccione ::..</option>
										<option value="dentro">Dentro del servicio</option>
										<option value="fuera">Fuera del servicio</option>
									</select>
									</div>
									</td>
								</tr>
								<tr>
									<td>Vacuna proporcionada: </td>
									<td>	
										<div class="select-wrapper">
										<select name="servicio" name="servicio" id="servicio">
											<option value="" selected>..:: Seleccione el tipo de vacuna ::..</option>
										<?php
										foreach ($datose as $dato) {
											$id_s = $dato->id_servicio;
										 	$servicio = $dato->nombre;
										 	$tipo = $dato->tipo;
										 	if($tipo == 'vacuna'){
										 		echo "<option value=".$id_s.">".$servicio."</option>";
										 	}
										} 
										?>
										</select>
										</div>
									</td>
								</tr>
								<tr>
									<td>Nro de dosis: </td>
									<td>
										<div class="select-wrapper">
										<select name="dosis" id="dosis" disabled="true">
											<option value="primera" selected>Dosis unica</option>
											<option value="segunda">2da dosis</option>
											<option value="tercera">3ra dosis</option>
											<!--<option value="cuarta">4ta dosis</option>
											<option value="quinta">5ta dosis</option>-->
										</select></td>
										</div>
								</tr>
								<tr>
									<td>Lote de vacuna a aplicar: </td>
									<td><div class="select-wrapper">
										<select name="lotevacunas" id="lotevacunas" >
											<option value="" selected>..:: Selecciones el lote de vacunas a usar ::..</option>
											<?php
											foreach ($vacunas as $data) {
												$id_s = $data->id_insumo;
											 	$nombre = $data->fec_exp." - ".$data->nombre." - ".$data->lote." - ".$data->cant_disp;
											 	$estado = $data->estado;
											 	if($estado == 'usable'){
											 		echo "<option value=".$id_s.">".$nombre."</option>";
											 	}
											} 
											?>
										</select>
									</div></td>
								</tr>
								<tr>
									<td>Lote de vacuna a aplicar: </td>
									<td><div class="select-wrapper">
										<select name="lotejeringas" id="lotejeringas" >
											<option value="" selected>..:: Selecciones el lote de jeringas a usar ::..</option>
											<?php
											foreach ($jeringas as $data) {
												$id_s = $data->id_insumo;
											 	$nombre = $data->fec_exp." - ".$data->nombre." - ".$data->medida." - ".$data->lote." - ".$data->cant_disp;
											 	$estado = $data->estado;
											 	if($estado == 'usable'){
											 		echo "<option value=".$id_s.">".$nombre."</option>";
											 	}
											} 
											?>
										</select>
									</div></td>
								</tr>
								<tr>
									<td colspan="2"><input type="hidden" name="id_pac" id="id_pac" value="<?php echo $id_pac; ?>"></td>
								</tr>
								<tr>
									<td><center><input type="submit" value="Registrar Vacunacion" /></center></td>
									<td><center><input type="reset" value="Limpiar Datos" class="alt" /></center></td>
								</tr>
							</table>
						</form>
						<table>
							<div id="resul" class="table-wrapper">
									
							</div>
						</table>
					</div>
				</section>
			</div>
		</div>
	</section>
</div>

<!-- Scripts -->
	<script src="../public/jquery-1.10.2.js"></script>
	<script src="funciones.js"></script>
	<script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
    <!-- polyfiller file to detect and load polyfills -->
    <script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
    <script>
      webshims.setOptions('waitReady', false);
      webshims.setOptions('forms-ext', {types: 'date'});
      webshims.polyfill('forms forms-ext');
    </script>
	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/jquery.dropotron.min.js"></script>
	<script src="../assets/js/jquery.scrollgress.min.js"></script>
	<script src="../assets/js/skel.min.js"></script>
	<script src="../assets/js/util.js"></script>
	<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
	<script src="../assets/js/main.js"></script>
</body>
</html>