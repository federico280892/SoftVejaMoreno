<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "SELECT 
    articulos.id AS 'id', 
    articulos.nombre AS 'nombre', 
    articulos.codigo_barra AS 'codigo_barra', 
    articulos.stockMin AS 'stockMin', 
    existencias.cantidad AS 'cantidad' 
    FROM articulos
    INNER JOIN existencias
    ON existencias.id_articulo = articulos.id
    ORDER BY articulos.nombre ASC");

    echo '<script>
    //tabla ajustes
	$("#tabla-ajustes").DataTable({
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
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": Activado el orden de columna ascendente",
                "sortDescending": ": Activado el orden de columna descendente"
            }
        }
	});
    </script>';

    echo '<table id="tabla-ajustes" class="table-striped table-hover" style="font-size: 0.9rem;">
        <thead>
            <tr>
                <th>Artículo</th>
                <th>Código de barras</th>
                <th>Stock minimo</th>
                <th>Stock actual</th>
            </tr>
        </thead>
        <tbody>';
            while($a = mysqli_fetch_assoc($peticion)){
                echo '<tr id="filaAjuste" data-articulo="'.$a['id'].'" data-nombre="'.$a['nombre'].'" data-stockMin="'.$a['stockMin'].'" data-cantidad="'.$a['cantidad'].'">
                    <td>'.$a['nombre'].'</td>
                    <td>'.$a['codigo_barra'].'</td>
                    <td>'.$a['stockMin'].'</td>
                    <td>'.$a['cantidad'].'</td>
                </tr>';
            }
        echo '<tbody>
    </table>';
    mysqli_close($stock);
}
?>