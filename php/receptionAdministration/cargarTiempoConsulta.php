<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT 
            tiempo_consulta.lun AS 'lun', 
            tiempo_consulta.mar AS 'mar', 
            tiempo_consulta.mie AS 'mie', 
            tiempo_consulta.jue AS 'jue', 
            tiempo_consulta.vie AS 'vie', 
            tiempo_consulta.sab AS 'sab', 
            tiempo_consulta.dom AS 'dom',
            medicos.celular AS 'celular',
            consultorios.lun AS consLun,
            consultorios.mar AS consMar,
            consultorios.mie AS consMie,
            consultorios.jue AS consJue,
            consultorios.vie AS consVie,
            consultorios.sab AS consSab,
            consultorios.dom AS consDom,
            otros_tiempos.lun AS 'otroLun', 
            otros_tiempos.mar AS 'otroMar', 
            otros_tiempos.mie AS 'otroMie', 
            otros_tiempos.jue AS 'otroJue', 
            otros_tiempos.vie AS 'otroVie', 
            otros_tiempos.sab AS 'otroSab', 
            otros_tiempos.dom AS 'otroDom',
            otros_consultorios.lun AS otroConsLun,
            otros_consultorios.mar AS otroConsMar,
            otros_consultorios.mie AS otroConsMie,
            otros_consultorios.jue AS otroConsJue,
            otros_consultorios.vie AS otroConsVie,
            otros_consultorios.sab AS otroConsSab,
            otros_consultorios.dom AS otroConsDom
        FROM tiempo_consulta
        INNER JOIN medicos ON tiempo_consulta.id_medico = medicos.id
        INNER JOIN consultorios ON consultorios.id_medico = medicos.id
        INNER JOIN otros_tiempos ON otros_tiempos.id_medico = medicos.id
        INNER JOIN otros_consultorios ON otros_consultorios.id_medico = medicos.id
        WHERE tiempo_consulta.id_medico = '".$_POST['idMedico']."' 
        LIMIT 1");
        while($t = mysqli_fetch_assoc($peticion)){
            echo $t['lun']."|".
            $t['mar']."|".
            $t['mie']."|".
            $t['jue']."|".
            $t['vie']."|".
            $t['sab']."|".
            $t['dom']."|".
            $t['celular']."|".
            $t['consLun']."|".
            $t['consMar']."|".
            $t['consMie']."|".
            $t['consJue']."|".
            $t['consVie']."|".
            $t['consSab']."|".
            $t['consDom']."|".
            $t['otroLun']."|".
            $t['otroMar']."|".
            $t['otroMie']."|".
            $t['otroJue']."|".
            $t['otroVie']."|".
            $t['otroSab']."|".
            $t['otroDom']."|".
            $t['otroConsLun']."|".
            $t['otroConsMar']."|".
            $t['otroConsMie']."|".
            $t['otroConsJue']."|".
            $t['otroConsVie']."|".
            $t['otroConsSab']."|".
            $t['otroConsDom'];
        }
    mysqli_close($veja);
}else{
 header("Location: ../../");   
}
?>