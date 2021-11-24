<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    
    if($_POST['rubro'] == "0" && $_POST['grupo'] == "0"){
        $egresos = mysqli_query($stock, "SELECT 
        articulos.id AS 'id', 
        articulos.nombre AS 'articulo',
        articulos.stockMin AS 'stockMin', 
        articulos.n_lote AS 'lote', 
        articulos.vencimiento AS 'vencimiento',
        articulos.marca AS 'marca',
        existencias.cantidad AS 'cantidad' 
        FROM articulos 
        INNER JOIN existencias
        ON existencias.id_articulo = articulos.id
        ORDER BY articulos.nombre ASC");
    }else if($_POST['rubro'] != "0" && $_POST['grupo'] == "0"){
        $egresos = mysqli_query($stock, "SELECT 
        articulos.id AS 'id', 
        articulos.nombre AS 'articulo',
        articulos.stockMin AS 'stockMin', 
        articulos.n_lote AS 'lote', 
        articulos.vencimiento AS 'vencimiento', 
        articulos.marca AS 'marca',
        existencias.cantidad AS 'cantidad' 
        FROM articulos 
        INNER JOIN existencias
        ON existencias.id_articulo = articulos.id
        WHERE articulos.id_rubro = '".$_POST['rubro']."'
        ORDER BY articulos.nombre ASC");
    }else if($_POST['rubro'] == "0" && $_POST['grupo'] != "0"){
        $egresos = mysqli_query($stock, "SELECT 
        articulos.id AS 'id', 
        articulos.nombre AS 'articulo',
        articulos.stockMin AS 'stockMin', 
        articulos.n_lote AS 'lote', 
        articulos.vencimiento AS 'vencimiento', 
        articulos.marca AS 'marca',
        existencias.cantidad AS 'cantidad' 
        FROM articulos 
        INNER JOIN existencias
        ON existencias.id_articulo = articulos.id
        WHERE articulos.id_grupo = '".$_POST['grupo']."'
        ORDER BY articulos.nombre ASC");
    }else if($_POST['rubro'] != "0" && $_POST['grupo'] != "0"){
        $egresos = mysqli_query($stock, "SELECT 
        articulos.id AS 'id', 
        articulos.nombre AS 'articulo',
        articulos.stockMin AS 'stockMin', 
        articulos.n_lote AS 'lote', 
        articulos.vencimiento AS 'vencimiento', 
        articulos.marca AS 'marca',
        existencias.cantidad AS 'cantidad' 
        FROM articulos 
        INNER JOIN existencias
        ON existencias.id_articulo = articulos.id
        WHERE articulos.id_grupo = '".$_POST['grupo']."'
        AND articulos.id_rubro = '".$_POST['rubro']."'
        ORDER BY articulos.nombre ASC");
    }

    echo '<script>
    //tabla egresos
	$("#tabla-egresos").DataTable({
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
            "emptyTable": "No Hay Datos Registrados",
            "info": "Mostrando _START_ de _END_ De Un Total Re _TOTAL_ Registros",
            "info": "Mostrando Un Total De _TOTAL_ Registros",
            "infoEmpty": "No Existen Registros Cargados",
            "infoFiltered": "(Filtrado De Un Total De _MAX_ Registros)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrando _MENU_ Registros Por Página",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "No Existen Coincidencias",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": Activado El Orden De Columna Ascendente",
                "sortDescending": ": Activado El Orden De Columna Descendente"
            }
        }
	});

    //$("#cardStock").attr("style", "height: 100%");

    </script>';

    echo '<table id="tabla-egresos" class="table table-hover table-striped" style="font-size:0.9rem;">
        <thead>
            <tr>
                <th class="text-left" style="width: 70%;">Artículo</th>
                <th class="text-center">Lote</th>
                <th class="text-center" style="width: 125px;">Vencimiento</th>
                <th class="text-center" style="width: 65px;">Stock</th>
                <th class="text-center">Cantidad</th>
            </tr>
        </thead>
        <tbody>';
            // $todoLentes = "";
            //     if($_POST['rubro'] == "2"){
            //     $todoLentes = mysqli_query($stock, "SELECT 
            //     lentes.*, 
            //     articulos.nombre AS 'nombre', 
            //     articulos.marca AS 'marca',
            //     articulos.stockMin AS 'stockMin',
            //     articulos.n_lote AS 'lote',
            //     articulos.vencimiento AS 'vencimiento'
            //     FROM lentes 
            //     INNER JOIN articulos 
            //     ON articulos.id = lentes.id_articulo
            //     WHERE articulos.id_rubro = '2'");  
            //     }else if($_POST['rubro'] == "0"){
            //     $todoLentes = mysqli_query($stock, "SELECT 
            //     lentes.*, 
            //     articulos.nombre AS 'nombre', 
            //     articulos.marca AS 'marca',
            //     articulos.stockMin AS 'stockMin',
            //     articulos.n_lote AS 'lote',
            //     articulos.vencimiento AS 'vencimiento'
            //     FROM lentes 
            //     INNER JOIN articulos 
            //     ON articulos.id = lentes.id_articulo");
            //     }
            //     else{
            //         $todoLentes = mysqli_query($stock, "SELECT 
            //         lentes.*, 
            //         articulos.nombre AS 'nombre', 
            //         articulos.marca AS 'marca',
            //         articulos.stockMin AS 'stockMin',
            //         articulos.n_lote AS 'lote',
            //         articulos.vencimiento AS 'vencimiento'
            //         FROM lentes 
            //         INNER JOIN articulos 
            //         ON articulos.id = lentes.id_articulo
            //         WHERE articulos.id_rubro = '0'");   
            //     }
            //     if(mysqli_num_rows($todoLentes) > 0){
            //         $diopInicio = 15;
            //         while($lentes = mysqli_fetch_array($todoLentes)){
            //             for($col = 2; $col < 23; $col++){
            //                 echo '<tr id="filaArticuloEgreso" class="">
            //                     <td class="text-left align-middle">
            //                         <div class="row">
            //                             <div class="col text-left">
            //                                 '.$lentes[23].' '.$lentes[24].' Diop: '.$diopInicio.'
            //                             </div>
            //                             <div class="col text-right">';
            //                             if($lentes[$col] <= $lentes[25]){
            //                                 echo '<i class="fas fa-circle text-danger"></i>';
            //                             }else if($lentes[$col] > $lentes[25] && $lentes[$col] <= ($lentes[25] + 10)){
            //                                 echo '<i class="fas fa-circle text-warning"></i>';
            //                             }else if($lentes[$col] > ($lentes[25] + 10)){
            //                                 echo '<i class="fas fa-circle text-success"></i>';
            //                             }
            //                             echo '</div>
            //                         </div>
            //                     </td>';
            //                     if($lentes[26] == ""){
            //                         echo '<td class="text-center align-middle">-</td>';
            //                     }else{
            //                         echo '<td class="text-center align-middle">'.$lentes[26].'</td>';
            //                     }
            //                     if($lentes[27] == "-" || $lentes[27] == ""){
            //                         echo '<td class="text-center align-middle">-</td>';
            //                     }else{
            //                         echo '<td class="text-center align-middle">'.date("d-m-Y", strtotime($lentes[27])).'</td>';
            //                     }
            //                     echo '<td class="text-center align-middle stockCantidadActual">'.$lentes[$col].'</td>';
            //                     echo '<td class="text-left align-middle">
            //                         <input id="unidadesParaDescontar" data-idarticulo="'.$lentes[1].'" data-lente="1" data-columna="d'.str_replace(".", "", $diopInicio).'" type="text" class="unidades form-control text-left" style="width: 80px; margin: auto;">
            //                     </td>';
            //                 echo '</tr>';
            //                 if($diopInicio < 25){
            //                     $diopInicio += 0.5;
            //                 }
            //             }
            //             $diopInicio = 15;
            //         }
            //     }  
                

            while($i = mysqli_fetch_assoc($egresos)){

                if($i['cantidad'] < 1){
                    $cero = "text-danger font-weight-bold";
                }else{
                    $cero = "";
                }

                echo '<tr id="filaArticuloEgreso" class="'.$cero.'">
                    <td class="text-left align-middle">
                        <div class="row">
                            <div class="col text-left">
                                '.$i['articulo'].' '.$i['marca'].'
                            </div>
                            <div class="col text-right">';
                            if($i['cantidad'] <= $i['stockMin']){
                                echo '<i class="fas fa-circle text-danger"></i>';
                            }else if($i['cantidad'] > $i['stockMin'] && $i['cantidad'] <= ($i['stockMin'] + 5)){
                                echo '<i class="fas fa-circle text-warning"></i>';
                            }else if($i['cantidad'] > ($i['stockMin'] + 5)){
                                echo '<i class="fas fa-circle text-success"></i>';
                            }
                            echo '</div>
                        </div>
                    </td>';
                    if($i['lote'] == ""){
                        echo '<td class="text-center align-middle">-</td>';
                    }else{
                        echo '<td class="text-center align-middle">'.$i['lote'].'</td>';
                    }
                    if($i['vencimiento'] == "-" || $i['vencimiento'] == ""){
                        echo '<td class="text-center align-middle">-</td>';
                    }else{
                        echo '<td class="text-center align-middle">'.date("d-m-Y", strtotime($i['vencimiento'])).'</td>';
                    }
                    echo '<td class="text-center align-middle stockCantidadActual">'.$i['cantidad'].'</td>';
                    if($i['cantidad'] < 1){
                        echo '<td class="text-left align-middle"><input disabled placeholder="Vacio" type="text" class="form-control text-center" style="width: 80px; margin: auto;"></td>';
                    }else{
                        echo '<td class="text-left align-middle"><input id="unidadesParaDescontar" data-idarticulo="'.$i['id'].'" data-lente="0" data-columna="0" type="text" class="unidades form-control text-left" style="width: 80px; margin: auto;"></td>';
                    }
                echo '</tr>';
            }
        echo '</tbody>
    </table>';

    echo '<div class="row">
        <div class="col text-right">
            <button disabled class="btn btn-success far fa-save" id="descontarUnidades"></button>
        </div>
    </div>';

    mysqli_close($stock);
}
?>