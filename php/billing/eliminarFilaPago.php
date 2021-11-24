<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    array_splice($_SESSION['datosFormaPago'], $_POST['id'], 1);
    if(count($_SESSION['datosFormaPago']) < 1){
        echo '0|<tr>
        <td colspan="8" class="text-center">No hay formas de pago registradas</td>
        <tr>';
    }else{
        echo $_SESSION['resultado'] += floatval($_POST['monto']);
        for($i = 0; $i < count($_SESSION['datosFormaPago']); $i++){
            echo '1|<tr id="filaFormaPago" data-id="'.$i.'">';
            $peticion = mysqli_query($veja, "SELECT pago FROM formas_pago WHERE id = '".$_SESSION['datosFormaPago'][$i][0]."' LIMIT 1");
            while($p = mysqli_fetch_assoc($peticion)){
                echo '<td>'.$p['pago'].'</td>';
            }
                echo '<td>'.$_SESSION['datosFormaPago'][$i][1].'</td>
                <td class="text-center">'.$_SESSION['datosFormaPago'][$i][2].'</td>
                <td class="text-center">'.$_SESSION['datosFormaPago'][$i][3].'</td>
                <td class="text-center">'.$_SESSION['datosFormaPago'][$i][4].'</td>
                <td class="text-center">'.date("d-m-Y", strtotime($_SESSION['datosFormaPago'][$i][5])).'</td>';
                if($_SESSION['datosFormaPago'][$i][6]){
                    echo '<td class="text-center">'.date("d-m-Y", strtotime($_SESSION['datosFormaPago'][$i][6])).'</td>';
                }else{
                    echo '<td class="text-center">-</td>';
                }
                echo '<td class="text-center">'.number_format(floatval($_SESSION['datosFormaPago'][$i][7]), 2, ',', '.').'</td>
            </tr>';
        }
    }
    mysqli_close($veja);
}
?>