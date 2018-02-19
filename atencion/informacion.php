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
            echo "<thead><tr><th colspan='2'>Informacion</th><th>Detalle Servicio</th></thead><tbody>";
            foreach($resultado as $inf){
                  $id_servicio = $inf->id_servicio;
                  $nombre = $inf->nombre;
                  $detalle = $inf->detalle;
                  $costo = $inf->costo;
                  $tipo = $inf->tipo;
                   
                  echo "<tr><td>Nro.: </td><td>".$id_servicio."</td><td rowspan='4'>".$detalle."</td><tr><td>Servicio: </td><td>".$nombre."</td></tr><tr><td>Costo: </td><td>Bs. ".$costo."</td></tr><tr><td>Tipo: </td><td>".$tipo."</td></tr>";    
            }
            echo "</tbody>";
      }
}
?>