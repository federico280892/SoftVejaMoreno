<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "SELECT insumos.id AS 'id', items.nombre AS 'nombre', insumos.img AS 'img', insumos.descripcion AS 'descripcion', existencias.cantidad AS 'cantidad' FROM insumos INNER JOIN existencias ON insumos.id = existencias.id_insumo INNER JOIN items ON items.id = insumos.id_item WHERE insumos.id = '".$_POST['id']."' LIMIT 1");
        while($i = mysqli_fetch_assoc($peticion)){
            echo '<div class="row">
                <div class="col text-right">
                    <img src="../img/products/'.$i['img'].'" class="img-fluid mb-2 mr-1" width="50px">
                    <small><b>'.$i['descripcion'].' ('.$i['cantidad'].' unidades)</b></small>
                </div>
            </div>
            <div class="row">
                <div class="col-md">
                    <div class="form-group">
                        <label for="modalItemAltaBajaAccion">Acción</label>
                        <select id="modalItemAltaBajaAccion" class="form-control custom-select">
                            <option value="0">Agregar al stock</option>
                            <option value="1">Quitar del stock</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="modalItemAltaBajaCantidad">Cantidad</label>
                        <input type="number" id="modalItemAltaBajaCantidad" value="1" min="1" placeholder="Cantidad" class="form-control text-center">
                    </div> 
                </div>
            </div>';
        }
    mysqli_close($stock);
}
?>