<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");

    $fechaTurno = date("Y-m-d", strtotime($_POST['fecha']));
    $horaTurno = date("H:i:s", strtotime($_POST['hora']));

    // $peticion = mysqli_query($veja, "SELECT 
    // IF(DATE_FORMAT(start , '%a') = 'Mon', (SELECT ROUND(TIMESTAMPDIFF(MINUTE, '".$fechaTurno." ".$horaTurno."', start) / (SELECT lun FROM tiempo_consulta WHERE id_medico = '".$_POST['idMed']."'), 0) FROM turnos WHERE id_medico = '".$_POST['idMed']."' AND DATE_FORMAT(start, '%H:%i:%s') > '".$horaTurno."' AND DATE_FORMAT(start, '%Y-%m-%d') = '".$fechaTurno."' ORDER BY start ASC LIMIT 1), 
    //    IF(DATE_FORMAT(start , '%a') = 'Tue', (SELECT ROUND(TIMESTAMPDIFF(MINUTE, '".$fechaTurno." ".$horaTurno."', start) / (SELECT mar FROM tiempo_consulta WHERE id_medico = '".$_POST['idMed']."'), 0) FROM turnos WHERE id_medico = '".$_POST['idMed']."' AND DATE_FORMAT(start, '%H:%i:%s') > '".$horaTurno."' AND DATE_FORMAT(start, '%Y-%m-%d') = '".$fechaTurno."' ORDER BY start ASC LIMIT 1), 
    //       IF(DATE_FORMAT(start , '%a') = 'Wed', (SELECT ROUND(TIMESTAMPDIFF(MINUTE, '".$fechaTurno." ".$horaTurno."', start) / (SELECT mie FROM tiempo_consulta WHERE id_medico = '".$_POST['idMed']."'), 0) FROM turnos WHERE id_medico = '".$_POST['idMed']."' AND DATE_FORMAT(start, '%H:%i:%s') > '".$horaTurno."' AND DATE_FORMAT(start, '%Y-%m-%d') = '".$fechaTurno."' ORDER BY start ASC LIMIT 1), 
    //          IF(DATE_FORMAT(start , '%a') = 'Thu', (SELECT ROUND(TIMESTAMPDIFF(MINUTE, '".$fechaTurno." ".$horaTurno."', start) / (SELECT jue FROM tiempo_consulta WHERE id_medico = '".$_POST['idMed']."'), 0) FROM turnos WHERE id_medico = '".$_POST['idMed']."' AND DATE_FORMAT(start, '%H:%i:%s') > '".$horaTurno."' AND DATE_FORMAT(start, '%Y-%m-%d') = '".$fechaTurno."' ORDER BY start ASC LIMIT 1), 
    //             IF(DATE_FORMAT(start , '%a') = 'Fri', (SELECT ROUND(TIMESTAMPDIFF(MINUTE, '".$fechaTurno." ".$horaTurno."', start) / (SELECT vie FROM tiempo_consulta WHERE id_medico = '".$_POST['idMed']."'), 0) FROM turnos WHERE id_medico = '".$_POST['idMed']."' AND DATE_FORMAT(start, '%H:%i:%s') > '".$horaTurno."' AND DATE_FORMAT(start, '%Y-%m-%d') = '".$fechaTurno."' ORDER BY start ASC LIMIT 1), 
    //                IF(DATE_FORMAT(start , '%a') = 'Sat', (SELECT ROUND(TIMESTAMPDIFF(MINUTE, '".$fechaTurno." ".$horaTurno."', start) / (SELECT sab FROM tiempo_consulta WHERE id_medico = '".$_POST['idMed']."'), 0) FROM turnos WHERE id_medico = '".$_POST['idMed']."' AND DATE_FORMAT(start, '%H:%i:%s') > '".$horaTurno."' AND DATE_FORMAT(start, '%Y-%m-%d') = '".$fechaTurno."' ORDER BY start ASC LIMIT 1), 
    //                IF(DATE_FORMAT(start , '%a') = 'Sun', (SELECT ROUND(TIMESTAMPDIFF(MINUTE, '".$fechaTurno." ".$horaTurno."', start) / (SELECT dom FROM tiempo_consulta WHERE id_medico = '".$_POST['idMed']."'), 0) FROM turnos WHERE id_medico = '".$_POST['idMed']."' AND DATE_FORMAT(start, '%H:%i:%s') > '".$horaTurno."' AND DATE_FORMAT(start, '%Y-%m-%d') = '".$fechaTurno."' ORDER BY start ASC LIMIT 1), 'NO'))))))) AS 'turnos' 
    //                FROM turnos WHERE id_medico = '".$_POST['idMed']."' AND DATE_FORMAT(start, '%H:%i:%s') > '".$horaTurno."' AND DATE_FORMAT(start, '%Y-%m-%d') = '".$fechaTurno."' GROUP BY DATE_FORMAT(start, '%Y-%m-%d') LIMIT 1");
    
    $peticion = mysqli_query($veja, "SELECT 
    IF(DATE_FORMAT(start , '%a') = 'lun', (SELECT ROUND(TIMESTAMPDIFF(MINUTE, '".$fechaTurno." ".$horaTurno."', start) / (SELECT lun FROM tiempo_consulta WHERE id_medico = '".$_POST['idMed']."'), 0) FROM turnos WHERE id_medico = '".$_POST['idMed']."' AND DATE_FORMAT(start, '%H:%i:%s') > '".$horaTurno."' AND DATE_FORMAT(start, '%Y-%m-%d') = '".$fechaTurno."' ORDER BY start ASC LIMIT 1), 
       IF(DATE_FORMAT(start , '%a') = 'mar', (SELECT ROUND(TIMESTAMPDIFF(MINUTE, '".$fechaTurno." ".$horaTurno."', start) / (SELECT mar FROM tiempo_consulta WHERE id_medico = '".$_POST['idMed']."'), 0) FROM turnos WHERE id_medico = '".$_POST['idMed']."' AND DATE_FORMAT(start, '%H:%i:%s') > '".$horaTurno."' AND DATE_FORMAT(start, '%Y-%m-%d') = '".$fechaTurno."' ORDER BY start ASC LIMIT 1), 
          IF(DATE_FORMAT(start , '%a') = 'mie', (SELECT ROUND(TIMESTAMPDIFF(MINUTE, '".$fechaTurno." ".$horaTurno."', start) / (SELECT mie FROM tiempo_consulta WHERE id_medico = '".$_POST['idMed']."'), 0) FROM turnos WHERE id_medico = '".$_POST['idMed']."' AND DATE_FORMAT(start, '%H:%i:%s') > '".$horaTurno."' AND DATE_FORMAT(start, '%Y-%m-%d') = '".$fechaTurno."' ORDER BY start ASC LIMIT 1), 
             IF(DATE_FORMAT(start , '%a') = 'jue', (SELECT ROUND(TIMESTAMPDIFF(MINUTE, '".$fechaTurno." ".$horaTurno."', start) / (SELECT jue FROM tiempo_consulta WHERE id_medico = '".$_POST['idMed']."'), 0) FROM turnos WHERE id_medico = '".$_POST['idMed']."' AND DATE_FORMAT(start, '%H:%i:%s') > '".$horaTurno."' AND DATE_FORMAT(start, '%Y-%m-%d') = '".$fechaTurno."' ORDER BY start ASC LIMIT 1), 
                IF(DATE_FORMAT(start , '%a') = 'vie', (SELECT ROUND(TIMESTAMPDIFF(MINUTE, '".$fechaTurno." ".$horaTurno."', start) / (SELECT vie FROM tiempo_consulta WHERE id_medico = '".$_POST['idMed']."'), 0) FROM turnos WHERE id_medico = '".$_POST['idMed']."' AND DATE_FORMAT(start, '%H:%i:%s') > '".$horaTurno."' AND DATE_FORMAT(start, '%Y-%m-%d') = '".$fechaTurno."' ORDER BY start ASC LIMIT 1), 
                   IF(DATE_FORMAT(start , '%a') = 'sáb', (SELECT ROUND(TIMESTAMPDIFF(MINUTE, '".$fechaTurno." ".$horaTurno."', start) / (SELECT sab FROM tiempo_consulta WHERE id_medico = '".$_POST['idMed']."'), 0) FROM turnos WHERE id_medico = '".$_POST['idMed']."' AND DATE_FORMAT(start, '%H:%i:%s') > '".$horaTurno."' AND DATE_FORMAT(start, '%Y-%m-%d') = '".$fechaTurno."' ORDER BY start ASC LIMIT 1), 
                   IF(DATE_FORMAT(start , '%a') = 'dom', (SELECT ROUND(TIMESTAMPDIFF(MINUTE, '".$fechaTurno." ".$horaTurno."', start) / (SELECT dom FROM tiempo_consulta WHERE id_medico = '".$_POST['idMed']."'), 0) FROM turnos WHERE id_medico = '".$_POST['idMed']."' AND DATE_FORMAT(start, '%H:%i:%s') > '".$horaTurno."' AND DATE_FORMAT(start, '%Y-%m-%d') = '".$fechaTurno."' ORDER BY start ASC LIMIT 1), 'NO'))))))) AS 'turnos' 
                   FROM turnos WHERE id_medico = '".$_POST['idMed']."' AND DATE_FORMAT(start, '%H:%i:%s') > '".$horaTurno."' AND DATE_FORMAT(start, '%Y-%m-%d') = '".$fechaTurno."' GROUP BY DATE_FORMAT(start, '%Y-%m-%d') LIMIT 1");

    
    while($c = mysqli_fetch_assoc($peticion)){
        if($c['turnos'] > 3){
            echo "3";
        }else{
            echo $c['turnos'];
        }
    }
    
    mysqli_close($veja);
}
?>