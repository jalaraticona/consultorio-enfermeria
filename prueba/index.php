<?php 
require_once("../public/usuario.php");
$u = new usuario();
$nombre = "2";
$cod = $u->encriptar($nombre);
$dec = $u->desencriptar("$cod");
echo $nombre."   -----   ".$cod."     ----   ".$dec;
echo "<br>";

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
?>