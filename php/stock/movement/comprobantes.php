<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");

    echo '<div class="row">
        <div class="col">
            <h5><i class="fas fa-clipboard-list mr-2 text-info"></i>Comprobantes</h5>
        </div>
    </div>';
    echo '<div class="row">
    <div class="col text-left">
        <i role="button" class="fas fa-eye mr-3 text-info h4 mt-4" id="verComprobante" style="display: none;"></i>
    </div>
    <div class="col" style="max-width: 245px;">
        <div class="form-group">
                <small>Filtrar Por Comprobantes</small>
                <select class="form-control" id="filtroTipoComprobante" style="border: 1px solid #aaa;">
                    <option value="99">No aplicado</option>
                    <option value="0">Factura</option>
                    <option value="1">Remito</option>
                    <option value="3">Egresos</option>
                    <option value="4">Ajuste</option>
                    <option value="2">Otros</option>
                    ';
                echo '</select>
            </div>       
        </div>
    </div>';

    echo '<div id="contenedor-tabla-comprobantes"></div>';

    mysqli_close($stock);
}
?>
