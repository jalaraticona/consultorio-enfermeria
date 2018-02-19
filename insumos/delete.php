<?php
require_once("../public/usuario.php");
if(!isset($_SESSION["id"])){
	header("Location: ../iniciarSesion.php");
}
$u = new usuario();
if(!isset($_GET["id_insumo"]) or !is_numeric($_GET["id_insumo"])){
	die("Error 404");
}
$datos = $u->getDatoPorId($_GET["id_insumo"]);
if(sizeof($datos) == 0){
	die("Error 404");
}
$u->deleteInsumo();
header("Location: index.php?m=3");
?>