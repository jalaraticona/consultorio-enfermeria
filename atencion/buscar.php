<?php
require_once("../public/usuario.php");
$buscar = $_POST['b'];      
if(!empty($buscar)) {
      buscar($buscar);
}
function edad($fecha){
      list($anyo,$mes,$dia) = explode("-",$fecha);
      $anyo_dif  = date("Y") - $anyo;
      $mes_dif = date("m") - $mes;
      $dia_dif   = date("d") - $dia;
      if ($dia_dif < 0 || $mes_dif < 0) $anyo_dif--;
      return $anyo_dif;
}
function buscar($b) {
      $pre = new usuario();
      $sql = "SELECT pe.*,pa.id_paciente FROM persona as pe, paciente as pa WHERE (pe.nombre LIKE '%".$b."%' or pa.ci LIKE '%".$b."%') and pa.ci = pe.ci";
      $resultado = $pre->getDatosPacienteSql($sql);
      if(sizeof($resultado) == 0){
            echo "No se han encontrado resultados para '<b>".$b."</b>' debe registrar primero al paciente...";
      }
      else{
            echo "<thead><tr><th>Nro.</th><th>Nombres</th><th>Apellido Paterno</th><th>Apellido Materno</th><th>C.I.</th><th>Edad</th><th>Sexo</th><th>Accion</th><th>Realizar Atención</th></tr></thead><tbody>";
            foreach($resultado as $informacion){
                  $nombre = $informacion->nombre;
                  $paterno = $informacion->paterno;
                  $materno = $informacion->materno;
                  $id_paciente = $informacion->id_paciente;
                  $expedido = $informacion->expedido;
                  $edad = edad($informacion->fec_nac);
                  $sexo = $informacion->sexo;
                  $ci = $informacion->ci;

                  $enc = $pre->encriptar($ci);
                   
                  echo "<tr><td>".$id_paciente."</td><td>".$nombre."</td><td>".$paterno."</td><td>".$materno."</td><td>".$ci." ".$expedido."</td><td>".$edad." años</td><td>".$sexo."</td><td><a href='../paciente/edit.php?ci=".$enc."' class='icon fa-pencil'>editar</a></td>
                        <td><a href='RegistraHistoria.php?ci=".$enc."' class='button small icon fa-plus'>Atender</a><br></td></tr>";    
            }
            echo "</tbody>";
      }
}
?>