<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    echo '<div class="animate__animated">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="notificacionesStaff-tab" data-toggle="tab" href="#notificacionesStaff" role="tab" aria-controls="notificacionesStaff" aria-selected="true"><i class="fas fa-envelope-open-text"></i> Notificaciones</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Otro 1</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Otro 2</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="notificacionesStaff" role="tabpanel" aria-labelledby="notificacionesStaff-tab">
                <div class="row">
                    <div class="col-12">
                        <h4 class="mt-4 mb-3">Notificaciones<i title="Nueva notificación" role="button" id="botonNuevoMensaje" class=" ml-3 fas fa-plus-circle text-success"></i></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h5>Notificaciones</h5>
                    </div>
                    <div class="col text-right">
                        <i title="Refrescar" id="refrescarMensajes" role="button" class="fas fa-sync-alt text-primary ml-3" style="font-size: 20px"></i>
                    </div>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr id="filaInfoMensaje">
                            <th class="text-center">Asunto</th>
                            <th class="text-center">Mensaje</th>
                            <th class="text-center">Prioridad</th>
                            <th class="text-center">Para</th>
                            <th class="text-center">Desde</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>';
                        $peticion = mysqli_query($veja, "SELECT mensajes.*, users.nombre AS 'para' FROM mensajes INNER JOIN users ON users.id = mensajes.destino ORDER BY fecha DESC");
                        while($m = mysqli_fetch_assoc($peticion)){
                            $peticion2 = mysqli_query($veja, "SELECT nombre FROM users WHERE id = '".$m['origen']."' LIMIT 1");
                            while($d = mysqli_fetch_assoc($peticion2)){
                                echo '<tr>
                                    <td>'.$m['asunto'].'</td>
                                    <td>'.$m['mensaje'].'</td>';
                                    switch($m['urgencia']){
                                        case "0":
                                            $prioridad = "Baja";
                                        break;
                                        case "1":
                                            $prioridad = "Media";
                                        break;
                                        case "2":
                                            $prioridad = "Alta";
                                        break;
                                    }
                                    echo '<td class="text-center">'.$prioridad.'</td>
                                    <td class="text-center">'.$m['para'].'</td>
                                    <td class="text-center">'.$d['nombre'].'</td>
                                    <td class="text-center">'.date('d-m-y H:i:s', strtotime($m['fecha'])).'</td>';
                                    if($m['estado'] == "0"){
                                        $estado = "<span class='text-success'>Leido</span>";
                                    }else{
                                        $estado = "<span class='text-danger'>Sin leer</span>";
                                    }
                                    echo '<td class="text-center">'.$estado.'</td>
                                    <td class="text-center">
                                        <i title="Editar mensaje" id="editarMensaje" data-id="'.$m['id'].'" role="button" class="fas fa-edit text-primary mr-3"></i>
                                        <i title="Eliminar mensaje" id="eliminarMensaje" data-id="'.$m['id'].'" role="button" class="fas fa-trash text-danger"></i>
                                    </td>
                                </tr>';
                            }
                        }
                    echo '</tbody>   
                </table>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
        </div>
    </div>';
    mysqli_close($veja);
}
?>