<?php
require_once("../public/usuario.php");
$buscar = $_POST['c'];      
if(!empty($buscar)) {
      buscar($buscar);
}
function buscar($b) {
      $pre = new usuario();
      $sql = "SELECT * FROM servicio WHERE id_servicio LIKE '%".$b."%' ";
      $resultado = $pre->getDatosPacienteSql($sql);
      if(sizeof($resultado) == 0){
            echo "No se han encontrado resultados para '<b>".$b."</b>' debe registrar primero al paciente...";
      }
      else{
            echo "<tbody>";
            foreach($resultado as $inf){
                  $nombre = "Vacuna contra ".$inf->nombre;
                  $detalle = $inf->detalle;
                  $costo = "Bs.".$inf->costo;
                  $tipo = $inf->tipo;
                   
                  echo "<tr><td>Servicio: ".$nombre."</td><td>Costo: ".$costo."</td></tr><tr><td colspan='2'><center>Detalle del servicio</center><br>".$detalle."</td></tr>";    
            }
            echo "</tbody>";
      }
}
?>