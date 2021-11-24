<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");

    // echo $_POST['cobertura'];

    // echo $_POST['coseguro'];

    $totalCobertura = 0.00;
    $totalCoseguro = 0.00;

    if($_POST['cobertura'] != ""){
        $peticion = mysqli_query($veja, "SELECT porcentaje_gral FROM coberturas_sociales WHERE codigo = '".$_POST['cobertura']."' LIMIT 1");
        if(mysqli_num_rows($peticion) == 1){
            while($cobertura = mysqli_fetch_assoc($peticion)){
                $porcentajeCobertura = $cobertura['porcentaje_gral'];
            }
            $totalCobertura = ($porcentajeCobertura * $_SESSION['ajuste'] / 100);
        }
    }

    if($_POST['coseguro'] != ""){
        $peticion = mysqli_query($veja, "SELECT porcentaje_gral FROM coberturas_sociales WHERE codigo = '".$_POST['coseguro']."' LIMIT 1");
        if(mysqli_num_rows($peticion) == 1){
            while($cobertura = mysqli_fetch_assoc($peticion)){
                $porcentajeCoseguro = $cobertura['porcentaje_gral'];
            }
            $totalCoseguro = ($porcentajeCoseguro * $_SESSION['ajuste'] / 100);
        }
    }
    $calculo = $_SESSION['ajuste'] - $totalCobertura - $totalCoseguro;
    echo number_format($calculo, 2, ',', '.');
    $_SESSION['resultado'] = $_SESSION['ajuste'] - $totalCobertura - $totalCoseguro;
    mysqli_close($veja);
}
?>