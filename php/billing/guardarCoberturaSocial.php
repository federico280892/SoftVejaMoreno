<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");

    if($_POST['tipo'] == "2"){
        $tipo = "2";
        $modulada = "2";
        }else{
            $tipo = "1";
            if($_POST['modulada'] == "1"){
                $modulada = "1";
            }else{
                $modulada = "0";
            }
        }

        if(mysqli_query($veja, "INSERT INTO coberturas_sociales VALUES(NULL,
        '".$_POST['codigo']."',
        '".strtoupper($_POST['coberturaSocial'])."',
        '".$_POST['plus']."',
        '".$tipo."',
        '".$modulada."',
        '".$_POST['telefono']."',
        '".$_POST['celular']."',
        '".$_POST['email']."',
        '".$_POST['cupoPorDia']."',
        '".strtoupper($_POST['domicilio'])."',
        '".$_POST['localidad']."',
        '".$_POST['codigoPostal']."',
        '".$_POST['provincia']."',
        '".strtoupper($_POST['observaciones'])."',
        '".$_POST['longBarra']."',
        '".$_POST['categoriaIVA']."',
        '".$_POST['cuit']."',
        '".$_POST['ingresosBrutos']."',
        '".$_POST['valCon']."',
        '".$_POST['galQui']."',
        '".$_POST['galPra']."',
        '".$_POST['gasPens']."',
        '".$_POST['gtoQui']."',
        '".$_POST['gtoRadi']."',
        '".$_POST['porcentajeGral']."',
        '".$_POST['pagaCategoria']."',
        '".$_POST['aumentoLiq']."',
        '".$_POST['porcentajeHon']."',
        '".$_POST['porcentajeGtos']."',
        '".$_POST['porcentajeN1']."',
        '".$_POST['porcentajeN2']."',
        '".$_POST['porcentajeN3']."',
        '".$_POST['modeloGenTXT']."',
        '".$_POST['longOrden']."',
        '".$_POST['longNAfiliado']."',
        '".strtoupper($_POST['alertaCirugia'])."',
        '".strtoupper($_POST['alertaSecundaria'])."',
        '".$_POST['activo']."')")){
            echo "1";
        }else{
            echo "0";
        }

    mysqli_close($veja);
}
?>