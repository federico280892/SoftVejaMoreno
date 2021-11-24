<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $_SESSION['listaArticulos'] = array();
    $_SESSION['totalComprobante'] = "";
    $_SESSION['cantidad_lentes'] = "";
    $_SESSION['dioptrias_lentes'] = "";
    $_SESSION['detalles_lentes'] = "";
    $_SESSION['lente'] = "";
    echo '<script>

    $("#movimientoNComprobante").mask("0000-00000000", {placeholder: "0000-00000000"});

    </script>';


    echo '<div id="contenedorMotivoMovimientos">';
        echo '<section class="container">
            <div class="row">
                <div class="col text-right">
                    <small>Fecha Actual:<span id="fechaActualMovimiento" class="ml-3 font-weight-bold"></span></small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="motivoMovimientoOpciones">Motivo Moviento</label>
                        <select class="form-control" id="motivoMovimientoOpciones">
                            <option value="0">Ingreso</option>
                            <option value="1">Egreso</option>
                            <option value="2">Consultas</option>
                        </select>
                    </div>
                </div>

                <!--INGRESO-->
                    <div class="col" id="motivoMovimientoIngresoComprobante" style="max-width: 150px;">
                        <div class="form-group">
                            <label for="movimientoIngreso">Comprobante</label>
                            <select class="form-control" id="movimientoIngreso">
                                <option value="0">Factura</option>
                                <option value="1">Remito</option>
                                <option value="2">Otros</option>
                                <option value="3">Por ajuste</option>
                            </select>
                        </div>
                    </div>
                    <div class="col" id="motivoMovimientoIngresoOpcionFecha" style="max-width: 210px;">
                        <div class="form-group">
                            <label for="fechaIngreso">Fecha Comprobante</label>
                            <input type="date" class="form-control" id="fechaIngreso" style="font-size:15px;">
                        </div>   
                    </div>
                    <div class="col" id="motivoMovimientoIngresoNComprobante" style="max-width: 200px;">
                        <div class="form-group">
                          <label for="movimientoNComprobante">N° Comprobante</label>   
                          <input type="text" id="movimientoNComprobante" class="form-control text-center">
                        </div>
                    </div>
                    <div class="col" id="motivoMovimientoIngresoOpcionProveedor">
                        <div class="form-group">
                            <label for="proveedorIngreso">Proveedor</label>
                            <select class="form-control" id="proveedrIngreso">';
                                $peticion = mysqli_query($stock, "SELECT id, nombre FROM proveedores ORDER BY nombre ASC");
                                while($p = mysqli_fetch_assoc($peticion)){
                                    echo "<option value=".$p['id'].">".$p['nombre']."</option>";
                                }
                            echo '</select>
                        </div>
                    </div>

                    <div id="contenedor-tabla_ingresos" class="container">                        
                    </div>
                <!--FIN INGRESO-->
                <!--EGRESO-->
                    <div class="col-md-2" id="motivoMovimientoEgresoOpcionMotivo">
                        <div class="form-group">
                            <label for="movimientoEgreso">Motivo</label>
                            <select class="form-control" id="movimientoEgreso">
                                <option value="0">Rotura</option>
                                <option value="1">Vencimiento</option>
                                <option value="2">Uso</option>
                                <option value="3">Por ajuste</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3" id="fechaMovimientoEgreso" style="display: none;">
                        <div class="form-group">
                            <label for="movimientoEgresoFechaUso">Fecha</label>
                            <input type="date" class="form-control" id="movimientoEgresoFechaUso">      
                        </div> 
                    </div>
                    
                    <div id="contenedor-tabla-egresos" class="container mt-3"> 
                    </div>  

                <!--FIN EGRESO-->
            </div>
            <!--CONSULTAS-->
                <div id="contenedor-consultas" class="row mt-3" style="display: none;">
                    <div class="col" id="comprobantesComprobantes"></div>   
                </div>
            <!--FIN CONSULTAS-->
            
            <!--AJUSTES-->
                <div id="contenedor-ajustes" class="container mt-3" style="display: none;">
                    <div id="contenedor-tabla-ajuste"></div>
                </div>
            <!--FIN AJUSTES-->


        </section>';
    echo '</div>';




    mysqli_close($stock);
}
?>