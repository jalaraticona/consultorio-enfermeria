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
		$sql = "insert into persona values ('".$_POST["ci"]."','".$_POST["expedido"]."','".$_POST["nombre"]."','".$_POST["paterno"]."','".$_POST["materno"]."','".$_POST["fec_nac"]."','".$_POST["sexo"]."')";
		$this->db->query($sql);
		$sql = "insert into paciente values (null,CURRENT_DATE(),'".$_POST["proced"]."','".$_POST["ci"]."')";
		$this->db->query($sql);
	}
	public function updatePaciente(){
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
		$sql = "update paciente 
				set procedencia = '".$_POST["proced"]."'
				where ci = '".$_POST["ci"]."' ";
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
		$sql = "SELECT pe.*, pa.procedencia FROM persona as pe, paciente as pa WHERE pa.ci = pe.ci and pe.ci = '".$ci."'";
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
		$sql = "insert into insumos values (null,'".$_POST["nombre"]."','".$_POST["tipo"]."','".$_POST["detalle"]."','".$_POST["fec_ing"]."','".$_POST["fec_exp"]."','".$_POST["stock"]."','usable','".$_SESSION["id_enf"]."')";
		$this->db->query($sql);
	}
	public function updateInsumo(){
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
		$sql = "insert into registrahistoria values (null, '".$_POST["motivo"]."', CURRENT_DATE(), '".$_POST["lugar"]."', '".$_POST["dosis"]."', '".$_SESSION["id_enf"]."','".$_POST["id_pac"]."','".$_POST["servicio"]."')";
		$this->db->query($sql);
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
}
?>