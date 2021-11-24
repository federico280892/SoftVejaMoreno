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

        if(mysqli_query($veja, "UPDATE coberturas_sociales SET
            codigo = '".$_POST['codigo']."',
            cobertura_social = '".strtoupper($_POST['coberturaSocial'])."',
            tipo = '".$tipo."',
            plus = '".$_POST['plus']."',
            modulada = '".$modulada."',
            telefono = '".$_POST['telefono']."',
            celular = '".$_POST['celular']."',
            email = '".$_POST['email']."',
            cupo_por_dia = '".$_POST['cupoPorDia']."',
            domicilio = '".strtoupper($_POST['domicilio'])."',
            localidad = '".$_POST['localidad']."',
            codigo_postal = '".$_POST['codigoPostal']."',
            provincia = '".$_POST['provincia']."',
            descripcion = '".strtoupper($_POST['observaciones'])."',
            long_barra = '".$_POST['longBarra']."',
            categoria_iva = '".$_POST['categoriaIVA']."',
            cuit = '".$_POST['cuit']."',
            ingresos_brutos = '".$_POST['ingresosBrutos']."',
            porcentaje_gral = '".$_POST['porcentajeGral']."',
            paga_categoria = '".$_POST['pagaCategoria']."',
            aumento_en_liq = '".$_POST['aumentoLiq']."',
            porcentaje_hon = '".$_POST['porcentajeHon']."',
            porcentaje_gtos = '".$_POST['porcentajeGtos']."',
            porcentaje_gtos = '".$_POST['porcentajeGtos']."',
            porcentaje_n1 = '".$_POST['porcentajeN1']."',
            porcentaje_n2 = '".$_POST['porcentajeN2']."',
            porcentaje_n3 = '".$_POST['porcentajeN3']."',
            modelo_generacion_txt = '".$_POST['modeloGenTXT']."',
            long_orden = '".$_POST['longOrden']."',
            long_n_afiliado = '".$_POST['longNAfiliado']."',
            alerta_secretarias_cirugia = '".$_POST['alertaCirugia']."',
            alerta = '".$_POST['alertaSecundaria']."',
            val_con = '".$_POST['valCon']."',
            gal_qui = '".$_POST['galQui']."',
            gal_pra = '".$_POST['galPra']."',
            gas_pens = '".$_POST['gasPens']."',
            gto_quir = '".$_POST['gtoQui']."',
            gto_radi = '".$_POST['gtoRadi']."',
            activo = '".$_POST['activo']."'
            WHERE id = '".$_POST['id']."' LIMIT 1")){
            echo "1";
        }else{
            echo "0";
        }
    
    mysqli_close($veja);
}
?>