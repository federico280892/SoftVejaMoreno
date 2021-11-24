<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");

    $ultimoCobro = mysqli_query($veja, "SELECT num_cobro FROM pagos ORDER BY id DESC LIMIT 1");
    if(mysqli_num_rows($ultimoCobro) > 0){
        while($nC = mysqli_fetch_assoc($ultimoCobro)){
            $numero_cobro = ($nC['num_cobro'] + 1);
        }
    }else{
        $numero_cobro = 1000000;
    }

    mysqli_query($veja, "INSERT INTO pagos VALUES(NULL, 
    '".$numero_cobro."',
    '".$_POST['id']."',
    '".$_POST['fechaTurno']."',
    '".$_POST['idMedico']."',
    '".$_POST['idPaciente']."',
    '".$_POST['fechaCobro']."',
    '".$_POST['controlTurno']."',
    '".$_POST['cobertura']."',
    '".$_POST['coseguro']."',
    '".$_POST['orden']."',
    '".$_POST['n_carnet']."',
    '".$_POST['amb']."',
    '".$_POST['n_orden']."',
    '".$_POST['id_autorizacion']."',
    '".$_SESSION['resultado']."',
    '".$_SESSION['id']."',
    '".date("d-m-Y H:i:s")."',
    '".$_POST['observacion']."')");


    $idPago = mysqli_query($veja, "SELECT 
    id 
    FROM pagos 
    WHERE id_medico = '".$_POST['idMedico']."' 
    AND id_paciente = '".$_POST['idPaciente']."' 
    AND fecha_cobro = '".$_POST['fechaCobro']."' 
    ORDER BY id DESC 
    LIMIT 1");

    while($idP = mysqli_fetch_assoc($idPago)){
        $id_pago = $idP['id'];
    }

    for($i = 0; $i < count($_SESSION['prestacion']); $i++){
        mysqli_query($veja, "INSERT INTO pagos_prestaciones VALUES(NULL, '".$id_pago."', '".$_SESSION['prestacion'][$i][6]."', '".$_SESSION['prestacion'][$i][2]."', '".$_SESSION['prestacion'][$i][7]."')");
    }

    for($i = 0; $i < count($_SESSION['datosFormaPago']); $i++){
        mysqli_query($veja, "INSERT INTO pagos_metodos_de_pago VALUES(
            NULL, 
            '".$id_pago."', 
            '".$_SESSION['datosFormaPago'][$i][0]."', 
            '".$_SESSION['datosFormaPago'][$i][1]."', 
            '".$_SESSION['datosFormaPago'][$i][2]."', 
            '".$_SESSION['datosFormaPago'][$i][3]."', 
            '".$_SESSION['datosFormaPago'][$i][4]."', 
            '".$_SESSION['datosFormaPago'][$i][5]."', 
            '".$_SESSION['datosFormaPago'][$i][6]."', 
            '".$_SESSION['datosFormaPago'][$i][7]."')");
    }

    $peticion = mysqli_query($veja, "SELECT start FROM turnos WHERE pago = '0' AND id = '".$_POST['id']."'");
    if(mysqli_num_rows($peticion) == 0){
        $valor = "0";
        $tiempo = "-";
        $cobro = "-";
    }else{
        $valor = "1";
        $tiempo = date("d-m-Y H:i:s");
        $cobro = $numero_cobro;
    }

    if(mysqli_query($veja, "UPDATE turnos SET pago = '".$valor."', ingreso = '".$tiempo."', n_cobro = '".$cobro."', responsable = '".$_SESSION['id']."', f_registro = '".date("Y-m-d H:i:s")."' WHERE id = '".$_POST['id']."' LIMIT 1")){
        echo "1";
    }else{
        echo "0";
    }

    $_SESSION['total'] = 0.00;
    mysqli_close($veja);
}
?>