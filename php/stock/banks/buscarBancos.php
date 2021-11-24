<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    
    $peticion = mysqli_query($veja, "SELECT * FROM bancos ORDER BY nombre ASC");
    if(mysqli_num_rows($peticion) == 0){
      echo '<tr>
        <td colspan="3">No existen registros.</td>
      </tr>';
    }else{
      while($b = mysqli_fetch_assoc($peticion)){
        echo '<tr>
          <td class="text-left">'.$b['nombre'].'</td>';
          if($b['activo']){
              echo '<td class="text-center">Activo</td>';
            }else{
              echo '<td class="text-center">Inactivo</td>';
          }
          echo '<td class="text-center">
          <i role="button" class="fas fa-trash mr-3 text-danger" onclick="eliminarBanco(\''.$b['id'].'\')"></i>
          <i role="button" class="fas fa-edit text-warning" onclick="modificarBanco(\''.$b['id'].'\')"></i>
          </td>
        </tr>';
      }
    }


    mysqli_close($stock);
}
?>