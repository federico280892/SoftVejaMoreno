<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "SELECT * FROM grupos WHERE id = '".$_POST['id']."' LIMIT 1");
    while($i = mysqli_fetch_assoc($peticion)){
        echo '<div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label><b>Ítem: </b>'.$i['nombre'].'</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label><b>Descripción: </b>'.$i['descripcion'].'</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label><b>Observación: </b>'.$i['observaciones'].'</label>
                </div>
            </div>
        </div>';
    }
}
?>