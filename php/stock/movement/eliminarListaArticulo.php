<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $resultado = "";
    $total = 0.00;

    array_splice($_SESSION['listaArticulos'], $_POST['pos'], 1);

    if(count($_SESSION['listaArticulos']) < 1){
        echo '<script>
            $("#btnGuardarListaArticulos").attr("disabled", true);
        </script>';
    }
    
    echo '<script>
    //tabla ingresos
	$("#tabla-ingresos").DataTable({
        ordering: true,
        searching: true,
        info: true,
        pageLength: 10,
        scrollX: true,
        // "lengthMenu": [4],
        bInfo: false,
        // "paging": false,
        autoWidth: true,
        bPaginate: true,
        bSort: false,
        language: {
            "decimal": "",
            "emptyTable": "No Hay Datos Registrados",
            "info": "Mostrando _START_ De _END_ De Un Total De _TOTAL_ Registros",
            "info": "Mostrando Un Total De _TOTAL_ Registros",
            "infoEmpty": "No Existen Registros Cargados",
            "infoFiltered": "(Filtrado de un total de _MAX_ registros)",
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
    </script>';
    
    echo '<div class="row">
        <div class="col">
            <i role="button" id="agregrArticuloAComprobante" class="fas fa-plus-circle ml-2 h4 mb-3 text-success"></i>
            <i role="button" id="eliminarFilaArticulo" class="fas fa-trash ml-2 h4 mb-3 text-danger" style="display: none;"></i>
        </div>
    </div>
    <div class="row">
        <div class="col text-right">
            <small>Total: <span id="modalAgregarNuevoArticuloAComprobanteTotal" class="ml-3 font-weight-bold h3">0.00</span></small>
        </div>
    </div>';
    echo '<table id="tabla-ingresos" class="table table-striped table-hover" style="font-size:0.9rem;">
        <thead>
            <tr>
                <th class="text-left" style="min-width:95px;">Artículo</th>
                <th class="text-left" style="min-width:95px;">Grupo</th>
                <th class="text-left">Marca</th>
                <th class="text-center">Lote</th>
                <th class="text-center">Vencimiento</th>
                <th class="text-center">Stock</th>
                <th class="text-center" style="width: 65px;">P Costo</th>
                <th class="text-center">Cantidad</th>
                <th class="text-center">Subtotal</th>
            </tr>
        </thead>
        <tbody>';
        for($i = 0; $i < count($_SESSION['listaArticulos']); $i++){

            echo "<tr id='filaListaArticulos' data-pos='".$i."'>";

                $peticion = mysqli_query($stock, "SELECT 
                    articulos.nombre AS 'nombre',
                    grupos.nombre AS 'grupo'
                    FROM articulos 
                    INNER JOIN grupos
                    ON grupos.id = articulos.id_grupo
                    WHERE articulos.id = '".$_SESSION['listaArticulos'][$i][0]."' LIMIT 1");
                while($art = mysqli_fetch_assoc($peticion)){
                    if($_SESSION['listaArticulos'][$i][6] == "-"){
                        echo '<td class="text-left">'.$art['nombre'].'</td>';
                    }else{
                        echo '<td class="text-left">'.$art['nombre'].' Diop: '.$_SESSION['listaArticulos'][$i][6].'</td>';
                    }
                    echo '<td class="text-left">'.$art['grupo'].'</td>';
                }
                            
                if($_SESSION['listaArticulos'][$i][4] == ""){
                    echo '<td class="text-left">-</td>';
                }else{
                    echo '<td class="text-left">'.$_SESSION['listaArticulos'][$i][4].'</td>';
                }
                if($_SESSION['listaArticulos'][$i][1] == ""){
                    echo '<td class="text-center">-</td>';
                }else{
                    echo '<td class="text-center">'.$_SESSION['listaArticulos'][$i][1].'</td>';
                }
                if($_SESSION['listaArticulos'][$i][2] == ""){
                    echo '<td class="text-center">-</td>';
                }else{
                    echo '<td class="text-center">'.date("d-m-Y", strtotime($_SESSION['listaArticulos'][$i][2])).'</td>';
                }
                $cantidad = mysqli_query($stock, "SELECT existencias.cantidad AS 'cantidad' FROM existencias INNER JOIN articulos ON articulos.id = existencias.id_articulo AND articulos.id = '".$_SESSION['listaArticulos'][$i][0]."'");
                if(mysqli_num_rows($cantidad) < 1){
                    echo '<td class="text-center">0</td>';
                }else{
                    while($c = mysqli_fetch_assoc($cantidad)){
                        echo '<td class="text-center">'.$c['cantidad'].'</td>';
                    }
                }
                echo '<td class="text-center">'.number_format($_SESSION['listaArticulos'][$i][3], 2, ',', '.').'</td>';
                echo '<td class="text-center">'.$_SESSION['listaArticulos'][$i][5].'</td>';
                $subtotal = $_SESSION['listaArticulos'][$i][3]*$_SESSION['listaArticulos'][$i][5];
                echo '<td class="text-right">'.number_format($subtotal, 2, ',', '.').'</td>';
            echo "</tr>";
            $total += $subtotal;
            $_SESSION['totalComprobante'] = $total;
        }
        echo '</tbody>
    </table>';
    echo '<div class="row">
        <div class="col text-right">
            <button disabled id="btnGuardarListaArticulos" class="btn btn-success btn-sm fas fa-cart-arrow-down"></button>
        </div>
    </div>';
    echo '<script>
    $("#modalAgregarNuevoArticuloAComprobanteTotal").text("$ "+separadorDeMiles('.$total.'));
    $("#btnGuardarListaArticulos").removeAttr("disabled");
    </script>';
    
    echo '<script>
    $("#modalAgregarNuevoArticuloAComprobanteTotal").text("$ "+separadorDeMiles('.$total.'));
    </script>';
    mysqli_close($stock);
}
?>