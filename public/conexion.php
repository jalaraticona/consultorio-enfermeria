<?php
	$con = mysql_connect("localhost","root","")  or die ('No se pudo conectar: ' . mysql_error());
	$bd = "consultorio";
	function verificaUsuario($bdatos,$conex){
		$sql = "select * from inf_personal";
		$resul = mysql_db_query($bdatos,$sql,$conex);
		$vec = array("ltj6121828","gsa6666666");
		$long = count($vec);
		while ($reg = mysql_fetch_array($resul)) {
			for($i = 0; $i <= count($vec); $i++){	
				if($reg[0] == $_SESSION["usuario"]){
					return true;
				}
			}
		}
		return false;
	}
?>