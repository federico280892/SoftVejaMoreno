<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    echo '<script>
    //preprarar datatable nomeclador
    $("#tabla-convenios").DataTable( {
        "ordering": false,
        "language": {
            "lengthMenu": "Mostrando _MENU_ por página",
            "zeroRecords": "No se encontraron resultados - disculpe",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "search": "Buscar",
            "infoFiltered": "(Filtrados _MAX_ del total de registros)"
        }
    } );
    $("#tabla-convenios_previous").text("Anterior");
    $("#tabla-convenios_next").text("Siguiente");
    </script>';
    echo '<div class="row">
        <div class="col-12">
            <h4 class="mb-3">Convenios
            <i title="Nuevo convenio" role="button" id="botonNuevoConvenio" data-toggle="modal" data-target="#modalNuevoConvenio" class="efecto-hover ml-3 fas fa-plus-circle text-success"></i>
            <i title="Ver convenio" role="button" id="botonVerConvenio" data-toggle="modal" data-target="#modalNuevoConvenio" class="efecto-hover ml-3 fas fa-eye text-info" style="display: none;"></i>
            <i title="Eliminar convenio" id="botonEliminarConvenio" role="button" class="efecto-hover fas fa-trash text-danger ml-3" style="display: none;"></i>
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-hover table-bordered" id="tabla-convenios">
                <thead>
                    <tr class="bg-info text-white">
                        <th class="text-center"><small>Ítem</small></th>
                        <th class="text-center"><small>Cobertura Social</small></th>
                        <th class="text-center"><small>Fecha Convenio</small></th>
                        <th class="text-center"><small>Vencimiento</small></th>
                        <th class="text-center"><small>Fecha De Carga</small></th>
                        <th class="text-center"><small>Usuario</small></th>
                    </tr>  
                </thead>
                <tbody>';
                    $peticion = mysqli_query($veja, "SELECT convenios.*,
                    coberturas_sociales.cobertura_social AS 'cobertura',
                    users.user AS 'user'
                    FROM convenios 
                    INNER JOIN coberturas_sociales ON coberturas_sociales.codigo = convenios.id_cobertura_social
                    INNER JOIN users ON users.id = convenios.usuario
                    GROUP BY convenios.id_cobertura_social ORDER BY convenios.fecha_carga");
                    while($p = mysqli_fetch_assoc($peticion)){
                        echo '<tr role="button" id="filaPrestacion" data-idConvenio="'.$p['id_cobertura_social'].'" data-fechaConvenio="'.$p['fecha'].'" data-vencimientoConvenio="'.$p['vencimiento'].'">
                            <td class="text-center">
                                <input onclick="opcionesConvenio(\''.$p['id_cobertura_social'].'\')" class="form-check-input" type="radio" name="idPrestacion" style="margin-left: -8px;">   
                            </td>
                            <td class="text-center"><small>'.$p['cobertura'].'</small></td>
                            <td class="text-center"><small>'.date("d-m-Y", strtotime($p['fecha'])).'</small></td>
                            <td class="text-center"><small>'.date("d-m-Y", strtotime($p['vencimiento'])).'</small></td>
                            <td class="text-center"><small>'.$p['fecha_carga'].'</small></td>
                            <td class="text-center"><small>'.$p['user'].'</small></td>
                        </tr>';
                    }
                echo '</tbody>   
            </table> 
        </div>
    </div>';
    mysqli_close($veja);
}
?>