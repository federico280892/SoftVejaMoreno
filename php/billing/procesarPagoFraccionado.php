<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $datosRecibidos = $_POST['datos'];
    //echo count($datosRecibidos);
    array_push($_SESSION['datosFormaPago'], $datosRecibidos);
    echo $_SESSION['resultado'] -= floatval($datosRecibidos[7]);
    echo "|";
    for($i = 0; $i < count($_SESSION['datosFormaPago']); $i++){
        echo '<tr id="filaFormaPago" data-id="'.$i.'" data-monto="'.$_SESSION['datosFormaPago'][$i][7].'">';
        $peticion = mysqli_query($veja, "SELECT pago FROM formas_pago WHERE id = '".$_SESSION['datosFormaPago'][$i][0]."' LIMIT 1");
        while($p = mysqli_fetch_assoc($peticion)){
            echo '<td>'.$p['pago'].'</td>';
        }

        $bancos = mysqli_query($veja, "SELECT nombre FROM bancos WHERE id = '".$_SESSION['datosFormaPago'][$i][1]."' LIMIT 1");
        while($banco = mysqli_fetch_assoc($bancos)){
            echo '<td>'.$banco['nombre'].'</td>';
        }
            echo '<td class="text-center">'.$_SESSION['datosFormaPago'][$i][2].'</td>
            <td class="text-center">'.$_SESSION['datosFormaPago'][$i][3].'</td>
            <td class="text-center">'.$_SESSION['datosFormaPago'][$i][4].'</td>
            <td class="text-center">'.date("d-m-Y", strtotime($_SESSION['datosFormaPago'][$i][5])).'</td>';
            if($_SESSION['datosFormaPago'][$i][6]){
                echo '<td class="text-center">'.date("d-m-Y", strtotime($_SESSION['datosFormaPago'][$i][6])).'</td>';
            }else{
                echo '<td class="text-center">-</td>';
            }
            echo '<td class="text-center">'.number_format($_SESSION['datosFormaPago'][$i][7], 2, ',', '.').'</td>
        </tr>';
    }
    mysqli_close($veja);
}
?>