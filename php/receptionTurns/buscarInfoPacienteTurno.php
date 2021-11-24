<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT 
    pacientes.apellido,
    pacientes.nombre, 
    pacientes.fecha_nacimiento, 
    localidades.localidad, 
    pacientes.tel1, 
    pacientes.tel2, 
    pacientes.cel, 
    pacientes.email, 
    coberturas_sociales.cobertura_social, 
    coberturas_sociales.activo, 
    pacientes.observacion 
    FROM pacientes 
    INNER JOIN localidades
    ON localidades.id = pacientes.localidad
    INNER JOIN coberturas_sociales
    ON coberturas_sociales.codigo = pacientes.cobertura_social
    WHERE pacientes.id = '".$_POST['idPaciente']."' 
    LIMIT 1");

    if(mysqli_num_rows($peticion) > 0){

        echo '<div class="row">
            <div class="col text-right">
                <i role="button" id="botonEdicionRapidaPaciente" class="fas fa-user-edit text-info h4" onclick="editarPaciente(\''.$_POST['idPaciente'].'\')"></i>
            </div>
        </div>';

        while($d = mysqli_fetch_assoc($peticion)){
            $fecha_nacimiento = new DateTime(date("d-m-Y", strtotime($d['fecha_nacimiento'])));
            $hoy = new DateTime();
            $edad = $hoy->diff($fecha_nacimiento);
            echo '<small class="d-block">Obra social: <b>'.$d['cobertura_social'].'</b>'; 
            if($d['activo'] == '1'){
                echo '<span class="text-success font-weight-bold ml-2">Activo</span>';
            }else{
                echo '<span class="text-danger font-weight-bold ml-2">Suspendida<i class="fas fa-exclamation-triangle h2 text-danger oscilar ml-2"></i></span>';
            }
            echo '</small>
            <small class="d-block">Ap y Nom: <b>'.substr($d['apellido'].' '.$d['nombre'],0 , 25).'</b></small>';
            if($d['fecha_nacimiento'] != "" || $d['fecha_nacimiento'] != "-"){
                echo '<small class="d-block">F Nacim: <b>'.date("d-m-Y", strtotime($d['fecha_nacimiento'])).' - '.$edad->y.' años</b></small>';
            }else{
                echo '<small class="d-block">F Nacim: <b> - <span class="text-danger">Por Favor Complete Edad</span></b></small>';
            }
            echo '<small class="d-block">Localidad: <b>'.$d['localidad'].'</b></small>
            <small class="d-block">Tel1: <b>'.$d['tel1'].'</b></small>
            <small class="d-block">Tel2: <b>'.$d['tel2'].'</b></small>
            <small class="d-block">Cel: <b>'.$d['cel'].'</b></small>
            <small class="d-block">Email: <b>'.$d['email'].'</b></small>
            <small class="d-block">Obs: <b>'.$d['observacion'].'</b></small>';
        }
    }else{
        echo "Seleccione un paciente";
    }




    // $peticion = mysqli_query($veja, "SELECT start, date_add(end, interval -1 day) AS 'end', title FROM dias_sin_atencion_medicos WHERE date_format(start, '%m') = '".date('m')."' AND id_medico = '".$_POST['id']."' ORDER BY start ASC, fecha_start ASC");
    // // $peticion = mysqli_query($veja, "SELECT start, date_add(end, interval -1 day) AS 'end', title FROM dias_sin_atencion_medicos WHERE (start >= '".date("Y-m-d")."' OR '".date("Y-m-d")."' BETWEEN start AND end) AND date_format(start, '%m') = '".date('m')."' AND id_medico = '".$_POST['id']."' ORDER BY start ASC, fecha_start ASC");
    // if(mysqli_num_rows($peticion) > 0){
    //     $dias = "";
    //     echo "<span class='text-danger'>Sin atención</span>";
    //     echo '<ul class="list-group-flush" style="padding: 0;">';
    //     while($tM = mysqli_fetch_assoc($peticion)){
           
    //         if($tM['start'] == $tM['end']){
    //             echo "<li class='list-group-item'>
    //                 <small class='text-danger'>Día: </small>
    //                 <small class='font-weight-bold'>".date("d-m-Y", strtotime($tM['start']))."</small>
    //                 <small class='text-danger'><br>Motivo: </small>
    //                 <small class='font-weight-bold'>".$tM['title']."</small
    //             </li>";
    //         }else{
    //             echo "<li class='list-group-item'>
    //                 <small class='text-danger'>Desde: </small>
    //                 <small class='font-weight-bold'>".date("d-m-Y", strtotime($tM['start']))."</small>
    //                 <small class='text-danger'> Hasta: </small>
    //                 <small class='font-weight-bold'>".date("d-m-Y", strtotime($tM['end']))."</small>
    //                 <small class='text-danger'> Motivo: </small>
    //                 <small class='font-weight-bold'>".$tM['title']."</small>
    //                 </li>";
    //         }
    //     }
    //     echo '</ul>'; 
    // }
    mysqli_close($veja);
}
?>