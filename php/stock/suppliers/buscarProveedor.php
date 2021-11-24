<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    echo '<script>
    //////////////////////////////////////MASCARAS//////////////////////////////////////
    $("#modalProveedoresModificarCuit_cuil").mask("00-00000000-0", {placeholder: "00-00000000-00"});
    $("#modalProveedoresModificarCBU").mask("0000000000000000000000", {placeholder: "0000000000000000000000"});
    //////////////////////////////////////FIN MASCARAS//////////////////////////////////////
    </script>';
    $peticion = mysqli_query($stock, "SELECT * FROM proveedores WHERE id = '".$_POST['id']."' LIMIT 1");
    while($p = mysqli_fetch_assoc($peticion)){
        echo '<div class="row">
            <div class="col text-right">'; 
                if($p['activo'] == "1"){
                    echo '<label>Activo: <input type="checkbox" checked id="modalProveedoresModificarActivo"></label>';
                }else{;
                    echo '<label>Activo: <input type="checkbox" id="modalProveedoresModificarActivo"></label>';
                }
            echo '</div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="modalProveedoresModificarNombre">Nombre / Razón Social</label>
                    <input value="'.$p['nombre'].'" type="text" id="modalProveedoresModificarNombre" class="form-control" placeholder="Nombre">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="modalProveedoresModificarR_social">Condición IVA</label>
                    <select id="modalProveedoresModificarR_social" class="form-control custom-select" style="font-size: 15px;">';
                    $razonSocial = mysqli_query($stock, "SELECT * FROM razon_social");
                    echo '<option value="0">Sin especificar</option>';
                    while($rS = mysqli_fetch_assoc($razonSocial)){
                        if(strtoupper($rS['nombre']) == $p['razon_social']){
                            echo '<option value="'.$rS['nombre'].'" selected>'.$rS['nombre'].'</option>';
                        }else{
                            echo '<option value="'.$rS['nombre'].'">'.$rS['nombre'].'</option>';
                        }
                    }                   
                    echo '</select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="modalProveedoresModificarCuit_cuil">CUIT/CUIL</label><span id="modalProveedoresModificarInfoCuil" class="ml-2 text-danger"></span>
                    <input value="'.$p['CUIT_CUIL'].'" type="text" id="modalProveedoresModificarCuit_cuil" class="form-control text-center">
                </div>
            </div>


        </div>
        <div class="row">

            <div class="col-md-4">
                <div class="form-group">
                    <label for="modalProveedoresModificarBanco">Banco</label>
                    <select class="form-control" id="modalProveedoresModificarBanco">';
                    $peticion = mysqli_query($veja, "SELECT id, nombre FROM bancos ORDER BY nombre ASC");
                        echo '<option calue="0">Sin especificar</option>';
                        while($b = mysqli_fetch_assoc($peticion)){
                            if($p['banco'] == $b['id']){
                                echo '<option value="'.$b['id'].'" selected>'.$b['nombre'].'</option>';
                            }else{
                                echo '<option value="'.$b['id'].'">'.$b['nombre'].'</option>';
                            }
                        } 
                    echo '</select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="modalProveedoresModificarCBU">CBU</label>
                    <input value="'.$p['CBU'].'" type="text" id="modalProveedoresModificarCBU" class="form-control text-center">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="modalProveedoresModificarAlias">Alias</label>
                    <input value="'.$p['alias'].'" type="text" id="modalProveedoresModificarAlias" placeholder="Alias" class="form-control">
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="modalProveedoresModificarDomicilio">Domicilio</label>
                    <input value="'.$p['domicilio'].'" type="text" id="modalProveedoresModificarDomicilio" placeholder="Domicilio" class="form-control">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="modalProveedoresModificarTelefono">Teléfono</label>
                    <input value="'.$p['telefono'].'" type="text" id="modalProveedoresModificarTelefono" placeholder="Teléfono" class="form-control text-center">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                <label for="modalProveedoresModificarCelular">Celular</label>
                <input value="'.$p['celular'].'" type="text" id="modalProveedoresModificarCelular" placeholder="Celular" class="form-control text-center">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="modalProveedoresModificarEmail">Email</label>
                    <input value="'.$p['mail'].'" type="text" class="form-control" id="modalProveedoresModificarEmail" placeholder="Email">
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="modalProveedoresModificarObs">Observación</label>
                    <textarea id="modalProveedoresModificarObs" class="form-control" placeholder="Observaciones">'.$p['observacion'].'</textarea>   
                </div>
            </div>
        </div>';
        mysqli_close($stock);
    }
}
?>