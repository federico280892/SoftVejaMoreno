<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");
    echo '<script>
        $("#telParticularMedico").mask("(0000)000000", {placeholder: "(0000)000000"});
        $("#telefonoConsultorio").mask("(0000)000000", {placeholder: "(0000)0000000"});
        $("#celMedico").mask("+54(000)0-000-000", {placeholder: "+54(000)0-000-000"});
    </script>';
    echo '<div class="row">
        <div class="col-12">
            <h4 class="mb-3">Doctores cargados<i title="Nuevo doctor" role="button" id="crearNuevoDoctor" class=" ml-3 fas fa-plus-circle text-success"></i></h4>
        </div>
    </div>
            
    <div class="row">';   
        
        $peticion = mysqli_query($veja, "SELECT users.avatar AS 'avatar', medicos.*, especialidades.especialidad AS 'especialidadMedico' FROM medicos INNER JOIN especialidades ON medicos.especialidad = especialidades.id INNER JOIN users ON users.id = medicos.usuario ORDER BY medicos.apellido ASC");
        if(mysqli_num_rows($peticion) > 0){
            while($doc = mysqli_fetch_assoc($peticion)){
                if($doc['activo'] == 'true'){
                    $activo = "Habilitado";
                }else{
                    $activo = "Inhabilitado";
                }
                echo '<div class="col-12 mb-4">
    
                    <div class="media medicosCargados">
                        <div class="contenedorImg">
                            <img src="../img/users/'.$doc['avatar'].'">
                        </div>
                        <div class="media-body ml-4">
                            <h6 class="mt-2">'.$doc['codigo'].' - <b>'.$doc['apellido'].'</b> '.$doc['nombre'].' - '.$activo.'</h6>
                            <i title="Eliminar" role="button" onclick="activarModal('.$doc['id'].')" data-toggle="modal" data-target="#modalDoctoresCargadosElimnar" class="fas fa-user-times mr-3 text-danger"></i>';
                            echo '<i title="Ver" role="button" id="verDetallesDoctor" data-id="'.$doc['id'].'" data-medicoNombre="'.$doc['apellido'].' '.$doc['nombre'].'" class="fas fa-eye mr-3 text-primary"></i>';
                            //<i title="Cambiar foto" role="button" onclick="editarFotoDoctor(\''.$doc['usuario'].'\')" class="far fa-image text-success mr-3"></i>';
                            echo ' <i title="Ajustes" role="button" class="fas fa-tools text-primary" data-id="'.$doc['id'].'" data-medicoNombre="'.$doc['apellido'].' '.$doc['nombre'].'" id="ajustesMedico"></i>
                        </div>
                    </div>
    
                </div>';
            }
        }else{
            echo '<div class="col">
                <div class="alert alert-info container text-center">No se encontraron registros.</div>
            </div>';
        }
       
        echo '</div>                  
    </div>';
}else{
    header('Location: ../../');
}
