<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "SELECT 
    articulos.activo,
    articulos.nombre,
    articulos.img,
    articulos.codigo_barra,
    articulos.stockMin,
    articulos.id_grupo,
    articulos.precio_costo,
    articulos.observaciones,
    proveedores.id AS 'proveedor',
    existencias.cantidad AS 'stock',
    (SELECT fecha_comprobante FROM cantidades_cargadas WHERE id_articulo = '".$_POST['id']."' ORDER BY fecha_comprobante DESC LIMIT 1) AS 'ultima_fecha'
    FROM articulos
    INNER JOIN cantidades_cargadas
    ON cantidades_cargadas.id_articulo = articulos.id
    INNER JOIN comprobantes
    ON comprobantes.id = cantidades_cargadas.id_comprobante
    INNER JOIN proveedores
    ON proveedores.id = comprobantes.proveedor
    INNER JOIN existencias
    ON existencias.id_articulo = articulos.id
    WHERE articulos.id = '".$_POST['id']."' LIMIT 1");

    while($i = mysqli_fetch_assoc($peticion)){

        echo '<div class="row">
            <div class="col-md-12 text-right">';
                if($i['activo'] == "1"){
                    echo '<label>Activo <input type="checkbox" id="modalModificarArticuloEstado" checked></label>';
                }else{
                    echo '<label>Activo <input type="checkbox" id="modalModificarArticuloEstado"></label>';
                }
            echo '</div>
        </div>
        <div class="row">
            <div class="col-md-2 text-center">
                <img role="button" id="previewArticuloEditar" src="../img/products/'.$i['img'].'" class="img-fluid img-thumbnail">
                <i role="button" class="fas fa-trash mt-2 text-danger" id="vaciarImgArticuloEditar" style="display: none"></i>
                <small id="nombreFotoOcupado" class="text-danger"></small>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="modalModificarArticuloNombre">Artículo</label>
                            <input value="'.$i['nombre'].'" type="text" class="form-control" placeholder="Nombre del artículo" id="modalModificarArticuloNombre"> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="modalModificarArticuloGrupo">Grupo</label>';
                            echo '<select class="form-control custom-select" id="modalModificarArticuloGrupo">';
                            $peticion = mysqli_query($stock, "SELECT 
                            grupos.id AS 'id', 
                            grupos.nombre AS 'nombre',
                            rubros.id AS 'rubro' 
                            FROM grupos 
                            INNER JOIN rubros 
                            ON rubros.id = grupos.rubro 
                            WHERE grupos.activo = '1' 
                            ORDER BY grupos.nombre ASC");
                                                        
                            while($g = mysqli_fetch_assoc($peticion)){
                                if($i['id_grupo'] == $g['id']){
                                    echo '<option value="'.$g['id'].'" data-rubro="'.$g['rubro'].'" selected>'.$g['nombre'].'</option>';
                                }else{
                                    echo '<option value="'.$g['id'].'" data-rubro="'.$g['rubro'].'">'.$g['nombre'].'</option>';
                                }
                            }
                            echo '</select>';
                        echo '</div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="modalModificarArticuloCodigoBarras">Código de barras</label>
                            <input value="'.$i['codigo_barra'].'" type="text" class="form-control" placeholder="Código de barras" id="modalModificarArticuloCodigoBarras"> 
                        </div>
                    </div>
                    <div class="col" style="max-width: 116.13px;">
                        <div class="form-group">
                            <label for="modalModificarArticuloStockMin">Stock min</label>
                            <input type="number" min="1" value="'.$i['stockMin'].'" class="form-control" placeholder="Stock min" id="modalModificarArticuloStockMin">
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        echo '<div class="row">
            <div class="col" style="max-width: 165px;">
                <div class="form-group">
                    <label>Última compra</label>
                    <input type="text" class="form-control text-center" value="'.date("d-m-Y", strtotime($i['ultima_fecha'])).'">      
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label>Proveedor</label>
                    <select class="form-control">';
                    $peticion = mysqli_query($stock, "SELECT id, nombre FROM proveedores");
                    while($p = mysqli_fetch_assoc($peticion)){
                            if($i['proveedor'] == $p['id']){
                                echo '<option value="'.$p['id'].'" selected>'.$p['nombre'].'</option>';
                            }else{
                                echo '<option value="'.$p['id'].'">'.$p['nombre'].'</option>';
                            }
                        }
                    echo '</select>
                </div>
            </div>

            <div class="col-3" style="max-width:140px;">
                <div class="form-group">
                    <label>Precio U</label>';
                    if($i['precio_costo'] != "" || $i['precio_costo'] != "-"){
                        echo '<input type="text" class="form-control" value="'.$i['precio_costo'].'">';
                    }else{
                        echo '<input type="text" class="form-control" value="'.$i['precio_costo'].'">';
                    }
                    
                echo '</div>
            </div>
            <div class="col-2" style="max-width: 90px;">
                <div class="form-group">
                    <label>Stock</label>
                    <input type="text" class="form-control" value="'.$i['stock'].'">      
                </div>
            </div>
        </div>';
            
        echo '<div class="row">
            <div class="col-md-12">
                <div id="form-group">
                    <label for="modalModificarArticuloObs">Observaciones</label>
                    <textarea class="form-control" placeholder="Observaciones" id="modalModificarArticuloObs">'.$i['observaciones'].'</textarea>
                </div> 
            </div>
        </div>';

    }
}
?>