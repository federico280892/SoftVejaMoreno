<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    echo '<script>
    //preprarar datatable nomeclador
    $("#tabla-nomenclador").DataTable( {
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
    $("#tabla-nomenclador_previous").text("Anterior");
    $("#tabla-nomenclador_next").text("Siguiente");
    </script>';
    echo '<div class="row">
        <div class="col-12">
            <h4 class="mb-3">Nomenclador
            <i title="Nueva prestación" role="button" id="botonNuevaPrestacion" class=" ml-3 fas fa-plus-circle text-success"></i>
            <i title="Eliminar prestación" id="botonEliminarPrestacion" role="button" class="fas fa-trash text-danger ml-3" style="display: none;"></i>
            <i title="Editar prestación" id="botonEditarPrestacion" role="button" class="fas fa-edit text-info ml-3" style="display: none;"></i>
            <i title="Ver prestación" id="botonVerPrestacion" role="button" class="fas text-primary fa-eye ml-3" style="display: none;"></i>
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-hover table-bordered" id="tabla-nomenclador">
                <thead>
                    <tr class="bg-info text-white">
                        <th class="text-center" style="width: 40px;"><small>Ítem</small></th>
                        <th class="text-center" style="width: 100px;"><small>Código</small></th>
                        <th class="text-center"><small>Descripción</small></th>
                        <th class="text-center" style="width: 75px;"><small>Un. Médico</small></th>
                        <th class="text-center" style="width: 75px;"><small>Un. Gesto</small></th>
                        <th class="text-center" style="width: 30px;"><small>Nivel</small></th>
                        <th class="text-center" style="width: 80px;"><small>Complejidad</small></th>
                        <th class="text-center" style="width: 105px;"><small>Expediente OSP</small></th>
                    </tr>  
                </thead>
                <tbody>';
                    $peticion = mysqli_query($veja, "SELECT * FROM prestaciones WHERE activo = '1' ORDER BY descripcion ASC");
                    while($p = mysqli_fetch_assoc($peticion)){
                        echo '<tr role="button" id="filaPrestacion">
                            <td class="text-center">
                                <input onclick="seleccionarPrestacion(\''.$p['id'].'\')" class="form-check-input" type="radio" name="idPrestacion" style="margin-left: -8px;">   
                            </td>
                            <td class="text-left"><small>'.$p['codigo'].'</small></td>
                            <td class="text-left"><small>'.$p['descripcion'].'</small></td>
                            <td class="text-center"><small>'.$p['un_medico'].'</small></td>
                            <td class="text-center"><small>'.$p['un_gastos'].'</small></td>
                            <td class="text-center"><small>'.$p['nivel'].'</small></td>
                            <td class="text-center"><small>'.$p['complejidad'].'</small></td>
                            <td class="text-center"><small>'.$p['expediente_osp'].'</small></td>
                        </tr>';
                    }
                echo '</tbody>   
            </table> 
        </div>
    </div>';
    mysqli_close($veja);
}
?>