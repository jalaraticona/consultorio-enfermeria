<?php
	session_start();
	unset($_SESSION["id_enf"]);
	unset($_SESSION["user"]);
	unset($_SESSION["tipo"]);
	unset($_SESSION["sw"]);
	session_unset();
	session_destroy();
	header("Location: index.php");
?>