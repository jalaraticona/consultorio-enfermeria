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
$sql = "SELECT id_reg_diario, saldo FROM registrodiario
    WHERE id_reg_diario = ( SELECT MAX(rd.id_reg_diario) FROM registrodiario as rd, insumos as ins where ins.id_insumo = rd.id_insumo and ins.nombre = 'difteria')";
$datos2 = $u->getDatosPacienteSql($sql);
print_r(sizeof($datos2)." ".$datos2[0]->id_reg_diario." ".$datos2[0]->saldo);exit;

?>