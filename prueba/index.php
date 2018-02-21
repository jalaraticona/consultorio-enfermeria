<?php 
function encriptar($cadena){
    $key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
    $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $cadena, MCRYPT_MODE_CBC, md5(md5($key))));
    return $encrypted; //Devuelve el string encriptado
}
function desencriptar($cadena){
    $key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
    $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($cadena), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
    return $decrypted;  //Devuelve el string desencriptado
}

require_once("../public/helpers.php");
$nombre = "jorge";
$cod = encriptar($nombre);
$dec = desencriptar("$cod");
echo $nombre."      ".$cod."        ".$dec;
echo date("m/d/y");
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