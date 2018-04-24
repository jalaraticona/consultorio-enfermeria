<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id_enf"])){
	header("Location: ../index.php");
}
$u = new usuario();
if(!isset($_GET["ci"]) or !is_numeric($_GET["ci"])){
	die("Error 404");
}
$datos = $u->getDatoPorCiPaciente($_GET["ci"]);
if(sizeof($datos) == 0){
	die("Error 404");
}
$u->deletePaciente();
header("Location: index.php?m=3");
?>