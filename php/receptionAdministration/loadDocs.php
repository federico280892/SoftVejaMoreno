<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT users.avatar AS 'avatar', medicos.*, especialidades.especialidad AS 'especialidadMedico' FROM medicos INNER JOIN especialidades ON medicos.especialidad = especialidades.id INNER JOIN users ON users.id = medicos.usuario ORDER BY medicos.apellido ASC");
    if(mysqli_num_rows($peticion) > 0){
        while($doc = mysqli_fetch_assoc($peticion)){
            if($doc['activo'] == 'true'){
                $activo = "Habilitado";
            }else{
                $activo = "Inhabilitado";
            }
            echo '<div class="col mb-4">

                <div class="media medicosCargados">
                    <div class="contenedorImg">
                        <img src="../img/users/'.$doc['avatar'].'">
                    </div>
                    <div class="media-body ml-2">
                        <h6 class="mt-2">'.$doc['codigo'].' - <b>'.$doc['apellido'].'</b> '.$doc['nombre'].' - '.$activo.'</h6>
                            <i title="Eliminar" role="button" onclick="activarModal('.$doc['id'].')" data-toggle="modal" data-target="#modalDoctoresCargadosElimnar" class="fas fa-user-times mr-3 text-danger"></i>
                            <i title="Editar" role="button" onclick="editarDoctor(\''.$doc['id'].'\', \''.$doc['apellido'].'\', \''.$doc['nombre'].'\', \''.$activo.'\', \''.$doc['codigo'].'\', \''.$doc['avatar'].'\', \''.$doc['dni'].'\', \''.$doc['domicilio'].'\', \''.$doc['telefono_particular'].'\', \''.$doc['celular'].'\', \''.$doc['telefono_consultorio'].'\', \''.$doc['especialidad'].'\', \''.date("d-m-Y" , strtotime($doc['matricula'])).'\', \''.$doc['consultorio'].'\', \''.$doc['observaciones'].'\')" class="fas fa-user-edit mr-3 text-info"></i>
                            <i title="Ver" role="button" onclick="verDoctor(\''.$doc['apellido'].'\', \''.$doc['nombre'].'\', \''.$activo.'\', \''.$doc['codigo'].'\', \''.$doc['avatar'].'\', \''.$doc['dni'].'\', \''.$doc['domicilio'].'\', \''.$doc['telefono_particular'].'\', \''.$doc['celular'].'\', \''.$doc['telefono_consultorio'].'\', \''.$doc['especialidadMedico'].'\', \''.date("d-m-Y" , strtotime($doc['matricula'])).'\', \''.$doc['consultorio'].'\', \''.$doc['observaciones'].'\')" class="fas fa-eye mr-3 text-primary"></i>
                            <i title="Cambiar foto" role="button" onclick="editarFotoDoctor(\''.$doc['usuario'].'\')" class="far fa-image text-success mr-3"></i>
                            <i title="Ajustes" role="button" class="fas fa-tools text-primary" data-id="'.$doc['id'].'" data-medicoNombre="'.$doc['apellido'].' '.$doc['nombre'].'" id="ajustesMedico"></i>
                    </div>
                </div>

            </div>';
        }
}else{
    echo '<div class="col">
    <div class="alert alert-info container text-center">No se encontraron registros.</div>
    </div>';
}
mysqli_close($veja);
}else{
 header("Location: ../../");   
}
?>