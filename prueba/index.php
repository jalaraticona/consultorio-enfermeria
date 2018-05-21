<?php 
require_once("../public/usuario.php");
$u = new usuario();
$nombre = "2";
//$cod = $u->encriptar($nombre);
//$dec = $u->desencriptar("$cod");
//echo $nombre."   -----   ".$cod."     ----   ".$dec;

/*echo "<br>";
$fecha = date("m/d/y");
echo $fecha;
echo "<br>";
echo date('y', strtotime($fecha));

echo "<br>";
$a = [2,3,5,2,4,6,7,8];
echo sizeof($a);
echo"<br>";
echo $a[1];
echo "<br>";
for ($i=0; $i < date('m'); $i++) { 
	echo $i;
}
$name = "6121828";
echo "<br>";
echo $name;
$cod = base64_encode($name);
echo "<br>";
echo $cod;
echo "<br>";
$dec = base64_decode($cod);
echo $dec;
echo "<br>";
$hash = "vpmn6Sbom5wbolZmX7qKtR4DdBTdhT+DiVkh4atMIKg=";
$hash = urldecode($hash);
echo $hash;
echo "<br>";

$message = "6121828";
$key ='';
$iv = implode(array_map('chr', array(0, 0, 0, 0, 0, 0, 0, 0)));
$cod = openssl_encrypt($message, 'des-ede3', $key, OPENSSL_RAW_DATA, $iv);

echo $cod;
echo "<br>";*/

//$cadena_decodificada=urldecode($cadena_codificada);
//echo $cadena_decodificada;

//$sql = "SELECT MAX(rd.id_reg_diario) as dia FROM registrodiario as rd, insumos as ins where ins.id_insumo = rd.id_insumo and ins.nombre = 'difteria' ";
//$fecha = date("Y-m-d");
//$sql = "SELECT fec_registro FROM registrodiario WHERE fec_registro = CURRENT_DATE()";
//$datos2 = $u->GetDatosSql($sql);
//$fecha2 = $datos2[0]->fec_registro;

if(isset($_POST["nombre"])){
	$a = trim($_POST["nombre"]);
	$b = trim($_POST["num"]);
	$f = strtotime($_POST["fecha"]);
	$dosmenos = date("Y-m-d", strtotime("-2 day", $f));
	if($u->soloNumero($b) and $b > 5 and $b < 50000000){
		print_r("son solo numeros ".$f);exit;
	}
	else {
		print_r("son letras y numeros o caracteres especiales".$f);exit;
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="../assets/css/main.css" />
	<script src="../public/ChartJS/Chart.bundle.js"></script>
	<script src="../public/ChartJS/samples/utils.js"></script>
	<script src="../public/jquery-1.10.2.js"></script>
	<style>
		canvas {
			-moz-user-select: none;
			-webkit-user-select: none;
			-ms-user-select: none;
		}
	</style>
	<script type="text/javascript">
function AbrirPopUp()
{
var strFeatures = "left=200,top=100,width=650,height=550,fullscreen=no"
var Pagina = "Plan de control pop up.aspx";
objNewWindow = window.open(Pagina,"newWin", strFeatures);
objNewWindow.focus();
}
</script>


<script language=javascript>
function SimularPopUpModal()
{
if (window.opener.focus){
window.opener.focus = false;
self.focus();
}
}
</script>
	<title></title>
	<style type="text/css" media="screen">
		.social {
	position: fixed; /* Hacemos que la posición en pantalla sea fija para que siempre se muestre en pantalla*/
	right: 0; /* Establecemos la barra en la izquierda */
	top: 200px; /* Bajamos la barra 200px de arriba a abajo */
	z-index: 2000; /* Utilizamos la propiedad z-index para que no se superponga algún otro elemento como sliders, galerías, etc */
}
 
	.social ul {
		list-style: none;
	}
 
	.social ul li a {
		display: inline-block;
		color:#fff;
		background: #000;
		padding: 10px 15px;
		text-decoration: none;
		-webkit-transition:all 500ms ease;
		-o-transition:all 500ms ease;
		transition:all 500ms ease; /* Establecemos una transición a todas las propiedades */
	}
 
	.social ul li .icon-facebook {background:#3b5998;} /* Establecemos los colores de cada red social, aprovechando su class */
	.social ul li .icon-twitter {background: #00abf0;}
	.social ul li .icon-googleplus {background: #d95232;}
	.social ul li .icon-pinterest {background: #ae181f;}
	.social ul li .icon-mail {background: #666666;}
 
	.social ul li a:hover {
		background: #000; /* Cambiamos el fondo cuando el usuario pase el mouse */
		padding: 10px 30px; /* Hacemos mas grande el espacio cuando el usuario pase el mouse */
	}



	</style>
</head>
<body onfocus="window.focus = true;">
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
	<nav class="navbar navbar-default" role="navigation">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>    
  </div>
  <div class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
      <li class="pull-left"><a href="#">Izquierda 1</a></li>
      <li class="pull-left"><a href="#">Izquierda 2</a></li>
      <li class="active"><a href="#">Center 1</a></li>
      <li><a href="#">Center</a></li>
      <li class="pull-right"><a href="#">Derecha 1</a></li>
      <li class="pull-right"><a href="#">Derecha 2</a></li>
    </ul>
  </div>
</nav>

<section class="box">
<a href="#openModal" class="button">Iniciar Sesion</a>

<div id="openModal" class="modalDialog">
						<div>
							<a href="#close" title="Close" class="close">X</a>
							<center><h3>LOGIN</h3></center>
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
								<center><label>Usuario:</label></center>
								<input type="text" name="user" id="user" placeholder="Ingrese Usuario">
								<br>
								<center><label>Contraseña:</label></center>
								<input type="password" name="password" id="password" placeholder="Ingrese contraseña">
								<br>
								<center><button type="submit" class="button">Iniciar sesion</button></center>
							</form>
						</div>
					</div> 

	<div id="container" style="width: 75%;">
		<canvas id="canvas"></canvas>
	</div>
	<button id="randomizeData">Randomize Data</button>
	<button id="addDataset">Add Dataset</button>
	<button id="removeDataset">Remove Dataset</button>
	<button id="addData">Add Data</button>
	<button id="removeData">Remove Data</button>
	<script>
		var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		var color = Chart.helpers.color;
		var barChartData = {
			labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
			datasets: [{
				label: 'Dataset 1',
				backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
				borderColor: window.chartColors.red,
				borderWidth: 1,
				data: [
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor()
				]
			}, {
				label: 'Dataset 2',
				backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
				borderColor: window.chartColors.blue,
				borderWidth: 1,
				data: [
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor()
				]
			}, {
				label: 'Dataset 3',
				backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
				borderColor: window.chartColors.blue,
				borderWidth: 1,
				data: [
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor()
				]
			}, {
				label: 'Dataset 4',
				backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
				borderColor: window.chartColors.blue,
				borderWidth: 1,
				data: [
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor()
				]
			}, {
				label: 'Dataset 5',
				backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
				borderColor: window.chartColors.blue,
				borderWidth: 1,
				data: [
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor()
				]
			}
			]

		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myBar = new Chart(ctx, {
				type: 'bar',
				data: barChartData,
				options: {
					responsive: true,
					legend: {
						position: 'top',
					},
					title: {
						display: true,
						text: 'Chart.js Bar Chart'
					}
				}
			});

		};

		document.getElementById('randomizeData').addEventListener('click', function() {
			var zero = Math.random() < 0.2 ? true : false;
			barChartData.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return zero ? 0.0 : randomScalingFactor();
				});

			});
			window.myBar.update();
		});

		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var colorName = colorNames[barChartData.datasets.length % colorNames.length];
			var dsColor = window.chartColors[colorName];
			var newDataset = {
				label: 'Dataset ' + barChartData.datasets.length,
				backgroundColor: color(dsColor).alpha(0.5).rgbString(),
				borderColor: dsColor,
				borderWidth: 1,
				data: []
			};

			for (var index = 0; index < barChartData.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());
			}

			barChartData.datasets.push(newDataset);
			window.myBar.update();
		});

		document.getElementById('addData').addEventListener('click', function() {
			if (barChartData.datasets.length > 0) {
				var month = MONTHS[barChartData.labels.length % MONTHS.length];
				barChartData.labels.push(month);

				for (var index = 0; index < barChartData.datasets.length; ++index) {
					// window.myBar.addData(randomScalingFactor(), index);
					barChartData.datasets[index].data.push(randomScalingFactor());
				}

				window.myBar.update();
			}
		});

		document.getElementById('removeDataset').addEventListener('click', function() {
			barChartData.datasets.splice(0, 1);
			window.myBar.update();
		});

		document.getElementById('removeData').addEventListener('click', function() {
			barChartData.labels.splice(-1, 1); // remove the label first

			barChartData.datasets.forEach(function(dataset) {
				dataset.data.pop();
			});

			window.myBar.update();
		});
	</script>
<br>
	<a href="#popup" class="popup-link">Ver mas información</a>

</section>


	<div class="social">
		<ul>
			<li><a href="http://www.facebook.com/falconmasters" target="_blank" class="icon-facebook">fa</a></li>
			<li><a href="http://www.twitter.com/falconmasters" target="_blank" class="icon-twitter">tw</a></li>
			<li><a href="http://www.googleplus.com/falconmasters" target="_blank" class="icon-googleplus">go</a></li>
			<li><a href="http://www.pinterest.com/falconmasters" target="_blank" class="icon-pinterest">pt</a></li>
			<li><a href="mailto:contacto@falconmasters.com" class="icon-mail">ml</a></li>
		</ul>
	</div>
	<form action="" method="POST" accept-charset="utf-8">
		<input type="text" name="nombre" id="nombre" placeholder="ingrese nombre">
		<br>
		<input type="number" name="num" id="num" placeholder="ingrese numero">
		<br>
		<input type="date" name="fecha" id="fecha">
		<br>
		<button type="submit">Enviar</button>
		<input type="checkbox" id="copy" name="copy">
		<label for="copy">Email me a copy of this message</label>
		<input type="checkbox" id="human" name="human" checked>
		<label for="human">I am a human and not a robot</label>
	</form>

	<section class="box">
	<select name="cambiar" id="cambiar" required>
      <option value="1"> opcion 1</option>
      <option value="2"> opcion 2</option>
      <option value="3"> opcion 3</option>
      <option value="4"> opcion 4</option>
</select>
<div id="adl">
   Contenido del Div #adl.... (display en CSS es BLOCK)
</div>
<div id="pax">
   Contenido del Div #pax.... (display en CSS es NONE)
</div>


	</section>
	<script src="../paciente/funciones.js"></script>
	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/jquery.dropotron.min.js"></script>
	<script src="../assets/js/jquery.scrollgress.min.js"></script>
	<script src="../assets/js/skel.min.js"></script>
	<script src="../assets/js/util.js"></script>
	<script src="../assets/js/main.js"></script>
</body>
</html>