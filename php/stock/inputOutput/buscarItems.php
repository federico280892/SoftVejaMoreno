<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "SELECT 
        insumos.id AS 'id', 
        insumos.descripcion AS 'descripcion', 
        insumos.n_lote AS 'lote', 
        insumos.vencimiento AS 'vencimiento', 
        existencias.cantidad AS 'cantidad' 
        FROM insumos 
        INNER JOIN existencias 
        ON insumos.id = existencias.id_insumo");

    if(mysqli_num_rows($peticion) > 0){
        while($i = mysqli_fetch_assoc($peticion)){
            echo '<tr>
                <td class="text-center align-middle">'.$i['descripcion'].'</td>
                <td class="text-center align-middle">'.$i['lote'].'</td>
                <td class="text-center align-middle">'.$i['vencimiento'].'</td>
                <td class="text-center align-middle">'.$i['cantidad'].'</td>
                <td class="text-center align-middle"><input type="text" class="form-control text-center" style="width: 80px; margin: auto;"></td>
            </tr>';
        }
        }else{
            echo '<tr>
                <td colspan="5" class="text-center">No se encontraron registros</td>
            </tr>';
        }
    mysqli_close($stock);
}
?>