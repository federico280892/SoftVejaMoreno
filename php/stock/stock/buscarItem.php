<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "SELECT * FROM grupos WHERE id = '".$_POST['id']."' LIMIT 1");
    while($i = mysqli_fetch_assoc($peticion)){
        echo '<div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3 text-right">
                <div class="form-group">';
                    if($i['activo'] == "1"){
                        echo '<label>Activo <input type="checkbox" id="modalModificarItemEstado" checked></label>';
                    }else{
                        echo '<label>Activo <input type="checkbox" id="modalModificarItemEstado"></label>';
                    }
                echo '</div>
            </div>
        </div>';
        echo '<div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="modalModificarItemNombre">Nombre</label>
                    <input value="'.$i['nombre'].'" type="text" id="modalModificarItemNombre" class="form-control" placeholder="Nombre">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="modalModificarItemDescripcion">Descripción</label>
                    <input value="'.$i['descripcion'].'" type="text" id="modalModificarItemDescripcion" class="form-control" placeholder="Descripción">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="modalModificarItemGrupo">Grupo</label>
                    <select class="form-control" id="modalModificarItemGrupo">';
                        $peticion = mysqli_query($stock, "SELECT id, nombre FROM rubros ORDER BY nombre ASC");
                        while($r = mysqli_fetch_assoc($peticion)){
                            if($r['id'] == $i['rubro']){
                                echo '<option value='.$r['id'].' selected>'.$r['nombre'].'</option>';
                            }else{
                                echo '<option value='.$r['id'].'>'.$r['nombre'].'</option>';
                            }
                        }
                    echo '</select>                    
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="modalModificarItemObservacion">Observaciones</label>';
                    if($i['observaciones'] == "-"){
                        echo '<input type="text" id="modalModificarItemObservacion" class="form-control" placeholder="Observaciones">';
                    }else{
                        echo '<input value="'.$i['observaciones'].'" type="text" id="modalModificarItemObservacion" class="form-control" placeholder="Observaciones">';
                    }
                echo '</div>
            </div>
        </div>';
        mysqli_close($stock);
    }
}
?>