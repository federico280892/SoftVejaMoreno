<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "SELECT 
    activo,
    nombre,
    img,
    codigo_barra,
    stockMin,
    id_grupo,
    observaciones
    FROM articulos
    WHERE id = '".$_POST['id']."' LIMIT 1");

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
                            $peticion2 = mysqli_query($stock, "SELECT 
                            grupos.id AS 'id', 
                            grupos.nombre AS 'nombre',
                            rubros.id AS 'rubro'
                            FROM grupos 
                            INNER JOIN rubros 
                            ON rubros.id = grupos.rubro 
                            WHERE grupos.activo = '1' 
                            ORDER BY grupos.nombre ASC");
                                                        
                            while($g = mysqli_fetch_assoc($peticion2)){
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
        </div>   
        
        <div class="row">
            <div id="divFileImagenEditar">
                <div class="form-group"> 
                    <input type="file" id="modalModificarArticuloFoto">
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
    mysqli_close($stock);
}
?>