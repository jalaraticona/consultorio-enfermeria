<?php
require_once("conectar.php");
require_once("helpers.php");
require_once("funciones.php");
class usuario extends Conectar{
	private $db;
	public function __construct(){
		$this->db = parent::conectar();
		parent::setNames();
	}

	//usuario consultas
	public function getLogin($user, $password){
		$sql = "SELECT * FROM usuarios WHERE user = '".$user."' and password = '".$password."'";
		$datos = $this->db->query($sql);
		$arreglo = array();
		while ($reg = $datos->fetch_object()) {
			$arreglo[] = $reg;
		}
		return $arreglo;
	}

	//pacientes consultas
	public function getDatosPaciente(){
		$sql = "SELECT * FROM paciente";
		$datos = $this->db->query($sql);
		$arreglo = array();
		while ($reg = $datos->fetch_object()) {
			$arreglo[] = $reg;
		}
		return $arreglo;
	}
	public function GetDatosSql($sql){
		$datos = $this->db->query($sql);
		$arreglo = array();
		while ($reg = $datos->fetch_object()) {
			$arreglo[] = $reg;
		}
		return $arreglo;
	}

	public function EjecutarSql($sql){
		$this->db->query($sql);
	}

	public function insertarPaciente(){
		$ci = $_POST["ci"];
		$expedido = $_POST["expedido"];
		$nombre = $_POST["nombre"];
		$paterno = $_POST["paterno"];
		$materno = $_POST["materno"];
		$fec_nac = $_POST["fec_nac"];
		$sexo = $_POST["sexo"];
		$residencia = $_POST["residencia"];
		$categoria = $_POST["categoria"];
		if($categoria == 'universitario'){
			$carrera = $_POST["carrera"];
		}
		else{
			$carrera = "---";
		}
		$sql = "insert into paciente values (null,'".$nombre."','".$paterno."','".$materno."','".$fec_nac."', '".$ci."','".$expedido."','".$sexo."',CURRENT_DATE(),'".$residencia."','".$categoria."','".$carrera."')";
		$this->db->query($sql);
	}
	public function updatePaciente(){
		$ci = $_POST["ci"];
		$expedido = $_POST["expedido"];
		$nombre = $_POST["nombre"];
		$paterno = $_POST["paterno"];
		$materno = $_POST["materno"];
		$fec_nac = $_POST["fec_nac"];
		$sexo = $_POST["sexo"];
		$residencia = $_POST["residencia"];
		$categoria = $_POST["categoria"];
		if($categoria == 'universitario'){
			$carrera = $_POST["carrera"];
		}
		else{
			$carrera = "---";
		}
		$sql = "UPDATE paciente 
				SET 
				nombre = '".$nombre."',
				paterno = '".$paterno."',
				materno = '".$materno."',
				fec_nac = '".$fec_nac."',
				ci = '".$ci."',
				expedido = '".$expedido."',
				sexo = '".$sexo."',
				residencia = '".$residencia."',
				categoria = '".$categoria."',
				carrera_cargo = '".$carrera."'
				WHERE ci = '".$ci."'";
		$this->db->query($sql);
	}
	public function deletePaciente(){
		$sql = "delete from insumos
				where id_insumo = '".$_GET["id_insumo"]."'";
		$this->db->query($sql);
		//$sql = "delete from persona
		//		where ci = '".$_GET["ci"]."'";
		//$this->db->query($sql);
	}
	public function getDatoPorCiPaciente($ci){
		$sql = "SELECT * FROM paciente WHERE ci = '".$ci."' ";
		$datos = $this->db->query($sql);
		$arreglo = array();
		while ($reg = $datos->fetch_object()) {
			$arreglo[] = $reg;
		}
		return $arreglo;
	}

	//insumos consultas
	public function getDatosInsumos(){
		$sql = "SELECT * FROM insumos";
		$datos = $this->db->query($sql);
		$arreglo = array();
		while ($reg = $datos->fetch_object()) {
			$arreglo[] = $reg;
		}
		return $arreglo;
	}
	public function insertarInsumo(){
		$comprobante = $_POST["comprobante"];
		$lote = $_POST["lote"];
		$origen = $_POST["origen"];
		$red = $_POST["red"];
		$tipo = $_POST["tipo"];
		$fec_ing = $_POST["fec_ing"];
		$fec_exp = $_POST["fec_exp"];
		$stock = $_POST["stock"];
		$est = "usable";
		$id_enf = $_SESSION["id_enf"];
		$id_ins = $_POST["insumo"];
		$sql = "INSERT INTO ingresoinsumos VALUES (null,'".$fec_ing."','".$fec_exp."','".$stock."','".$stock."','".$comprobante."','".$lote."','".$origen."','".$red."','".$est."','".$id_enf."','".$id_ins."') ";
		$this->db->query($sql);
		//verificamos el ultimo id ingresado
		$sql = "SELECT MAX(id_ingreso) as id FROM ingresoinsumos";
		$dato = $this->db->query($sql);
		$arreglo = array();
		while ($reg = $dato->fetch_object()) {
			$arreglo[] = $reg;
		}
		$nro_id = $arreglo[0]->id;
		//verificamos si existe un registro en la salida de insumos de ser positivo se crea un nuevo de ser lo contrario de toma el saldo anterior y se crea otro
		$sql = "SELECT saldo FROM salidainsumos WHERE id_salida = ( SELECT MAX(sal.id_salida) FROM salidainsumos as sal, ingresoinsumos as ing where ing.id_ingreso = sal.id_ingreso and sal.id_ingreso = '".$nro_id."' )";
		$dato = $this->db->query($sql);
		if(sizeof($dato) == 0){
			$sql = "INSERT INTO salidainsumos VALUES (null, '".$fec_ing."', '0', '".$stock."', '0', '0', '0', '0', '0', '0', '".$stock."', '".$id_enf."', '".$nro_id."' ) ";
			$this->db->query($sql);
		}
		else{
			$otro = array();
			while ($reg = $dato->fetch_object()) {
				$otro[] = $reg;
			}
			$saldo = $otro[0]->saldo;
			$total = $saldo + $stock;
			$sql = "INSERT INTO salidainsumos VALUES (null, '".$fec_ing."', '".$saldo."', '".$total."', '0', '0', '0', '0', '0', '0', '".$total."', '".$id_enf."', '".$nro_id."' ) ";
			$this->db->query($sql);
		}
	}

	public function insertarDesechoVacuna(){
		$fav = $_POST["fa"];
		$fev = $_POST["fe"];
		$fmv = $_POST["fm"];
		$frv = $_POST["fr"];
		$tot = $fav+$fev+$fmv+$frv;
		$lotvac = $_POST["lotevacunas"];

		$sql = "SELECT cant_disp, estado, nombre, lote FROM insumos WHERE id_insumo = '".$lotvac."' and estado = 'usable' ";
		$vacuna = $this->db->query($sql);
		$vac = array();
		while ($reg = $vacuna->fetch_object()) {
			$vac[] = $reg;
		}
		$res = $vac[0]->cant_disp-$tot;
		$estv = 'usable';
		if($res == 0){
			$estv = 'vacio';
		}
		$sql = "UPDATE insumos 
				SET 
				cant_disp = '".$res."',
				estado = '".$estv."'
				where id_insumo = '".$lotvac."' ";
		$this->db->query($sql);
		$sql = "SELECT id_reg_diario, fec_registro, sal_ant, cant_egre, saldo, id_insumo FROM registrodiario WHERE id_reg_diario = ( SELECT MAX(id_reg_diario) FROM registrodiario where id_insumo = '".$lotvac."' )";
		$datoo = $this->db->query($sql);
		$dato = array();
		while ($reg = $datoo->fetch_object()) {
			$dato[] = $reg;
		}
		if(sizeof($dato) > 0){
			$fec_actual = date("Y-m-d");
			$idreg = $dato[0]->id_reg_diario;
			$regi = $dato[0]->fec_registro;
			$canegr = $dato[0]->cant_egre;
			$saldo = $dato[0]->saldo;
			if($fa > 0){ $fa = $fa+$fav; } else{ $fa = $fav; }
			if($fr > 0){ $fr = $fr+$frv; } else{ $fr = $frv; }
			if($fm > 0){ $fm = $fm+$fmv; } else{ $fm = $fmv; }
			if($fe > 0){ $fe = $fe+$fev; } else{ $fe = $fev; }
			if($dato[0]->id_insumo == $lotvac){
				$canegr = $canegr+$tot;
				$saldo = $saldo-$tot;
				$sql = "UPDATE registrodiario
						SET 
						cant_egre = '".$canegr."',
						fa = '".$fa."',
						fr = '".$fr."',
						fm = '".$fm."',
						fe = '".$fe."',
						saldo = '".$saldo."'
						where id_reg_diario = '".$idreg."' ";
				$this->db->query($sql);
			}
		}
		else {
			print_r("Error 404");exit;
		}
	}

	public function insertarDesechoJeringa(){
		$tot = $_POST["cantidad"];
		$lotjer = $_POST["lotejeringas"];

		$sql = "SELECT cant_disp, estado, nombre, lote FROM insumos WHERE id_insumo = '".$lotjer."' and estado = 'usable' ";
		$vacuna = $this->db->query($sql);
		$vac = array();
		while ($reg = $vacuna->fetch_object()) {
			$vac[] = $reg;
		}
		$res = $vac[0]->cant_disp-$tot;
		$estv = 'usable';
		if($res == 0){
			$estv = 'vacio';
		}
		$sql = "UPDATE insumos 
				SET 
				cant_disp = '".$res."',
				estado = '".$estv."'
				where id_insumo = '".$lotjer."' ";
		$this->db->query($sql);
		$sql = "SELECT id_reg_diario, fec_registro, sal_ant, cant_egre, saldo, id_insumo FROM registrodiario WHERE id_reg_diario = ( SELECT MAX(id_reg_diario) FROM registrodiario where id_insumo = '".$lotjer."' )";
		$datoo = $this->db->query($sql);
		$dato = array();
		while ($reg = $datoo->fetch_object()) {
			$dato[] = $reg;
		}
		if(sizeof($dato) > 0){
			$fec_actual = date("Y-m-d");
			$idreg = $dato[0]->id_reg_diario;
			$regi = $dato[0]->fec_registro;
			$canegr = $dato[0]->cant_egre;
			$saldo = $dato[0]->saldo;
			$cant_per = $dato[0]->cant_per;
			if($cant_per > 0){ $cant_per = $cant_per+$tot; } else{ $cant_per = $tot; }
			if($dato[0]->id_insumo == $lotjer){
				$canegr = $canegr+$tot;
				$saldo = $saldo-$tot;
				$sql = "UPDATE registrodiario
						SET 
						cant_egre = '".$canegr."',
						saldo = '".$saldo."',
						cant_per = '".$cant_per."'
						where id_reg_diario = '".$idreg."' ";
				$this->db->query($sql);
			}
		}
		else {
			print_r("Error 404");exit;
		}
	}

	public function updateVacuna(){
		$sql = "UPDATE insumos 
				SET 
				nombre = '".$_POST["nombre"]."',
				tipo = '".$_POST["tipo"]."',
				detalle = '".$_POST["detalle"]."',
				fec_ing = '".$_POST["fec_ing"]."',
				fec_exp = '".$_POST["fec_exp"]."',
				stock = '".$_POST["stock"]."',
				estado = '".$_POST["estado"]."'
				WHERE id_insumo = '".$_POST["id_insumo"]."'";
		$this->db->query($sql);
	}
	public function deleteInsumo(){
		$sql = "DELETE FROM insumos
				WHERE id_insumo = '".$_GET["id_insumo"]."'";
		$this->db->query($sql);
		//$sql = "delete from persona
		//		where ci = '".$_GET["ci"]."'";
		//$this->db->query($sql);
	}
	public function getDatoPorId($id_ingreso){
		$sql = "SELECT * FROM insumos AS ins, ingresoinsumos AS ing WHERE ins.id_insumo = ing.id_insumo AND id_iingreso = '".$id_ingreso."'";
		$datos = $this->db->query($sql);
		$arreglo = array();
		while ($reg = $datos->fetch_object()) {
			$arreglo[] = $reg;
		}
		return $arreglo;
	}

	//servicios consultas
	public function getDatosServicio(){
		$sql = "SELECT * FROM servicio";
		$datos = $this->db->query($sql);
		$arreglo = array();
		while ($reg = $datos->fetch_object()) {
			$arreglo[] = $reg;
		}
		return $arreglo;
	}

	public function getDatoPorIdServicio($id_servicio){
		$sql = "SELECT * FROM servicio WHERE id_servicio = '".$id_servicio."' ";
		$datos = $this->db->query($sql);
		$arreglo = array();
		while ($reg = $datos->fetch_object()) {
			$arreglo[] = $reg;
		}
		return $arreglo;
	}

	public function insertarServicio(){
		$nom = trim($_POST["nombre"]);
		$cla = trim($_POST["clave"]);
		$det = trim($_POST["detalle"]);
		$cos = trim($_POST["costo"]);
		$tip = trim($_POST["tipo"]);
		if($tip == "vacuna"){ $dos = trim($_POST["dosis"]); }
		else{ $dos = 0; }
		$sql = "INSERT INTO servicio VALUES (null, '".$cla."', '".$nom."', '".$dos."', '".$det."','".$cos."','".$tip."')";
		$this->db->query($sql);
	}

	public function upsateServicio(){
		$nom = trim($_POST["nombre"]);
		$cla = trim($_POST["clave"]);
		$det = trim($_POST["detalle"]);
		$cos = trim($_POST["costo"]);
		$tip = trim($_POST["tipo"]);
		if($tip == "vacuna"){ $dos = trim($_POST["dosis"]); }
		else{ $dos = 0; }
		$sql = "INSERT INTO servicio VALUES (null, '".$cla."', '".$nom."', '".$dos."', '".$det."','".$cos."','".$tip."')";
		$this->db->query($sql);
	}
	//Historia consultas
	//Insertar proceso enfermero
	public function insertarHistoria(){
		$motivo = $_POST["motivo"];
		$lugar = $_POST["lugar"];
		$dosis = "---";
		$id_enf = $_SESSION["id_enf"];
		$id_pac = $_POST["id_pac"];
		$id_ser = $_POST["servicio"];
		$sql = "INSERT INTO historia VALUES (null, '".$motivo."', CURRENT_DATE(), '".$lugar."', '".$dosis."', '".$id_enf."','".$id_pac."','".$id_ser."')";
		$this->db->query($sql);
	}

	//insertar vacunacion a historia
	public function insertarVacunacion(){
		$nomvac = "";
		$nomjer = "";
		$lotevacuna = "";
		$lotejeringa = "";
		$motivo = "vacunacion";
		$lugar = $_POST["lugar"];
		$dosis = $_POST["dosis"];
		$lotvac = $_POST["lotevacunas"];
		$lotjer = $_POST["lotejeringas"];
		$id_enf = $_SESSION["id_enf"];
		$id_pac = $_POST["id_pac"];
		$id_ser = $_POST["serv"];
		//registro en la historia clinica
		$sql = "INSERT INTO historia VALUES (null, '".$motivo."', CURRENT_DATE(), '".$lugar."', '".$dosis."', '".$id_enf."','".$id_pac."','".$id_ser."')";
		$this->db->query($sql);
		//verificacion de stock del insumo jeringas y vacunas (disponible - no disponible), update de cantidad disponible del insumo y asignacion de disponibilidad del insumo
		$sql = "SELECT cant_disp, estado FROM ingresoinsumos WHERE id_ingreso = '".$lotvac."' AND estado = 'usable' ";
		$vacuna = $this->db->query($sql);
		$vac = array();
		while ($reg = $vacuna->fetch_object()) {
			$vac[] = $reg;
		}
		$res = $vac[0]->cant_disp-1;
		$estv = 'usable';
		if($res == 0){
			$estv = 'vacio';
		}
		$sql = "UPDATE ingresoinsumos 
				SET 
				cant_disp = '".$res."',
				estado = '".$estv."'
				where id_ingreso = '".$lotvac."' ";
		$this->db->query($sql);
		$sql = "SELECT cant_disp, estado FROM ingresoinsumos WHERE id_ingreso = '".$lotjer."' and estado = 'usable' ";
		$jeringa= $this->db->query($sql);
		$jer = array();
		while ($reg = $jeringa->fetch_object()) {
			$jer[] = $reg;
		}
		$resj = $jer[0]->cant_disp-1;
		$estj = 'usable';
		if($resj == 0){
			$estj = 'vacio';
		}
		$sql = "UPDATE ingresoinsumos 
				set 
				cant_disp = '".$resj."',
				estado = '".$estj."'
				where id_ingreso = '".$lotjer."' ";
		$this->db->query($sql);

		//registro de vacunas y jeringas en el registro diario, verificacion de usabilidad
		//VACUNAS
		
		$sql = "SELECT * FROM salidainsumos WHERE id_salida = ( SELECT MAX(id_salida) FROM salidainsumos where id_ingreso = '".$lotvac."' )";
		$datoo = $this->db->query($sql);
		$dato = array();
		while ($reg = $datoo->fetch_object()) {
			$dato[] = $reg;
		}
		if(sizeof($dato) > 0){
			$fec_actual = date("Y-m-d");
			$idreg = $dato[0]->id_salida;
			$salant = $dato[0]->sal_ant;
			$canegr = $dato[0]->cant_egre;
			$saldo = $dato[0]->saldo;
			$regi = $dato[0]->fec_reg;
			if($dato[0]->id_ingreso == $lotvac){
				//Si existe ya un registro en el dia
				if ($regi == $fec_actual) {
					$canegr++;
					$saldo--;
					$sql = "UPDATE salidainsumos
							SET 
							cant_egre = '".$canegr."',
							saldo = '".$saldo."'
							where id_salida = '".$idreg."' ";
					$this->db->query($sql);
				}
				//si no existe un registro en el dia
				else {
					$salant = $saldo;
					$egreso = 1;
					$saldo--;
					$sql = "INSERT INTO salidainsumos VALUES (null, CURRENT_DATE(), '".$salant."', '".$salant."', '".$egreso."', '0', '0', '0', '0', '0', '".$saldo."', '".$id_enf."', '".$lotvac."'  )";
					$this->db->query($sql);
				}
			}
			else{
				$salant = $saldo;
				$egreso = 1;
				$saldo--;
				$sql = "INSERT INTO salidainsumos VALUES (null, CURRENT_DATE(), '".$salant."', '".$salant."', '".$egreso."', '0', '0', '0', '0', '0', '".$saldo."', '".$id_enf."', '".$lotvac."'  )";
				$this->db->query($sql);
			}
		}
		else {
			print_r("Error 404");exit;
		}

		$sql = "SELECT * FROM salidainsumos WHERE id_salida = ( SELECT MAX(id_salida) FROM salidainsumos where id_ingreso = '".$lotjer."' )";
		$datoo = $this->db->query($sql);
		$dato = array();
		while ($reg = $datoo->fetch_object()) {
			$dato[] = $reg;
		}
		if(sizeof($dato) > 0){
			$fec_actual = date("Y-m-d");
			$idreg = $dato[0]->id_salida;
			$salant = $dato[0]->sal_ant;
			$canegr = $dato[0]->cant_egre;
			$saldo = $dato[0]->saldo;
			$regi = $dato[0]->fec_reg;
			if($dato[0]->id_ingreso == $lotjer){
				//Si existe ya un registro en el dia
				if ($regi == $fec_actual) {
					$canegr++;
					$saldo--;
					$sql = "UPDATE salidainsumos
							SET 
							cant_egre = '".$canegr."',
							saldo = '".$saldo."'
							where id_salida = '".$idreg."' ";
					$this->db->query($sql);
				}
				//si no existe un registro en el dia
				else {
					$salant = $saldo;
					$egreso = 1;
					$saldo--;
					$sql = "INSERT INTO salidainsumos VALUES (null, CURRENT_DATE(), '".$salant."', '".$salant."', '".$egreso."', '0', '0', '0', '0', '0', '".$saldo."', '".$id_enf."', '".$lotjer."'  )";
					$this->db->query($sql);
				}
			}
			else{
				$salant = $saldo;
				$egreso = 1;
				$saldo--;
				$sql = "INSERT INTO salidainsumos VALUES (null, CURRENT_DATE(), '".$salant."', '".$salant."', '".$egreso."', '0', '0', '0', '0', '0', '".$saldo."', '".$id_enf."', '".$lotjer."'  )";
				$this->db->query($sql);
			}
		}
		else {
			print_r("Error 404");exit;
		}
	}

	//Enfermera consultas
	public function getDatoPorCiEnfermera($ci){
		$sql = "SELECT * FROM enfermera as en, usuarios as us WHERE ci = '".$ci."' and en.id_enfermera = us.id_enfermera ";
		$datos = $this->db->query($sql);
		$arreglo = array();
		while ($reg = $datos->fetch_object()) {
			$arreglo[] = $reg;
		}
		return $arreglo;
	}

	public function editInformacion(){
		$nombre = $_POST["nombre"];
		$paterno = $_POST["paterno"];
		$materno = $_POST["materno"];
		$fec_nac = $_POST["fec_nac"];
		$ci = $_POST["ci"];
		$sexo = $_POST["sexo"];
		$user = $_POST["user"];
		$pass = $_POST["password"];
		$id = $_POST["guardar"];
		$sql = "UPDATE enfermera 
				SET 
				nombre = '".$nombre."',
				paterno = '".$paterno."',
				materno = '".$materno."',
				fec_nac = '".$fec_nac."',
				ci = '".$ci."',
				sexo = '".$sexo."'
				WHERE ci = '".$ci."'";
		$this->db->query($sql);
		$sql = "UPDATE usuarios 
				SET 
				user = '".$user."',
				password = '".$pass."'
				WHERE id_enfermera = '".$id."'";
		$this->db->query($sql);
	}

	public function insertarEnfermera(){
		$nombre = $_POST["nombre"];
		$paterno = $_POST["paterno"];
		$materno = $_POST["materno"];
		$fec_nac = $_POST["fec_nac"];
		$ci = $_POST["ci"];
		$expedido = $_POST["expedido"];
		$sexo = $_POST["sexo"];
		$tipo = $_POST["tipo"];
		$sql = "INSERT INTO enfermera VALUES (null,'".$nombre."','".$paterno."','".$materno."','".$fec_nac."','".$ci."','".$expedido."','".$sexo."',CURRENT_DATE())";
		$this->db->query($sql);
		$pa = substr($paterno, 0, 1);
		$ma = substr($materno, 0, 1);
		$no = substr($nombre, 0, 1);
		$cod = $pa."".$ma."".$no."".$ci;
		$estado = "activo";
		$sql = "SELECT MAX(id_enfermera) AS id FROM enfermera";
		$datoo = $this->db->query($sql);
		$dato = array();
		while ($reg = $datoo->fetch_object()) {
			$dato[] = $reg;
		}
		$id_enf = $dato[0]->id;
		$sql = "INSERT INTO usuarios VALUES (null,'".$cod."','".$ci."','".$tipo."','".$estado."','".$id_enf."')";
		$datoo = $this->db->query($sql);
	}

	public function updateEnfermera(){
		$ci = $_POST["ci"];
		$expedido = $_POST["expedido"];
		$nombre = $_POST["nombre"];
		$paterno = $_POST["paterno"];
		$materno = $_POST["materno"];
		$fec_nac = $_POST["fec_nac"];
		$sexo = $_POST["sexo"];
		$sql = "UPDATE enfermera 
				SET 
				nombre = '".$nombre."',
				paterno = '".$paterno."',
				materno = '".$materno."',
				fec_nac = '".$fec_nac."',
				ci = '".$ci."',
				expedido = '".$expedido."',
				sexo = '".$sexo."'
				WHERE ci = '".$ci."'";
		$this->db->query($sql);
	}

	//funciones de ayuda
	public function encriptar($cadena){
        $key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
        //$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $cadena, MCRYPT_MODE_CBC, md5(md5($key))));
        $enc = base64_encode($cadena);
        return $enc; //Devuelve el string encriptado
    }
     
    public function desencriptar($cadena){
        $key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
        //$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($cadena), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
        $dec = base64_decode($cadena);
        return $dec;  //Devuelve el string desencriptado
    }
    public function edad($fecha){
		list($anyo,$mes,$dia) = explode("-",$fecha);
		$anyo_dif  = date("Y") - $anyo;
		$mes_dif = date("m") - $mes;
		$dia_dif   = date("d") - $dia;
		if ($dia_dif < 0 || $mes_dif < 0) $anyo_dif--;
		return $anyo_dif;
	}
	public function fecha($fecha)
    {
   	    $dia = date('d',strtotime($fecha));
		$mes = date('m',strtotime($fecha));
		$ani = date('y',strtotime($fecha));
      
        switch ($mes){
        	case '01':
        	$mes="Enero";
        	break;
        	case '02':
        	$mes="Febrero";
        	break;
        	case '03':
        	$mes="Marzo";
        	break;
        	case '04':
        	$mes="Abril";
        	break;
        	case '05':
        	$mes="Mayo";
        	break;
        	case '06':
        	$mes="Junio";
        	break;
        	case '07':
        	$mes="Julio";
        	break;
        	case '08':
        	$mes="Agosto";
        	break;
        	case '09':
        	$mes="Septiembre";
        	break;
        	case '10':
        	$mes="Octubre";
        	break;
        	case '11':
        	$mes="Noviembre";
        	break;
        	case '12':
        	$mes="Diciembre";
        	break;
        }
        $fecha=$dia." de ".$mes." de 20".$ani;
        return $fecha; 
    }

	public function soloLetras($palabra){
		if(preg_match('/^[a-zA-Z[:space:] áéíóúÁÉÍÓÚñÑ]+$/',$palabra)) return true;
		else return false;
	}

	public function soloNumero($num){
		if(preg_match('/^[0-9]+$/',$num)) return true;
		else return false;
	}

	public function validaFecha($fecha){
		date_default_timezone_set("America/Caracas");
		$actual = strtotime(date("Y-m-d"));
		$fec_dato = strtotime($fecha);
		if($actual > $fec_dato) return true;
		return false;
	}

	public function validaFechaM($fecha){
		date_default_timezone_set("America/Caracas");
		$actual = strtotime(date("Y-m-d"));
		$fec_dato = strtotime($fecha);
		if($actual < $fec_dato) return true;
		return false;
	}

	public function validaFechaInsumo($fecha){
		date_default_timezone_set("America/Caracas");
		$fec_dato = strtotime($fecha);
		$dosmenos = strtotime(date("Y-m-d", strtotime("-2 day", $fec_dato)));
		$actual = strtotime(date("Y-m-d"));
		if($fec_dato >= $dosmenos and $fec_dato <= $actual) return true;
		return false;
	}

	public function validaFechas2($fecha1, $fecha2){
		date_default_timezone_set("America/Caracas");
		$fecha1 = strtotime($fecha1);
		$fecha2 = strtotime($fecha2);
		if($fecha1 > $fecha2) return true;
		return false;
	}
}
?>