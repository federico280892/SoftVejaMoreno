<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    echo '<div class="animate__animated">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="coberturasSociales-tab" data-toggle="tab" href="#coberturasSociales" role="tab" aria-controls="coberturasSociales" aria-selected="true"><i class="fas fa-file-medical"></i> Coberturas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="aaaaaaaa-tab" data-toggle="tab" href="#aaaaaaaa" role="tab" aria-controls="aaaaaaaa" aria-selected="false">Otro 1</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="bbbbbbb-tab" data-toggle="tab" href="#bbbbbbb" role="tab" aria-controls="bbbbbbb" aria-selected="false">Otro 2</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="coberturasSociales" role="tabpanel" aria-labelledby="coberturasSociales-tab">
                <div class="row">
                    <div class="col-12">
                        <h4 class="mt-4 mb-3">Coberturas<i title="Nueva cobertura" role="button" data-toggle="modal" data-target="#modalAgregarCoberturaSocial" class=" ml-3 fas fa-plus-circle text-success"></i></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h5>Coberturas</h5>
                    </div>
                    <div class="col text-right">
                        <i title="Refrescar" id="refrescarCoberturas" role="button" class="fas fa-sync-alt text-primary ml-3" style="font-size: 20px"></i>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center align-middle">Cobertura social</th>
                                <th class="text-center align-middle">Código</th>
                                <th class="text-center align-middle">Barra</th>
                                <th class="text-center align-middle">Plus</th>
                                <th class="text-center align-middle">Cupo por dia</th>
                                <th class="text-center align-middle">Domicilio</th>
                                <th class="text-center align-middle">Localidad</th>
                                <th class="text-center align-middle">Código postal</th>
                                <th class="text-center align-middle">Provincia</th>
                                <th class="text-center align-middle">Teléfono</th>
                                <th class="text-center align-middle">Fax</th>
                                <th class="text-center align-middle">Tipo</th>
                                <th class="text-center align-middle">Descripción</th>
                                <th class="text-center align-middle">Long barra</th>
                                <th class="text-center align-middle">IDSocOtalm</th>
                                <th class="text-center align-middle">Categoria IVA</th>
                                <th class="text-center align-middle">CUIT</th>
                                <th class="text-center align-middle">Ingresos brutos</th>
                                <th class="text-center align-middle">Val con</th>
                                <th class="text-center align-middle">Gal cli</th>
                                <th class="text-center align-middle">Gal qui</th>
                                <th class="text-center align-middle">Gal pra</th>
                                <th class="text-center align-middle">Gal ane</th>
                                <th class="text-center align-middle">Gal rad</th>
                                <th class="text-center align-middle">Gal kin</th>
                                <th class="text-center align-middle">Gas pens</th>
                                <th class="text-center align-middle">Gto quir</th>
                                <th class="text-center align-middle">Otros gtos</th>
                                <th class="text-center align-middle">Gto radi</th>
                                <th class="text-center align-middle">Porcentaje gral</th>
                                <th class="text-center align-middle">Paga categoria</th>
                                <th class="text-center align-middle">Aumento en liq</th>
                                <th class="text-center align-middle">Porcentaje hon</th>
                                <th class="text-center align-middle">Porcentaje gtos</th>
                                <th class="text-center align-middle">Porcentaje N1</th>
                                <th class="text-center align-middle">Porcentaje N2</th>
                                <th class="text-center align-middle">Porcentaje N3</th>
                                <th class="text-center align-middle">Val cons modulo</th>
                                <th class="text-center align-middle">Modelo generación txt</th>
                                <th class="text-center align-middle">Long orden</th>
                                <th class="text-center align-middle">Long n afiliado</th>
                                <th class="text-center align-middle">Observaciones</th>
                                <th class="text-center align-middle">Activo</th>
                            </tr>
                        </thead>
                        <tbody>';
                            // $peticion = mysqli_query($veja, "SELECT * FROM coberturas_sociales ORDER BY cobertura_social ASC");
                            // while($c = mysqli_fetch_assoc($peticion)){
                            //     echo '<tr>
                            //         <td>'.$c['cobertura_social'].'</td>
                            //         <td>'.$c['codigo'].'</td>
                            //         <td>'.$c['barra'].'</td>
                            //         <td>'.$c['plus'].'</td>
                            //         <td>'.$c['cupo_por_dia'].'</td>
                            //         <td>'.$c['domicilio'].'</td>
                            //         <td>'.$c['localidad'].'</td>
                            //         <td>'.$c['codigo_postal'].'</td>
                            //         <td>'.$c['provincia'].'</td>
                            //         <td>'.$c['telefono'].'</td>
                            //         <td>'.$c['fax'].'</td>
                            //         <td>'.$c['tipo'].'</td>
                            //         <td>'.$c['descripcion'].'</td>
                            //         <td>'.$c['long_barra'].'</td>
                            //         <td>'.$c['IDSocOtalm'].'</td>
                            //         <td>'.$c['categoria_iva'].'</td>
                            //         <td>'.$c['cuit'].'</td>
                            //         <td>'.$c['ingresos_brutos'].'</td>
                            //         <td>'.$c['val_con'].'</td>
                            //         <td>'.$c['gal_cli'].'</td>
                            //         <td>'.$c['gal_qui'].'</td>
                            //         <td>'.$c['gal_pra'].'</td>
                            //         <td>'.$c['gal_ane'].'</td>
                            //         <td>'.$c['gal_rad'].'</td>
                            //         <td>'.$c['gal_kin'].'</td>
                            //         <td>'.$c['gas_pens'].'</td>
                            //         <td>'.$c['gto_quir'].'</td>
                            //         <td>'.$c['otros_gtos'].'</td>
                            //         <td>'.$c['gto_radi'].'</td>
                            //         <td>'.$c['porcentaje_gral'].'</td>
                            //         <td>'.$c['paga_categoria'].'</td>
                            //         <td>'.$c['aumento_en_liq'].'</td>
                            //         <td>'.$c['porcentaje_hon'].'</td>
                            //         <td>'.$c['porcentaje_gtos'].'</td>
                            //         <td>'.$c['porcentaje_n1'].'</td>
                            //         <td>'.$c['porcentaje_n2'].'</td>
                            //         <td>'.$c['porcentaje_n3'].'</td>
                            //         <td>'.$c['val_cons_modulo'].'</td>
                            //         <td>'.$c['modelo_generacion_txt'].'</td>
                            //         <td>'.$c['long_orden'].'</td>
                            //         <td>'.$c['long_n_afiliado'].'</td>
                            //         <td>'.$c['observaciones'].'</td>
                            //         <td>'.$c['activo'].'</td>
                            //     </tr>';
                            // }
                        echo '</tbody>   
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="aaaaaaaa" role="tabpanel" aria-labelledby="aaaaaaaa-tab">...</div>
            <div class="tab-pane fade" id="bbbbbbb" role="tabpanel" aria-labelledby="bbbbbbb-tab">...</div>
        </div>
    </div>';
    mysqli_close($veja);
}
?>