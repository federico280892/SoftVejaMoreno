<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    echo '<div class="row">
        <div class="col-md-12 text-right">
            <label>Activo <input type="checkbox" checked id="modalAgregarArticuloActivo"></label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 text-center">
            <img role="button" id="previewArticulo" src="../img/products/default_product.jpg" class="img-fluid img-thumbnail">
            <i role="button" class="fas fa-trash mt-2 text-danger" id="vaciarImgArticulo" style="display: none"></i>
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="modalAgregarArticuloNombre">Artículo</label><span id="articuloDuplicado" class="ml-2"></span>
                        <input type="text" class="form-control" placeholder="Nombre del artículo" id="modalAgregarArticuloNombre"> 
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="modalAgregarArticuloGrupo">Grupo</label>';
                        echo '<select class="form-control custom-select" id="modalAgregarArticuloGrupo">';
                        $peticion = mysqli_query($stock, "SELECT 
                        grupos.id AS 'id', 
                        grupos.nombre AS 'nombre', 
                        rubros.id AS 'rubro', 
                        rubros.dioptria AS 'dioptria' 
                        FROM grupos 
                        INNER JOIN rubros 
                        ON rubros.id = grupos.rubro 
                        WHERE grupos.activo = '1' 
                        ORDER BY grupos.nombre ASC");

                        while($i = mysqli_fetch_assoc($peticion)){
                            echo '<option value="'.$i['id'].'" data-rubro="'.$i['rubro'].'" data-dioptria="'.$i['dioptria'].'">'.$i['nombre'].'</option>';
                        }
                        echo '</select>';
                    echo '</div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="modalAgregarArticuloCod_Barras">Código de Barras</label>
                        <input type="text" class="form-control" placeholder="Código de barras" id="modalAgregarArticuloCod_Barras"> 
                    </div>
                </div>
                <div class="col" style="max-width: 116.13px;">
                    <div class="form-group">
                        <label for="modalAgregarArticulosStockMin">Stock Min</label>
                        <input type="number" min="1" value="1" class="form-control" placeholder="Stock min" id="modalAgregarArticulosStockMin">
                    </div>
                </div>
            </div>
        </div>
    </div>';
        
    echo '<div class="row">
        <div id="divFileImagen">
            <div class="form-group"> 
                <div id="modalAgregarArticuloFotoInfo"></div>
                <input type="file" id="modalAgregarArticuloFoto">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="form-group">
                <label for="modalAgregarArticuloObservaciones">Observaciones</label>
                <textarea class="form-control" placeholder="Observaciones" id="modalAgregarArticuloObservaciones"></textarea>
            </div> 
        </div>
    </div>';
}
?>