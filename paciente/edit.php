<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id"])){
	header("Location: ../iniciarSesion.php");
}
$u = new usuario();
$var = str_replace ( " " , "+" , $_GET["ci"] );
$des = $u->desencriptar($var);
if(!isset($_GET["ci"]) and !is_numeric($des)){
	die("Error 404");
}
$datos = $u->getDatoPorCiPaciente($des);
if(sizeof($datos) == 0){
	die("Error 404");
}
$mensaje='';
if(isset($_POST["grabar"])){
	if( filter_var( trim($_POST["nombre"]) ) == false){
		$mensaje.='El campo nombre es obligatorio. <br>';
	}
	if( filter_var( trim($_POST["paterno"]) ) == false){
		$mensaje.='El campo paterno es obligatorio. <br>';
	}
	if( filter_var( trim($_POST["materno"]) ) == false){
		$mensaje.='El campo materno es obligatorio. <br>';
	}
	if( filter_var( trim($_POST["ci"]) ) == false){
		$mensaje.='El campo Cedula de Identidad es obligatorio. <br>';
	}
	if( filter_var( trim($_POST["expedido"]) ) == false){
		$mensaje.='Es necesario seleccionar la ciudad de expedición. <br>';
	}
	if( filter_var( trim($_POST["fec_nac"]) ) == false){
		$mensaje.='El campo Fecha de Naciemiento en obligatorio. <br>';
	}
	if( filter_var( trim($_POST["sexo"]) ) == false){
		$mensaje.='Es necesario seleccionar su genero. <br>';
	}
	if($mensaje == ''){
		$u = new usuario();
		if(isset($_POST["nombre"])){
			$u->updatePaciente();
			header("Location: index.php?m=2");
		}
	}
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>..:: Editar información Pacientes ::..</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="../assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	</head>
	<body>
		<div id="page-wrapper">

			<!-- Header -->
				<header id="header">
					<h1>UNIVERSIDAD MAYOR DE SAN ANDRÉS - CARRERA DE ENFERMERÍA</h1>
					<nav id="nav">
						<ul>
							<li><a href="index.php">Inicio</a></li>
							<li><a href="../paciente/" class="button">Volver Atras</a></li>
						</ul>
					</nav>
				</header>

			<!-- Main -->
				<section id="main" class="container">
					<header>
						<h2>Editar Información Paciente</h2>
					</header>
					<div class="row">
						<div class="12u">

							<!-- Form -->
								<section class="box">
									<form method="post" action="#">
										<table>
											<thead>
												<th colspan="3"><center><h3>..:: Editar Datos del paciente ::..</h3></center></th>
											</thead>
											<tbody>
												<tr>
													<td>Nombres: </td>
													<td colspan="2"><input type="text" name="nombre" id="nombre" placeholder="Ingrese Nombre" value="<?php echo $datos[0]->nombre ?>" required="true" autofocus="true"  /></td>
												</tr>
												<tr>
													<td>Apellido paterno: </td>
													<td colspan="2"><input type="text" name="paterno" id="paterno" placeholder="Ingrese Nombre" value="<?php echo $datos[0]->paterno ?>" required="true" autofocus="true"  /></td>
												</tr>
												<tr>
													<td>Apellido materno: </td>
													<td colspan="2"><input type="text" name="materno" id="materno" placeholder="Ingrese Nombre" value="<?php echo $datos[0]->materno ?>" required="true" autofocus="true"  /></td>
												</tr>
												<tr>
													<td>Numero C.I.: </td>
													<td><input type="number" name="ci" id="ci" placeholder="Cedula Identidad" value="<?php echo $datos[0]->ci ?>" required="true"/>
													</td>
													<td>
													<select name="expedido" id="expedido" required="true">
														<option value="<?php echo $datos[0]->expedido ?>" selected><?php echo $datos[0]->expedido ?></option>
														<option value="">Seleccione.......</option>
														<option value="la paz">La Paz</option>
														<option value="santa cruz">Santa Cruz</option>
														<option value="cochabamba">Cochabamba</option>
														<option value="pando">Pando</option>
														<option value="beni">Beni</option>
														<option value="oruro">Oruro</option>
														<option value="potosi">Potosi</option>
														<option value="chuquisaca">Chuquisaca</option>
														<option value="tarija">Tarija</option>
													</select></td>
												</tr>
												<tr>
													<td>Fecha de Nacimiento:</td>
													<td colspan="2"><input type="date" name="fec_nac" id="fec_nac" value="<?php echo $datos[0]->fec_nac ?>" required="true"/></td>
												</tr>
												<tr>
													<td>Sexo: </td>
													<td colspan="2"><select name="sexo" id="sexo" required="true">
														<option value="<?php echo $datos[0]->sexo ?>" selected><?php echo $datos[0]->sexo ?></option>
														<option value="masculino" >Masculino</option>
														<option value="femenino" >Femenino</option>
													</select></td>
												</tr>
												<tr>
													<td>Municipio de residencia: </td>
													<td colspan="2">
														<div class="select-wrapper">
															<select name="residencia" id="residencia" required="true">
																<?php $municipios = ['ixiamas','san buena ventura','sica sica','calamarca','collana','colquencha','patacamaya','umala','general juan jose perez (charazani)','curva','puerto acosta','mocomoco','puerto carabuco','escoma','humanata','caranavi','alto beni','apolo','pelechuco','san pedro de curahuara','chacarilla','papel pampa','viacha','andres de machaca','desaguadero','guaqui','jesús de machaca','taraco','tiahuanaco','inquisivi','cajuata','colquiri','ichoca','licoma pampa','quime','santiago de machaca','catacora','sorata','combaya','guanay','mapiri','quiabaya','tacacoma','teoponte','tipuani','luribay','cairoma','malla','sapahaqui','yaco','pucarani','batallas','laja','puerto perez','copacabana','san pedro de tiquina','tito yupanqui','chuma','aucapata','ayata','palca','achocalla','el alto','la paz','mecapaca','coroico','coripata','achacachi','ancoraimes','chua cocani','huarina','huatajata','santiago de huata','coro coro','calacoto','caquiaviri','charana','comanche','nazacara de pacajes','santiago de callapa','waldo ballivian','chulumani','irupana','la asunta','palos blancos','yanacachi'];
																for ($i = 0; $i < sizeof($municipios) ; $i++) {
																 	if($datos[0]->residencia == $municipios[$i]){
																 		echo "<option value=".$municipios[$i]." selected>".$municipios[$i]."</option>";
																 	}
																 	else{
																 		echo "<option value=".$municipios[$i].">".$municipios[$i]."</option>";
																 	}
																 } ?>
															</select>
														</div>
													</td>
												</tr>
												<tr>
													<td>Categoria: </td>
													<td colspan="2">
														<div class="select-wrapper">
															<select name="categoria" id="categoria">
																<?php $categorias = ['universitario','docente','personal administrativo','externo'];
																for ($i = 0; $i < sizeof($categorias) ; $i++) {
																 	if($datos[0]->categoria == $categorias[$i]){
																 		echo "<option value=".$categorias[$i]." selected>".$categorias[$i]."</option>";
																 	}
																 	else{
																 		echo "<option value=".$categorias[$i].">".$categorias[$i]."</option>";
																 	}
																 } ?>
															</select>
														</div>
													</td>
												</tr>
												<tr>
													<td>Carrera o cargo: </td>
													<td colspan="2">
														<div class="select-wrapper">
															<select name="carrera" id="carrera">
																<?php $carreras = ['ingenieria agronomica','tecnica superior agropecuaria de viacha','administracion de empresas','auditoria','economia','biologia','estadistica','fisica','informatica','matematicas','quimica','antropologia y arqueologia','ciencias de la comunicacion social','sociologia','trabajo social','bibliotecologia y cs. informacion','ciencias de la educacion','filosofia','historia','linguistica e idiomas','literatura','psicologia','turismo','derecho','ciencias politicas','bioquimica','quimica farmaceutica','ingenieria geografica','ingenieria geologica y medio ambiente','ing. civil','ing. electrica','ing. electronica','ing. industrial','ing. mecanica','ing. metalurgica y materiales','ing. petrolera','ing. quimica','medicina','enfermeria','nutricion y dietetica','odontologia','construcciones civiles','topografia y geodesia','electricidad','electronica y telecomunicaciones','electromecanica','mecanica automotriz','mecanica de aviacion','mecanica industrial','quimica industrial'];
																for ($i = 0; $i < sizeof($carreras) ; $i++) {
																 	if($datos[0]->categoria == $carreras[$i]){
																 		echo "<option value=".$carreras[$i]." selected>".$carreras[$i]."</option>";
																 	}
																 	else{
																 		echo "<option value=".$carreras[$i].">".$carreras[$i]."</option>";
																 	}
																 } ?>
															</select>
														</div>
													</td>
												</tr>
												<tr>
													<td><input type="hidden" name="grabar" id="grabar" value="si" /></td>
												</tr>
												<tr>
													<td></td>
													<td><center><input type="submit" value="Registrar" /></center></td>
													<td><center><input type="reset" value="Limpiar Datos" class="alt" /></center></td>
												</tr>
											</tbody>
										</table>
									</form>
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