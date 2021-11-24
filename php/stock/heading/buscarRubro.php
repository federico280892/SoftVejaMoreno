<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "SELECT * FROM rubros WHERE id = '".$_POST['id']."' LIMIT 1");
    while($r = mysqli_fetch_assoc($peticion)){
        echo '<div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="modalModificarNombre">Nombre</label>
                    <input value="'.$r['nombre'].'" type="text" class="form-control" placeholder="Nombre" id="modalModificarNombre">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="modalModificarEstado">Estado</label>';
                    if($r['activo'] == "1"){
                        echo '<select id="modalModificarEstado" class="form-control custom-select">
                            <option value="1" selected>Activo</option>
                            <option value="0">Inactivo</option>
                        </select>';
                    }else{
                        echo '<select id="modalModificarEstado" class="form-control custom-select">
                            <option value="1">Activo</option>
                            <option value="0" selected>Inactivo</option>
                        </select>';
                    }
                echo '</div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="modalModificarDioptria">Permite dioptria</label>';
                    if($r['dioptria'] == "1"){
                        echo '<select id="modalModificarDioptria" class="form-control custom-select">
                            <option value="1" selected>SI</option>
                            <option value="0">NO</option>
                        </select>';
                    }else{
                        echo '<select id="modalModificarDioptria" class="form-control custom-select">
                            <option value="1">SI</option>
                            <option value="0" selected>NO</option>
                        </select>';
                    }
                echo '</div> 
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="modalModificarObservacion">Observación</label>';
                    if($r['observacion'] == "-"){
                        echo '<textarea class="form-control" placeholder="Observación" id="modalModificarObservacion"></textarea>';
                    }else{
                        echo '<textarea class="form-control" placeholder="Observación" id="modalModificarObservacion">'.$r['observacion'].'</textarea>';
                    }
                echo '</div>
            </div>
        </div>';
        mysqli_close($stock);
    }
}
?>