<?php
	session_start();
	unset($_SESSION["id_enf"]);
	unset($_SESSION["user"]);
	session_destroy();
	header("Location: index.php");
?>