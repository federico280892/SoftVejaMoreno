<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $tipo = "";
    $peticion = mysqli_query($veja, "SELECT 
        medicos.apellido AS 'apellidoMedico', 
        medicos.nombre AS 'nombreMedico', 
        turnos.*, 
        pacientes.apellido AS 'apellido', 
        pacientes.nombre AS 'nombre' 
        FROM turnos 
        INNER JOIN pacientes ON pacientes.DNI = turnos.dni_solicitante 
        INNER JOIN medicos ON medicos.id = turnos.id_medico 
        WHERE turnos.id = '".$_POST['id']."' LIMIT 1");

        while($t = mysqli_fetch_assoc($peticion)){
            echo '<div class="row">
                <div class="col-md-3">
                    <div class="form-group">';
                        if($t['urgencia'] == "1"){
                            echo '<small for="modalEditarTurnoUrgencia">Urgencia: <input type="checkbox" checked id="modalEditarTurnoUrgencia"></small>';
                        }else{
                            echo '<small for="modalEditarTurnoUrgencia">Urgencia: <input type="checkbox" id="modalEditarTurnoUrgencia"></small>';
                        }
                    echo '</div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <small for="modalEditarTurnoTitle">Motivo</small>
                        <input type="text" id="modalEditarTurnoTitle" class="form-control" value="'.$t['title'].'" placeholder="Motivo">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <small for="modalEditarTurnoObservacion">Observación del turno</small>
                        <textarea id="modalEditarTurnoObservacion" class="form-control">'.$t['observacion'].'</textarea>
                    </div>
                </div>
            </div>';
        }

    mysqli_close($veja);
}
?>