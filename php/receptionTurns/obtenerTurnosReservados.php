<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT
    coberturas_sociales.cobertura_social AS 'cobertura', 
    coberturas_sociales.activo AS 'coberturaEstado', 
    coberturas_sociales.modulada AS 'modulada', 
    turnos.*, 
    users.apellido AS 'apellidoResponsable',
    users.nombre AS 'nombreResponsable',
    medicos.codigo AS 'codigo',
    medicos.apellido AS 'apellidoMedico',
    medicos.nombre AS 'nombreMedico',
    pacientes.id AS 'idPaciente', 
    pacientes.apellido AS 'apellido', 
    pacientes.nombre AS 'nombre', 
    pacientes.tel1 AS 'tel1', 
    pacientes.tel2 AS 'tel2', 
    pacientes.cel AS 'cel',
    pacientes.DNI AS 'dni',
    pacientes.cobertura_social AS 'codCobertura',
    pacientes.n_carnet AS 'nCarnet',
    pacientes.coseguro AS 'coseguro',
    pacientes.observacion AS 'observacionPaciente',
    pagos.id AS 'idPago', 
    pagos.cobertura AS 'pagoCobertura' 
    FROM turnos 
    INNER JOIN pacientes ON pacientes.DNI = turnos.dni_solicitante 
    INNER JOIN users ON users.id = turnos.responsable
    INNER JOIN coberturas_sociales ON pacientes.cobertura_social = coberturas_sociales.codigo
    INNER JOIN medicos ON medicos.id = turnos.id_medico 
    LEFT JOIN pagos ON pagos.id_turno = turnos.id
    WHERE 
        turnos.id_medico = '".$_POST['medico']."' AND 
        DATE_FORMAT(turnos.start, '%Y-%m-%d') = '".$_POST['fecha']."'
    ORDER BY turnos.start ASC LIMIT 100");
    if(mysqli_num_rows($peticion) == 0){
        echo '<tr>
            <td colspan="17" class="text-left"><b>No se encontraron coincidencias</b></td>
        </tr>';
    }else{
        while($t = mysqli_fetch_assoc($peticion)){

            if($t['sobreturno'] == ""){
                $sobreturno = "";
            }else{
                $sobreturno = "sobreturno";
            }

            if($t['observacion'] == ""){
                $observacion = "-";
            }else{
                $observacion = $t['observacion'];
            }

            if($t['tipo_turno'] == 1){
                $reserva = "Consulta";
                if($t['urgencia'] == "0"){
                    $clase = "consulta";
                }else{
                    $clase = "urgencia";
                }
            }else if($t['tipo_turno'] == 2){
                $reserva = "Estudio";
                if($t['urgencia'] == "0"){
                    $clase = "estudio";
                }else{
                    $clase = "urgencia";
                }
            }else if($t['tipo_turno'] == 3){
                $reserva = "Cirugua";
                if($t['urgencia'] == "0"){
                    $clase = "cirugia";
                }else{
                    $clase = "urgencia";
                }
            }

            if($t['coberturaEstado'] == "1"){
                $estadoCobertura = '<i class="fas fa-circle text-success mr-2 ml-1"></i>';
            }else{
                $estadoCobertura = '<i class="fas fa-circle text-danger mr-2 ml-1"></i>';
            }
            if($t['pago'] == "1"){
                $data_idPago = 'data-idPago="'.$t['idPago'].'"';
                $pago = '<input disabled type="checkbox" id="paciente'.$t['id'].'" checked>';
                $pagado = 'pagado';
            }else{
                $data_idPago = "";
                $pago = '<input disabled type="checkbox" id="paciente'.$t['id'].'">';
                $pagado = 'sin pagar';
            }
            if($t['confirmado'] == "1"){
                $confirmado = '<i class="fas fa-check text-success" id="confirmado'.$t['id'].'" data-estado="1"></i>';
                $conf = 'confirmado';
            }else{
                $confirmado = '<i class="fas fa-times text-danger" id="confirmado'.$t['id'].'" data-estado="0"></i>';
                $conf = 'sin confirmar';
            }
            if($t['primera_vez'] == "1"){
                $primeraVez = ' 1° vez';
            }else{
                $primeraVez = '';
            }
            if($t['ingreso'] == "-"){
                $ingreso = '-';
            }else{
                $ingreso = date("d-m-Y H:i:s", strtotime($t['ingreso']));
            }
            if($t['egreso'] == "-"){
                $egreso = '-';
            }else{
                $egreso = date("H:i", strtotime($t['egreso']));
            }
            if($t['n_cobro'] == "-"){
                $nCobro = '-';
            }else{
                $nCobro = "#".$t['n_cobro'];
            }
            if($t['responsable'] == "-"){
                $responsable = '-';
            }else{
                $responsable = strtoupper(substr($t['apellidoResponsable'].', '.$t['nombreResponsable'],0 ,16));
            }
            if($t['atendido'] == "1"){
                $atendido = '<i class="fas fa-user-md mr-2 ml-1 text-success"></i>Atendido';
                $estado = 'Atendido';
            }else if($t['atendido']  == "0"){
                $atendido = '<i class="fas fa-circle-notch mr-2 ml-1 rotar text-warning"></i>En espera';
                $estado = 'En espera';
            }else if($t['atendido']  == "2"){
                $atendido = '<i class="fas fa-exclamation mr-2 ml-1 text-danger"></i>Ausente';
                $estado = 'Ausente';
            }else{
                $atendido = '<div class="text-center">-</div>';
                $estado = '-';
            }
            echo '<tr role="button" data-tipoTurno="'.$t['tipo_turno'].'" '.$data_idPago.' class="'.$clase.' filaTurno" data-buscar="
                            '.strtoupper(substr($t['apellido'].' '.$t['nombre'],0, 15)).' 
                            '.strtoupper($t['cobertura']).' 
                            '.$t['tel1'].' 
                            '.$t['tel2'].' 
                            '.$t['cel'].' 
                            '.date("H:i", strtotime($t['start'])).' 
                            '.$estado.' 
                            '.$conf.' 
                            '.$pagado.' 
                            '.$sobreturno.' 
                            '.$t['ingreso'].' 
                            '.$t['title'].' 
                            '.$t['observacion'].' 
                            '.$primeraVez.' 
                            '.strtoupper(substr($t['apellidoResponsable'].', '.$t['nombreResponsable'],0 ,15)).'
                            ">
                <td class="align-middle text-center">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="idTurno" style="margin-left: -16px;" onclick="idRegistroSeleccionado(\''.$t['id'].'\', \''.$t['cel'].'\', \''.$t['dni'].'\', \''.date('d-m-Y', strtotime($t['start'])).'\', \''.$t['codigo'].' - '.$t['apellidoMedico'].' '.$t['nombreMedico'].'\', \''.$t['dni_solicitante'].'\', \''.$t['dni'].' - '.$t['apellido'].' '.$t['nombre'].'\', \''.$t['codCobertura'].'\', \''.$t['coseguro'].'\', \''.$t['modulada'].'\', \''.$t['tipo_turno'].'\', \''.$t['nCarnet'].'\', \''.$t['idPaciente'].'\')" id="radioBuutton'.$t['id'].'" value="'.$t['id'].'">
                    </div>
                </td>
                <td class="align-middle text-center"><small>'.date('H:i', strtotime($t['start'])).'</small></td>
                <td class="align-middle text-left"><small>'.strtoupper(substr($t['apellido'].' '.$t['nombre'],0, 15)).$primeraVez.'</small></td>
                <td class="align-middle text-left"><small>'.$estadoCobertura.strtoupper($t['cobertura']).'</small></td>
                <td class="align-middle text-center"><small>'.$atendido.'</small></td>
                <td class="align-middle text-center"><small>'.$t['tel1'].'<b><i class="fas fa-dot-circle ml-1 mr-1 text-primary"></i></b>'.$t['tel2'].'<b><i class="fas fa-dot-circle ml-1 mr-1 text-primary"></i></b>'.substr($t['cel'],3,14).'</small></td>
                <td class="align-middle text-center"><small id="ingresoPaciente'.$t['id'].'">'.$ingreso.'</small></td>
                <td class="align-middle text-center"><small>'.$egreso.'</small></td>
                <td class="align-middle text-center"><small>'.$pago.'</small></td>
                <td class="align-middle text-center"><small>'.$confirmado.'</small></td>
                <td class="align-middle text-left"><small>'.$t['title'].'</small></td>
                <td class="align-middle text-left"><small>'.strtoupper(substr($observacion,0 , 18)).'</small></td>';

                if($t['pagoCobertura'] == ""){
                    echo '<td class="align-middle text-center"><small>-</small></td>';
                }else{
                    $coberturas = mysqli_query($veja, "SELECT cobertura_social FROM coberturas_sociales WHERE codigo = '".$t['pagoCobertura']."' LIMIT 1");
                    while($cobertura = mysqli_fetch_assoc($coberturas)){
                        echo '<td class="align-middle text-center"><small>'.strtoupper($cobertura['cobertura_social']).'</small></td>';
                    }
                }
                
                
                echo '<td class="align-middle text-center"><small>'.$responsable.'</small></td>
                <td class="align-middle text-center"><small>'.$nCobro.'</small></td>
                <td class="align-middle text-left"><small>'.date("d-m-Y H:i:s", strtotime($t['f_registro'])).'</small></td>
                <td class="align-middle text-center"><i role="button" class="fas fa-info-circle text-info" onclick="verInformacionTurno(\''.$t['id'].'\')"></i></td>
            </tr>';
        }
    }
    echo '<script>
        $("#cantidadConsultas").html('.mysqli_num_rows(mysqli_query($veja, "SELECT id FROM turnos WHERE id_medico = '".$_POST['medico']."' AND 
        DATE_FORMAT(start, '%Y-%m-%d') = '".$_POST['fecha']."' AND tipo_turno = '1'")).');
        $("#cantidadEstudios").html('.mysqli_num_rows(mysqli_query($veja, "SELECT id FROM turnos WHERE id_medico = '".$_POST['medico']."' AND 
        DATE_FORMAT(start, '%Y-%m-%d') = '".$_POST['fecha']."' AND tipo_turno = '2'")).');
        $("#cantidadCirugias").html('.mysqli_num_rows(mysqli_query($veja, "SELECT id FROM turnos WHERE id_medico = '".$_POST['medico']."' AND 
        DATE_FORMAT(start, '%Y-%m-%d') = '".$_POST['fecha']."' AND tipo_turno = '3'")).');
        $("#cantidadUrgencias").html('.mysqli_num_rows(mysqli_query($veja, "SELECT id FROM turnos WHERE id_medico = '".$_POST['medico']."' AND 
        DATE_FORMAT(start, '%Y-%m-%d') = '".$_POST['fecha']."' AND urgencia = '1'")).');
    </script>';
    mysqli_close($veja);
}
?>