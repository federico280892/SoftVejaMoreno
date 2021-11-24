<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT pacientes.nombre AS 'nombrePaciente', pacientes.apellido AS 'apellidoPaciente', turnos.*, medicos.nombre AS 'nombreMedico', medicos.apellido AS 'apellidoMedico' FROM turnos INNER JOIN medicos ON medicos.id = turnos.id_medico INNER JOIN pacientes ON pacientes.DNI = turnos.dni_solicitante WHERE turnos.id = '".$_POST['id']."' LIMIT 1");
    while($t = mysqli_fetch_assoc($peticion)){
        switch($t['tipo_turno']){
            case "1":
                $turno = "Consulta";
            break;
            case "2":
                $turno = "Estudio";
            break;
            case "3":
                $turno = "Cirugía";
            break;
        }
        if($t['sobreturno'] == "1"){
            $sobreturno = "SI";
        }else{
            $sobreturno = "NO";
        }
        if($t['confirmado'] == "1"){
            $confirmado = "SI";
        }else{
            $confirmado = "NO";
        }
        if($t['urgencia'] == "1"){
            $urgencia = "SI";
        }else{
            $urgencia = "NO";
        }
        echo '<div class="row">
            <div class="col text-center"><h4>'.$t['apellidoPaciente'].' '.$t['nombrePaciente'].'</h4></div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <small class="font-weight-bold">Tipo de turno: </small><br>'.$turno.'
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <small class="font-weight-bold">Motivo: </small><br>'.$t['title'].'
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <small class="font-weight-bold">Médico efector: </small><br>'.$t['apellidoMedico'].' '.$t['nombreMedico'].'
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">';
                $mS = mysqli_query($veja, "SELECT apellido, nombre FROM medicos WHERE id = '".$t['mSolicitante']."' LIMIT 1");
                if(mysqli_num_rows($mS) > 0){
                    echo '<small class="font-weight-bold">Médico solicitante: </small><br>'.$t['apellidoMedico'].' '.$t['nombreMedico'];
                }else{
                    echo '<small class="font-weight-bold">Médico solicitante: </small><br> Ninguno';
                }
                echo '</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <small class="font-weight-bold">DNI del solicitante: </small><br>'.$t['dni_solicitante'].'
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <small class="font-weight-bold">Inicio del turno: </small><br>'.$t['start'].'
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <small class="font-weight-bold">Fin del turno: </small><br>'.$t['end'].'
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <small class="font-weight-bold">Sobreturno: </small><br>'.$sobreturno.'
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <small class="font-weight-bold">Confirmado: </small><br>'.$confirmado.'
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <small class="font-weight-bold">Urgencia: </small><br>'.$urgencia.'
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <small class="font-weight-bold">Observación: </small><br>'.$t['observacion'].'
                </div>
            </div>
        </div>';
    }
    mysqli_close($veja);
}
?>