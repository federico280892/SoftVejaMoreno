<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");

echo '<script>
    //tabla articulos
    $("#tabla-articulos").DataTable({
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


    // $todoLentes = mysqli_query($stock, "SELECT 
    //     lentes.*, 
    //     articulos.img AS 'img', 
    //     articulos.nombre AS 'nombre', 
    //     grupos.nombre AS 'grupo',
    //     articulos.marca AS 'marca',
    //     articulos.stockMin AS 'stockMin',
    //     articulos.n_lote AS 'lote',
    //     articulos.vencimiento AS 'vencimiento'
    //     FROM lentes 
    //     INNER JOIN articulos 
    //     ON articulos.id = lentes.id_articulo
    //     INNER JOIN grupos
    //     ON grupos.id = articulos.id_grupo
    //     WHERE articulos.id_rubro = '2'"); 

    $peticion = mysqli_query($stock, "SELECT 
        articulos.img AS 'foto', 
        grupos.nombre AS 'grupo', 
        rubros.dioptria AS 'dioptria', 
        articulos.nombre AS 'nombre', 
        existencias.cantidad AS 'cantidad',
        articulos.activo AS 'activo', 
        articulos.id AS 'id'
        FROM articulos
        INNER JOIN grupos 
        ON grupos.id = articulos.id_grupo
        INNER JOIN rubros
        ON rubros.id = articulos.id_rubro
        INNER JOIN existencias
        ON existencias.id_articulo = articulos.id
        WHERE articulos.activo = '1'");

echo '<table class="table table-hover table-striped" id="tabla-articulos" style="font-size: 0.9rem">
<thead>
    <tr>
        <th class="align-middle text-center" style="width: 45px">Foto</th>
        <th class="align-middle text-left">Artículo</th>
        <th class="align-middle text-left">Grupo</th>
        <th class="align-middle text-center" style="width: 65px">Cantidad</th>
        <th class="align-middle text-center" style="width: 70px">Acciones</th>
    </tr>
</thead>
<tbody>';
    // if(mysqli_num_rows($todoLentes) > 0){
    //     $diopInicio = 15;
    //     while($lentes = mysqli_fetch_array($todoLentes)){
    //         for($col = 2; $col < 23; $col++){
    //             echo '<tr>
    //                 <td class="text-left align-middle">
    //                     <img src="../img/products/'.$lentes[23].'" class="img-fluid" width="50px">
    //                 </td>';
    //                 echo '<td class="text-left align-middle">'.$lentes[24].' '.$diopInicio.'</td>';
    //                 echo '<td class="text-left align-middle">'.$lentes[25].'</td>';
    //                 echo '<td class="text-center align-middle stockCantidadActual">'.$lentes[$col].'</td>';
    //                 echo '<td class="align-middle text-center">';
    //                     echo '<i role="button" class="fas fa-search-plus text-info" onclick="verExistencia(\''.$lentes['id'].'\', \'1\')"></i>
    //                     <i role="button" class="fas fa-pencil-alt text-warning ml-3" onclick="editarExistencia(\''.$lentes['id'].'\', \'1\')"></i>
    //                     <i role="button" class="fas fa-trash-alt text-danger ml-3" onclick="eliminarExistencia(\''.$lentes['id'].'\', \'1\')"></i>';
    //                 echo '</td>';
    //             echo '</tr>';
    //             if($diopInicio < 25){
    //                 $diopInicio += 0.5;
    //             }
    //         }
    //         $diopInicio = 15;
    //     }
    // } 
        
    while($e = mysqli_fetch_assoc($peticion)){
        if($e['activo'] == "1"){
            $insumo = '<td class="align-middle text-left text-success">'.$e['nombre'].'</td>';
        }else{
            $insumo = '<td class="align-middle text-left text-danger">'.$e['nombre'].'</td>';
        }
        echo '<tr data-buscar="'.$e['nombre'].' '.$e['cantidad'].'" class="existenciaFila">
            <td class="align-middle text-center"><img src="../img/products/'.$e['foto'].'" class="img-fluid" width="50px"></td>
            '.$insumo.'
            <td class="align-middle text-left">'.$e['grupo'].'</td>
            <td class="align-middle text-center">'.$e['cantidad'].'</td>
            <td class="align-middle text-center">';
                echo '<i role="button" class="fas fa-search-plus text-info" onclick="verExistencia(\''.$e['id'].'\', \''.$e['dioptria'].'\')"></i>
                <i role="button" class="fas fa-pencil-alt text-warning ml-3" onclick="editarExistencia(\''.$e['id'].'\', \''.$e['dioptria'].'\')"></i>
                <i role="button" class="fas fa-trash-alt text-danger ml-3" onclick="eliminarExistencia(\''.$e['id'].'\', \''.$e['dioptria'].'\')"></i>';
            echo '</td>
        </tr>';
    }
echo'</tbody>
</table>';



}
?>