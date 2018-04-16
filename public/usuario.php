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
		$sql = "select * from usuarios where user = '".$user."' and pass = '".$password."'";
		$datos = $this->db->query($sql);
		$arreglo = array();
		while ($reg = $datos->fetch_object()) {
			$arreglo[] = $reg;
		}
		return $arreglo;
	}

	//pacientes consultas
	public function getDatosPaciente(){
		$sql = "select pe.* from paciente as pa, persona as pe where pa.ci = pe.ci";
		$datos = $this->db->query($sql);
		$arreglo = array();
		while ($reg = $datos->fetch_object()) {
			$arreglo[] = $reg;
		}
		return $arreglo;
	}
	public function getDatosPacienteSql($sql){
		$datos = $this->db->query($sql);
		$arreglo = array();
		while ($reg = $datos->fetch_object()) {
			$arreglo[] = $reg;
		}
		return $arreglo;
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
		$sql = "insert into persona values ('".$ci."','".$expedido."','".$nombre."','".$paterno."','".$materno."','".$fec_nac."','".$sexo."')";
		$this->db->query($sql);
		$sql = "insert into paciente values (null,CURRENT_DATE(),'".$residencia."','".$categoria."','".$carrera."','".$ci."')";
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
		$sql = "update persona 
				set 
				ci = '".$ci."',
				expedido = '".$expedido."',
				nombre = '".$nombre."',
				paterno = '".$paterno."',
				materno = '".$materno."',
				fec_nac = '".$fec_nac."',
				sexo = '".$sexo."'
				where ci = '".$ci."'";
		$this->db->query($sql);
		$sql = "update paciente 
				set residencia = '".$residencia."',
				categoria = '".$categoria."',
				carrera_cargo = '".$carrera."'
				where ci = '".$ci."' ";
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
		$sql = "SELECT pe.*, pa.residencia, pa.categoria, pa.carrera_cargo FROM persona as pe, paciente as pa WHERE pa.ci = pe.ci and pe.ci = '".$ci."'";
		$datos = $this->db->query($sql);
		$arreglo = array();
		while ($reg = $datos->fetch_object()) {
			$arreglo[] = $reg;
		}
		return $arreglo;
	}

	//insumos consultas
	public function getDatosInsumos(){
		$sql = "select * from insumos";
		$datos = $this->db->query($sql);
		$arreglo = array();
		while ($reg = $datos->fetch_object()) {
			$arreglo[] = $reg;
		}
		return $arreglo;
	}
	public function getDatosInsumosSql($sql){
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
		$estado = "usable";
		$id_enf = $_SESSION["id_enf"];
		if($tipo == 'jeringa'){
			$medida = $_POST["medida"];
			$nombre = "Jeringa ".$_POST["medida"];
		}
		else{
			$medida = "---";
			$nombre = $_POST["nombre"];
		}
		$sql = "insert into insumos values (null,'".$nombre."','".$medida."','".$tipo."','".$fec_ing."','".$fec_exp."','".$stock."','".$stock."','".$comprobante."','".$lote."','".$origen."','".$red."','".$estado."','".$id_enf."') ";
		$this->db->query($sql);
		$sql = "SELECT MAX(id_insumo) as id FROM insumos";
		$dato = $this->db->query($sql);
		$arreglo = array();
		while ($reg = $dato->fetch_object()) {
			$arreglo[] = $reg;
		}
		$id = $arreglo[0]->id;
		$sql = "SELECT saldo FROM registrodiario WHERE id_reg_diario = ( SELECT MAX(rd.id_reg_diario) FROM registrodiario as rd, insumos as ins where ins.id_insumo = rd.id_insumo and ins.nombre = '".$nombre."' )";
		$dato = $this->db->query($sql);
		if(sizeof($dato) == 0){
			$sql = "INSERT INTO registrodiario VALUES (null, '".$fec_ing."', '0', '".$stock."', '".$stock."', '0', '".$origen."', '0', '0', '0', '0', '0', '".$stock."', '".$id_enf."', '".$id."' ) ";
			$this->db->query($sql);
		}
		else{
			$otro = array();
			while ($reg = $dato->fetch_object()) {
				$otro[] = $reg;
			}
			$saldo = $otro[0]->saldo;
			$total = $saldo + $stock;
			$sql = "INSERT INTO registrodiario VALUES (null, '".$fec_ing."', '".$saldo."', '".$stock."', '".$total."', '0', '".$origen."', '0', '0', '0', '0', '0', '".$total."', '".$id_enf."', '".$id."' ) ";
			$this->db->query($sql);
		}

		//$sql = "SELECT MAX(id_insumo) AS id FROM insumos where nombre=".$nombre." ";
		//$dato = $this->db->query($sql);
		//$num = $dato[0]->id;
		//$sql = "SELECT MAX(id_reg_diario) as id, saldo  FROM registrodiariovacuna WHERE id_insumo = ".$num." ";
		//if(!isset($datos)){
			//$sql = "insert into registrodiariovacuna values (null, CURRENT_DATE(), 0, '".$tipo."','".$fec_ing."','".$fec_exp."','".$stock."','".$stock."','".$comprobante."','".$lote."','".$origen."','".$red."','".$estado."','".$id_enf."')";
		//}
	}
	public function updateVacuna(){
		$sql = "update insumos 
				set 
				nombre = '".$_POST["nombre"]."',
				tipo = '".$_POST["tipo"]."',
				detalle = '".$_POST["detalle"]."',
				fec_ing = '".$_POST["fec_ing"]."',
				fec_exp = '".$_POST["fec_exp"]."',
				stock = '".$_POST["stock"]."',
				estado = '".$_POST["estado"]."'
				where id_insumo = '".$_POST["id_insumo"]."'";
		$this->db->query($sql);
	}
	public function deleteInsumo(){
		$sql = "delete from insumos
				where id_insumo = '".$_GET["id_insumo"]."'";
		$this->db->query($sql);
		//$sql = "delete from persona
		//		where ci = '".$_GET["ci"]."'";
		//$this->db->query($sql);
	}
	public function getDatoPorId($id_insumo){
		$sql = "select * from insumos where id_insumo = '".$id_insumo."'";
		$datos = $this->db->query($sql);
		$arreglo = array();
		while ($reg = $datos->fetch_object()) {
			$arreglo[] = $reg;
		}
		return $arreglo;
	}

	//servicios consultas
	public function getDatosServicio(){
		$sql = "select * from servicio";
		$datos = $this->db->query($sql);
		$arreglo = array();
		while ($reg = $datos->fetch_object()) {
			$arreglo[] = $reg;
		}
		return $arreglo;
	}

	//Historia consultas
	public function insertarHistoria(){
		$motivo = $_POST["motivo"];
		$lugar = $_POST["lugar"];
		$dosis = "---";
		$id_enf = $_SESSION["id_enf"];
		$id_pac = $_POST["id_pac"];
		$id_ser = $_POST["servicio"];
		$sql = "INSERT INTO registrahistoria VALUES (null, '".$motivo."', CURRENT_DATE(), '".$lugar."', '".$dosis."', '".$id_enf."','".$id_pac."','".$id_ser."')";
		$this->db->query($sql);
	}

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
		$id_ser = $_POST["servicio"];
		//registro en la historia clinica
		$sql = "insert into registrahistoria values (null, '".$motivo."', CURRENT_DATE(), '".$lugar."', '".$dosis."', '".$id_enf."','".$id_pac."','".$id_ser."')";
		$this->db->query($sql);
		//verificacion de stock del insumo jeringas y vacunas (disponible - no disponible), update de cantidad disponible del insumo y asignacion de disponibilidad del insumo
		$sql = "SELECT cant_disp, estado, nombre, lote FROM insumos WHERE id_insumo = '".$lotvac."' and estado = 'usable' ";
		$vacuna = $this->db->query($sql);
		$vac = array();
		while ($reg = $vacuna->fetch_object()) {
			$vac[] = $reg;
		}
		$res = $vac[0]->cant_disp-1;
		$nomvac = $vac[0]->nombre;
		$lotevacuna = $vac[0]->lote;
		$estv = 'usable';
		if($res == 0){
			$estv = 'vacio';
		}
		$sql = "update insumos 
				set 
				cant_disp = '".$res."',
				estado = '".$estv."'
				where id_insumo = '".$lotvac."' ";
		$this->db->query($sql);
		$sql = "SELECT cant_disp, estado, nombre, lote FROM insumos WHERE id_insumo = '".$lotjer."' and estado = 'usable' ";
		$jeringa= $this->db->query($sql);
		$jer = array();
		while ($reg = $jeringa->fetch_object()) {
			$jer[] = $reg;
		}
		$resj = $jer[0]->cant_disp-1;
		$nomjer = $jer[0]->nombre;
		$lotejeringa = $jer[0]->lote;
		$estj = 'usable';
		if($resj == 0){
			$estj = 'vacio';
		}
		$sql = "update insumos 
				set 
				cant_disp = '".$resj."',
				estado = '".$estj."'
				where id_insumo = '".$lotjer."' ";
		$this->db->query($sql);

		//registro de vacunas y jeringas en el registro diario, verificacion de usabilidad
		//VACUNAS
		
		$sql = "SELECT id_reg_diario, fec_registro, sal_ant, cant_egre, saldo, id_insumo FROM registrodiario WHERE id_reg_diario = ( SELECT MAX(id_reg_diario) FROM registrodiario where id_insumo = '".$lotvac."' )";
		$datoo = $this->db->query($sql);
		$dato = array();
		while ($reg = $datoo->fetch_object()) {
			$dato[] = $reg;
		}
		if(sizeof($dato) > 0){
			$fec_actual = date("Y-m-d");
			$idreg = $dato[0]->id_reg_diario;
			$salant = $dato[0]->sal_ant;
			$canegr = $dato[0]->cant_egre;
			$saldo = $dato[0]->saldo;
			$regi = $dato[0]->fec_registro;
			if($dato[0]->id_insumo == $lotvac){
				//Si existe ya un registro en el dia
				if ($regi == $fec_actual) {
					$canegr++;
					$saldo--;
					$sql = "update registrodiario
							set 
							cant_egre = '".$canegr."',
							saldo = '".$saldo."'
							where id_reg_diario = '".$idreg."' ";
					$this->db->query($sql);
				}
				//si no existe un registro en el dia
				else {
					$salant = $saldo;
					$egreso = 1;
					$saldo--;
					$sql = "INSERT INTO registrodiario VALUES (null, CURRENT_DATE(), '".$salant."', '0', '".$salant."', '".$egreso."', '".$motivo."', '0', '0', '0', '0', '0', '".$saldo."', '".$id_enf."', '".$lotvac."'  )";
					$this->db->query($sql);
				}
			}
			else{
				$salant = $saldo;
				$egreso = 1;
				$saldo--;
				$sql = "INSERT INTO registrodiario VALUES (null, CURRENT_DATE(), '".$salant."', '0', '".$salant."', '".$egreso."', '".$motivo."', '0', '0', '0', '0', '0', '".$saldo."', '".$id_enf."', '".$lotvac."'  )";
				$this->db->query($sql);
			}
		}
		else {
			print_r("Error 404");exit;
		}
	}

	//Usuario consultas
	public function insertarEnfermera(){
		$sql = "insert into persona values ('".$_POST["ci"]."','".$_POST["expedido"]."','".$_POST["nombre"]."','".$_POST["paterno"]."','".$_POST["materno"]."','".$_POST["fec_nac"]."','".$_POST["sexo"]."')";
		$this->db->query($sql);
		$anio  = date("Y");
		$sql = "insert into enfermera values (null,'".$anio."','".$_POST["ci"]."')";
		$this->db->query($sql);		 
	}
	public function updateUsuario(){
		$sql = "update persona 
				set 
				ci = '".$_POST["ci"]."',
				expedido = '".$_POST["expedido"]."',
				nombre = '".$_POST["nombre"]."',
				paterno = '".$_POST["paterno"]."',
				materno = '".$_POST["materno"]."',
				fec_nac = '".$_POST["fec_nac"]."',
				sexo = '".$_POST["sexo"]."'
				where ci = '".$_POST["ci"]."'";
		$this->db->query($sql);
	}

	//Enfermera consultas
	public function getDatoPorCiEnfermera($ci){
		$sql = "select * from enfermera where ci = '".$ci."'";
		$datos = $this->db->query($sql);
		$arreglo = array();
		while ($reg = $datos->fetch_object()) {
			$arreglo[] = $reg;
		}
		return $arreglo;
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
		if(preg_match('/^[a-zA-Z áéíóúÁÉÍÓÚñÑ]+$/',$palabra)) return true;
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