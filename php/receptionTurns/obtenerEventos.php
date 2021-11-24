<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    $contador = 0;
    $contador2 = 0;
    $contador3 = 0;
    $contador4 = 0;
    $separador = "";
    $auxSinAtencion = "";
    header("Content-type: application-json");
    require_once("../conn.php");

    $turnos = "";
    $peticion = mysqli_query($veja, "SELECT * FROM turnos WHERE id_medico = '".$_GET['idM']."' AND start >= '".date("Y-m-d")."'");
    echo "[";
    while($res = mysqli_fetch_assoc($peticion)){
        $contador++;
        if($contador == mysqli_num_rows($peticion)){
            $aux = "";
            $separador = ",";
        }else{
            $separador = "";
            $aux = ",";
        }
        $turnos .= json_encode($res).$aux;
    }

    $diasCerrado = "";
    $diasNoLaborables = mysqli_query($veja, "SELECT * FROM dias_no_laborales");
    while($dias = mysqli_fetch_assoc($diasNoLaborables)){
        $contador2++;
        if($contador2 == mysqli_num_rows($diasNoLaborables)){
            $aux2 = "";
        }else{
            $aux2 = ",";
        }
        $diasCerrado .= json_encode($dias).$aux2;
    }

    // $diaSinAtencionMedico = mysqli_query($veja, "SELECT apLun, ciLun, apMar, ciMar, apMie, ciMie, apJue, ciJue, apVie, ciVie, apSab, ciSab, apDom, ciDom FROM horarios_semanales WHERE id_medico = '".$_GET['idM']."'");
    // if(mysqli_num_rows($diaSinAtencionMedico) > 1){
    //     $columnas = "";
    //     $coma = ",";
    //     $flagLun = false;
    //     $flagMar = false;
    //     $flagMie = false;
    //     $flagJue = false;
    //     $flagVie = false;
    //     $flagSab = false;
    //     while($c = mysqli_fetch_assoc($diaSinAtencionMedico)){ 
    //         if($c['apLun'] == "00:00:00" && $c['ciLun'] == "00:00:00"){
    //             $columnas .= "apLun, ciLun";
    //             $flagLun = true;
    //         }else{
    //             $columnas = "";
    //             $flagLun = false;
    //         }
    //         if($c['apMar'] == "00:00:00" && $c['ciMar'] == "00:00:00"){
    //             $flagMar = true;
    //             if($flagLun){
    //                 $columnas .= $coma."apMar, ciMar";
    //             }else{
    //                 $columnas .= "apMar, ciMar";
    //             }
    //         }else{
    //             $columnas = "";
    //             $flagMar = false;
    //         }
    //         if($c['apMie'] == "00:00:00" && $c['ciMie'] == "00:00:00"){
    //             $flagMie = true;
    //             if($flagLun || $flagMar){
    //                 $columnas .= $coma."apMie, ciMie";
    //                 echo "SIIIIIIIIIII";
    //             }else{
    //                 $columnas .= "apMie, ciMie";
    //             }
    //         }else{
    //             $columnas = "";
    //             $flagMie = false;
    //         }
    //         if($c['apJue'] == "00:00:00" && $c['ciJue'] == "00:00:00"){
    //             $flagJue = true;
    //             if($flagLun || $flagMar || $flagMie){
    //                 $columnas .= $coma."apJue, ciJue";
    //             }else{
    //                 $columnas .= "apJue, ciJue";
    //             }
    //         }else{
    //             $columnas = "";
    //             $flagJue = false;
    //         }
    //         if($c['apVie'] == "00:00:00" && $c['ciVie'] == "00:00:00"){
    //             $flagVie = true;
    //             if($flagLun || $flagMar || $flagMie || $flagJue){
    //                 $columnas .= $coma."apVie, ciVie";
    //             }else{
    //                 $columnas .= "apVie, ciVie";
    //             }
    //         }else{
    //             $columnas = "";
    //             $flagVie = false;
    //         }
    //         if($c['apSab'] == "00:00:00" && $c['ciSab'] == "00:00:00"){
    //             $flagSab = true;
    //             if($flagLun || $flagMar || $flagMie || $flagJue || $flagVie){
    //                 $columnas .= $coma."apSab, ciSab";
    //             }else{
    //                 $columnas .= "apSab, ciSab";
    //             }
    //         }else{
    //             $columnas = "";
    //             $flagSab = false;
    //         }
    //         if($c['apDom'] == "00:00:00" && $c['ciDom'] == "00:00:00"){
    //             $flagDom = true;
    //             if($flagLun || $flagMar || $flagMie || $flagJue || $flagVie || $flagSab){
    //                 $columnas .= $coma."apDom, ciDom";
    //             }else{
    //                 $columnas .= "apDom, ciDom";
    //             }
    //         }else{
    //             $columnas = "";
    //             $flagDom = false;
    //         }
    //     }
    //     $diasSemanalesNoDisponibles = mysqli_query($veja, "SELECT ".$columnas." FROM horarios_semanales");
    
    // echo $columnas;
    
    //     // while($d = mysqli_fetch_assoc($diasSemanalesNoDisponibles)){
    //     //     $contador3++;
    //     //     if($contador2 == mysqli_num_rows($diasNoLaborables)){
    //     //         $aux3 = "";
    //     //     }else{
    //     //         $aux3 = ",";
    //     //     }
    //     //     $dSemanaSinAtencion .= json_encode($d).$aux3;
    //     // }

    // }

    $diasConAtencion = "";
    $diasAFuturo = 90;
    $fecha_actual = date("d-m-Y");
    $diasInactivos = array("Sun");
    $color = "";
    for($i = 0; $i <= $diasAFuturo; $i++){
            
        if(!in_array(date("D",strtotime($fecha_actual."+ ".$i." day")), $diasInactivos)){

            switch(date("D",strtotime($fecha_actual."+ ".$i." day"))){
                case "Mon":
                    $diaEnCero = "apLun";
                    break;
                case "Tue":
                    $diaEnCero = "apMar";
                    break;
                case "Wed":
                    $diaEnCero = "apMie";
                    break;
                case "Thu":
                    $diaEnCero = "apJue";
                    break;
                case "Fri":
                    $diaEnCero = "apVie";
                    break;
                case "Sat":
                    $diaEnCero = "apSab";
                    break;
                case "Sun":
                    $diaEnCero = "apDom";
                    break;
            }
            
            $comprobarCeros = mysqli_query($veja, "SELECT ".$diaEnCero." FROM horarios_semanales WHERE id_medico = '".$_GET['idM']."' AND ".$diaEnCero." = '00:00:00'");
            if(mysqli_num_rows($comprobarCeros) == 2){
                $color = "#bfbfbf";
            }else{
                $color = "#d1ebf5";
            }

            // while($cero = mysqli_fetch_assoc($comprobarCeros)){
            //     if($cero[$diaEnCero] == "00:00:00"){
            //         $color = "#bfbfbf";
            //     }else{
            //         $color = "#d1ebf5";
            //     }
            // }
                
            $diasQueAtiende = mysqli_query($veja, "SELECT  
            date_add('".date("Y-m-d")."', interval ".$i." day) AS 'start',
            date_add('".date("Y-m-d")."', interval ".$i." day) AS 'end',
            'false' AS 'overlap', 
            'background' AS 'display', 
            '".$color."' AS 'color'
            FROM dias_sin_atencion_medicos WHERE 
            start != date_add('".date("Y-m-d")."', interval ".$i." day)
            AND id_medico = '".$_GET['idM']."'
            GROUP BY id_medico");

            while($dF = mysqli_fetch_assoc($diasQueAtiende)){
                $diasConAtencion .= json_encode($dF).",";
            }

        }


    }
    
    $info = "";
    $informacion = mysqli_query($veja, "SELECT  
    DATE_FORMAT(start, '%Y-%m-%d') AS 'start', 
    DATE_FORMAT(end, '%Y-%m-%d') AS 'end', 
    'false' AS 'overlap', 
    'background' AS 'display', 
    '#bbc2ec' AS 'color',
    IF((IF(DATE_FORMAT(start, '%a') = 'lun', (SELECT SUM(ROUND(TIMESTAMPDIFF(MINUTE,apLun,ciLun) / (SELECT lun FROM tiempo_consulta WHERE id_medico = '".$_GET['idM']."'))) FROM `horarios_semanales` WHERE id_medico = '".$_GET['idM']."'), 
       IF(DATE_FORMAT(start, '%a') = 'mar', (SELECT SUM(ROUND(TIMESTAMPDIFF(MINUTE,apMar,ciMar) / (SELECT mar FROM tiempo_consulta WHERE id_medico = '".$_GET['idM']."'))) FROM `horarios_semanales` WHERE id_medico = '".$_GET['idM']."'), 
          IF(DATE_FORMAT(start, '%a') = 'mie', (SELECT SUM(ROUND(TIMESTAMPDIFF(MINUTE,apMie,ciMie) / (SELECT mie FROM tiempo_consulta WHERE id_medico = '".$_GET['idM']."'))) FROM `horarios_semanales` WHERE id_medico = '".$_GET['idM']."'), 
             IF(DATE_FORMAT(start, '%a') = 'jue', (SELECT SUM(ROUND(TIMESTAMPDIFF(MINUTE,apJue,ciJue) / (SELECT jue FROM tiempo_consulta WHERE id_medico = '".$_GET['idM']."'))) FROM `horarios_semanales` WHERE id_medico = '".$_GET['idM']."'), 
                IF(DATE_FORMAT(start, '%a') = 'vie', (SELECT SUM(ROUND(TIMESTAMPDIFF(MINUTE,apVie,ciVie) / (SELECT vie FROM tiempo_consulta WHERE id_medico = '".$_GET['idM']."'))) FROM `horarios_semanales` WHERE id_medico = '".$_GET['idM']."'), 
                   IF(DATE_FORMAT(start, '%a') = 'sáb', (SELECT SUM(ROUND(TIMESTAMPDIFF(MINUTE,apSab,ciSab) / (SELECT sab FROM tiempo_consulta WHERE id_medico = '".$_GET['idM']."'))) FROM `horarios_semanales` WHERE id_medico = '".$_GET['idM']."'), 
                      IF(DATE_FORMAT(start, '%a') = 'dom', (SELECT SUM(ROUND(TIMESTAMPDIFF(MINUTE,apDom,ciDom) / (SELECT dom FROM tiempo_consulta WHERE id_medico = '".$_GET['idM']."'))) FROM `horarios_semanales` WHERE id_medico = '".$_GET['idM']."'), 'NO'))))))) - COUNT(id)) = '0', ' ','') AS 'title' 
    FROM turnos WHERE id_medico = '".$_GET['idM']."' AND DATE_FORMAT(start, '%Y-%m-%d') >= '".date('Y-m-d')."'
    GROUP BY DATE_FORMAT(start, '%Y-%m-%d')
    ORDER BY start ASC");

    // $informacion = mysqli_query($veja, "SELECT  
    // DATE_FORMAT(start, '%Y-%m-%d') AS 'start', 
    // DATE_FORMAT(end, '%Y-%m-%d') AS 'end', 
    // 'false' AS 'overlap', 
    // 'background' AS 'display', 
    // '#bbc2ec' AS 'color',
    // (IF(DATE_FORMAT(start, '%a') = 'Mon', (SELECT SUM(ROUND(TIMESTAMPDIFF(MINUTE,apLun,ciLun) / (SELECT lun FROM tiempo_consulta WHERE id_medico = '".$_GET['idM']."'))) FROM `horarios_semanales` WHERE id_medico = '".$_GET['idM']."'), 
    //    IF(DATE_FORMAT(start, '%a') = 'Tue', (SELECT SUM(ROUND(TIMESTAMPDIFF(MINUTE,apMar,ciMar) / (SELECT mar FROM tiempo_consulta WHERE id_medico = '".$_GET['idM']."'))) FROM `horarios_semanales` WHERE id_medico = '".$_GET['idM']."'), 
    //       IF(DATE_FORMAT(start, '%a') = 'Wed', (SELECT SUM(ROUND(TIMESTAMPDIFF(MINUTE,apMie,ciMie) / (SELECT mie FROM tiempo_consulta WHERE id_medico = '".$_GET['idM']."'))) FROM `horarios_semanales` WHERE id_medico = '".$_GET['idM']."'), 
    //          IF(DATE_FORMAT(start, '%a') = 'Thu', (SELECT SUM(ROUND(TIMESTAMPDIFF(MINUTE,apJue,ciJue) / (SELECT jue FROM tiempo_consulta WHERE id_medico = '".$_GET['idM']."'))) FROM `horarios_semanales` WHERE id_medico = '".$_GET['idM']."'), 
    //             IF(DATE_FORMAT(start, '%a') = 'Fri', (SELECT SUM(ROUND(TIMESTAMPDIFF(MINUTE,apVie,ciVie) / (SELECT vie FROM tiempo_consulta WHERE id_medico = '".$_GET['idM']."'))) FROM `horarios_semanales` WHERE id_medico = '".$_GET['idM']."'), 
    //                IF(DATE_FORMAT(start, '%a') = 'Sat', (SELECT SUM(ROUND(TIMESTAMPDIFF(MINUTE,apSab,ciSab) / (SELECT sab FROM tiempo_consulta WHERE id_medico = '".$_GET['idM']."'))) FROM `horarios_semanales` WHERE id_medico = '".$_GET['idM']."'), 
    //                   IF(DATE_FORMAT(start, '%a') = 'Sun', (SELECT SUM(ROUND(TIMESTAMPDIFF(MINUTE,apDom,ciDom) / (SELECT dom FROM tiempo_consulta WHERE id_medico = '".$_GET['idM']."'))) FROM `horarios_semanales` WHERE id_medico = '".$_GET['idM']."'), 'NO')))))))) AS 'title' 
    // FROM turnos WHERE id_medico = '".$_GET['idM']."'
    // GROUP BY DATE_FORMAT(start, '%Y-%m-%d')
    // ORDER BY start ASC");

    while($inf = mysqli_fetch_assoc($informacion)){
        $info .= json_encode($inf).",";
    }

    $diasSinAtencionPorMedico = "";
    $diasNoLaborablesMedicos = mysqli_query($veja, "SELECT 
    dias_sin_atencion_medicos.*, 
    'true' AS 'overlap', 
    'background' AS 'display', 
    '#ff9f89' AS 'color'
    FROM dias_sin_atencion_medicos WHERE id_medico = '".$_GET['idM']."'");
    if(mysqli_num_rows($diasNoLaborablesMedicos) > 0){
        while($diasSinAtencion = mysqli_fetch_assoc($diasNoLaborablesMedicos)){
            $diasSinAtencionPorMedico .= json_encode($diasSinAtencion).",";
        }
    }
    

    echo $diasConAtencion.$diasSinAtencionPorMedico.$diasCerrado.$separador.$info.$turnos;
    // echo $diasConAtencion.$diasCerrado;
    echo "]";
    mysqli_close($veja);

}
?>