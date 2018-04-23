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
	<title></title>
</head>
<body>
	<form action="" method="POST" accept-charset="utf-8">
		<input type="text" name="nombre" id="nombre" placeholder="ingrese nombre">
		<br>
		<input type="number" name="num" id="num" placeholder="ingrese numero">
		<br>
		<input type="date" name="fecha" id="fecha">
		<br>
		<button type="submit">Enviar</button>
	</form>
</body>
</html>