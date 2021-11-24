<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT 
        * 
        FROM coberturas_sociales 
        INNER JOIN medicos_coberturas_sociales 
        ON medicos_coberturas_sociales.id_cobertura_social = coberturas_sociales.id
        WHERE medicos_coberturas_sociales.id_medico = '".$_POST['id']."'");
    if(mysqli_num_rows($peticion) > 0){
        while($c = mysqli_fetch_assoc($peticion)){
            echo '<tr>
                <td class="text-center"><input disabled type="checkbox" name="coberturas" data-telefono="'.$c['telefono'].'" data-valor="'.$c['id'].'" id="coberturaCheck"></td>
                <td class="text-center">'.$c['codigo'].'</td>
                <td>'.$c['cobertura_social'].'</td>
                <td>'.$c['plus'].'</td>
                <td>'.$c['descripcion'].'</td>
            </tr>';
        }
    }else{
        echo '<tr>
            <td colspan="5" class="text-center font-weight-bold">El médico no posee coberturas sociales asociadas.</td>
        </tr>';
        echo '<script>
            $("#opcionNuevaCoberturaSocial, #opcionEliminarCobertura, #opcionEditarCobertura").hide();
        </script>';
    }
    mysqli_close($veja);
}else{
 header("Location: ../../");   
}
?>