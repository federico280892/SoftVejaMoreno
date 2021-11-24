<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");

    echo '<script>
    //tabla articulos
    $("#tabla-proveedores").DataTable({
        ordering: true,
        searching: true,
        info: true,
        pageLength: 10,
        // "lengthMenu": [4],
        bInfo: false,
        // "paging": false,
        autoWidth: true,
        bPaginate: true,
        bSort: false,
        language: {
            "decimal": "",
            "emptyTable": "No hay datos registrados",
            "info": "Mostrando _START_ de _END_ de un total de _TOTAL_ registros",
            "info": "Mostrando un total de _TOTAL_ registros",
            "infoEmpty": "No existen registros cargados",
            "infoFiltered": "(Filtrado de un total de _MAX_ registros)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrando _MENU_ registros por página",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "No existen coincidencias",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior",
            },
            "aria": {
                "sortAscending": ": Activado el orden de columna ascendente",
                "sortDescending": ": Activado el orden de columna descendente",
            },
        },
    });
    </script>';

    echo '<table class="table table-striped table-hover" id="tabla-proveedores">
        <thead>
            <th class="align-middle text-left">Nombre</th>
            <th class="align-middle text-leff">Condición IVA</th>
            <th class="align-middle text-left">Domicilio</th>
            <th class="align-middle text-left">Teléfono</th>
            <th class="align-middle text-center">Extras</th>
        </thead>
        <tbody>';
            $peticion = mysqli_query($stock, "SELECT * FROM proveedores ORDER BY nombre ASC");
            if(mysqli_num_rows($peticion) == 0){
                echo '<tr>
                    <td colspan="12" class="text-center">No se encontraron registros</td>;
                </tr>';
            }else{
                while($p = mysqli_fetch_assoc($peticion)){
                    if($p['activo'] == "1"){
                        $estado = "Activo";
                        $nombre = '<td class="align-middle text-left text-success"><b>'.substr($p['nombre'],0, 30).'</b></td>';
                    }else{
                        $estado = "Inactivo";
                        $nombre = '<td class="align-middle text-left text-danger"><b>'.substr($p['nombre'],0, 30).'</b></td>';
                    }
                    echo '<tr class="proveedorFila" data-buscar="'.$p['nombre'].' '.$p['razon_social'].' '.$p['CUIT_CUIL'].' '.$p['domicilio'].' '.$p['telefono'].' '.$p['CBU'].' '.$p['alias'].' '.$p['banco'].' '.$p['mail'].' '.$p['observacion'].' '.$estado.'">';
                        echo $nombre;
                        echo '<td class="align-middle text-left">'.substr($p['razon_social'],0, 30).'</td>
                        <td class="align-middle text-left">'.substr($p['domicilio'],0, 30).'</td>
                        <td class="align-middle text-left">'.$p['telefono'].'</td>
                        <td class="align-middle text-center">
                        <i role="button" class="fas fa-search-plus text-info" onclick=verProveedor(\''.$p['id'].'\')></i>
                        <i role="button" class="fas fa-pencil-alt text-warning ml-3" onclick=editarProveedor(\''.$p['id'].'\')></i>
                        <i role="button" class="fas fa-trash-alt text-danger ml-3" onclick=eliminarProveedor(\''.$p['id'].'\')></i>
                        </td>
                    </tr>';
                }
            }

        echo '</tbody>
    </table>';





    mysqli_close($stock);
}

?>