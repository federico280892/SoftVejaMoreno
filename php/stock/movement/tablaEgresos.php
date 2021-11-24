<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");

    echo '<div class="row">
    <div class="col"></div>
    <div class="col" style="max-width: 245px;">
        <div class="form-group">
                <small>Filtrar Por Rubro</small>
                <select class="form-control" id="filtroRubroEgreso" style="border: 1px solid #aaa;">
                    <option value="0">No aplicado</option>';
                    $peticion = mysqli_query($stock, "SELECT id, nombre FROM rubros ORDER BY nombre ASC");
                    while($r = mysqli_fetch_assoc($peticion)){
                        echo '<option value='.$r['id'].'>'.$r['nombre'].'</option>';
                    }
                echo '</select>
            </div>       
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <small>Filtrar Por Grupo</small>
                <select class="form-control" id="filtroGrupoEgreso" style="border: 1px solid #aaa;">
                    <option value="0">No aplicado</option>';
                    $peticion = mysqli_query($stock, "SELECT id, nombre FROM grupos WHERE rubro != '2' ORDER BY nombre ASC");
                    while($r = mysqli_fetch_assoc($peticion)){
                        echo '<option value='.$r['id'].'>'.$r['nombre'].'</option>';
                    }
                echo '</select>
            </div>       
        </div>
    </div>';

    echo '<div id="contenedorTablaEgresosFiltrada"></div>';

    mysqli_close($stock);
}
?>