<?php
require_once("../public/usuario.php");
$buscar = $_POST['b'];      
if(!empty($buscar)) {
      buscar($buscar);
}
function buscar($b) {
      $pre = new usuario();
      $sql = "SELECT * FROM paciente WHERE nombre LIKE '%".$b."%' or ci LIKE '%".$b."%' ";
      $resultado = $pre->GetDatosSql($sql);
      if(sizeof($resultado) == 0){
            echo "No se han encontrado resultados para '<b>".$b."</b>' debe registrar primero al paciente...";
      }
      else{
            echo "<thead><tr><th>Nro.</th><th>Nombres y Apellidos</th><th>C.I.</th><th>Edad</th><th>Sexo</th><th>Accion</th><th>Realizar Atención</th><th>Historial</th></tr></thead><tbody>";
            foreach($resultado as $informacion){
                  $nombre = $informacion->nombre;
                  $paterno = $informacion->paterno;
                  $materno = $informacion->materno;
                  $completo = $nombre." ".$paterno." ".$materno;
                  $id_paciente = $informacion->id_paciente;
                  $expedido = $informacion->expedido;
                  $edad = $pre->edad($informacion->fec_nac);
                  $sexo = $informacion->sexo;
                  $ci = $informacion->ci;

                  $enc = $pre->encriptar($ci);
                   
                  echo "<tr><td>".$id_paciente."</td><td>".$completo."</td><td>".$ci." ".$expedido."</td><td>".$edad." años</td><td>".$sexo."</td><td><a href='../paciente/edit.php?ci=".$enc."' class='icon fa-pencil'>editar</a><br><td><a href='RegistraHistoria.php?ci=".$enc."' class='icon fa-user'>Proc Enf</a><br><a href='RegistraVacunacion.php?ci=".$enc."' class='icon fa-user'>Vacunacion</a></td><td><a href='../paciente/historial.php?ci=".$enc."' class='icon fa-file'>Mostrar</a></td></tr>";    
            }
            echo "</tbody>";
      }
}
?>