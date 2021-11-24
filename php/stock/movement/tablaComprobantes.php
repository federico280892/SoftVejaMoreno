<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");

    echo '<script>
    //tabla comprobantes
	$("#tabla-comprobantes").DataTable({
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

    if($_POST['tipo'] == "99"){
        $peticion = mysqli_query($stock, "SELECT 
        comprobantes.id AS 'id', 
        comprobantes.tipo_comprobante AS 'tipo_comprobante',
        comprobantes.n_comprobante AS 'n_comprobante',
        proveedores.nombre AS 'proveedor',
        comprobantes.importe AS 'importe',
        comprobantes.fecha_comprobante AS 'fecha_comprobante',
        comprobantes.fecha_carga AS 'fecha_carga'
        FROM comprobantes
        LEFT JOIN proveedores
        ON proveedores.id = comprobantes.proveedor
        ORDER BY comprobantes.fecha_carga DESC");
    }else if($_POST['tipo'] != "99"){
        $peticion = mysqli_query($stock, "SELECT 
        comprobantes.id AS 'id', 
        comprobantes.tipo_comprobante AS 'tipo_comprobante',
        comprobantes.n_comprobante AS 'n_comprobante',
        proveedores.nombre AS 'proveedor',
        comprobantes.importe AS 'importe',
        comprobantes.fecha_comprobante AS 'fecha_comprobante',
        comprobantes.fecha_carga AS 'fecha_carga'
        FROM comprobantes
        LEFT JOIN proveedores
        ON proveedores.id = comprobantes.proveedor
        WHERE comprobantes.tipo_comprobante = '".$_POST['tipo']."'
        ORDER BY comprobantes.fecha_carga DESC");
    }

    echo '<table calss="table table-striped table-hover" id="tabla-comprobantes" style="font-size: 0.9rem;">
        <thead>
            <tr>
                <th class="text-center">Tipo</th>
                <th class="text-center">N° de comprobante</th>
                <th class="text-center">Proveedor</th>
                <th class="text-right">Importe</th>
                <th class="text-center">Fecha comprobante</th>
                <th class="text-center">Fecha carga</th>
            </tr>
        </thead>
        <tbody>';
            while($c = mysqli_fetch_assoc($peticion)){
                echo '<tr id="filaComprobante" data-comprobante="'.$c['id'].'">';
                    switch($c['tipo_comprobante']){
                        case "0":
                            echo '<td class="text-center">Factura</td>';
                            break;
                        case "1":
                            echo '<td class="text-center">Remito</td>';
                            break;
                        case "2":
                            echo '<td class="text-center">Otros</td>';
                            break;
                        case "3":
                            echo '<td class="text-center">Egresos</td>';
                            break;
                        case "4":
                            echo '<td class="text-center">Ajuste</td>';
                            break;
                    }
                    if($c['n_comprobante'] == "-" || $c['n_comprobante'] == ""){
                        echo'<td class="text-center">-</td>';
                    }else{
                        echo'<td clasS="text-center">'.$c['n_comprobante'].'</td>';
                    }
                    if($c['proveedor'] == "-" || $c['proveedor'] == ""){
                        echo '<td class="text-center">-</td>';
                    }else{
                        echo '<td class="text-center">'.$c['proveedor'].'</td>';
                    }
                    if($c['importe'] != "" || $c['importe'] != "-"){
                        echo '<td class="text-right">-</td>';
                    }else{
                        echo '<td class="text-right">'.number_format($c['importe'], 2, ',', '.').'</td>';
                    }
                    if($c['fecha_comprobante'] != "" || $c['fecha_comprobante'] != "-"){
                        echo '<td clasS="text-center">-</td>';
                    }else{
                        echo '<td clasS="text-center">'.date("d-m-Y", strtotime($c['fecha_comprobante'])).'</td>';
                    }
                    echo '<td clasS="text-center">'.date("d-m-Y H.i:s", strtotime($c['fecha_carga'])).'</td>
                </tr>';
            }
        echo '</tbody>
    </table>';

    mysqli_close($stock);
}
?>