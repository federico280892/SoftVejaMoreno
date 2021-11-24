<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");

    switch(date('D', strtotime($_POST['fecha']))){
        case 'Mon':
            $columnaHorarioAp = "apLun";
            $columnaHorarioCi = "ciLun";
            $columnaMinutos = "lun";
           break;
        case 'Tue':
            $columnaHorarioAp = "apMar";
            $columnaHorarioCi = "ciMar";
            $columnaMinutos = "mar";
            break;
        case 'Wed':
            $columnaHorarioAp = "apMie";
            $columnaHorarioCi = "ciMie";
            $columnaMinutos = "mie";
            break;
        case 'Thu':
            $columnaHorarioAp = "apJue";
            $columnaHorarioCi = "ciJue";
            $columnaMinutos = "jue";
            break;
        case 'Fri':
            $columnaHorarioAp = "apvie";
            $columnaHorarioCi = "ciVie";
            $columnaMinutos = "vie";
            break;
        case 'Sat':
            $columnaHorarioAp = "apSab";
            $columnaHorarioCi = "ciSab";
            $columnaMinutos = "sab";
            break;
        case 'Sun':
            $columnaHorarioAp = "apDom";
            $columnaHorarioCi = "ciDom";
            $columnaMinutos = "dom";
            break;
    }

    $diaSemana = mysqli_query($veja, "SELECT $columnaMinutos FROM tiempo_consulta WHERE id_medico = '".$_POST['medico']."' LIMIT 1");
    while($min = mysqli_fetch_assoc($diaSemana)){
        $tiempo_consulta = $min[$columnaMinutos];
    }

    if($tiempo_consulta != "00:00"){
        for($t = 1; $t <= 2; $t++){
            $horarioApCi = mysqli_query($veja, "SELECT ".$columnaHorarioAp.", ".$columnaHorarioCi." FROM horarios_semanales WHERE id_medico = '".$_POST['medico']."' AND turno = '".$t."' LIMIT 1");
            while($fila = mysqli_fetch_assoc($horarioApCi)){
                if($fila[$columnaHorarioAp] != "-"){
                    for($h = date("G", strtotime($fila[$columnaHorarioAp])); $h <= date("G", strtotime($fila[$columnaHorarioCi])); $h++){
                        if(strlen($h) == 1){
                            $hora = "0".$h;
                        }else{
                            $hora = $h;
                        }
                        for($m = 0; $m < 60; $m+=$tiempo_consulta){
                            if(strlen($m) == 1){
                                $minuto = "0".$m;
                            }else{
                                $minuto = $m;
                            }
                            $nuevaHora = new DateTime($hora.":".$minuto);
                            $nuevaHora->modify("+".$tiempo_consulta." minute");
                            $peticion = mysqli_query($veja, "SELECT
                            coberturas_sociales.cobertura_social AS 'cobertura', 
                            coberturas_sociales.activo AS 'coberturaEstado', 
                            turnos.*, 
                            users.apellido AS 'apellidoResponsable',
                            users.nombre AS 'nombreResponsable',
                            pacientes.apellido AS 'apellido', 
                            pacientes.nombre AS 'nombre', 
                            pacientes.tel1 AS 'tel1', 
                            pacientes.tel2 AS 'tel2', 
                            pacientes.cel AS 'cel', 
                            pacientes.DNI AS 'DNI',
                            pacientes.observacion AS 'observacionPaciente' 
                            FROM turnos 
                            INNER JOIN pacientes ON pacientes.DNI = turnos.dni_solicitante 
                            INNER JOIN users ON users.id = turnos.responsable
                            INNER JOIN coberturas_sociales ON pacientes.cobertura_social = coberturas_sociales.codigo 
                            WHERE 
                                turnos.id_medico = '".$_POST['medico']."' AND 
                                DATE_FORMAT(turnos.start, '%Y-%m-%d') = '".$_POST['fecha']."' AND
                                DATE_FORMAT(turnos.start, '%H:%i') = '".date("H:i", strtotime($hora.":".$minuto))."' AND 
                                DATE_FORMAT(turnos.start, '%H:%i') < '".date("H:i", strtotime($nuevaHora->format("H:i")))."' 
                            ORDER BY turnos.start ASC");
                
                            if(mysqli_num_rows($peticion) == 0){
                                echo '<tr style="cursor: pointer;">
                                    <td class="align-middle text-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="idTurnoPegar" onclick="prepararTurno(\''.$hora.":".$minuto.'\')" id="radioBuutton'.$hora.":".$minuto.'" value="'.$hora.":".$minuto.'">
                                        </div>
                                    </td>
                                    <td class="align-middle text-center"><small>'.$hora.":".$minuto.'</small></td>
                                    <td colspan="14" class="align-middle text-left"><small class="text-success font-weight-bold"><i class="fas fa-dot-circle mr-2 text-success"></i>Disponible</small></td>
                                    <td class="align-middle text-center"><i role="button" disabled class="fas fa-info-circle text-info"></i></td>
                                </tr>';
                            }else{
                                while($fila = mysqli_fetch_assoc($peticion)){
                                    echo '<tr style="cursor: no-drop;">
                                        <td class="align-middle text-center">
                                            <div class="form-check">
                                                <input disabled class="form-check-input" type="radio" name="idTurnoPegar" onclick=pegarTurno(this.value) id="radioBuutton'.$t['turnos.id'].'" value="'.$t['turnos.id'].'">
                                            </div>
                                        </td>
                                        <td class="align-middle text-center"><small>'.date("H:i", strtotime($fila['start'])).'</small></td>
                                        <td colspan="14" class="align-middle text-left"><small class="text-danger"><i class="far fa-dot-circle mr-2 text-danger"></i>Ocupado</small></td>
                                        <td class="align-middle text-center"><i role="button" disabled class="fas fa-info-circle text-info"></i></td>
                                    </tr>';
                                }
                                
                            }
                        }
                    }
                }else{
                    echo '<tr>
                        <td>Los dias domingos no hay atención. No puedes pegar un turno en este día.</td>
                    </tr>';
                }
            }
        }
    }else{
        echo '<tr>
            <td colspan="17">Horario sin atención. No puede pegar un turno en este espacio.</td>
        </tr>';
    }
    
    mysqli_close($veja);
}
?>