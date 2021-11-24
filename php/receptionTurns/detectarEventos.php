<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    switch(date('D', strtotime($_POST['fecha']))){
        case 'Mon':
            $columnaDia = 3;
            $dia = "Lunes";
            $columnaMinutos = "lun";
            break;
        case 'Tue':
            $columnaDia = 5;
            $dia = "Martes";
            $columnaMinutos = "mar";
            break;
        case 'Wed':
            $columnaDia = 7;
            $dia = "Miercoles";
            $columnaMinutos = "mie";
            break;
        case 'Thu':
            $columnaDia = 9;
            $dia = "Jueves";
            $columnaMinutos = "jue";
            break;
        case 'Fri':
            $columnaDia = 11;
            $dia = "Viernes";
            $columnaMinutos = "vie";
            break;
        case 'Sat':
            $columnaDia = 13;
            $dia = "Sabado";
            $columnaMinutos = "sab";
            break;
        case 'Sun':
            $columnaDia = 15;
            $dia = "Domingo";
            $columnaMinutos = "dom";
            break;
    }

    $diaSemana = mysqli_query($veja, "SELECT $columnaMinutos FROM tiempo_consulta WHERE id_medico = '".$_POST['medico']."' LIMIT 1");
    while($min = mysqli_fetch_assoc($diaSemana)){
        $tiempo_consulta = $min[$columnaMinutos];
    }
    //echo ($tiempo_consulta - 1);
    $peticion = mysqli_query($veja, "SELECT turnos.*, medicos.nombre AS 'medicoNombre', 
        medicos.apellido AS 'medicoApellido', 
        pacientes.apellido AS 'apellidoPaciente', 
        pacientes.nombre AS 'nombrePaciente', 
        coberturas_sociales.cobertura_social AS 'cobertura_social' 
        FROM turnos 
        INNER JOIN medicos 
        ON medicos.id = turnos.id_medico
        INNER JOIN pacientes 
        ON pacientes.dni = turnos.dni_solicitante
        INNER JOIN coberturas_sociales
        ON coberturas_sociales.codigo = pacientes.cobertura_social
        WHERE start 
        BETWEEN '".date("Y-m-d", strtotime($_POST['fecha']))."' 
        AND date_add('".date("Y-m-d", strtotime($_POST['fecha']))."', interval 1 day)
        AND turnos.id_medico = '".$_POST['medico']."'
        AND turnos.sobreturno = '0'
        ORDER BY start ASC");
    $reservas = array();
    $idReserva = array();
    $pacienteReserva = array();
    $motivoReserva = array();
    $tipoReserva = array();
    $medicoEfector = array();
    $medicoSolicitante = array();
    $coberturaSocial = array();
    $observacion = array();
    $sobreturno = array();
    $urgencia = array();
    $confirmado = array();
    $indice = -1;
    $reserva = "";
    $clase = "";
    $turnoSinAtencion = 0;
    echo '<div class="text-center">
    <h6>Turnos Reservados Para El Día <b><span class="text-center text-danger">'.$dia.' '.date('d-m-Y', strtotime($_POST['fecha'])).'</span></b><i role="button" data-fecha="'.date('Y-m-d', strtotime($_POST['fecha'])).'" data-medico="'.$_POST['medico'].'" class="fas fa-info-circle ml-2 text-info" id="verDetallesDelDia"></i></h6>';
    echo '</div>
    <script>  $(function () {
        $(\'[data-toggle="popover"]\').popover({
            trigger: \'hover\',
            delay: 50,
            html: true
        })
      })</script>';
    $feriados = mysqli_query($veja, "SELECT id FROM dias_no_laborales WHERE start = '".date("Y-m-d", strtotime($_POST['fecha']))."'");
    $diasSinAtencion = mysqli_query($veja, "SELECT id FROM dias_sin_atencion_medicos WHERE start = '".date("Y-m-d", strtotime($_POST['fecha']))."'");
    if(mysqli_num_rows($feriados) < 1 && mysqli_num_rows($diasSinAtencion) < 1){
        echo '<div class="text-right">
        <h6 role="button" class=" btn btn-success btn-sm" id="nuevoSobreTurno"><i class="fas fa-plus"></i> Sobreturno</h6>
        </div>';
    }
    echo '<ul class="list-group" style="overflow-y: scroll; height: 320px;">';
        for($i = 1; $i < 3; $i++){

            $otrosHorarios = mysqli_query($veja, "SELECT desde, hasta FROM otros_horarios WHERE id_medico = '".$_POST['medico']."' AND turno = '".$i."'");
            while($o = mysqli_fetch_assoc($otrosHorarios)){
                $otroHorario = mysqli_query($veja, "SELECT id FROM otros_horarios WHERE '".date("Y-m-d", strtotime($_POST['fecha']))."' BETWEEN '".$o['desde']."' AND '".$o['hasta']."' AND turno = '".$i."' AND id_medico = '".$_POST['medico']."'");
                if(mysqli_num_rows($otroHorario) > 0){
                    $peticion2 = mysqli_query($veja, "SELECT * FROM otros_horarios WHERE turno = '".$i."' AND id_medico = '".$_POST['medico']."'");
                }else{
                    $peticion2 = mysqli_query($veja, "SELECT * FROM horarios_semanales WHERE turno = '".$i."' AND id_medico = '".$_POST['medico']."'");
                }
            }

            while($horario = mysqli_fetch_array($peticion2)){
                if($horario[$columnaDia] == "00:00:00"){
                    $turnoSinAtencion++;
                    if($turnoSinAtencion == 1){
                        $turnosExtras = mysqli_query($veja, "SELECT 
                        turnos.start AS 'inicio',
                        turnos.title AS 'title',
                        turnos.observacion AS 'observacion',
                        pacientes.nombre AS nombre,
                        pacientes.apellido AS apellido,
                        coberturas_sociales.cobertura_social AS cobertura
                        FROM turnos 
                        INNER JOIN pacientes
                        ON pacientes.DNI = turnos.dni_solicitante
                        INNER JOIN coberturas_sociales
                        ON coberturas_sociales.codigo = pacientes.cobertura_social
                        WHERE DATE_FORMAT(start, '%Y-%m-%d') = '".date("Y-m-d", strtotime($_POST['fecha']))."'
                        AND DATE_FORMAT(start, '%Y-%m-%d %H:%i:%s') <= '".date("Y-m-d H:i:s", strtotime($_POST['fecha']))."'
                        AND turnos.id_medico = '".$_POST['medico']."'
                        ORDER BY start ASC");
                    }else{
                        $turnosExtras = mysqli_query($veja, "SELECT 
                        turnos.start AS 'inicio',
                        turnos.title AS 'title',
                        turnos.observacion AS 'observacion',
                        pacientes.nombre AS nombre,
                        pacientes.apellido AS apellido,
                        coberturas_sociales.cobertura_social AS cobertura
                        FROM turnos 
                        INNER JOIN pacientes
                        ON pacientes.DNI = turnos.dni_solicitante
                        INNER JOIN coberturas_sociales
                        ON coberturas_sociales.codigo = pacientes.cobertura_social
                        WHERE DATE_FORMAT(start, '%Y-%m-%d') = '".date("Y-m-d", strtotime($_POST['fecha']))."'
                        AND turnos.id_medico = '".$_POST['medico']."'
                        ORDER BY start ASC");
                        echo "<p class='text-center font-weight-bold text-info mt-2'>Día Sin Atención</p>";

                    }

                    if(mysqli_num_rows($turnosExtras) > 0){
                        echo '<ul class="list-group">';
                            while($tE = mysqli_fetch_assoc($turnosExtras)){
                                echo '<li class="list-group-item '.$clase.'" style="padding:0;">
                                    <div style="display:table; width:100%;">
                                        <div style="display: table-row">                                                
                                            <div class="text-center" style="display: table-cell; width:10%;">
                                                <small>'.date("H:i", strtotime($tE['inicio'])).'</small>
                                            </div>
                                            <div style="display: table-cell; width:35%;">
                                                <small>'.strtoupper(substr($tE['apellido']." ".$tE['nombre'], 0, 20)).'</small>
                                            </div>
                                            <div style="display: table-cell; width:15%;">
                                                <small>'.strtoupper($tE['cobertura']).'</small>
                                            </div>
                                            <div style="display: table-cell; width:25%;">
                                                <small>'.substr($tE['title'],0,12).'</small>
                                            </div>
                                            <div style="display: table-cell; width:5%;">
                                            <i style="font-size: 15px;" class="fas fa-comment-dots" 
                                                type="button" 
                                                data-container="body" 
                                                data-toggle="popover" 
                                                data-placement="left" 
                                                data-content="<h6>'.date('H:i', strtotime($tE['inicio'])).' '.strtoupper($tE['apellido']." ".$tE['nombre']).'</h6>
                                                <b>Reserva:</b> '.$tE['title'].'<br>
                                                <b>Observación: </b>'.$tE['observacion'].'">
                                            </i>
                                            </div>
                                        </div>
                                    </div>    
                                </li>';
                            }
                        echo '</ul>';
                    }



                }else{
                    if(date('G', strtotime($horario[$columnaDia])) == date('G', strtotime($horario[$columnaDia + 1]))){
                        $horaInicioTurno = date('G', strtotime($horario[$columnaDia]));
                        $horaFinTurno = (date('G', strtotime($horario[$columnaDia + 1])) + 1);
                    }else{
                        $horaInicioTurno = date('G', strtotime($horario[$columnaDia]));
                        $horaFinTurno = date('G', strtotime($horario[$columnaDia + 1]));
                    }
                    for($h = $horaInicioTurno; $h < $horaFinTurno; $h ++){
                        if(strlen($h) == 1){
                            $h = "0".$h;
                        }
                        if(date('i', strtotime($horario[$columnaDia + 1])) == "00"){
                            $minMax = 60;
                        }else{
                            $minMax = date('i', strtotime($horario[$columnaDia + 1]));
                        }
                        for($m = 0; $m < $minMax; $m+=$tiempo_consulta){
                            if(strlen($m) == 1){
                                $m = "0".$m;
                            }

                            while($turno = mysqli_fetch_assoc($peticion)){
                                array_push($reservas, date('H:i', strtotime($turno['start'])));
                                array_push($idReserva, $turno['id']);
                                array_push($pacienteReserva, $turno['apellidoPaciente']." ".$turno['nombrePaciente']);
                                array_push($motivoReserva, $turno['title']);
                                array_push($sobreturno, $turno['sobreturno']);
                                array_push($urgencia, $turno['urgencia']);
                                array_push($confirmado, $turno['confirmado']);
                                array_push($tipoReserva, $turno['tipo_turno']);
                                array_push($coberturaSocial, $turno['cobertura_social']);
                                array_push($medicoEfector, $turno['medicoApellido']." ".$turno['medicoNombre']);
                                $consulta = mysqli_query($veja, "SELECT apellido, nombre FROM medicos WHERE id = '".$turno['mSolicitante']."' LIMIT 1"); 
                                if(mysqli_num_rows($consulta) > 0){
                                    while($mS = mysqli_fetch_assoc($consulta)){
                                        array_push($medicoSolicitante, $mS['apellido']." ".$mS['nombre']);
                                    }
                                }else{
                                    array_push($medicoSolicitante, "Ninguno");
                                }
                                array_push($observacion, $turno['observacion']);
                            }
                               
                            if(in_array($h.":".$m, $reservas)){
                                $indice++;
                                if($confirmado[$indice] == "1"){
                                    $confirmacionTurno = 'Confirmado';
                                }else{
                                    $confirmacionTurno = 'Sin confirmar';
                                }
                                if($sobreturno[$indice] == "1"){
                                    $sobre = 'Si';
                                }else{
                                    $sobre = 'No';
                                }
                                if($tipoReserva[$indice] == 1){
                                    $reserva = "Consulta";
                                    if($urgencia[$indice] == "0"){
                                        $clase = "consulta";
                                    }else{
                                        $clase = "urgencia";
                                    }
                                }else if($tipoReserva[$indice] == 2){
                                    $reserva = "Estudio";
                                    if($urgencia[$indice] == "0"){
                                        $clase = "estudio";
                                    }else{
                                        $clase = "urgencia";
                                    }
                                }else if($tipoReserva[$indice] == 3){
                                    $reserva = "Cirugua";
                                    if($urgencia[$indice] == "0"){
                                        $clase = "cirugia";
                                    }else{
                                        $clase = "urgencia";
                                    }
                                }
                                
                                echo '<li class="list-group-item '.$clase.'" style="padding:0;">
                                    <div style="display:table; width:100%;">
                                        <div style="display: table-row">                                                
                                            <div class="text-center" style="display: table-cell; width:10%;">
                                                <small>'.$h.":".$m.'</small>
                                            </div>
                                            <div style="display: table-cell; width:35%;">
                                                <small>'.strtoupper(substr($pacienteReserva[$indice], 0, 20)).'</small>
                                            </div>
                                            <div style="display: table-cell; width:15%;">
                                                <small>'.strtoupper($coberturaSocial[$indice]).'</small>
                                            </div>
                                            <div style="display: table-cell; width:25%;">
                                                <small>'.substr($motivoReserva[$indice],0,20).'</small>
                                            </div>
                                            <div style="display: table-cell; width:5%;">
                                            <i style="font-size: 15px;" class="fas fa-comment-dots" 
                                                type="button" 
                                                data-container="body" 
                                                data-toggle="popover" 
                                                data-placement="left" 
                                                data-content="<h6>'.date('H:i', strtotime($reservas[$indice])).' '.strtoupper($pacienteReserva[$indice]).'</h6>
                                                <b>Reserva:</b> '.$motivoReserva[$indice].'<br>
                                                <b>Observación: </b>'.$observacion[$indice].'">
                                            </i>
                                            </div>
                                        </div>
                                    </div>    
                                </li>';

                                $query = mysqli_query($veja, "SELECT turnos.*, medicos.nombre AS 'medicoNombre', 
                                medicos.apellido AS 'medicoApellido', 
                                pacientes.apellido AS 'apellidoPaciente', 
                                pacientes.nombre AS 'nombrePaciente', 
                                coberturas_sociales.cobertura_social AS 'cobertura_social' 
                                FROM turnos 
                                INNER JOIN medicos 
                                ON medicos.id = turnos.id_medico
                                INNER JOIN pacientes 
                                ON pacientes.dni = turnos.dni_solicitante
                                INNER JOIN coberturas_sociales
                                ON coberturas_sociales.id = pacientes.cobertura_social
                                WHERE start
                                BETWEEN date_add('".date("Y-m-d H:i:s", strtotime($_POST['fecha']." ".$h.":".$m))."', interval 1 minute)
                                AND date_add('".date("Y-m-d H:i:s", strtotime($_POST['fecha']." ".$h.":".$m))."', interval ".($tiempo_consulta - 1)." minute)
                                AND sobreturno = '1'
                                AND id_medico = '".$_POST['medico']."'
                                ORDER BY start ASC");

                                while($sT = mysqli_fetch_assoc($query)){

                                    if($sT['confirmado'] == "1"){
                                        $confirmacionTurno = 'Confirmado';
                                    }else{
                                        $confirmacionTurno = 'Sin confirmar';
                                    }
                                    if($sT['sobreturno'] == "1"){
                                        $sobre = 'Si';
                                    }else{
                                        $sobre = 'No';
                                    }
                                    if($sT['tipo_turno'] == 1){
                                        $reserva = "Consulta";
                                        if($sT['urgencia'] == "0"){
                                            $clase = "consulta";
                                        }else{
                                            $clase = "urgencia";
                                        }
                                    }else if($sT['tipo_turno'] == 2){
                                        $reserva = "Estudio";
                                        if($sT['urgencia'] == "0"){
                                            $clase = "estudio";
                                        }else{
                                            $clase = "urgencia";
                                        }
                                    }else if($sT['tipo_turno'] == 3){
                                        $reserva = "Cirugua";
                                        if($sT['urgencia'] == "0"){
                                            $clase = "cirugia";
                                        }else{
                                            $clase = "urgencia";
                                        }
                                    }


                                    $consulta = mysqli_query($veja, "SELECT apellido, nombre FROM medicos WHERE id = '".$sT['mSolicitante']."' LIMIT 1"); 
                                        if(mysqli_num_rows($consulta) > 0){
                                            while($mS = mysqli_fetch_assoc($consulta)){
                                                $medSolicitante = $mS['apellido']." ".$mS['nombre'];
                                            }
                                        }else{
                                            $medSolicitante = "Ninguno";
                                        }


                                    echo '<li class="list-group-item '.$clase.'" style="padding:0;">
                                        <div style="display: table; width:100%">
                                            <div class="display: table-row">
                                                <div class="text-center" style="display: table-cell; width:10%;">
                                                    <small>'.date("H:i", strtotime($sT['start'])).'</small>
                                                </div>
                                                <div style="display: table-cell; width:35%;">
                                                <small>'.strtoupper(substr($sT['apellidoPaciente'].' '.$sT['nombrePaciente'],0, 20)).'</small>
                                                </div>
                                                <div style="display: table-cell; width:15%;">
                                                    <small>'.strtoupper($sT['cobertura_social']).'</small>
                                                </div>
                                                <div style="display: table-cell; width:25%;">
                                                    <small>'.substr($sT['title'],0, 20).'</small>
                                                </div>
                                                <div style="display: table-cell; width:5%;">
                                                    <i style="font-size: 10px;" class="fas fa-comment-dots" 
                                                        type="button" 
                                                        data-container="body" 
                                                        data-toggle="popover" 
                                                        data-placement="left" 
                                                        data-content="<h6>'.date('H:i', strtotime($sT['start'])).' '.strtoupper($sT['apellidoPaciente'].' '.$sT['nombrePaciente']).'</h6>
                                                        <b>Reserva:</b> '.$sT['title'].'<br>
                                                        <b>Observación: </b>'.$sT['observacion'].'">
                                                    </i>
                                                </div>
                                            </div>
                                        </div>    
                                    </li>';
                                }

                                
                            }else{

                                echo '<li role="button" class="list-group-item" id="agregarTurnoDiaSeleccionado" data-fecha="'.$_POST['fecha'].'" data-hora="'.$h.':'.$m.'" style="padding:0;">
                                    <i class="far fa-calendar-check text-success"></i> '.$h.":".$m.'
                                </li>';

                                $query = mysqli_query($veja, "SELECT turnos.*, medicos.nombre AS 'medicoNombre', 
                                medicos.apellido AS 'medicoApellido', 
                                pacientes.apellido AS 'apellidoPaciente', 
                                pacientes.nombre AS 'nombrePaciente', 
                                coberturas_sociales.cobertura_social AS 'cobertura_social' 
                                FROM turnos 
                                INNER JOIN medicos 
                                ON medicos.id = turnos.id_medico
                                INNER JOIN pacientes 
                                ON pacientes.dni = turnos.dni_solicitante
                                INNER JOIN coberturas_sociales
                                ON coberturas_sociales.id = pacientes.cobertura_social
                                WHERE start
                                BETWEEN date_add('".date("Y-m-d H:i:s", strtotime($_POST['fecha']." ".$h.":".$m))."', interval 1 minute)
                                AND date_add('".date("Y-m-d H:i:s", strtotime($_POST['fecha']." ".$h.":".$m))."', interval ".($tiempo_consulta - 1)." minute)
                                AND sobreturno = '1'
                                AND id_medico = '".$_POST['medico']."'
                                ORDER BY start ASC");

                                while($sT = mysqli_fetch_assoc($query)){

                                    if($sT['confirmado'] == "1"){
                                        $confirmacionTurno = 'Confirmado';
                                    }else{
                                        $confirmacionTurno = 'Sin confirmar';
                                    }
                                    if($sT['sobreturno'] == "1"){
                                        $sobre = 'Si';
                                    }else{
                                        $sobre = 'No';
                                    }
                                    if($sT['tipo_turno'] == 1){
                                        $reserva = "Consulta";
                                        if($sT['urgencia'] == "0"){
                                            $clase = "consulta";
                                        }else{
                                            $clase = "urgencia";
                                        }
                                    }else if($sT['tipo_turno'] == 2){
                                        $reserva = "Estudio";
                                        if($sT['urgencia'] == "0"){
                                            $clase = "estudio";
                                        }else{
                                            $clase = "urgencia";
                                        }
                                    }else if($sT['tipo_turno'] == 3){
                                        $reserva = "Cirugua";
                                        if($sT['urgencia'] == "0"){
                                            $clase = "cirugia";
                                        }else{
                                            $clase = "urgencia";
                                        }
                                    }

                                    $consulta = mysqli_query($veja, "SELECT apellido, nombre FROM medicos WHERE id = '".$sT['mSolicitante']."' LIMIT 1"); 
                                        if(mysqli_num_rows($consulta) > 0){
                                            while($mS = mysqli_fetch_assoc($consulta)){
                                                $medSolicitante = $mS['apellido']." ".$mS['nombre'];
                                            }
                                        }else{
                                            $medSolicitante = "Ninguno";
                                        }

                                        echo '<li class="list-group-item '.$clase.'" style="padding:0;">
                                        <div style="display: table; width:100%">
                                            <div class="display: table-row">
                                                <div class="text-center" style="display: table-cell; width:10%;">
                                                    <small>'.date("H:i", strtotime($sT['start'])).'</small>
                                                </div>
                                                <div style="display: table-cell; width:35%;">
                                                <small>'.strtoupper(substr($sT['apellidoPaciente'].' '.$sT['nombrePaciente'],0, 20)).'</small>
                                                </div>
                                                <div style="display: table-cell; width:15%;">
                                                    <small>'.strtoupper($sT['cobertura_social']).'</small>
                                                </div>
                                                <div style="display: table-cell; width:25%;">
                                                    <small>'.substr($sT['title'],0, 20).'</small>
                                                </div>
                                                <div style="display: table-cell; width:5%;">
                                                    <i style="font-size: 10px;" class="fas fa-comment-dots" 
                                                        type="button" 
                                                        data-container="body" 
                                                        data-toggle="popover" 
                                                        data-placement="left" 
                                                        data-content="<h6>'.date('H:i', strtotime($sT['start'])).' '.$sT['apellidoPaciente'].' '.$sT['nombrePaciente'].'</h6>
                                                        <b>Reserva:</b> '.$sT['title'].'<br>
                                                        <b>Observación: </b>'.$sT['observacion'].'">
                                                    </i>
                                                </div>
                                            </div>
                                        </div>    
                                    </li>';
                                }

                            }                            
                        }
                    }
                }
            }
        }
    echo '</ul>';
}
?>