<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    echo '<script>
    //preprarar datatable nomeclador
    $("#tabla-pacientes").DataTable( {
        "ordering": false,
        "scrollX": true,
        "language": {
            "lengthMenu": "Mostrando _MENU_ por página",
            "zeroRecords": "No se encontraron resultados - disculpe",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "search": "Buscar",
            "infoFiltered": "(Filtrados _MAX_ del total de registros)"
        }
    } );
    </script>';
    echo '<div class="row">
        <div class="col-12">
            <h4 class="mb-3">Pacientes
            <i title="Nuevo paciente" role="button" id="botonNuevoPaciente" class="efecto-hover ml-3 fas fa-plus-circle text-success"></i>
            <i title="Eliminar paciente" id="botonEliminarPaciente" role="button" class="efecto-hover fas fa-trash text-danger ml-3" style="display: none;"></i>
            <i title="Editar paciente" role="button" id="botonEditarPaciente" class="fas fa-edit text-info efecto-hover ml-3" style="display: none;"></i>
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-hover table-bordered tabla-pacientes" id="tabla-pacientes">
                <thead>
                    <tr class="bg-info text-white">
                        <th class="text-center" style="width: 40px;"><small>DNI</small></th>
                        <th class="text-center" style="width: 150px;"><small>Apellido</small></th>
                        <th class="text-center" style="width: 150px;"><small>Nombre</small></th>
                        <th class="text-center" style="width: 90px;"><small>F. nacimiento</small></th>
                        <th class="text-center" style="width: 80px;"><small>Sexo</small></th>
                        <th class="text-center" style="width: 250px;"><small>Domicilio</small></th>
                        <th class="text-center" style="width: 150px;"><small>Localidad</small></th>
                        <th class="text-center" style="width: 80px;"><small>Teléfono 1</small></th>
                        <th class="text-center" style="width: 80px;"><small>Teléfono 2</small></th>
                        <th class="text-center" style="width: 110px;"><small>Celular</small></th>
                        <th class="text-center" style="width: 150px;"><small>email</small></th>
                        <th class="text-center" style="width: 150px;"><small>Cobertura social</small></th>
                        <th class="text-center" style="width: 150px;"><small>N° carnet cobertura</small></th>
                        <th class="text-center" style="width: 150px;"><small>Coseguro</small></th>
                        <th class="text-center" style="width: 150px;"><small>N° carnet coseguro</small></th>
                        <th class="text-center" style="width: 200px;"><small>Observación</small></th>
                    </tr>  
                </thead>
                <tbody>';
                $peticion = mysqli_query($veja, "SELECT pacientes.*, 
                    localidades.localidad AS 'loc',
                    coberturas_sociales.cobertura_social AS 'cobertura'
                    FROM pacientes 
                    INNER JOIN localidades ON localidades.id = pacientes.localidad
                    INNER JOIN coberturas_sociales ON coberturas_sociales.codigo = pacientes.cobertura_social
                    ORDER BY pacientes.apellido ASC");
                    while($p = mysqli_fetch_assoc($peticion)){
                        if($p['sexo'] == "0"){
                            $sexo = "MASCULINO";
                        }else{
                            $sexo = "FEMENINO";
                        }
                        echo '<tr id="filaTablaPacientes" data-id="'.$p['id'].'">
                            <td>'.$p['DNI'].'</td>
                            <td>'.$p['apellido'].'</td>
                            <td>'.$p['nombre'].'</td>
                            <td class="text-center">'.date("d-m-Y", strtotime($p['fecha_nacimiento'])).'</td>
                            <td class="text-center">'.$sexo.'</td>
                            <td>'.$p['domicilio'].'</td>
                            <td>'.strtoupper($p['loc']).'</td>
                            <td>'.$p['tel1'].'</td>
                            <td>'.$p['tel2'].'</td>
                            <td>'.$p['cel'].'</td>
                            <td>'.$p['email'].'</td>
                            <td>'.$p['cobertura'].'</td>
                            <td>'.$p['n_carnet'].'</td>';
                            $peticion2 = mysqli_query($veja, "SELECT cobertura_social FROM coberturas_sociales WHERE codigo = '".$p['coseguro']."'");
                            if(mysqli_num_rows($peticion2) == 1){
                                while($co = mysqli_fetch_assoc($peticion2)){
                                    echo '<td>'.$co['cobertura_social'].'</td>';
                                }
                            }else{
                                echo '<td>Ninguno</td>';
                            }
                            echo '<td>'.$p['n_carnet_coseguro'].'</td>
                            <td>'.$p['observacion'].'</td>
                        </tr>';
                    }
                echo '</tbody>   
            </table> 
        </div>
    </div>
    <script>
        $("#tabla-pacientes_previous").text("Anterior");
        $("#tabla-pacientes_next").text("Siguiente");
    </script>';
    mysqli_close($veja);
}
?>