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
<body>
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