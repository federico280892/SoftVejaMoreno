<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    echo '<script>
    //preprarar datatable nomeclador
    $("#tabla-coberturasMedicas").DataTable( {
        "ordering": false,
        "info": false,
        "paging": false,
        "scrollX": true,
        "language": {
            "lengthMenu": "Mostrando _MENU_ por página",
            "zeroRecords": "No se encontraron resultados - disculpe",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "search": "Buscar",
            "infoFiltered": "(Filtrados _MAX_ del total de registros)"
        }
    } );

    $("#tabla-coberturasMedicas_wrapper .dataTables_scroll .dataTables_scrollHead .dataTables_scrollHeadInner .table").removeClass("mb-2");
    </script>';
    echo '<div class="row">
        <div class="col-12">
            <h4 class="mb-3">Coberturas sociales
            <i title="Nueva Cobertura" role="button" id="botonAgregarCoberturaSocial" class="efecto-hover ml-3 fas fa-plus-circle text-success"></i>
            <i title="Eliminar cobertura" id="botonEliminarCobertura" role="button" class="efecto-hover fas fa-trash text-danger ml-3" style="display: none;"></i>
            <i title="Editar cobertura" id="botonEditarCobertura" role="button" class="efecto-hover fas fa-edit text-info ml-3" style="display: none;"></i>
            <i title="Ver cobertura" id="botonVerCobertura" role="button" class="efecto-hover fas text-primary fa-eye ml-3" style="display: none;"></i>
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col">
            
                <table class="table table-hover table-bordered mb-2" id="tabla-coberturasMedicas">
                    <thead>
                        <tr class="bg-info text-white">
                            <th class="text-center" style="width: 30px;"><small>Ítem</small></th>
                            <th class="text-center" style="width: 45px"><small>Código</small></th>
                            <th class="text-center" style="width: 200px;"><small>Obra social</small></th>
                            <th class="text-center" style=""><small>Plus</small></th>
                            <th class="text-center" style="width: 200px;"><small>Descripción</small></th>
                            <th class="text-center" style="width: 80px;"><small>Cupo por día</small></th>
                            <th class="text-center" style="width: 250px;"><small>Domicilio</small></th>
                            <th class="text-center" style="width: 150px;"><small>Localidad</small></th>
                            <th class="text-center" style=""><small>CP</small></th>
                            <th class="text-center" style="width: 120px;"><small>Provincia</small></th>
                            <th class="text-center" style=""><small>Teléfono</small></th>
                            <th class="text-center" style="width: 120px;"><small>Celular</small></th>
                            <th class="text-center" style="width: 250px;"><small>Email</small></th>
                            <th class="text-center" style="width: 100px;"><small>Tipo</small></th>
                            <th class="text-center" style=""><small>Modulada</small></th>
                            <th class="text-center" style="width: 160px;"><small>Categoria IVA</small></th>
                            <th class="text-center" style="width: 100px;"><small>CUIT</small></th>
                            <th class="text-center" style="width: 100px;"><small>Ingresos brutos</small></th>
                            <th class="text-center" style="width: 50px;"><small>Val con.</small></th>
                            <th class="text-center" style="width: 50px;"><small>Gal qui</small></th>
                            <th class="text-center" style="width: 50px;"><small>Gal pra</small></th>
                            <th class="text-center" style="width: 60px;"><small>Gas pens</small></th>
                            <th class="text-center" style="width: 60px;"><small>Gto Quir</small></th>
                            <th class="text-center" style="width: 60px;"><small>Gto Radi</small></th>
                            <th class="text-center" style="width: 95px;"><small>Porcentaje gral</small></th>
                            <th class="text-center" style="width: 100px;"><small>Paga categoria</small></th>
                            <th class="text-center" style="width: 150px;"><small>Aumento en liq</small></th>
                            <th class="text-center" style="width: 150px;"><small>Porcentaje Hon</small></th>
                            <th class="text-center" style="width: 150px;"><small>Porcentaje Gtos</small></th>
                            <th class="text-center" style="width: 150px;"><small>Pctj Nivel 1</small></th>
                            <th class="text-center" style="width: 150px;"><small>Pctj Nivel 2</small></th>
                            <th class="text-center" style="width: 150px;"><small>Pctj Nivel 3</small></th>
                            <th class="text-center" style="width: 150px;"><small>Modelo generacion TXT</small></th>
                            <th class="text-center" style="width: 150px;"><small>Long Orden</small></th>
                            <th class="text-center" style="width: 150px;"><small>Long N° afiliado</small></th>
                            <th class="text-center" style="width: 150px;"><small>Long barra</small></th>
                            <th class="text-center" style="width: 250px;"><small>Alerta secretarias</small></th>
                            <th class="text-center" style="width: 250px;"><small>Alerta</small></th>
                            <th class="text-center" style="width: 50px;"><small>Activo</small></th>
                            </tr>  
                    </thead>
                    <tbody>';
                        $peticion = mysqli_query($veja, "SELECT coberturas_sociales.*, 
                            provincias.provincia AS 'prov', 
                            localidades.localidad AS 'loc',
                            categorias_iva.razon_social AS 'razon',
                            tipos_de_cobertura.tipo AS 'tipoCobertura' 
                         FROM coberturas_sociales
                         INNER JOIN provincias ON provincias.id = coberturas_sociales.provincia
                         INNER JOIN localidades ON localidades.id = coberturas_sociales.localidad
                         INNER JOIN tipos_de_cobertura ON tipos_de_cobertura.id = coberturas_sociales.tipo 
                         INNER JOIN categorias_iva ON categorias_iva.id = coberturas_sociales.categoria_iva
                         ORDER BY coberturas_sociales.cobertura_social ASC");
                        while($p = mysqli_fetch_assoc($peticion)){
                            if($p['activo'] == "1"){
                                $estado = "Activo";
                            }else{
                                $estado = "Inactivo";
                            }

                            if($p['modulada'] == "1"){
                                $modulada = "SI";
                            }else if($p['modulada'] == "0"){
                                $modulada = "NO";
                            }else{
                                $modulada = "No aplica";
                            }
                            echo '<tr role="button" id="filaCoberturaSocial">
                                <td class="text-center">
                                    <input onclick="seleccionarCoberturaSocial(\''.$p['id'].'\')" class="form-check-input" type="radio" name="idCoberturaSocial" style="margin-left: -8px;">   
                                </td>
                                <td class="text-center"><small>'.$p['codigo'].'</small></td>
                                <td class="text-left"><small>'.$p['cobertura_social'].'</small></td>
                                <td class="text-left"><small>'.$p['plus'].'</small></td>
                                <td class="text-left"><small>'.$p['descripcion'].'</small></td>
                                <td class="text-center"><small>'.$p['cupo_por_dia'].'</small></td>
                                <td class="text-left"><small>'.$p['domicilio'].'</small></td>
                                <td class="text-left"><small>'.$p['loc'].'</small></td>
                                <td class="text-center"><small>'.$p['codigo_postal'].'</small></td>
                                <td class="text-left"><small>'.$p['prov'].'</small></td>
                                <td class="text-center"><small>'.$p['telefono'].'</small></td>
                                <td class="text-center"><small>'.$p['celular'].'</small></td>
                                <td class="text-center"><small>'.$p['email'].'</small></td>
                                <td class="text-center"><small>'.$p['tipoCobertura'].'</small></td>
                                <td class="text-center"><small>'.$modulada.'</small></td>
                                <td class="text-left"><small>'.$p['razon'].'</small></td>
                                <td class="text-center"><small>'.$p['cuit'].'</small></td>
                                <td class="text-center"><small>'.$p['ingresos_brutos'].'</small></td>
                                <td class="text-center"><small>'.$p['val_con'].'</small></td>
                                <td class="text-center"><small>'.$p['gal_qui'].'</small></td>
                                <td class="text-center"><small>'.$p['gal_pra'].'</small></td>
                                <td class="text-center"><small>'.$p['gas_pens'].'</small></td>
                                <td class="text-center"><small>'.$p['gto_quir'].'</small></td>
                                <td class="text-center"><small>'.$p['gto_radi'].'</small></td>
                                <td class="text-center"><small>'.$p['porcentaje_gral'].'</small></td>
                                <td class="text-center"><small>'.$p['paga_categoria'].'</small></td>
                                <td class="text-center"><small>'.$p['aumento_en_liq'].'</small></td>
                                <td class="text-center"><small>'.$p['porcentaje_hon'].'</small></td>
                                <td class="text-center"><small>'.$p['porcentaje_gtos'].'</small></td>
                                <td class="text-center"><small>'.$p['porcentaje_n1'].'</small></td>
                                <td class="text-center"><small>'.$p['porcentaje_n2'].'</small></td>
                                <td class="text-center"><small>'.$p['porcentaje_n3'].'</small></td>
                                <td class="text-center"><small>'.$p['modelo_generacion_txt'].'</small></td>
                                <td class="text-center"><small>'.$p['long_orden'].'</small></td>
                                <td class="text-center"><small>'.$p['long_n_afiliado'].'</small></td>
                                <td class="text-center"><small>'.$p['long_barra'].'</small></td>
                                <td class="text-center"><small>'.$p['alerta_secretarias_cirugia'].'</small></td>
                                <td class="text-center"><small>'.$p['alerta'].'</small></td>
                                <td class="text-center"><small>'.$estado.'</small></td>
                            </tr>';
                        }
                    echo '</tbody>   
                </table> 

        </div>
    </div>';
    mysqli_close($veja);
}
?>