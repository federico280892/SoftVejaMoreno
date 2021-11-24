<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "SELECT * FROM proveedores WHERE id = '".$_POST['id']."' LIMIT 1");
    while($p = mysqli_fetch_assoc($peticion)){

        echo '<div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3 text-right">';
                if($p['activo'] == '1'){
                    echo '<label>Activo <input disabled type="checkbox" checked></label>';
                }else{
                    echo '<label>Activo <input disabled type="checkbox"></label>';
                }
            echo '</div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label>Nombre / Razón Social</label>
                    <input disabled value="'.$p['nombre'].'" type="text" class="form-control" placeholder="Nombre">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Condición IVA</label>';
                    if($p['razon_social'] != ""){
                        echo '<input disabled type="text" value="'.$p['razon_social'].'" class="form-control">';
                    }else{
                        echo '<input disabled type="text" value="Sin definir" class="form-control">';
                    }
                echo '</div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>CUIL/CUIT</label><span id="modalProveedoresInfoCuil" class="ml-2 text-danger"></span>
                    <input disabled type="text" value="'.$p['CUIT_CUIL'].'" class="form-control text-center">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Banco</label>';
                    if($p['banco'] != ""){
                        $peticion = mysqli_query($veja, "SELECT nombre FROM bancos WHERE id = '".$p['banco']."' LIMIT 1");
                        while($banco = mysqli_fetch_assoc($peticion)){
                            echo '<input disabled type="text" value="'.$banco['nombre'].'" class="form-control">';
                        }
                    }else{
                        echo '<input disabled type="text" value="Sin definir" class="form-control">';
                    }
                echo '</div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>CBU</label>
                    <input disabled type="text" value="'.$p['CBU'].'" class="form-control text-center">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Alias</label>';
                    if($p['alias'] != ""){
                        echo '<input disabled type="text" value="'.$p['alias'].'" placeholder="Alias" class="form-control">';
                    }else{
                        echo '<input disabled type="text" value="Sin definir" placeholder="Alias" class="form-control">';
                    }
                echo '</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Domicilio</label>';
                    if($p['domicilio'] != ""){
                        echo '<input disabled type="text" value="'.$p['domicilio'].'" placeholder="Alias" class="form-control">';
                    }else{
                        echo '<input disabled type="text" value="Sin definir" class="form-control">';
                    }
                echo '</div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Teléfono</label>';
                    if($p['telefono'] != ""){
                        echo '<input disabled type="text" value="'.$p['telefono'].'" class="form-control">';
                    }else{
                        echo '<input disabled type="text" value="Sin definir" class="form-control">';
                    }
                echo '</div>
            </div>
            <div class="col-md-3">
            <div class="form-group">
                <label for="modalProveedoresCelular">Celular</label>';
                if($p['celular'] != ""){
                    echo '<input disabled type="text" value="'.$p['celular'].'" class="form-control">';
                }else{
                    echo '<input disabled type="text" value="Sin definir" class="form-control">';
                }
            echo '</div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="modalProveedoresEmail">Email</label>';
                    if($p['mail'] != ""){
                        echo '<input disabled type="text" value="'.$p['mail'].'" class="form-control">';
                    }else{
                        echo '<input disabled type="text" value="Sin definir" class="form-control">';
                    }
                echo '</div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="modalProveedoresObs">Observación</label>';
                    if($p['observacion'] != ""){
                        echo '<textarea disabled class="form-control">'.$p['observacion'].'</textarea>';
                    }else{
                        echo '<textarea disabled class="form-control">Sin definir</textarea>';
                    }
                echo '</div>
            </div>
        </div>';

    }
}
?>