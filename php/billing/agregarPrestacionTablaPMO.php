<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $datosRecibidos = $_POST['datos'];
    array_push($_SESSION['prestacion'], $datosRecibidos);
    $porcentajeCoseguro = 0.00;
    $_SESSION['ajuste'] = 0.00;
    $resultado = 0.00;
    for($i = 0; $i < count($_SESSION['prestacion']); $i++){
        echo '<tr id="filaPrestacionPMO" data-id="'.$i.'">
            <td>'.$_SESSION['prestacion'][$i][0].'</td>
            <td>'.$_SESSION['prestacion'][$i][1].'</td>
            <td class="text-center">'.$_SESSION['prestacion'][$i][2].'</td>
            <td class="text-center">'.$_SESSION['prestacion'][$i][3].'</td>
            <td class="text-center">'.number_format($_SESSION['prestacion'][$i][4], 2, ',', '.').'</td>
        </tr>';
        $peticion = mysqli_query($veja, "SELECT porcentaje_gral FROM coberturas_sociales WHERE codigo = '".$_SESSION['prestacion'][$i][5]."' LIMIT 1");
        while($c = mysqli_fetch_assoc($peticion)){
            $descuentoCobertura = $c['porcentaje_gral'];
        }
        $_SESSION['total'] += $_SESSION['prestacion'][$i][4];
    }
    $_SESSION['ajuste'] = $_SESSION['total'];
    $_SESSION['resultado'] = $_SESSION['total'];
    $resultado += $_SESSION['total'] - ($descuentoCobertura * $_SESSION['total'] / 100);

    if($_POST['coseguro'] != ""){
        $peticion = mysqli_query($veja, "SELECT porcentaje_gral FROM coberturas_sociales WHERE codigo = '".$_POST['coseguro']."' LIMIT 1");
        while($c = mysqli_fetch_assoc($peticion)){
            $porcentajeCoseguro = $c['porcentaje_gral'];
        }

        $descuentoCoseguro = $porcentajeCoseguro * $_SESSION['total'] / 100; 
        $resultado = $resultado - $descuentoCoseguro;
    }

    echo "|".number_format(floatval($resultado), 2, ',', '.');
    $_SESSION['total'] = 0.00;
    $_SESSION['resultado'] = $resultado;
    mysqli_close($veja);
}
?>