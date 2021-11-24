<?php
session_start();
if(!isset($_SESSION['id'])){
header("Location: ..");
}else{
  require_once("../php/conn.php");
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!--EVITAR CACHE-->
		<meta http-equiv="Expires" content="0" />

		<meta http-equiv="Last-Modified" content="0" />

		<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate" />

		<meta http-equiv="Pragma" content="no-cache" />
		<!--FIN EVITAR CACHE-->


    <link rel="icon" type="image/png" href="../img/actives/icon.png">
    <title>Veja Moreno - Gestión</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/ohsnap.css">
    <link rel="stylesheet" href="../css/calendar/main.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/animate.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/jquery.mask.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <!-- <script src="../js/popper.min.js"></script> -->
    <script src="../js/bootstrap.js"></script>
    <script src="../js/calendar/main.min.js"></script>
    <script src="../js/calendar/locales/es.js"></script>
    <script src="../js/shortcut.js"></script>
    <script src="../js/ohsnap.js"></script>
    <script src="../js/moment.js"></script>
		<script>
			moment().format();
		</script>
    <script>
      $(function () {
          $('[data-toggle="popover"]').popover({
            trigger: 'click',
            delay: 50,
            html: true
          })
        })
    </script>
    <?php
    $color = mysqli_query($veja, "SELECT theme_color, font_theme_color FROM users WHERE id = '".$_SESSION['id']."' LIMIT 1");
    while($c = mysqli_fetch_assoc($color)){
      $theme_color = $c['theme_color'];
      $font_theme_color = $c['font_theme_color'];
      $fixed_theme_color = explode(",", $theme_color);
      $dark15 = ($fixed_theme_color[0] - 19).', '.($fixed_theme_color[1] - 57).', '.($fixed_theme_color[2] - 36);
      $dark10 = ($fixed_theme_color[0] - 13).', '.($fixed_theme_color[1] - 38).', '.($fixed_theme_color[2] - 24);
      $dark20 = ($fixed_theme_color[0] - 25).', '.($fixed_theme_color[1] - 77).', '.($fixed_theme_color[2] - 48);
      $lighten10 = ($fixed_theme_color[0] + 13).', '.($fixed_theme_color[1] + 38).', '.($fixed_theme_color[2] + 24);
      echo '<style id="coloresDeTema">
        body{
          background: rgba('.$theme_color.', 0.3);
        }

        .header{
          background: rgb('.$theme_color.');
        }

        .nav-tabs .nav-link{
          color: rgb('.$theme_color.');
        }

        .nav-tabs .nav-link.active{
          color: rgb('.$dark20.');
        }

        .modal .modal-header{
          background: rgb('.$theme_color.');
          color: rgb('.$font_theme_color.');
        }

        .content #seccionABMMedicos nav .navbar-brand, .content #seccionPrincipal nav .navbar-brand, .content #seccionAdministracion nav .navbar-brand, .content #contenedorCategoriaConfiguracionGeneral nav .navbar-brand{
          color: rgb('.$dark10.');
        }

        .content #turnosReservados table thead tr{
          color: rgb('.$font_theme_color.');
        }

        .header .fa-hospital-alt{
          color: rgb('.$font_theme_color.'); 
        }
        
        .header #veja_moreno{
          color: rgb('.$font_theme_color.'); 
        }

        .content #menuGeneral .categoria i{
          background: rgb('.$theme_color.');
          color: rgb('.$font_theme_color.'); 
        }

        .content #seccionABMMedicos #calendario .fc-highlight, .content #seccionPrincipal #calendario .fc-highlight {
          background: rgba('.$dark10.', 0.5);
        }

        .content #seccionABMMedicos #calendario .fc-scrollgrid-sync-inner .fc-col-header-cell-cushion, .content #seccionPrincipal #calendario .fc-scrollgrid-sync-inner .fc-col-header-cell-cushion {
          color: rgb('.$font_theme_color.');
        }

        .content #seccionABMMedicos #calendario .fc-day-today, .content #seccionPrincipal #calendario .fc-day-today {
          background: rgb('.$dark15.');
        }

        .urgencia{
          color: rgb('.$font_theme_color.');
        }

      </style>';
    }
    ?>
  </head>
  <body>
      <!--MODALS-->
        <!-------------------BANCOS----------------->
            <!--MODAL NUEVO BANCO-->
              <div class="modal fade" id="modalBanco" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalBancoTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nuevo Banco</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col text-right">
                          <label for="">Activo <input type="checkbox" checked id="modalBancoActivo"></label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <label for="modalBancoNombreBanco">Nombre</label>
                            <input type="text" class="form-control" id="modalBancoNombreBanco" placeholder="Nombre">
                          </div>
                        </div>
                      </div> 
                      <table class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <th clasS="text-left">Nombre</th>
                            <th clasS="text-center">Estado</th>
                            <th clasS="text-center">Acciones</th>
                          </tr>
                        </thead>
                        <tbody id="modalBancosContenido"></tbody>
                      </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Anular</button>
                        <button type="button" class="btn btn-success btn-sm" id="modalBancoGuardar">Guardar</button>
                    </div>
                    </div>
                </div>
              </div>
            <!--FIN MODAL NUEVO BANCO-->
            <!--MODAL EDITAR BANCO-->
              <div class="modal fade" id="modalEditarBanco" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEditarBancoTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nuevo Banco</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col text-right">
                          <label for="">Activo <input type="checkbox" checked id="modalEditarBancoActivo"></label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <label for="modalEditarBancoNombreBanco">Nombre</label>
                            <input type="text" class="form-control" id="modalEditarBancoNombreBanco" placeholder="Nombre">
                          </div>
                        </div>
                      </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Anular</button>
                        <button type="button" class="btn btn-success btn-sm" id="modalEditarBancoGuardar">Actualizar</button>
                    </div>
                    </div>
                </div>
              </div>
            <!--FIN MODAL EDITAR BANCO-->
            <!--MODAL CONFIRMAR ELIMINAR RUBRO-->
              <div class="modal fade" id="modalEliminarBanco" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEliminarBancoTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar Eliminar Banco</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <select id="modalEliminarBancoSeleccion" class="form-control custom-select">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Anular</button>
                        <button type="button" class="btn btn-success btn-sm" id="modalEliminarBancoBoton" disabled>Confirmar</button>
                    </div>
                    </div>
                </div>
                </div>
            <!--FIN MODAL CONFIRMAR ELIMINAR RUBRO-->
        <!-------------------FIN BANCOS----------------->
        <!-------------------AJUSTES----------------->
            <!--MODAL AJUSTE-->
              <div class="modal fade" id="modalAjuste" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalAjusteTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajustar Cantidad</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <label for="">Articulo: <b id="modalAjusteNombreArticulo"></b> - Stock min: <b id="modalAjusteStockMin"></b> - Unidades: <b id="modalAjusteCantidad"></b></label>
                            <input type="number" id="modalAjusteValor" class="form-control" placeholder="Valor de ajuste">
                          </div>
                        </div>
                      </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Anular</button>
                        <button type="button" class="btn btn-success btn-sm" id="modalAjusteGuardar">Ajustar</button>
                    </div>
                    </div>
                </div>
              </div>
            <!--FIN MODAL AJUSTE-->
        <!-------------------FIN AJUSTES----------------->
        <!-------------------STOCK----------------->
            <!--MODAL PROVEEDORES-->
              <div class="modal fade" id="modalProveedores" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalProveedoresTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Proveedor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-9"></div>
                            <div class="col-md-3 text-right">
                                <label>Activo <input type="checkbox" id="modalProveedoresActivo" checked></label>   
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="modalProveedoresNombre">Nombre / Razón Social</label>
                                    <input type="text" id="modalProveedoresNombre" class="form-control" placeholder="Nombre">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="modalProveedoresR_social">Condición IVA</label>
                                    <select id="modalProveedoresR_social" class="form-control custom-select" style="font-size: 15px;">
                                      <?php
                                        $razonSocial = mysqli_query($stock, "SELECT nombre FROM razon_social ORDER BY nombre ASC");
                                        while($rS = mysqli_fetch_assoc($razonSocial)){
                                            echo '<option value="'.$rS['nombre'].'">'.$rS['nombre'].'</option>';
                                        }
                                      ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="modalProveedoresCuit_cuil">CUIL/CUIT</label><span id="modalProveedoresInfoCuil" class="ml-2 text-danger"></span>
                                    <input type="text" id="modalProveedoresCuit_cuil" class="form-control text-center">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="modalProveedoresBanco">Banco</label>
                                    <select id="modalProveedoresBanco" class="form-control">
                                    <?php
                                      $peticion = mysqli_query($veja, "SELECT nombre FROM bancos ORDER BY nombre ASC");
                                      while($b = mysqli_fetch_assoc($peticion)){
                                        echo '<option value="'.$b['nombre'].'">'.$b['nombre'].'</option>';
                                      } 
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="modalProveedoresCBU">CBU</label>
                                    <input type="text" id="modalProveedoresCBU" class="form-control text-center">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="modalProveedoresAlias">Alias</label>
                                    <input type="text" id="modalProveedoresAlias" placeholder="Alias" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="modalProveedoresDomicilio">Domicilio</label>
                                    <input type="text" id="modalProveedoresDomicilio" placeholder="Domicilio" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="modalProveedoresTelefono">Teléfono</label>
                                    <input type="text" id="modalProveedoresTelefono" placeholder="Teléfono" class="form-control text-center">
                                </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="modalProveedoresCelular">Celular</label>
                                <input type="text" id="modalProveedoresCelular" placeholder="Celular" class="form-control text-center">
                              </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modalProveedoresEmail">Email</label>
                                    <input type="text" class="form-control" id="modalProveedoresEmail" placeholder="Email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="modalProveedoresObs">Observación</label>
                                    <textarea id="modalProveedoresObs" class="form-control" placeholder="Observaciones"></textarea>   
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Anular</button>
                        <button type="button" class="btn btn-success btn-sm" id="modalProveedoresGuardar">Guardar proveedor</button>
                    </div>
                    </div>
                </div>
                </div>
            <!--FIN MODAL PROVEEDORES-->
            <!--MODAL NUEVO ITEM-->
              <div class="modal fade" id="modalNuevoItem" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalNuevoItemTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Crear Grupo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-9"></div>
                            <div class="col-md-3 text-right">
                                <div class="form-group">
                                    <label for="modalNuevoItemActivo">Activo <input type="checkbox" checked id="modalNuevoItemActivo"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="modalNuevoItemNombre">Nombre</label>
                                    <input type="text" id="modalNuevoItemNombre" class="form-control" placeholder="Nombre">   
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="modalNuevoItemDescripcion">Descripción</label>
                                    <textarea id="modalNuevoItemDescripcion" class="form-control" placeholder="Descripción"></textarea>   
                                </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="modalNuevoItemRubro">Rubro</label>
                                <select class="form-control" id="modalNuevoItemRubro"></select>
                              </div>
                            </div>
                            <div class="col-md-12">
                            <div class="form-group">
                                <label for="modalNuevoItemObservaciones">Observaciones</label>
                                <input type="text" id="modalNuevoItemObservaciones" class="form-control" placeholder="Observaciones">   
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="modalNuevoItemAnular">Anular</button>
                        <button type="button" class="btn btn-success btn-sm" id="modalNuevoItemGuardar">Guardar</button>
                    </div>
                    </div>
                </div>
                </div>
            <!-- FIN MODAL NUEVO ITEM-->
            <!--MODAL AGREGAR NUEVO ITEM A COMPROBANTE-->
              <div class="modal fade" id="modalAgregarNuevoArticuloAComprobante" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalAgregarNuevoArticuloAComprobanteTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Completar Comprobante</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="contenido_tabla-completar-comprobante"></div>
                        <div class="row mt-3">
                          <div class="col" style="max-width: 125px;">
                              <div class="form-group">
                                  <label for="modalAgregarArticuloPrecioCosto">Precio U</label>
                                  <input type="text" class="form-control" placeholder="Costo" id="modalAgregarArticuloPrecioCosto">
                              </div>
                          </div>
                          <div class="col" style="max-width: 105px">
                              <div class="form-group">
                                  <label for="modalAgregarArticuloCantidad">Cantidad</label>
                                  <input type="text" class="form-control" placeholder="Cant" id="modalAgregarArticuloCantidad">
                              </div>
                          </div>
                          <div class="col" style="max-width: 200px;">
                              <div class="form-group">
                                  <label for="modalAgregarArticuloNLote">N° de lote</label>
                                  <input type="text" class="form-control" placeholder="N° de lote" id="modalAgregarArticuloNLote">
                              </div>
                          </div>
                          <div class="col" style="max-width:220px;">
                              <div class="form-group">
                                  <label for="modalAgregarArticuloVencimiento">Vencimiento</label>
                                  <input type="date" class="form-control" placeholder="Vencimiento" id="modalAgregarArticuloVencimiento">
                              </div>
                          </div>
                          <div class="col">
                              <div class="form-group">
                                  <label for="modalAgregarArticuloMarca">Marca</label>
                                  <input type="text" class="form-control" placeholder="Marca" id="modalAgregarArticuloMarca">
                              </div>
                          </div>
                          <div class="col-md-1" id="dioptriasDelLente" style="display: none;">
                            <div class="form-group">
                              <label for="valorDioptria">Diop</label>
                              <input type="text" id="valorDioptria" placeholder="Valor" class="form-control text-center">
                            </div>
                          </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="modalAgregarNuevoArticuloAComprobanteAnular">Anular</button>
                        <button disabled type="button" class="btn btn-success btn-sm" id="modalAgregarNuevoArticuloAComprobanteGuardar">Agregar</button>
                    </div>
                    </div>
                </div>
                </div>
            <!-- FIN MODAL AGREGAR NUEVO ITEM A COMPROBANTE-->
            <!--MODAL RUBROS-->
                <div class="modal fade" id="modalRubros" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalRubrosTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Rubro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="modalRubrosNombre">Nombre</label>
                                    <input type="text" class="form-control" placeholder="Nombre" id="modalRubrosNombre">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="modalRubrosEstado">Estado</label>
                                    <select id="modalRubrosEstado" class="form-control custom-select">
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                              <div class="form-group">
                                <label for="modalRubrosDioptria">Permite Dioptria</label>
                                <select class="form-control" id="modalRubrosDioptria">
                                  <option value="0" selected>NO</option>
                                  <option value="1">SI</option>
                                </select>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="modalRubrosObservacion">Observación</label>
                                    <textarea class="form-control" placeholder="Observación" id="modalRubrosObservacion"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Anular</button>
                        <button type="button" class="btn btn-success btn-sm" id="modalRubrosGuardar">Guardar rubro</button>
                    </div>
                    </div>
                </div>
                </div>
            <!--FIN MODAL RUBROS-->
            <!--MODAL AGREGAR ARTICULO-->
                <div class="modal fade" id="modalAgregarArticulo" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalAgregarArticuloTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Agregar Nuevo Artículo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="modalAgregarArticuloContenido"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="modalAgregarArticuloAnular">Anular</button>
                            <button type="button" class="btn btn-success btn-sm" id="modalAgregarArticuloGuardar">Confirmar</button>
                        </div>
                        </div>
                    </div>
                </div>
            <!--FIN MODAL AGREGAR ARTICULO-->
            <!--MODAL EDITAR EXISTECNIAS-->
                <div class="modal fade" id="modalItemAltaBaja" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalItemAltaBajaLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalItemAltaBajaLabel">Ajustar Ítem</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="modalItemAltaBajaContenido"></div>  
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="modalItemAltaBajaAnular">Anular</button>
                        <button type="button" class="btn btn-success btn-sm" id="modalItemAltaBajaBoton">Aplicar</button>
                    </div>
                    </div>
                </div>
                </div>
            <!--FIN MODAL EDITAR EXISTENCIAS-->
            <!--MODAL CONFIRMAR ELIMINAR RUBRO-->
                <div class="modal fade" id="modalEliminarRubro" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEliminarRubroTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar Eliminar De Rubro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <select id="modalEliminarRubroSeleccion" class="form-control custom-select">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Anular</button>
                        <button type="button" class="btn btn-success btn-sm" id="modalEliminarRubroBoton" disabled>Confirmar</button>
                    </div>
                    </div>
                </div>
                </div>
            <!--FIN MODAL CONFIRMAR ELIMINAR RUBRO-->
            <!--MODAL CONFIRMAR ELIMINAR EXISTENCIA-->
                <div class="modal fade" id="modalEliminarArticulo" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEliminarArticuloTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar Eliminar Artículo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <select id="modalEliminarArticuloSeleccion" class="form-control custom-select">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Anular</button>
                        <button type="button" class="btn btn-success btn-sm" id="modalEliminarArticuloBoton" disabled>Confirmar</button>
                    </div>
                    </div>
                </div>
                </div>
            <!--FIN MODAL CONFIRMAR ELIMINAR EXISTENCIA-->
            <!--MODAL CONFIRMAR ELIMINAR PROVEEDOR-->
                <div class="modal fade" id="modalEliminarProveedor" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEliminarProveedorTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar Eliminar Proveedor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <select id="modalEliminarProveedorSeleccion" class="form-control custom-select">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Anular</button>
                        <button type="button" class="btn btn-success btn-sm" id="modalEliminarProveedorBoton" disabled>Confirmar</button>
                    </div>
                    </div>
                </div>
                </div>
            <!--FIN MODAL CONFIRMAR ELIMINAR PROVEEDOR-->
            <!--MODAL CONFIRMAR ELIMINAR ITEM-->
                <div class="modal fade" id="modalEliminarItem" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEliminarItemTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar Eliminar Ítem</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center text-danger mb-3"><b>ADVERTENCIA ESTA ACCIÓN ELIMINARÁ TODOS LOS DATOS VINCULADOS A ESTE GRUPO</b></div> 
                        <div class="form-group">
                            <select id="modalEliminarItemSeleccion" class="form-control custom-select">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Anular</button>
                        <button type="button" class="btn btn-success btn-sm" id="modalEliminarItemBoton" disabled>Confirmar</button>
                    </div>
                    </div>
                </div>
                </div>
            <!--FIN MODAL CONFIRMAR ELIMINAR ITEM-->
            <!--MODAL CONFIRMAR EGRESO-->
              <div class="modal fade" id="modalConfirmarEgreso" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalConfirmarEgresoTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar Egreso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <select id="modalConfirmarEgresoSeleccion" class="form-control custom-select">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Anular</button>
                        <button type="button" class="btn btn-success btn-sm" id="modalConfirmarEgresoBoton" disabled>Confirmar</button>
                    </div>
                    </div>
                </div>
              </div>
            <!--FIN MODAL CONFIRMAR EGRESO-->
            <!--MODAL VER COMPROBANTE-->
              <div class="modal fade" id="modalVerComprobante" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalConfirmarEgresoTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalles del comprobante</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="modalVerComprobanteContenido"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Listo</button>
                    </div>
                    </div>
                </div>
              </div>
            <!--FIN MODAL VER COMPROBANTE-->
            <!--MODAL MODIFICAR RUBRO-->
                <div class="modal fade" id="modalModificarRubro" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalModificarRubroTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Modificar Rubro</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="respuestaModalModificarRubro"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Anular</button>
                            <button type="button" class="btn btn-success btn-sm" id="modalModificarRubroBoton">Actualizar</button>
                        </div>
                        </div>
                    </div>
                </div>
            <!--FIN MODAL MODIFICAR RUBRO-->
            <!--MODAL MODIFICAR PROVEEDOR-->
                <div class="modal fade" id="modalModificarProveedor" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalModificarProveedorTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Modificar Proveedor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="respuestaModalModificarProveedor"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Anular</button>
                            <button type="button" class="btn btn-success btn-sm" id="modalModificarProveedorBoton">Actualizar</button>
                        </div>
                        </div>
                    </div>
                </div>
            <!--FIN MODAL MODIFICAR PROVEEDOR-->
            <!--MODAL MODIFICAR EXISTENCIA-->
                <div class="modal fade" id="modalModificarArticulo" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalModificarArticuloTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Modificar Artículo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="respuestaModalModificarArticulo"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Anular</button>
                            <button type="button" class="btn btn-success btn-sm" id="modalModificarArticuloBoton">Actualizar</button>
                        </div>
                        </div>
                    </div>
                </div>
            <!--FIN MODAL MODIFICAR EXISTENCIA-->
            <!--MODAL MODIFICAR ITEM-->
                <div class="modal fade" id="modalModificarItem" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalModificarItemTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Modificar Ítem</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="respuestaModalModificarItem"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Anular</button>
                            <button type="button" class="btn btn-success btn-sm" id="modalModificarItemBoton">Actualizar</button>
                        </div>
                        </div>
                    </div>
                </div>
            <!--FIN MODAL MODIFICAR ITEM-->
            <!--MODAL VER PROVEEDOR-->
                <div class="modal fade" id="modalVerProveedor" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalVerProveedorTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                      <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title">Detalles Del Proveedor</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div id="modalVerProveedorDetalles"></div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Listo</button>
                      </div>
                      </div>
                  </div>
                </div>
            <!--FIN MODAL VER PROVEEDOR-->
            <!--MODAL VER ITEM-->
                <div class="modal fade" id="modalVerItem" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalVerItemTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalles del Ítem</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="modalVerItemDetalles"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Listo</button>
                    </div>
                    </div>
                </div>
                </div>
            <!--FIN MODAL VER ITEM-->
            <!--MODAL VER EXISTENCIA-->
                <div class="modal fade" id="modalVerExistencia" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalVerItemTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalles Del Artículo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="modalVerExistenciaDetalles"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Listo</button>
                    </div>
                    </div>
                </div>
                </div>
            <!--FIN MODAL VER EXISTENCIA-->
            <!--MODAL STOCK BAJO-->
                <div class="modal fade" id="modalBajoStock" tabindex="-1" role="dialog" aria-labelledby="modalBajoStockLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalBajoStockLabel">ADVERTENCIA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>Verificar Los Siguietnes Artículos</h5>
                        <div id="modalBajoStockContenido"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Entendido</button>
                    </div>
                    </div>
                </div>
                </div>
            <!--FIN MODAL STOCK BAJO-->
        <!-------------------FIN STOCK----------------->

        <!-------------------MENSAJES----------------->
          <!--VER MENSAJES-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalVerMensaje" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalVerDoctorLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Mensaje</h5>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-12">
                        <small class="font-weight-bold">Fecha: </small><span id="fechaMensaje"></span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <small class="font-weight-bold">Remitente: </small><span id="remitenteMensaje"></span>
                      </div>
                      <div class="col">
                        <small class="font-weight-bold">Destino: </small><span id="destinoMensaje"></span>
                      </div>
                    </div>
                    <div class="row mt-3">
                      <div class="col">
                        <b>Asunto: </b><span id="asuntoMensaje"></span>
                      </div>
                    </div>
                    <div class="row mt-3">
                      <div class="col">
                        <b class="font-weight-bold">Mensaje</b>
                        <span id="contenidoMensaje"></span>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-block" id="mensajeLeido" data-dismiss="modal">Listo</button>
                  </div>
                </div>
              </div>
            </div>
          <!--FIN VER MENSAJES-->
          <!--NUEVO MENSAJE-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalNuevoMensaje" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalVerDoctorLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Nueva notificación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-8">
                        <div class="form-group">
                          <label for="modalNuevoMensajeDestino" class="font-weight-bold">Destino: </label>
                          <select class="form-control custom-select" id="modalNuevoMensajeDestino">
                            <?php
                              $peticion = mysqli_query($veja, "SELECT id, user, apellido, nombre FROM users ORDER BY apellido ASC");
                              while($d = mysqli_fetch_assoc($peticion)){
                                echo '<option value="'.$d['id'].'">'.$d['user'].' - '.$d['apellido'].', '.$d['nombre'].'</option>';
                              }
                            ?>
                          </select>
                        </div>

                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="modalNuevoMensajeAsunto" class="font-weight-bold">Asunto</label>
                          <textarea class="form-control" id="modalNuevoMensajeAsunto" cols="30" rows="2"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="modalNuevoMensajeMensaje" class="font-weight-bold">Mensaje</label>
                          <textarea class="form-control" id="modalNuevoMensajeMensaje" cols="30" rows="3"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="modalNuevoMensajePrioridad" class="font-weight-bold">Prioridad</label>
                          <select class="form-control" id="modalNuevoMensajePrioridad">
                            <option value="0">Baja</option>
                            <option value="1" selected>Normal</option>
                            <option value="2">Alta</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-block" id="modalNuevoMensajeBoton">Guardar notificación</button>
                  </div>
                </div>
              </div>
            </div>
          <!--FIN NUEVO MENSAJE-->
          <!--EDITAR MENSAJE-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalEditarMensaje" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalVerDoctorLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Editar notificación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-8">
                        <div class="form-group">
                          <label for="modalEditarMensajeDestino" class="font-weight-bold">Destino: </label>
                          <select class="form-control custom-select" id="modalEditarMensajeDestino">
                            <?php
                              $peticion = mysqli_query($veja, "SELECT id, user, apellido, nombre FROM users ORDER BY apellido ASC");
                              while($d = mysqli_fetch_assoc($peticion)){
                                echo '<option value="'.$d['id'].'">'.$d['user'].' - '.$d['apellido'].', '.$d['nombre'].'</option>';
                              }
                            ?>
                          </select>
                        </div>

                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="modalEditarMensajeAsunto" class="font-weight-bold">Asunto</label>
                          <textarea class="form-control" id="modalEditarMensajeAsunto" cols="30" rows="2"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="modalEditarMensajeMensaje" class="font-weight-bold">Mensaje</label>
                          <textarea class="form-control" id="modalEditarMensajeMensaje" cols="30" rows="3"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="modalEditarMensajePrioridad" class="font-weight-bold">Prioridad</label>
                          <select class="form-control custom-select" id="modalEditarMensajePrioridad">
                            <option value="0">Baja</option>
                            <option value="1" selected>Normal</option>
                            <option value="2">Alta</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="modalEditarMensajeEstado" class="font-weight-bold">Estado</label>
                          <select class="form-control custom-select" id="modalEditarMensajeEstado">
                              <option value="0">Leido</option>
                              <option value="1">Sin leer</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-block" id="modalEditarMensajeBoton" data-dismiss="modal">Editar notificación</button>
                  </div>
                </div>
              </div>
            </div>
          <!--FIN EDITAR MENSAJE-->
          <!--MODAL CONFIRMAR ELIMINAR MENSAJE-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalEliminarMensaje" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEliminarMensajeLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Eliminar mensaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body text-center">
                    <h5 class="text-danger">¿Confirma la eliminación del mensaje?</h5>
                    <div class="form-group">
                      <label for="modalEliminarMensajeConfirmacion"></label>
                      <select class="form-control custom-select" id="modalEliminarMensajeConfirmacion">
                        <option value="0">NO</option>
                        <option value="1">SI</option>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button id="modalEliminarMensajeBoton" type="button" class="btn btn-danger btn-sm" disabled>Eliminar mensaje</button>
                  </div>
                </div>
              </div>
            </div>
          <!--MODAL FIN CONFIRMAR ELIMINAR MENSAJE-->
        <!-------------------FIN MENSAJES----------------->

        <!-------------------MEDICOS----------------->
          <!--MODAL ELIMINAR DOCTOR-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalDoctoresCargadosElimnar" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalDoctoresCargadosElimnarLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="modalDoctoresCargadosElimnarLabel">Esta a punto de eliminar un doctor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                    Confirme la aliminación del doctor
                    </div>
                    <div class="modal-footer">
                    <button id="modalDoctoresCargadosElimnarBoton" data-id="" onclick="eliminarDoctor($(this).attr('data-id'))" type="button" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
                </div>
            </div>
          <!--FIN MODAL ELIMINAR DOCTOR-->
          <!--VER DOCTOR-->
            <!-- <div class="modal fade animate__animated animate__bounceInUp" id="modalVerDoctor" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalVerDoctorLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalVerDoctorLabel">Detalles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                      <div class="row">
                        <div class="col-6">
                          <img id="modalVerDoctorAvatar" src="#" class="card-img-top">
                        </div>
                        <div class="col-6">
                          <p><small class="font-weight-bold">Matricula:</small> <span id="modalVerDoctorCodigo"></span></p>
                          <p><small class="font-weight-bold">Fecha de matricula:</small> <span id="modalVerDoctorMatricula"></span></p>
                          <p><small class="font-weight-bold">DNI:</small> <span id="modalVerDoctorDNI"></span></p>
                          <p><small class="font-weight-bold">Domicilio:</small> <span id="modalVerDoctorDomicilio"></span></p>
                          <p><small class="font-weight-bold">Tel particular:</small> <span id="modalVerDoctorTelPart"></span></p>
                          <p><small class="font-weight-bold">Tel consultorio:</small> <span id="modalVerDoctorTelCons"></span></p>
                          <p><small class="font-weight-bold">Celular:</small> <span id="modalVerDoctorCelular"></span></p>
                          <p><small class="font-weight-bold">Especialidad:</small> <span id="modalVerDoctorEspecialidad"></span></p>
                          <p><small class="font-weight-bold">Anestesista:</small> <span id="modalVerDoctorAnestesista"></span></p>
                          <p><small class="font-weight-bold">Observaciones:</small> <span id="modalVerDoctorObservacion"></span></p>
                        </div>
                      </div>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Listo</button>
                  </div>
                </div>
              </div>
            </div> -->
          <!--FIN VER DOCTOR-->
          <!--MODAL GUARDAR MEDICO-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalGuardarMedico" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalGuardarMedicoLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalGuardarMedicoLabel">Nuevo médico</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    
                      <div class="row">
                          <div class="col">
                              <div class="custom-control custom-checkbox mr-sm-2 text-right">
                              <input disabled type="checkbox" class="custom-control-input" id="estadoMedico" checked>
                              <label class="custom-control-label" for="estadoMedico">Activo</label>
                              </div>
                          </div>
                      </div>
                    
                      <div class="row">
                          <div class="col-md-2">
                              <div class="form-group">
                              <label for="codigoMedico">Matricula</label>
                              <input type="text" id="codigoMedico" class="form-control" placeholder="Matricula">
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="apellidoMedico">Apellido</label>
                                  <input disabled type="text" id="apellidoMedico" class="form-control" placeholder="Apellido">
                              </div>
                          </div>
                    
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="nombreMedico">Nombre</label>
                                  <input disabled type="text" id="nombreMedico" class="form-control" placeholder="Nombre">
                              </div>
                          </div>

                          <div class="col-md-2">
                              <div class="form-group">
                              <label id="labelDniMedico" for="dniMedico">N° de documento</label>
                              <input disabled class="form-control" type="text" id="dniMedico" placeholder="DNI del medico">
                              </div>
                          </div>
                      </div>
                    
                      <div class="row">

                          <div class="col-md-3" style="max-width: 220px;">
                              <div class="form-group">
                                  <label for="celMedico">N° de celular</label>
                                  <input disabled type="text" id="celMedico" class="form-control text-center" placeholder="N° de celular">
                              </div>
                          </div>

                          <div class="col-md-2">
                              <div class="form-group">
                                  <label for="telParticularMedico">Teléfono particular</label>
                                  <input disabled type="text" id="telParticularMedico" class="form-control text-center" placeholder="Teléfono particular">
                              </div>
                          </div>

                          <div class="col-md-2">
                              <div class="form-group">
                                  <label for="telefonoConsultorio">Teléfono consultorio</label>
                                  <input disabled type="text" id="telefonoConsultorio" class="form-control text-center" placeholder="Teléfono consultorio">
                              </div>
                          </div>

                          <div class="col">
                              <div class="form-group">
                                  <label for="domicilioMedico">Domicilio</label>
                                  <input disabled type="text" id="domicilioMedico" class="form-control" placeholder="Domicilio">
                              </div>
                          </div>

                      </div>
                    
                      <div class="row">
                          <div class="col" style="max-width:220px;">
                              <div class="form-group">
                                  <label for="fechaMatricula">Fecha de matricula</label>
                                  <input disabled type="date" id="fechaMatricula" class="form-control" placeholder="Fecha de matricula">
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label for="especialidadMedico">Especialidad</label>
                                  <select disabled id="especialidadMedico" class="form-control custom-select">
                                      <option value="0">ESPECIALIDAD</option>
                                      <?php
                                      $peticion = mysqli_query($veja, "SELECT * FROM especialidades ORDER BY especialidad ASC");
                                      while($e = mysqli_fetch_assoc($peticion)){
                                          echo '<option value="'.$e['id'].'">'.$e['especialidad'].'</option>';
                                      }
                                      ?>
                                  </select>
                              </div>
                          </div>
                          <!-- <div class="col">
                            <div class="form-group">
                              <label for="anestesista">Anestesista</label>
                              <select disabled class="form-control" id="anestesista">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                              </select>
                            </div>
                          </div> -->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="userMedico">Usuario</label>
                              <select disabled class="custom-select" id="userMedico">
                                <?php
                                  $peticion = mysqli_query($veja, "SELECT id, user, nombre, apellido FROM users WHERE activo = '1' ORDER BY nombre ASC");
                                  while($u = mysqli_fetch_assoc($peticion)){
                                      echo "<option value=".$u['id'].">".$u['user']." - ".$u['apellido']." ".$u['nombre']."</option>";
                                  }
                                ?>
                              </select>
                            </div>
                          </div>
                      </div>
                    
                      <div class="row">
                          <div class="col">
                          <div class="form-group">
                              <label for="observacionMedico">Observaciones</label>
                              <textarea disabled id="observacionMedico" class="form-control" placeholder="Observaciones"></textarea>
                          </div>
                          </div>
                      </div>

                      <div class="row">
                        <div class="col">
                          <label>Anestesista
                            <input type="checkbox" name="" id="anestesista">
                          </label>
                        </div>
                        <div class="col">
                          <label for="">Técnico/a
                            <input type="checkbox" name="" id="">
                          </label>
                        </div>
                        <div class="col">
                          <label for="">Enfermero/a
                            <input type="checkbox" name="" id="">
                          </label>
                        </div>
                        <div class="col">
                          <label for="">Turnos Web
                            <input type="checkbox" name="" id="">
                          </label>
                        </div>
                      </div>
                    
                      <div class="row">
                          <div class="col">
                              <div class="text-right">
                              <button id="botonGuardarDatosMedico" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalGuardarDatosMedico">Guardar datos</button>
                              </div>
                          </div>
                      </div>

                  </div>
                </div>
              </div>
            </div>
          <!--FIN MODAL GUARDAR MEDICO-->
          <!--OPCIONES MEDICOS-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalOpcionesMedico" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalOpcionesMedicoLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalOpcionesMedicoLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="datosConsulta-tab" data-toggle="tab" href="#datosConsulta" role="tab" aria-controls="datosConsulta" aria-selected="false"><i class="fas fa-info-circle"></i> Datos de consulta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="cronograma-tab" data-toggle="tab" href="#cronograma" role="tab" aria-controls="cronograma" aria-selected="false"><i class="fas fa-stopwatch"></i> Cronograma</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="otrosHorarios-tab" data-toggle="tab" href="#otrosHorarios" role="tab" aria-controls="otrosHorarios" aria-selected="false"><i class="fas fa-user-clock"></i> Otros horarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="coberturasMedicas-tab" data-toggle="tab" href="#coberturasMedicas" role="tab" aria-controls="coberturasMedicas" aria-selected="false"><i class="fas fa-comment-medical"></i> Coberturas medicas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="diaSinAtencionMedico-tab" data-toggle="tab" href="#diaSinAtencionMedico" role="tab" aria-controls="diaSinAtencionMedico" aria-selected="false"><i class="far fa-calendar-times"></i> Dias sin atención</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <!--DATOS CONSULTA-->
                          <div class="tab-pane fade show active mt-4" id="datosConsulta" role="tabpanel" aria-labelledby="datosConsulta-tab">
                            
                            <div class="row">
                              <div class="col">
                                <div class="form-group text-right">
                                  <label for="ABMestadoMedico">Activo: <input type="checkbox" id="ABMestadoMedico"></label>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-3">
                                  <div class="contenedorImagenMedico">
                                    <img id="ABMImagenMedico" src="" class="img-fluid">
                                    <i id="ABMBotonCambiarImagenMedico" title="Cambiar foto" role="button" data-usuario="" class="far fa-image text-success"></i>
                                  </div>
                              </div>
                              <div class="col-md-9">
                                <div class="row">
                                  <div class="col-md-2 text-center" style="max-width: 100px;">
                                    <div class="form-group">
                                      <label for="ABMnumeroMatriculaMedico">Matricula</label>
                                      <input type="text" class="form-control text-center" id="ABMnumeroMatriculaMedico" style="width: 75px;">
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label for="ABMfechaMatriculaMedico">Fecha</label>
                                      <input type="date" class="form-control" id="ABMfechaMatriculaMedico">
                                    </div>
                                  </div>
                                  <div class="col">
                                    <div class="form-group">
                                      <label for="ABMapellidoMedico">Apellido</label>
                                      <input type="text" class="form-control" id="ABMapellidoMedico">
                                    </div>
                                  </div>
                                  <div class="col">
                                    <div class="form-group">
                                      <label for="ABMnombreMedico">Nombre</label>
                                      <input type="text" class="form-control" id="ABMnombreMedico">
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-2">
                                    <div class="form-group">
                                      <label for="ABMdniMedico">DNI</label>
                                      <input type="text" class="form-control" id="ABMdniMedico">
                                    </div>
                                  </div>
                                  <div class="col">
                                    <div class="form-group">
                                      <label for="ABMdomicilioMedico">Domicilio</label>
                                      <input type="text" class="form-control" id="ABMdomicilioMedico">
                                    </div>
                                  </div>
                                  <div class="col">
                                    <label for="ABMtelefono_particularMedico">Teléfono particular</label>
                                    <input type="text" class="form-control" id="ABMtelefono_particularMedico">
                                  </div>
                                  <div class="col">
                                    <label for="ABMtelefono_consultorioMedico">Teléfono consultorio</label>
                                    <input type="text" class="form-control" id="ABMtelefono_consultorioMedico">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-3">
                                    <label for="ABMcelularMedico">Celular</label>
                                    <input type="text" class="form-control" id="ABMcelularMedico">
                                  </div>
                                  <div class="col-2">
                                      <div class="form-group">
                                        <label for="ABMusuarioMedico">Usuario</label>
                                        <select class="form-control custom-select" id="ABMusuarioMedico">
                                          <?php
                                            $peticion = mysqli_query($veja, "SELECT id, user, apellido, nombre FROM users ORDER BY apellido ASC");
                                            while($u = mysqli_fetch_assoc($peticion)){
                                              echo '<option value="'.$u['id'].'">'.$u['user'].'</option>'; 
                                            }
                                          ?>  
                                        </select>
                                      </div>
                                  </div>
                                  <div class="col-3">
                                    <div class="form-group">
                                      <label for="ABMespecialidadMedico">Especialidad</label>
                                      <select class="form-control custom-select" id="ABMespecialidadMedico">
                                      <?php
                                        $peticion = mysqli_query($veja, "SELECT id, especialidad FROM especialidades ORDER BY especialidad ASC");
                                        while($u = mysqli_fetch_assoc($peticion)){
                                          echo '<option value="'.$u['id'].'">'.$u['especialidad'].'</option>'; 
                                        }
                                      ?>  
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-2">
                                    <div class="form-group">
                                      <label for="ABManestesistaMedico">Anestesista</label>
                                      <select class="form-control custom-select" id="ABManestesistaMedico">
                                        <option value="0">NO</option>
                                        <option value="1">SI</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col">
                                <div class="form-group">
                                  <label for="ABMobservacionesMedico">Observaciones</label>
                                  <textarea class="form-control" id="ABMobservacionesMedico"></textarea>
                                </div>
                              </div>
                            </div>
                          
                            <div class="row">
                              <div class="col text-right">
                                <div class="form-group">
                                  <button class="btn btn-success btn-sm" id="ABMBotonActualizarMedico" onclick="actualizarDoctor()">Actualizar</button>
                                </div>
                              </div>
                            </div>

                            

                          </div>
                        <!--FINDATOS CONSULTA-->
                        <!--ABM CRONOGRAMA-->
                            <div class="tab-pane fade mt-4" id="cronograma" role="tabpanel" aria-labelledby="cronograma-tab">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Datos de contacto</label><br>
                                            <small><i class="fas fa-phone-alt mr-1 text-primary"></i><b>Teléfono:</b><span id="infoTel" class="ml-1">-</span></small><br>  
                                            <small><i class="fab fa-whatsapp mr-1 text-success"></i><b>Whatsapp:</b><span id="infoWhatsapp" class="ml-1">-</span></small>   
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Tiempo de atención por día</label>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center align-middle"><i class="fas fa-clinic-medical"></i></th>
                                                        <th class="text-center">lunes<span id="infoL"></span></th>
                                                        <th class="text-center">martes<span id="infoM"></span></th>
                                                        <th class="text-center">miercoles<span id="infoX"></span></th>
                                                        <th class="text-center">jueves<span id="infoJ"></span></th>
                                                        <th class="text-center">viernes<span id="infoV"></span></th>
                                                        <th class="text-center">sabado<span id="infoS"></span></th>
                                                        <th class="text-center">domingo<span id="infoD"></span></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                      <td class="text-left align-middle"><span class="mr-2">Lpaso de consulta / Minutos</span></td>
                                                      <td><input type="number" min="1" step="1" data-dia="lun" class="form-control text-center" id="tiempoAtencionLun"></td>
                                                      <td><input type="number" min="1" step="1" data-dia="mar" class="form-control text-center" id="tiempoAtencionMar"></td>
                                                      <td><input type="number" min="1" step="1" data-dia="mie" class="form-control text-center" id="tiempoAtencionMie"></td>
                                                      <td><input type="number" min="1" step="1" data-dia="jue" class="form-control text-center" id="tiempoAtencionJue"></td>
                                                      <td><input type="number" min="1" step="1" data-dia="vie" class="form-control text-center" id="tiempoAtencionVie"></td>
                                                      <td><input type="number" min="1" step="1" data-dia="sab" class="form-control text-center" id="tiempoAtencionSab"></td>
                                                      <td><input type="text" class="form-control text-center" id="tiempoAtencionDom"></td>
                                                    </tr>
                                                    <tr>
                                                      <td class="text-left align-middle"><span class="mr-2">Consultorio</span></td>
                                                      <td>
                                                        <select class="form-control text-center" id="consultorioLun">
                                                          <option value="-">-</option>
                                                          <option value="1">C1</option>
                                                          <option value="2">C2</option>
                                                          <option value="3">C3</option>
                                                        </select>
                                                      </td>
                                                      <td>
                                                        <select class="form-control text-center" id="consultorioMar">
                                                          <option value="-">-</option>
                                                          <option value="1">C1</option>
                                                          <option value="2">C2</option>
                                                          <option value="3">C3</option>
                                                        </select>
                                                      </td>
                                                      <td>
                                                        <select class="form-control text-center" id="consultorioMie">
                                                          <option value="-">-</option>
                                                          <option value="1">C1</option>
                                                          <option value="2">C2</option>
                                                          <option value="3">C3</option>
                                                        </select>
                                                      </td>
                                                      <td>
                                                        <select class="form-control text-center" id="consultorioJue">
                                                          <option value="-">-</option>  
                                                          <option value="1">C1</option>
                                                          <option value="2">C2</option>
                                                          <option value="3">C3</option>
                                                        </select>
                                                      </td>
                                                      <td>
                                                        <select class="form-control text-center" id="consultorioVie">
                                                          <option value="-">-</option>
                                                          <option value="1">C1</option>
                                                          <option value="2">C2</option>
                                                          <option value="3">C3</option>
                                                        </select>
                                                      </td>
                                                      <td>
                                                        <select class="form-control text-center" id="consultorioSab">
                                                          <option value="-">-</option>
                                                          <option value="1">C1</option>
                                                          <option value="2">C2</option>
                                                          <option value="3">C3</option>
                                                        </select>
                                                      </td>
                                                      <td>
                                                        <select class="form-control text-center" id="consultorioDom">
                                                          <option value="-">-</option>
                                                          <option value="1">C1</option>
                                                          <option value="2">C2</option>
                                                          <option value="3">C3</option>
                                                        </select>
                                                      </td>
                                                    </tr>
                                                </tbody>
                                            </table>         
                                        </div>
                                    </div>
                                </div>
                                <h5>Horarios Semanales</h5>
                                  <table class="table table-striped table-hover mb-3">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Turno</th>
                                            <th class="text-center">Lunes<span id="infoSemL"></span></th>
                                            <th class="text-center">Martes<span id="infoSemM"></span></th>
                                            <th class="text-center">Miercoles<span id="infoSemX"></span></th>
                                            <th class="text-center">Jueves<span id="infoSemJ"></span></th>
                                            <th class="text-center">Viernes<span id="infoSemV"></span></th>
                                            <th class="text-center">Sabado<span id="infoSemS"></span></th>
                                            <th class="text-center">Domingo<span id="infoSemD"></span></th>
                                        </tr>
                                    </thead>
                                    <tbody id="listaHorariosSemanales"></tbody>
                                  </table>
                                  <div class="row">
                                    <div class="col-md-5">
                                      <h5>Días Sin Atención</h5>
                                      <div id="diasSinAtencion"></div>
                                    </div> 
                                    <div class="col-md-7" id="modelosFichaVerDoctor">
                                      <div class="row">

                                          <div class="col-4 text-left">
                                            <div class="form-group">
                                              <label for="">Plantillas</label>
                                              <select class="form-control custom-select" id="plantillasMedico">
                                                <option value="0">Modelo 01</option>
                                                <option value="1">Modelo 02</option>
                                              </select>
                                            </div>
                                          </div>

                                          <div class="col text-right">
                                            <div class="form-group">
                                              <label for="">¿Queda el paciente en espera?
                                                <input type="checkbox">
                                              </label>
                                            </div>

                                            <div class="form-group">                                 
                                                <label for="">Sobreturno por Defecto
                                                  <input type="checkbox" name="" id="">
                                                </label>
                                            </div>
                                          </div>

                                          </div>
                                      </div> 
                                  </div>
                            </div>
                        <!--FIN ABM CRONOGRAMA-->
                        <!--ABM OTROS HORARIOS-->
                            <div class="tab-pane fade mt-4" id="otrosHorarios" role="tabpanel" aria-labelledby="otrosHorarios-tab">
                              <h5 class="mt-2">Nueva regla</h5>
                                <table class="table table-hover table-bordered table-striped tabla-regla">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Desde / Hasta</th>
                                            <th class="text-center">lunes</th>
                                            <th class="text-center">martes</th>
                                            <th class="text-center">miercoles</th>
                                            <th class="text-center">jueves</th>
                                            <th class="text-center">viernes</th>
                                            <th class="text-center">sabado</th>
                                            <th class="text-center">domingo</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="contenidoOtrosHorarios"></tbody>   
                                </table>   

                                <div class="row">
                                  <div class="col-4">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="aplicableDesdeFecha">Aplicable desde</label>
                                                <input type="date" class="form-control" id="aplicableDesdeFecha">   
                                            </div> 
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="aplicableHastaFecha">Aplicable hasta</label>
                                                <input type="date" class="form-control" id="aplicableHastaFecha">   
                                            </div> 
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-8">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-center align-middle"><i class="fas fa-clinic-medical"></i></th>
                                                <th class="text-center">lunes<span id="oInfoL"></span></th>
                                                <th class="text-center">martes<span id="oInfoM"></span></th>
                                                <th class="text-center">miercoles<span id="oInfoX"></span></th>
                                                <th class="text-center">jueves<span id="oInfoJ"></span></th>
                                                <th class="text-center">viernes<span id="oInfoV"></span></th>
                                                <th class="text-center">sabado<span id="oInfoS"></span></th>
                                                <th class="text-center">domingo<span id="oInfoD"></span></th>
                                            </tr>
                                        </thead>
                                        <tbody id="contenidoEditarOtrosHorarios">
                                            <tr>
                                                <td class="text-left align-middle"><span class="mr-2">Lapso de consulta / Minutos</span></td>
                                                <td><input id="otroTiempoLun" value="20" type="number" min="1" step="1" data-dia="lun" class="form-control text-center"></td>
                                                <td><input id="otroTiempoMar" value="20" type="number" min="1" step="1" data-dia="mar" class="form-control text-center"></td>
                                                <td><input id="otroTiempoMie" value="20" type="number" min="1" step="1" data-dia="mie" class="form-control text-center"></td>
                                                <td><input id="otroTiempoJue" value="20" type="number" min="1" step="1" data-dia="jue" class="form-control text-center"></td>
                                                <td><input id="otroTiempoVie" value="20" type="number" min="1" step="1" data-dia="vie" class="form-control text-center"></td>
                                                <td><input id="otroTiempoSab" value="20" type="number" min="1" step="1" data-dia="sab" class="form-control text-center"></td>
                                                <td><input id="otroTiempoDom" value="20" type="text" data-dia="dom" class="form-control text-center"></td>
                                            </tr>
                                            <tr>
                                              <td class="text-left align-middle"><span class="mr-2">Consultorio</span></td>
                                              <td>
                                                <select class="form-control text-center" id="otroConsultorioLun">
                                                  <option value="0">-</option>
                                                  <option value="1">C1</option>
                                                  <option value="2">C2</option>
                                                  <option value="2">C3</option>
                                                </select>
                                              </td>
                                              <td>
                                                <select class="form-control text-center" id="otroConsultorioMar">
                                                  <option value="0">-</option>
                                                  <option value="1">C1</option>
                                                  <option value="2">C2</option>
                                                  <option value="2">C3</option>
                                                </select>
                                              </td>
                                              <td>
                                                <select class="form-control text-center" id="otroConsultorioMie">
                                                  <option value="0">-</option>
                                                  <option value="1">C1</option>
                                                  <option value="2">C2</option>
                                                  <option value="2">C3</option>
                                                </select>
                                              </td>
                                              <td>
                                                <select class="form-control text-center" id="otroConsultorioJue">
                                                  <option value="0">-</option>
                                                  <option value="1">C1</option>
                                                  <option value="2">C2</option>
                                                  <option value="2">C3</option>
                                                </select>
                                              </td>
                                              <td>
                                                <select class="form-control text-center" id="otroConsultorioVie">
                                                  <option value="0">-</option>
                                                  <option value="1">C1</option>
                                                  <option value="2">C2</option>
                                                  <option value="2">C3</option>
                                                </select>
                                              </td>
                                              <td>
                                                <select class="form-control text-center" id="otroConsultorioSab">
                                                  <option value="0">-</option>
                                                  <option value="1">C1</option>
                                                  <option value="2">C2</option>
                                                  <option value="2">C3</option>
                                                </select>
                                              </td>
                                              <td>
                                                <select class="form-control text-center" id="otroConsultorioDoms">
                                                  <option value="0">-</option>
                                                  <option value="1">C1</option>
                                                  <option value="2">C2</option>
                                                  <option value="2">C3</option>
                                                </select>
                                              </td>

                                            </tr>
                                        </tbody>
                                    </table> 
                                  </div>
                                </div>
                              
                                <table class="table table-striped table-hover mb-3">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Turno</th>
                                            <th class="text-center">Lunes<span id="infoSemL"></span></th>
                                            <th class="text-center">Martes<span id="infoSemM"></span></th>
                                            <th class="text-center">Miercoles<span id="infoSemX"></span></th>
                                            <th class="text-center">Jueves<span id="infoSemJ"></span></th>
                                            <th class="text-center">Viernes<span id="infoSemV"></span></th>
                                            <th class="text-center">Sabado<span id="infoSemS"></span></th>
                                            <th class="text-center">Domingo<span id="infoSemD"></span></th>
                                        </tr>
                                    </thead>
                                    <tbody id="inputsOtrosHorarios">
                                      <tr>
                                        <td class="align-middle" rowspan="2"><small>1° turno</small></td>
                                        <td><input id="otrosHorariosApLun1" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosApMar1" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosApMie1" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosApJue1" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosApVie1" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosApSab1" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosApDom1" type="time" class="form-control"></td>
                                      </tr>
                                      <tr>
                                        <td><input id="otrosHorariosCiLun1" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosCiMar1" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosCiMie1" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosCiJue1" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosCiVie1" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosCiSab1" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosCiDom1" type="time" class="form-control"></td>
                                      </tr>
                                      <tr>
                                        <td class="align-middle" rowspan="2"><small>2° turno</small></td>
                                        <td><input id="otrosHorariosApLun2" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosApMar2" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosApMie2" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosApJue2" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosApVie2" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosApSab2" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosApDom2" type="time" class="form-control"></td>
                                      </tr>
                                      <tr>
                                        <td><input id="otrosHorariosCiLun2" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosCiMar2" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosCiMie2" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosCiJue2" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosCiVie2" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosCiSab2" type="time" class="form-control"></td>
                                        <td><input id="otrosHorariosCiDom2" type="time" class="form-control"></td>
                                      </tr>
                                    </tbody>
                                  </table>

        
                                <div class="row">
                                    <div class="col text-right">
                                        <ubtton class="btn btn-success btn-sm" id="actualizarOtrosHorarios">Actualizar</button>
                                    </div>    
                                </div>

                            </div>
                        <!--FIN ABM OTROS HORARIOS-->
                        <!--ABM COBERTURAS MEDICAS-->
                          <div class="tab-pane fade mt-4" id="coberturasMedicas" role="tabpanel" aria-labelledby="coberturasMedicas-tab">
                              <div class="row">
                                  <div class="col text-right">
                                      <button id="opcionAsignarTodo" class="btn btn-success btn-sm mr-3"><i class="fas fa-globe"></i> Asiganr todas</button>  
                                      <i title="Refrescar" role="button" id="opcionRefrescarCoberturas" class="fas fa-sync mr-3 text-primary"></i>
                                      <i title="Desvincular cobertura" role="button" id="opcionEliminarCobertura" class="fas fa-unlink text-danger mr-3" style="display: none;"></i>
                                      <i title="Asignar plus" role="button" id="opcionEditarCobertura" class="fas fa-wrench text-primary mr-3" style="display:none;"></i>
                                      <a title="Llamar cobertura social" id="opcionLlamarCobertura" href="#" target="_blank" role="button" style="display: none;"><i class="fas fa-phone-alt"></i></a>
                                  </div>
                              </div>
                              <h6>Coberturas sociales con las que actualmente cuenta <b id="nombreMedicoSeleccionado"></b></h6>
                              <table class="table table-hover table-striped">
                                  <thead>
                                          <th clasS="text-center" style="width:60px;">Ítem</th>
                                          <th clasS="text-center" style="width:80px";>Código</th>
                                          <th>Cobertura</th>
                                          <th>Plus</th>
                                          <th>Descripción</th>
                                      </tr>
                                  </thead>
                                  <tbody id="contenidoCoberturasSociales"></tbody>
                              </table>
                          </div>
                        <!--FIN ABM COBERTURAS MEDICAS-->
                        <!--DIAS SIN ATENCION-->
                          <div class="tab-pane fade mt-4" id="diaSinAtencionMedico" role="tabpanel" aria-labelledby="diaSinAtencionMedico-tab">
                              <div class="row">
      
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <small>Tipo de registro</small>
                                                <select id="horarioSinAtencionModo" class="form-control custom-select">
                                                    <option value="0">Unico día</option>
                                                    <option value="1">Rango</option>
                                                    <option value="2">Único día solo rango horario</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="horarioSinAtencionUnicoDia">
                                            <div class="form-group">
                                                <small id="horarioSinAtencionLabelDia">Día</small>
                                                <input id="fechaSinActividad" type="date" class="form-control">
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-12">
                                            <small for="">Horario de inicio de permiso</small> 
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <small for="fechaSinActividadHora" id="horarioSinAtencionLabelHora">Hora</small>
                                                        <select id="fechaSinActividadHora" class="form-control custom-select">';
                                                            for($i = 0; $i < 24; $i++){
                                                                if(strlen($i) == 1){
                                                                    $hora = "0".$i;
                                                                }else{
                                                                    $hora = $i;
                                                                }
                                                                echo "<option value='".$hora."'>".$hora."</option>";
                                                            }
                                                        echo '</select>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <small for="fechaSinActividadMinutos" id="horarioSinAtencionLabelMinuto">Minuto</small>
                                                        <select id="fechaSinActividadMinutos" class="form-control custom-select">';
                                                            for($i = 0; $i < 59; $i++){
                                                                if(strlen($i) == 1){
                                                                    $minuto = "0".$i;
                                                                }else{
                                                                    $minuto = $i;
                                                                }
                                                                echo "<option value='".$minuto."'>".$minuto."</option>";
                                                            }
                                                        echo '</select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="col-md-12" id="horarioSinAtencionUltimoDia" style="display: none">
                                            <div class="form-group">
                                                <small>Último día del rango</small>
                                                <input id="fechaSinActividadFin" type="date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="horarioSinAtencionUnicoDiaPorHoras" style="display: none">
                                            <div class="form-group">
                                                <small>Rango horario</small>
                                                <div class="row">
                                                    <div class="col">
                                                      <small>Desde</small>
                                                      <input id="fechaSinActividadDesde" type="time" class="form-control">
                                                    </div>
                                                    <div class="col">
                                                      <small>Hasta</small>
                                                      <input id="fechaSinActividadHasta" type="time" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-12">
                                            <small for="">Horario de regreso finalizado el permiso</small> 
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <small for="fechaSinActividadHoraFin" id="horarioSinAtencionLabelHora">Hora</small>
                                                        <select id="fechaSinActividadHoraFin" class="form-control custom-select">';
                                                            for($i = 0; $i < 24; $i++){
                                                                if(strlen($i) == 1){
                                                                    $hora = "0".$i;
                                                                }else{
                                                                    $hora = $i;
                                                                }
                                                                echo "<option value='".$hora."'>".$hora."</option>";
                                                            }
                                                        echo '</select>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <small for="fechaSinActividadMinutosFin" id="horarioSinAtencionLabelMinuto">Minuto</small>
                                                        <select id="fechaSinActividadMinutosFin" class="form-control custom-select">';
                                                            for($i = 0; $i < 60; $i++){
                                                                if(strlen($i) == 1){
                                                                    $minuto = "0".$i;
                                                                }else{
                                                                    $minuto = $i;
                                                                }
                                                                echo "<option value='".$minuto."'>".$minuto."</option>";
                                                            }
                                                        echo '</select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <small for="observacionFechaSinActividad">Observación</small>
                                                <textarea id="observacionFechaSinActividad" class="form-control" placeholder="Observación"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <button disabled id="horariosSinAtencionPorMedicoBoton" class="btn btn-success btn-block">Guardar evento</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Fechas</th>
                                                <th>Observación</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody id="listaDiasSinAtencionMedicos"></tbody>
                                    </table>
                                </div>
                                
                              </div>
                          </div>
                        <!--FIN DIAS SIN ATENCION-->
                    </div>

                  </div>
                </div>
              </div>
            </div>
          <!--FIN OPCIONES MEDICOS-->
        <!-------------------FIN MEDICOS----------------->

        <!-------------------PACIENTES----------------->                                                
          <!--MODAL AGREGAR PACIENTE-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalNuevoPaciente" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="modalNuevoPacienteLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevoPacienteLabel">Nuevo Paciente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                     
                    <div class="row">
                      <div class="col-md-2">
                        <div class="form-group">
                          <small for="modalNuevoPacienteDNI">DNI</small><small id="modalNuevoPacienteDNIExiste" class="text-danger ml-2" style="display: none;">El DNI ya existe</small>
                          <input type="text" class="form-control is-invalid" id="modalNuevoPacienteDNI">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                            <small for="modalNuevoPacienteApellido">Apellido</small>
                            <input type="text" class="form-control is-invalid" id="modalNuevoPacienteApellido" placeholder="Apellido">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <small for="modalNuevoPacienteNombre">Nombre</small>
                          <input type="text" class="form-control is-invalid" id="modalNuevoPacienteNombre" placeholder="Nombre">
                        </div>
                      </div>
                      <div class="col-md-3" style="max-width: 240px;">
                        <div class="form-group">
                            <small for="modalNuevoPacienteFechaNacimiento">Fecha de nacimiento</small>
                            <input type="date" class="form-control is-invalid" id="modalNuevoPacienteFechaNacimiento">
                        </div>
                      </div>
                      <div class="col-md-1">
                        <div class="form-group">
                            <small for="modalNuevoPacienteEdad">Edad</small>
                            <input disabled type="text" class="form-control" id="modalNuevoPacienteEdad">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                            <small for="modalNuevoPacienteDomicilio">Domicilio</small>
                            <input type="text" class="form-control is-invalid" id="modalNuevoPacienteDomicilio" placeholder="Domicilio">
                        </div>
                      </div>
                      <div class="col-md-3" style="max-width: 225px;">
                        <div class="form-group">
                            <small for="modalNuevoPacienteProvincia">Provincia</small>
                            <select id="modalNuevoPacienteProvincia" class="form-control custom-select">
                              <?php
                                $localidades = mysqli_query($veja, "SELECT * FROM provincias ORDER BY provincia ASC");
                                while($l = mysqli_fetch_assoc($localidades)){
                                  if($l['provincia'] == "San Juan"){
                                    echo '<option selected value="'.$l['id'].'">'.strtoupper($l['provincia']).'</option>';
                                  }else{
                                    echo '<option value="'.$l['id'].'">'.strtoupper($l['provincia']).'</option>';
                                  }
                                  
                                }
                              ?>
                            </select>
                        </div>
                      </div>
                      <div class="col-md-3" style="max-width: 260px;">
                        <div class="form-group">
                            <small for="modalNuevoPacienteLocalidad">Localidad</small>
                            <select id="modalNuevoPacienteLocalidad" class="form-control custom-select">
                                <option value="0">Ninguno</option>
                            </select>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <small for="modalNuevoPacienteSexo">Sexo</small>
                          <select class="form-control custom-select" id="modalNuevoPacienteSexo">';
                            <option value="0">MASCULINO</option>
                            <option value="1">FEMENINO</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <small for="modalNuevoPacienteTelFijo1">Teléfono Fijo 1 (Opcional)</small>
                          <input type="text" class="form-control text-center" laceholder="Teléfono fijo 1" id="modalNuevoPacienteTelFijo1">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <small for="modalNuevoPacienteTelFijo2">Teléfono Fijo 2 (Opcional)</small>
                          <input type="text" placeholder="Teléfono fijo 2" id="modalNuevoPacienteTelFijo2" class="form-control text-center">
                        </div>
                      </div>
                      <div class="col-md-3" style="max-width:240px">
                        <div class="form-group">
                          <small for="modalNuevoPacienteCelular">Celular</small>
                          <input type="text" id="modalNuevoPacienteCelular" placeholder="Celular" class="form-control is-invalid text-center">
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="form-group">
                          <small for="modalNuevoPacienteEmail">Email</small>
                          <input type="text" id="modalNuevoPacienteEmail" class="form-control" placeholder="Email">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <small for="modalNuevoPacienteCobrtura">Cobertura social</small>
                          <select class="form-control custom-select" id="modalNuevoPacienteCobrtura">
                            <?php
                              $cobertura = mysqli_query($veja, "SELECT codigo, cobertura_social FROM coberturas_sociales WHERE tipo = '1' AND activo = '1' ORDER BY cobertura_social ASC");
                              while($c = mysqli_fetch_assoc($cobertura)){
                                if($c['cobertura_social'] == "PARTICULAR"){
                                  echo '<option selected value="'.$c['codigo'].'">'.$c['cobertura_social'].'</option>';
                                }else{
                                  echo '<option value="'.$c['codigo'].'">'.$c['cobertura_social'].'</option>';
                                }
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                            <small for="modalNuevoPacienteN_carnet">N° carnet</small>
                            <input disabled type="text" id="modalNuevoPacienteN_carnet" class="form-control" placeholder="N° de carnet">  
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                            <small for="modalNuevoPacienteCoseguro">Coseguro</small>
                            <select id="modalNuevoPacienteCoseguro" class="form-control">
                              <option value="0">Ninguno</option>
                              <?php
                              $coseguro = mysqli_query($veja, "SELECT codigo, cobertura_social FROM coberturas_sociales WHERE tipo = '2' AND activo = '1' ORDER BY cobertura_social ASC");
                              while($c = mysqli_fetch_assoc($coseguro)){
                                echo '<option value="'.$c['codigo'].'">'.$c['cobertura_social'].'</option>';
                              }
                              ?>
                            </select>  
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                            <small for="modalNuevoPacienteCarnetCoseguro">N° coseguro</small>
                            <input disabled type="text" id="modalNuevoPacienteCarnetCoseguro" class="form-control" placeholder="N° de carnet coseguro">  
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <small for="modalNuevoPacienteObservacion">Observaciones</small>
                          <textarea class="form-control" placeholder="Observaciones" id="modalNuevoPacienteObservacion"></textarea>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success btn-sm" id="modalNuevoPacienteBoton">Guardar</button>
                  </div>
                </div>
              </div>
            </div>
          <!--FIN MODAL AGREGAR PACIENTE-->
          <!--MODAL EDITAR PACIENTE-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalEditarPaciente" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="modalEditarPacienteLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarPacienteLabel">Editar Paciente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                      <div id="modalEditarPacienteContenido"></div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="modalEditarPacienteGuardar">Guardar Cambios</button>
                    <button type="button" class="btn btn-secondary" id="modalEditarPacientePacienteEquivocado">No Es El Paciente</button>
                    <button type="button" class="btn btn-primary" id="modalEditarPacienteContinuar" data-dismiss="modal">Continuar</button>
                  </div>
                </div>
              </div>
            </div>
          <!--FIN MODAL EDITAR PACIENTE-->
          <!--MODAL PACIENTE NO ENCONTRADO-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalPacienteNoEncontrado" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalConfirmarQuitarTurnoLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalPacienteNoEncontradoLabel">Paciente no encontrado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body text-center">
                    <h5>¿Desea agregar el nuevo paciente?</h5>
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <button class="btn btn-success btn-block" id="modalPacienteNoEncontradoAgregar">SI</button>
                        </div>
                      </div>
                      <div class="col-6">
                        <button class="btn btn-danger btn-block" id="modalPacienteNoEncontradoCancelar">NO</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <!--MODAL FIN PACIENTE NO ENCONTRADO-->
          <!--MODAL CONFIRMAR ELIMINAR TURNO-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalEliminarPaciente" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEliminarPacienteLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalEliminarPacienteLabel">Eliminar paciente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body text-center">
                    <h5 class="text-danger">¿Confirma la eliminación del paciente seleccionado?</h5>
                    <div class="form-group">
                      <label for="modalEliminarPacienteConfirmacion"></label>
                      <select class="form-control custom-select" id="modalEliminarPacienteConfirmacion">
                        <option value="0">NO</option>
                        <option value="1">SI</option>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button id="modalEliminarPacienteBoton" type="button" class="btn btn-danger btn-sm" disabled>Quitar paciente</button>
                  </div>
                </div>
              </div>
            </div>
          <!--MODAL FIN CONFIRMAR ELIMINAR TURNO-->
        <!-------------------FIN PACIENTES----------------->

        <!-------------------TURNOS----------------->
          <!--MODAL ULTIMOS DETALLES DEL TURNO-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalAgregarDatosPaciente" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalAgregarDatosPacienteLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarDatosPacienteLabel">Últimos datos del turno</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <h6 id="modalAgregarDatosPacienteFecha" class="text-center text-danger"></h6>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="modalAgregarDatosSobreTurno">Sobreturno <input type="checkbox" id="modalAgregarDatosSobreTurno"></label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="modalAgregarDatos1eraVez">1° vez <input disabled type="checkbox" id="modalAgregarDatos1eraVez"></label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="modalAgregarDatosConfirmado">Confirmado <input type="checkbox" id="modalAgregarDatosConfirmado"></label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="modalAgregarDatosUrgencia">Urgencia <input type="checkbox" id="modalAgregarDatosUrgencia"></label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="modalAgregarDatosPacienteTurno">Tipo de turno</label>
                          <select id="modalAgregarDatosPacienteTurno" class="form-control custom-select">
                              <option Value="1">Consulta</option>
                              <option Value="2">Práctica / Estudio</option>
                              <option Value="3">Cirugías</option>
                          </select>   
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="modalAgregarDatosCantidad">Cantidad</label>
                          <input type="number" class="form-control" id="modalAgregarDatosCantidad" placeholder="Cantidad" min="1" step="1" value="1">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="modalAgregarDatosPacienteHora">Hora</label><span id="horaMsg"></span>
                          <input type="time" class="form-control" placeholder="Hora del turno" id="modalAgregarDatosPacienteHora" style="width: 110px;">
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="form-group">
                          <label for="modalAgregarDatosPacienteTitle">Motivo del turno</label>
                          <input type="text" class="form-control" id="modalAgregarDatosPacienteTitle" placeholder="¿Qué padece el paciente?">
                        </div>
                      </div> 
                    </div>
                    <div class="row">
                      <div class="col-md-6" id="modalAgregarDatosPacientePractica" style="display: none;">
                        <div class="form-group">
                          <label for="modalAgregarDatosMSolicitante">Médico solicitante</label>
                          <select class="form-control custom-select" id="modalAgregarDatosMSolicitante">
                            <?php
                              $peticion = mysqli_query($veja, "SELECT * FROM medicos WHERE activo = 'true' ORDER BY apellido ASC");
                              while($d = mysqli_fetch_assoc($peticion)){
                                echo '<option value="'.$d['id'].'">'.$d['apellido'].' '.$d['nombre'].'</option>';
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6" id="modalAgregarDatosPacienteCirugia" style="display: none;">
                        <div class="form-group">
                          <label for="modalAgregarDatosMSolicitante">Solicitante / Derivador</label>
                          <select class="form-control custom-select" id="modalAgregarDatosMSolicitante">
                            <?php
                              $peticion = mysqli_query($veja, "SELECT * FROM medicos WHERE activo = 'true' ORDER BY apellido ASC");
                              while($d = mysqli_fetch_assoc($peticion)){
                                echo '<option value="'.$d['id'].'">'.$d['apellido'].' '.$d['nombre'].'</option>';
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="modalAgregarDatosPacienteObservacion">Observación</label>
                          <textarea class="form-control" id="modalAgregarDatosPacienteObservacion" placeholder="Mensaje para el médico"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3" id="modalAgregarDatosPacienteLente" style="display: none;">
                        <div class="form-group">    
                          <label for="modalAgregarDatosPacienteL">Lente</label>
                          <input type="text" class="form-control" placeholder="Lente" id="modalAgregarDatosPacienteL">
                        </div>
                      </div>
                      <div class="col-md-3" id="modalAgregarDatosPacienteDioptrias" style="display: none;">
                        <div class="form-group">    
                          <label for="modalAgregarDatosPacienteD">Dioptrias</label>
                          <input type="text" class="form-control" placeholder="Dioptrias" id="modalAgregarDatosPacienteD">
                        </div>
                      </div>
                      <div class="col-md-6" id="modalAgregarDatosPacienteOjos" style="display: none;">
                        <div class="form-group">
                          <label for="">Ojos</label> 
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="modalAgregarDatosPacienteOD">
                            <label class="form-check-label" for="modalAgregarDatosPacienteOD">
                              Ojo derecho
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="modalAgregarDatosPacienteOI">
                            <label class="form-check-label" for="modalAgregarDatosPacienteOI">
                              Ojo izquierdo
                            </label>
                          </div>   
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" id="modalAgregarDatosPacienteGuardar" class="btn btn-success">Guardar</button>
                  </div>
                </div>
              </div>
            </div>
          <!--FIN MODAL ULTIMOS DETALLES DEL TURNO-->
          <!--MODAL CONFIRMAR ELIMINAR TURNO-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalConfirmarQuitarTurno" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalConfirmarQuitarTurnoLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalConfirmarQuitarTurnoLabel">Confirmación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body text-center">
                    <h5 class="text-danger">¿Confirma la eliminación del turno seleccionado?</h5>
                    <div class="form-group">
                      <label for="modalConfirmarQuitarTurnoConfirmacion"></label>
                      <select class="form-control custom-select" id="modalConfirmarQuitarTurnoConfirmacion">
                        <option value="0">NO</option>
                        <option value="1">SI</option>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button id="modalConfirmarQuitarTurnoBoton" type="button" class="btn btn-danger btn-sm" disabled>Quitar turno</button>
                  </div>
                </div>
              </div>
            </div>
          <!--MODAL FIN CONFIRMAR ELIMINAR TURNO-->
          <!--MODAL EDITAR TURNO-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalEditarTurno" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEditarTurnoLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarTurnoLabel">Editar turno</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div id="modalEditarTurnoContenido"></div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button id="modalEditarTurnoConfirmar" type="button" class="btn btn-success">Actualizar</button>
                  </div>
                </div>
              </div>
            </div>
          <!--FIN MODAL EDITAR TURNO-->
          <!--VER TURNO-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalInformacionTurno" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalVerDoctorLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Detalles del turno</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="modalInformacionTurnoContenido">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Listo</button>
                  </div>
                </div>
              </div>
            </div>
          <!--FIN VER TURNO-->

          <!--MODAL COBRAR TURNO-->
            <!-- <div class="modal fade" id="modalCobrarTurno" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="modalCobrarTurnoLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalCobrarTurnoLabel">Cobrar Turno</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body pb-0">
                    <div class="row" style="font-size: 12px">
                      <div class="col" style="max-width: 133px; padding-right:0px;">
                        <div class="form-group">
                          <small for="">N° cobro</small>
                          <?php 
                            $ultimoCobro = mysqli_query($veja, "SELECT num_cobro FROM pagos ORDER BY id DESC LIMIT 1");
                            if(mysqli_num_rows($ultimoCobro) > 0){
                                while($nC = mysqli_fetch_assoc($ultimoCobro)){
                                    $numero_cobro = ($nC['num_cobro'] + 1);
                                }
                            }else{
                                $numero_cobro = 1000000;
                            }
                            echo '<input disabled id="modalCobrarTurnoNumCobro" type="text" value="'.$numero_cobro.'" class="form-control-sm text-center" style="width: 75px;">';
                            ?>
                        </div>
                      </div>
                      <div class="col" style="max-width: 132px; padding-right:0px;">
                        <div class="form-group">
                          <small for="">Turno N°</small>
                          <input id="modalCobrarTurnoNTurno" disabled type="text" class="form-control-sm text-center" style="width: 75px;">
                        </div>
                      </div>
                      <div class="col" style="max-width:164px; padding-right:0px;">
                        <div class="form-group">
                          <small for="">Fecha turno</small>
                          <input id="modalCobrarTurnoFechaTurno" disabled type="text" class="form-control-sm text-center" style="width:90px;">
                        </div>
                      </div>
                      <div class="col" style="max-width:301px; padding-right:0px;">
                        <div class="form-group">
                          <small for="">Medico</small>
                          <input id="modalCobrarTurnoFechaTurnoMedico" disabled class="form-control-sm text-center" style="width: 250px;">
                        </div>
                      </div>

                      <div class="col" style="max-width:333px; padding-right:0px;">
                        <div class="form-group">
                          <small for="">Paciente</small>
                          <input id="modalCobrarTurnoNPaciente" disabled type="text" class="form-control-sm text-center" style="width: 275px;">
                        </div>
                      </div>

                    </div>
                    
                    <div class="row" style="font-size: 12px;">
                      <div class="col-6 text-left">
                          <div class="form-group">
                            <small for="">Fecha de cobro</small>
                            <input type="date" class="form-control-sm text-center borde-input" id="modalCobrarTurnoFechaActual" style="width: 141px;">
                          </div>
                      </div>
                      <div class="col-6 text-right">
                              <small for="">Control</small>
                              <input type="checkbox" style="margin-right: 60px;" id="modalCobrarTurnoControl">
                        </div>
                    </div>

                    <h6>Obra social seleccionada: <span id="modalCobrarTurnoCoberturaSeleccionada" class="h3 font-weight-bold ml-2"></span></h6>

                    <div class="row">
                      <div class="col">
                        <div class="row">
                          <div class="col-12">
                            <div class="row form-group">
                              <div class="col-2" style="max-width: 95px;">
                                <small>Cobertura</small>
                              </div>
                              <div class="col-1">
                                <input id="modalCobrarTurnoCodigoCoberturaSocial" type="text" class="form-control-sm ml-2 text-center borde-input" style="width:50px;">
                              </div>
                              <div class="col">
                                <select id="modalCobrarTurnoCoberturaSocial" class="form-control-sm custom-select-sm borde-input" style="width: 100%;">
                                  <?php
                                    $peticion = mysqli_query($veja, "SELECT codigo, cobertura_social FROM coberturas_sociales WHERE activo = '1' AND tipo = '1' ORDER BY cobertura_social ASC");
                                    while($o = mysqli_fetch_assoc($peticion)){
                                      echo '<option class="cobertura" data-buscar="'.$o['cobertura_social'].'" value="'.$o['codigo'].'">'.$o['cobertura_social'].'</option>';
                                    }
                                  ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="row form-group">
                              <div class="col-2" style="max-width: 95px;">
                                <small>Coseguro</small>
                              </div>
                              <div class="col-1">
                                <input id="modalCobrarTurnoCodigoCoseguro" type="text" class="form-control-sm ml-2 text-center borde-input" style="width: 50px;">
                              </div>
                              <div class="col">
                                <select id="modalCobrarTurnoCoseguro" class="form-control-sm custom-select-sm borde-input" id="" style="width: 100%;">
                                  <?php
                                      $peticion = mysqli_query($veja, "SELECT codigo, cobertura_social FROM coberturas_sociales WHERE activo = '1' AND tipo = '2' ORDER BY cobertura_social ASC");
                                      while($o = mysqli_fetch_assoc($peticion)){
                                        echo '<option value="'.$o['codigo'].'">'.$o['cobertura_social'].'</option>';
                                      }
                                    ?>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group">
                              <input type="text" id="modalCobrarTurnoFiltrarCoberturas" class="form-control-sm borde-input" style="width: 290px;">
                            </div>
                          </div>
                          <div class="col-12 text-center" style="position: relative;">
                            <span id="modalCobrarTurnoTotalACobrar" class="font-weight-bold text-success">0.00</span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col" style="padding-right: 0px;">
                        <table class="table table-hover table-bordered tabla-pmo" id="tabla-pmo">
                            <thead>
                              <tr class="bg-info text-white">
                                <th class="text-center" style="width: 150px;"><small>Código</small></th>
                                <th class="text-center"><small>Prestación</small></th>
                                <th class="text-center" style="width: 40px;"><small>Cant</small></th>
                                <th class="text-center" style="width: 95px;"><small>Valor unitario</small></th>
                                <th class="text-center" style="width: 105px;"><small>Valor total</small></th>
                              </tr>
                            </thead>
                            <tbody id="contenido-tabla-pmo"></tbody>
                        </table>
                      </div>
                      <div class="col-1" style="max-width: 70px; padding: 0;">
                        <div class="row">
                          <div class="col text-center">
                            <i role="button" id="consultaCodigos" class="fas fa-plus-circle text-success" style="font-size: 15px;"></i>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col text-center">
                            <i role="button" id="eliminarCodigo" class="fas fa-trash text-danger mt-2" style="font-size: 15px; display:none;"></i>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-3">
                      
                      <div class="col" style="max-width:115px;">
                            <small for="">Trae orden <input type="checkbox" checked id="modalCobrarTurnoTraeOrden"></small>
                      </div>

                      <div class="col" style="max-width:320px;">
                          <div class="form-group">
                            <small>N° afiliado</small>
                            <input id="modalCobrarTurnoNCarnet" type="text" class="form-control-sm text-center borde-input" style="width: 200px;">
                          </div>
                      </div>
                        
                      <div class="col" style="max-width: 240px;">
                        <div class="form-group">
                          <small>N° Orden</small>
                          <input type="text" class="form-control-sm text-center borde-input" id="modalCobrarTurnoNOden" style="width: 150px;">
                        </div>
                      </div>
                      <div class="col" style="max-width:283px;">
                        <div class="form-group">
                          <small for="">Id autorización OS</small>
                          <input type="text" class="form-control-sm borde-input" style="width: 137px;" id="modalCobrarTurnoAutorizacion">
                        </div>
                      </div>
                      <div class="col" style="max-width: 130px;">
                        <div class="form-group">
                          <small for="">Amb / Int</small>
                          <input type="text" class="form-control-sm text-center borde-input" style="width: 30px;" id="modalCobrarTurnoAmb">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                        <div class="col" style="padding-right: 0px;">
                          <div class="table-responsive">
                            <table class="table table-hover table-bordered tabla-cobros" id="tabla-formas-de-pago">
                              <thead>
                                <tr class="bg-info text-white">
                                  <th class="text-left"><small>Forma de Pago</small></th>
                                  <th class="text-left"><small>Banco</small></th>
                                  <th class="text-left"><small>Localidad</small></th>
                                  <th class="text-center"><small>N° Cuenta</small></th>
                                  <th class="text-center"><small>N° Cheque / Documento</small></th>
                                  <th class="text-center"><small>Fecha de Emisión</small></th>
                                  <th class="text-center"><small>Fecha de Vto</small></th>
                                  <th class="text-center"><small>Importe en Pesos</small></th>
                                </tr>
                              </thead>
                              <tbody id="contenidoTablaFormasDePago"></tbody>
                            </table>
                          </div>
                        </div>
                        <div class="col-1 text-center" style="max-width: 70px; padding: 0;">
                          <div class="row">
                            <div class="col">
                              <i id="agregarFormaDePago" role="button" class="fas fa-dollar-sign text-success" style="font-size:15px; display: none;"></i>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col">
                              <i id="eliminarFormaDePago" role="button" class="fas fa-trash text-danger" style="font-size:15px; display: none;"></i>
                            </div>
                          </div>
                        </div>
                    </div>

                    <div class="row">
                      <div class="col">
                        <div class="form-group mt-2">
                          <small for="">Observaciones</small>
                          <input type="text" class="form-control-sm borde-input" style="width: 957px;" id="modalCobrarTurnoObservaciones">
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="modal-footer">
                    <div class="row" style="width: 100%;">
                      <div class="col text-left">
                          <small>F8 - Pago EFECTIVO</small>
                          <small>F9 - Grabar</small>
                      </div>
                      <div class="col text-right">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" id="modalcobrarTurnoCancelar">Cancelar</button>
                        <button disabled type="button" class="btn btn-sm btn-success" id="modalCobrarTurnoBoton">Cobrar</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->
          <!--FIN MODAL COBRAR TURNO-->

          <!--MODAL AGREGAR FORMA DE PAGO-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalAgregarFormaDePago" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalAgregarFormaDePagoLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarFormaDePagoLabel">Forma de pago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group">
                            <small>Forma de pago</small>
                            <select class="form-control" id="modalAgregarFormaDePagoFormaPago">
                              <?php
                                $peticion = mysqli_query($veja, "SELECT id, pago FROM formas_pago ORDER BY pago ASC");
                                while($f = mysqli_fetch_assoc($peticion)){
                                  if($f['id'] == "1"){
                                    echo '<option selected value='.$f['id'].'>'.$f['pago'].'</option>';
                                  }else{
                                    echo '<option value='.$f['id'].'>'.$f['pago'].'</option>';
                                  }
                                }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <small>Banco</small>
                            <select class="form-control" id="modalAgregarFormaDePagoBanco">
                              <?php
                                $bancos = mysqli_query($veja, "SELECT id, nombre FROM bancos WHERE activo = '1' ORDER BY nombre ASC");
                                while($b = mysqli_fetch_assoc($bancos)){
                                  echo '<option value="'.$b['id'].'">'.$b['nombre'].'</option>';
                                }
                              ?>    
                            </select>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <small>Localidad</small>
                            <input type="text" class="form-control" id="modalAgregarFormaDePagoLocalidad" placeholder="Localidad">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <small>N° cuenta</small>
                            <input type="text" class="form-control" id="modalAgregarFormaDePagoNCuenta" placeholder="N° cuenta">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <small>N° cheque</small>
                            <input type="text" class="form-control" id="modalAgregarFormaDePagoCheque" placeholder="N° cheque">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <small>Fecha de emisión</small>
                            <input id="modalAgregarFormaDePagoFechaActual" type="date" class="form-control" placeholder="Fecha de emisión">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <small>Fecha de vencimiento</small>
                            <input type="date" class="form-control" id="modalAgregarFormaDePagoFechaVencimiento" placeholder="Fecha de vencimiento">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <small>Importe</small>
                            <input id="modalAgregarFormaDePagoSaldoParcial" type="text" class="form-control" placeholder="Importe">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <small>Importe</small>
                            <div class="text-center pt-1">
                              <span class="h2 text-success font-weight-bold" id="modalAgregarFormaDePagoSaldoRestante"></span>
                            </div>
                          </div>
                        </div>

                          



                      </div>
                        
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                    <button id="modalAgregarFormaDePagoConfirmar" type="button" class="btn btn-success btn-sm">Agregar</button>
                  </div>
                </div>
              </div>
            </div>
          <!--FIN MODAL AGREGAR FORMA DE PAGO-->

          <!--MODAL CONFIRMAR CAMBIO DE DIA-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalConfirmarDrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalConfirmarDropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalConfirmarDropLabel">Confirmación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body text-center">
                    <div class="alert alert-danger" id="modalConfirmarDropMsg"></div>
                  </div>
                  <div class="modal-footer">
                    <button id="modalConfirmarDropCancelar" type="button" class="btn btn-danger">Cancelar</button>
                    <button id="modalConfirmarDropConfirmar" type="button" class="btn btn-success">Cambiar fecha</button>
                  </div>
                </div>
              </div>
            </div>
          <!--FIN MODAL CONFIRMAR CAMBIO DE DIA-->

          <!--MODAL CONFIRMAR ELIMINAR OTRO TURNO-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalEliminarOtroHorario" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEliminarOtroHorarioLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalEliminarOtroHorarioLabel">Confirmación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body text-center">
                    <h5 class="text-danger">¿Confirma la eliminación del horario seleccionado?</h5>
                    <div class="form-group">
                      <label for="modalEliminarOtroHorarioConfirmacion"></label>
                      <select class="form-control custom-select" id="modalEliminarOtroHorarioConfirmacion">
                        <option value="0">NO</option>
                        <option value="1">SI</option>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button id="modalEliminarOtroHorarioBoton" type="button" class="btn btn-danger btn-sm" disabled>Quitar turno</button>
                  </div>
                </div>
              </div>
            </div>
          <!--MODAL FIN CONFIRMAR ELIMINAR OTRO TURNO-->
          <!--MODAL HISTORIAL DE TURNOS-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalHistorialDeTurnos" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalHistorialDeTurnos" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Historial de turnos del paciente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Motivo</th>
                            <th>Estado</th>
                          </tr>
                        </thead>
                        <tbody id="modalHistorialDeTurnosContenido"></tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <!--FIN MODAL HISTORIAL DE TURNOS-->
          <!--MODAL CONSULTA CODIGOS-->
            <div class="modal fade" id="modalConsultaCodigos" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="modalConsultaCodigos" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalConsultaCodigosLabel">Consulta códigos</h5>
                  </div>
                  <div class="modal-body">

                    <div id="modalConsultaCodigosTabla"></div>

                    <div class="row mt-3">
                      <div class="col-3" style="max-width: 190px;">
                        <div class="form-group">
                          <small>Código</small>
                          <input type="text" value="-" id="modalConsultaCodigosCodigo" class="form-control-sm borde-input text-center" style="width: 112px;">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <small>Descripción</small>
                          <input type="text" value="-" id="modalConsultaCodigosDescripcion" class="form-control-sm borde-input" style="width: 390px;">
                        </div>
                      </div>
                      <div class="col-2" style="max-width: 110px;">
                        <div class="form-group">
                          <small>Mes</small>
                          <input id="modalConsultaCodigosMes" type="text" class="form-control-sm borde-input text-center" style="width: 50px;">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      
                      <div class="col" style="max-width: 116px;">
                        <div class="form-group">
                          <small>Cantidad</small>
                          <input id="modalConsultacodigosCantidad" type="text" value="1" class="form-control-sm borde-input text-center" style="width: 40px;">
                        </div>
                      </div>

                      <div class="col" style="max-width: 201px;">
                        <div class="form-group">
                          <small>Valor unitario</small>
                          <input disabled id="modalConsultaCodigosValorUnitario" type="text" value="0" class="form-control-sm borde-input text-center" style="width: 100px;">
                        </div>
                      </div>

                      <div class="col" style="max-width:130px;">
                        <div class="form-group">
                          <small>Plus</small>
                          <input id="modalConsultaCodigosPlus" value="0" type="text" class="form-control-sm borde-input text-center" style="width: 85px;">
                        </div>
                      </div>
                    
                      <div class="col" style="max-width:185px;">
                        <div class="form-group">
                          <small>Descuento</small>
                          <input id="modalConsultaCodigosDescuento" type="text" value="0" class="form-control-sm borde-input text-center" style="width: 100px;">
                        </div>
                      </div>
                      <div class="col" style="max-width:149px;">
                        <div class="form-group">
                          <small>Total</small>
                          <input disabled id="modalConsultaCodigosTotal" type="text" value="0" class="form-control-sm borde-input text-center" style="width:100px;">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-4" style="max-width: 218px;">
                        <div class="form-group">
                          <small>N° Orden</small>
                          <input type="text" class="form-control-sm borde-input" placeholder="N° de orden" id="modalConsultaCodigoPrestacion">
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                          <small>Id Autorización</small>
                          <input type="text" class="form-control-sm borde-input" placeholder="Id de autorización" id="modalConsultaCodigoIdAutorizacion">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col text-center">
                        <i class="fas fa-ellipsis-h text-info" type="button" data-toggle="collapse" data-target="#valoresUnitarios" aria-expanded="false" aria-controls="valoresUnitarios"></i>
                      </div>
                    </div>

                    <div class="collapse" id="valoresUnitarios">
                      <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <small>Honorarios</small>
                            <input id="modalConsultaCodigosHonorarios1" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <small>Val_ino</small>
                            <input type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <small>%</small>
                            <input type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <small>Gastos</small>
                            <input type="text" class="form-control-sm borde-input text-center" style="width: 50px;">
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <small>Val_gas</small>
                            <input type="text" class="form-control-sm borde-input text-center" style="width: 50px;">
                          </div>
                        </div>   
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <small>Honorarios</small>
                            <input type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <small>Val_ino</small>
                            <input type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <small>%</small>
                            <input type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <small>Gastos</small>
                            <input type="text" class="form-control-sm borde-input text-center" style="width: 50px;">
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <small>Val_gas</small>
                            <input type="text" class="form-control-sm borde-input text-center" style="width: 50px;">
                          </div>
                        </div>   
                      
                      </div>
                    </div>




                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" id="modalConsultaCodigosCancelar">Cancelar</button>
                    <button disabled type="button" class="btn btn-success btn-sm" id="modalConsultaCodigosAceptar">Agregar</button>
                  </div>
                </div>
              </div>
            </div>
          <!--FIN MODAL CONSULTA CODIGOS-->
        <!-------------------FIN TURNOS----------------->

        <!-------------------EDITAR FOTO----------------->
          <!--MODAL EDITAR FOTO-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalEditarFoto" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEditarFoto" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Cambiar foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="modalEditarFotoFoto">Seleccione una imagen</label>
                            <input type="file" id="modalEditarFotoFoto">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button id="modalEditarFotoBoton" type="button" class="btn btn-success btn-sm">Cambiar foto</button>
                  </div>
                </div>
              </div>
            </div>
          <!--FIN MODAL EDITAR FOTO-->
        <!-------------------FIN EDITAR FOTO----------------->

        <!-------------------FORMAS DE PAGO Y COBRO----------------->
          <!--MODAL TIPO DE PAGO Y COBRO-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalTiposDeFormasDePago" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalTiposDeFormasDePagoLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalTiposDeFormasDePagoLabel">Formas de pago y cobro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                        <div class="col text-center text-danger" id="estadoFormaPagoCobro"></div>
                      </div>
                    
                      <div class="row">
                        <div class="col">               
 
                              Nuevo<i data-toggle="collapse" href="#nuevoTipoCobro" role="button" aria-expanded="false" aria-controls="nuevoTipoCobro" class="fas fa-plus-circle text-success ml-2"></i>
                              <div class="collapse" id="nuevoTipoCobro">
                                <form class="form-inline">
                                  <div class="form-group">
                                    <input type="text" class="form-control mr-2" id="modalTiposDeFormasDePagoNuevoCobroTipo" placeholder="Forma de pago" style="width: 470px;">
                                  </div>
                                  <div class="form-group">
                                    <input type="text" class="form-control mr-2" id="modalTiposDeFormasDePagoDescripcion" placeholder="Descripción" style="width: 240px;">
                                  </div>
                                  <button disabled id="modalTiposDeFormasDePagoBoton" type="submit" class="far fa-save btn btn-success"></button>
                                </form>
                              </div>

                          <table class="table table-hover table-striped mt-3">
                              <thead>
                                <tr>
                                  <th class="text-center">Forma de pago</th>
                                  <th class="text-center">Descripción</th>
                                  <th class="text-center"><i class="fas fa-tools"></i></th>
                                </tr>
                              </thead>
                              <tbody id="listaFormasDePago"></tbody>
                          </table>
                        </div>
                      </div>
                        

                  </div>
                </div>
              </div>
            </div>                    
          <!--FIN MODAL TIPO DE PAGO Y COBRO-->
          <!--MODAL MODIFICAR PAGO Y COBRO-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalModificarDeFormasDePago" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalModificarDeFormasDePagoLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalModificarDeFormasDePagoLabel">Modificar formas de pago y cobro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                        <div class="col text-center text-danger" id="estadoFormaPagoCobro"></div>
                      </div>
                    
                      <div class="row">
                        <div class="col">               
 
                              <form class="form-inline">
                                <div class="form-group">
                                  <input type="text" class="form-control mr-2" id="modalModificarDeFormasDePagoNuevoCobroTipo" placeholder="Forma de pago">
                                </div>
                                <div class="form-group">
                                  <input type="text" class="form-control mr-2" id="modalModificarDeFormasDePagoDescripcion" placeholder="Descripción">
                                </div>
                                <button id="modalModificarDeFormasDePagoBoton" type="submit" class="fas fa-pencil-alt btn btn-success"></button>
                              </form>

                        </div>
                      </div> 

                  </div>
                </div>
              </div>
            </div>  
          <!--FIN MODAL MODIFICAR PAGO Y COBRO-->
        <!-------------------FIN FORMAS DE PAGO Y COBRO----------------->

        <!-------------------COBERTURA SOCIAL----------------->
          <!--MODAL AGREGAR COBERTURA SOCIAL-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalAgregarCoberturaSocial" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalAgregarCoberturaSocial" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Nueva cobertura social</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                    <div class="row">
                      <div class="col text-right">
                        <div class="form-group">
                          <small class="mr-3">Activo <input id="modalAgregarCoberturaSocialEstado" type="checkbox" checked></small>
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                        <div class="col" style="max-width: 180px;">
                          <div class="form-group">
                            <small>Código</small>
                            <input id="modalAgregarCoberturaSocialCodigo" type="text" class="form-control-sm borde-input text-center" style="width: 100px;">
                          </div>
                        </div>
                        <div class="col" style="max-width: 451px;">
                          <div class="form-group">
                            <small>Descripción</small>
                            <input id="modalAgregarCoberturaSocialDescripcion" type="text" class="form-control-sm borde-input" style="width:360px;">
                          </div>
                        </div>
                        <div class="col" style="max-width:125px;">
                          <div class="form-group">
                          <small>Plus</small>
                            <input id="modalAgregarCoberturaSocialPlus" type="text" class="form-control-sm borde-input" style="width: 80px">
                          </div>
                        </div>
                        <div class="col" style="max-width:155px;">
                          <div class="form-group">
                            <small>Cupo por día</small>
                            <input id="modalAgregarCoberturaSocialCupoPorDia" type="text" class="form-control-sm borde-input" style="width: 40px">
                          </div>
                        </div>
                    </div>

                    <div class="row">
                      <div class="col-12">
                        <span class="font-weight-bold">Domicilio</span>
                      </div>
                      <div class="col" style="max-width: 400px;">
                        <div class="form-group">
                          <small>Domicilio</small>
                          <input id="modalAgregarCoberturaSocialDomicilio" type="text" class="form-control-sm borde-input" style="width:326px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 220px;">
                        <div class="form-group">
                          <small>Provincia</small>
                          <select id="modalAgregarCoberturaSocialProvincia" class="form-control-sm custom-select-sm borde-input" id="">
                          <?php
                              $peticion = mysqli_query($veja, "SELECT * FROM provincias ORDER BY provincia ASC");
                              while($p = mysqli_fetch_assoc($peticion)){
                                echo '<option value="'.$p['id'].'">'.$p['provincia'].'</option>';
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-4" style="max-width: 350px;">
                        <div class="form-group">
                          <small>Localidad</small>
                          <select id="modalAgregarCoberturaSocialLocalidad" class="form-control-sm custom-select-sm borde-input">
                            <option value="0">Ninguno</option>
                          </select>
                        </div>
                      </div>
                      <div class="col" style="max-width: 112px;">
                        <div class="form-group">
                          <small>CP</small>
                          <input id="modalAgregarCoberturaSocialCP" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-12">
                        <span class="font-weight-bold">Contacto</span>
                      </div>
                      <div class="col" style="max-width: 203px;">
                        <div class="form-group">
                          <small>Celular</small>
                          <input id="modalAgregarCoberturaSocialCel" type="text" class="form-control-sm borde-input text-center" style="width: 140px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 181px;">
                        <div class="form-group">
                          <small>Teléfono</small>
                          <input id="modalAgregarCoberturaSocialTel" type="text" class="form-control-sm borde-input text-center" style="width: 110px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 350px;">
                        <div class="form-group">
                          <small>email</small>
                          <input id="modalAgregarCoberturaSocialEmail" type="text" class="form-control-sm borde-input" style="width: 257px;">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col" style="max-width: 175px;">
                        <div class="form-group">
                          <small>Tipo</small>
                          <select id="modalAgregarCoberturaSocialTipo" class="form-control-sm custom-select-sm borde-input" id="">
                            <?php
                              $peticion = mysqli_query($veja, "SELECT * FROM tipos_de_cobertura");
                              while($t = mysqli_fetch_assoc($peticion)){
                                echo '<option value="'.$t['id'].'">'.$t['tipo'].'</option>';
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-5" style="max-width: 426px;">
                        <div class="form-group">
                          <small>Categoria IVA</small>
                          <select id="modalAgregarCoberturaSocialCategoriaIVA" class="form-control-sm custom-select-sm borde-input" id="">
                            <?php
                            $peticion = mysqli_query($veja, "SELECT * FROM categorias_iva ORDER BY razon_social ASC");
                            while($r = mysqli_fetch_assoc($peticion)){
                              echo '<option value="'.$r['id'].'">'.$r['razon_social'].'</option>';
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col" style="max-width: 156px;">
                        <div class="form-group">
                          <small>CUIT</small>
                          <input id="modalAgregarCoberturaSocialCUIT" type="text" class="form-control-sm borde-input text-center" style="width: 105px;">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <small>Ingresos brutos</small>
                          <input id="modalAgregarCoberturaSocialIngresosBrutos" type="text" class="form-control-sm borde-input text-center" style="width: 105px;">
                        </div>
                      </div>
                    </div>

                    <div class="row" id="modalAgregarCoberturaSocialTipoCobertura">
                        <div class="col" style="max-width: 93px;">
                          <div class="form-group">
                            <small>Modulada <input id="modalAgregarCoberturaSocialModulada" type="radio" name="modalAgregarCoberturaRadio"></small>
                          </div>
                        </div>
                        <div class="col" style="max-width:130px;">
                          <div class="form-group">
                            <small>No modulada <input checked id="modalAgregarCoberturaSocialNoModulada" type="radio" name="modalAgregarCoberturaRadio"></small>
                          </div>
                        </div>
                    </div>

                    <div class="row">
                      <div class="col" style="max-width: 202px;">
                          <div class="form-group">
                          <small>Valor cononsulta</small>
                          <input id="modalAgregarCoberturaSocialValCon" type="text" class="form-control-sm borde-input text-center" style="width: 80px;">                     
                        </div>
                      </div>
                      <div class="col" style="max-width: 144px;">
                        <div class="form-group">
                          <small>Gal Qui</small>
                          <input id="modalAgregarCoberturaSocialGalQui" type="text" class="form-control-sm borde-input text-center" style="width: 80px;">                     
                        </div>
                      </div>
                      <div class="col" style="max-width: 145px;">
                        <div class="form-group">
                          <small>Gal Pra</small>
                          <input id="modalAgregarCoberturaSocialGalPra" type="text" class="form-control-sm borde-input text-center" style="width: 80px;">                     
                        </div>
                      </div>
                      <div class="col" style="max-width: 157px;">
                        <div class="form-group">
                          <small>Gas Pens</small>
                          <input id="modalAgregarCoberturaSocialGasPens" type="text" class="form-control-sm borde-input text-center" style="width: 80px;">                     
                        </div>
                      </div>
                      <div class="col" style="max-width: 145px;">
                        <div class="form-group">
                          <small>Gto Qui</small>
                          <input id="modalAgregarCoberturaSocialGtoQui" type="text" class="form-control-sm borde-input text-center" style="width: 80px;">                     
                        </div>
                      </div>
                      <div class="col" style="max-width: 148px;">
                        <div class="form-group">
                          <small>Gto radi</small>
                          <input id="modalAgregarCoberturaSocialGtoRadi" type="text" class="form-control-sm borde-input text-center" style="width: 80px;">                       
                        </div>
                      </div>
                      <div class="col" style="max-width: 175px;">
                        <div class="form-group">
                          <small>Paga categoria</small>
                          <input id="modalAgregarCoberturaSocialPagaCategoria" type="text" class="form-control-sm borde-input text-center" style="width: 30px;">                       
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <small>Aumento en liq</small>
                          <input id="modalAgregarCoberturaSocialAumentoEnLiq" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">                       
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col" style="max-width:195px;">
                        <div class="form-group">
                          <small>Porcentaje general</small>
                          <input id="modalAgregarCoberturaSocialPorcentajeGral" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">                       
                        </div>
                      </div>
                      <div class="col" style="max-width: 214px;">
                          <div class="form-group">
                            <small>Porcentaje honorarios</small>
                            <input id="modalAgregarCoberturaSocialPorcentajeHonorarios" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                          </div>
                      </div>
                      <div class="col" style="max-width: 197px;">
                        <div class="form-group">
                          <small>Porcentaje gastos</small>
                          <input id="modalAgregarCoberturaSocialPorcentajeGastos" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 163px;">
                        <div class="form-group">
                          <small>Porcentaje N1</small>
                          <input id="modalAgregarCoberturaSocialPorcentajeN1" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 167px;">
                        <div class="form-group">
                          <small>Porcentaje N2</small>
                          <input id="modalAgregarCoberturaSocialPorcentajeN2" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 167px;">
                        <div class="form-group">
                          <small>Porcentaje N3</small>
                          <input id="modalAgregarCoberturaSocialPorcentajeN3" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col" style="max-width: 197px;">
                        <div class="form-group">
                          <small>Modelo generación TXT</small>
                          <input id="modalAgregarCoberturaSocialModeloTXT" type="text" class="form-control-sm borde-input text-center" style="width: 30px;">
                        </div>
                      </div>
                        <div class="col">
                            <div class="form-group">
                              <small>Long Orden</small>
                              <input id="modalAgregarCoberturaSocialLongOrden" type="text" class="form-control-sm borde-input">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                              <small>Long N° Afi</small>
                              <input id="modalAgregarCoberturaSocialLongNafi" type="text" class="form-control-sm borde-input">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                              <small>Long barra</small>
                              <input id="modalAgregarCoberturaSocialLongBarra" type="text" class="form-control-sm borde-input">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                              <small>Observaciones</small>
                              <input id="modalAgregarCoberturaSocialObservaciones" type="text" class="form-control-sm borde-input">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-4">
                        <div class="form-group">
                          <small>Alerta secrearia cirugia</small>
                          <textarea id="modalAgregarCoberturaSocialAlertaCirugia" class="form-control borde-input" id=""></textarea>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                          <small>Alerta 2</small>
                          <textarea id="modalAgregarCoberturaSocialAlertaSecundaria" class="form-control borde-input" id=""></textarea>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button id="modalAgregarCoberturaSocialBoton" type="button" class="btn btn-success">Guardar</button>
                  </div>
                </div>
              </div>
            </div>
          <!--FIN MODAL AGREGAR COBERTURA SOCIAL-->
          <!--MODAL EDITAR COBERTURA-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalEditarCoberturaSocial" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEditarCoberturaSocial" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Editar cobertura social</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                    <div class="row">
                      <div class="col text-right">
                        <div class="form-group">
                          <small class="mr-3">Activo <input id="modalEditarCoberturaSocialEstado" type="checkbox"></small>
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                        <div class="col" style="max-width: 180px;">
                          <div class="form-group">
                            <small>Código</small>
                            <input id="modalEditarCoberturaSocialCodigo" type="text" class="form-control-sm borde-input text-center" style="width: 100px;">
                          </div>
                        </div>
                        <div class="col" style="max-width: 451px;">
                          <div class="form-group">
                            <small>Descripción</small>
                            <input id="modalEditarCoberturaSocialDescripcion" type="text" class="form-control-sm borde-input" style="width:360px;">
                          </div>
                        </div>
                        <div class="col" style="max-width:125px;">
                          <div class="form-group">
                          <small>Plus</small>
                            <input id="modalEditarCoberturaSocialPlus" type="text" class="form-control-sm borde-input" style="width: 80px">
                          </div>
                        </div>
                        <div class="col" style="max-width:155px;">
                          <div class="form-group">
                            <small>Cupo por día</small>
                            <input id="modalEditarCoberturaSocialCupoPorDia" type="text" class="form-control-sm borde-input" style="width: 40px">
                          </div>
                        </div>
                    </div>

                    <div class="row">
                      <div class="col-12">
                        <span class="font-weight-bold">Domicilio</span>
                      </div>
                      <div class="col" style="max-width: 400px;">
                        <div class="form-group">
                          <small>Domicilio</small>
                          <input id="modalEditarCoberturaSocialDomicilio" type="text" class="form-control-sm borde-input" style="width:326px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 220px;">
                        <div class="form-group">
                          <small>Provincia</small>
                          <select id="modalEditarCoberturaSocialProvincia" class="form-control-sm custom-select-sm borde-input" id="">
                            <?php
                              $peticion = mysqli_query($veja, "SELECT * FROM provincias ORDER BY provincia ASC");
                              while($p = mysqli_fetch_assoc($peticion)){
                                echo '<option value="'.$p['id'].'">'.$p['provincia'].'</option>';
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-4" style="max-width: 350px;">
                        <div class="form-group">
                          <small>Localidad</small>
                          <select id="modalEditarCoberturaSocialLocalidad" class="form-control-sm custom-select-sm borde-input">
                            <?php
                              $peticion = mysqli_query($veja, "SELECT * FROM localidades ORDER BY localidad ASC");
                              while($l = mysqli_fetch_assoc($peticion)){
                                echo '<option value="'.$l['id'].'">'.$l['localidad'].'</option>';
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col" style="max-width: 112px;">
                        <div class="form-group">
                          <small>CP</small>
                          <input id="modalEditarCoberturaSocialCP" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col" style="max-width: 203px;">
                        <div class="form-group">
                          <small>Celular</small>
                          <input id="modalEditarCoberturaSocialCel" type="text" class="form-control-sm borde-input text-center" style="width: 140px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 181px;">
                        <div class="form-group">
                          <small>Teléfono</small>
                          <input id="modalEditarCoberturaSocialTel" type="text" class="form-control-sm borde-input text-center" style="width: 110px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 350px;">
                        <div class="form-group">
                          <small>email</small>
                          <input id="modalEditarCoberturaSocialEmail" type="text" class="form-control-sm borde-input" style="width: 257px;">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col" style="max-width: 175px;">
                        <div class="form-group">
                          <small>Tipo</small>
                          <select id="modalEditarCoberturaSocialTipo" class="form-control-sm custom-select-sm borde-input" id="">
                          <?php
                              $peticion = mysqli_query($veja, "SELECT * FROM tipos_de_cobertura");
                              while($t = mysqli_fetch_assoc($peticion)){
                                echo '<option value="'.$t['id'].'">'.$t['tipo'].'</option>';
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-5" style="max-width: 426px;">
                        <div class="form-group">
                          <small>Categoria IVA</small>
                          <select id="modalEditarCoberturaSocialCategoriaIVA" class="form-control-sm custom-select-sm borde-input" id="">
                            <?php
                            $peticion = mysqli_query($veja, "SELECT * FROM categorias_iva ORDER BY razon_social ASC");
                            while($r = mysqli_fetch_assoc($peticion)){
                              echo '<option value="'.$r['id'].'">'.$r['razon_social'].'</option>';
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col" style="max-width: 156px;">
                        <div class="form-group">
                          <small>CUIT</small>
                          <input id="modalEditarCoberturaSocialCUIT" type="text" class="form-control-sm borde-input text-center" style="width: 105px;">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <small>Ingresos brutos</small>
                          <input id="modalEditarCoberturaSocialIngresosBrutos" type="text" class="form-control-sm borde-input text-center" style="width: 105px;">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                        <div class="col" style="max-width: 93px;">
                          <div class="form-group">
                            <small>Modulada <input id="modalEditarCoberturaSocialModulada" type="radio" name="modalAgregarCoberturaRadio"></small>
                          </div>
                        </div>
                        <div class="col" style="max-width:130px;">
                          <div class="form-group">
                            <small>No modulada <input id="modalEditarCoberturaSocialNoModulada" type="radio" name="modalAgregarCoberturaRadio"></small>
                          </div>
                        </div>
                    </div>

                    <div class="row">
                      <div class="col" style="max-width: 202px;">
                          <div class="form-group">
                          <small>Valor cononsulta</small>
                          <input id="modalEditarCoberturaSocialValCon" type="text" class="form-control-sm borde-input text-center" style="width: 80px;">                     
                        </div>
                      </div>
                      <div class="col" style="max-width: 144px;">
                        <div class="form-group">
                          <small>Gal Qui</small>
                          <input id="modalEditarCoberturaSocialGalQui" type="text" class="form-control-sm borde-input text-center" style="width: 80px;">                     
                        </div>
                      </div>
                      <div class="col" style="max-width: 145px;">
                        <div class="form-group">
                          <small>Gal Pra</small>
                          <input id="modalEditarCoberturaSocialGalPra" type="text" class="form-control-sm borde-input text-center" style="width: 80px;">                     
                        </div>
                      </div>
                      <div class="col" style="max-width: 157px;">
                        <div class="form-group">
                          <small>Gas Pens</small>
                          <input id="modalEditarCoberturaSocialGasPens" type="text" class="form-control-sm borde-input text-center" style="width: 80px;">                     
                        </div>
                      </div>
                      <div class="col" style="max-width: 145px;">
                        <div class="form-group">
                          <small>Gto Qui</small>
                          <input id="modalEditarCoberturaSocialGtoQui" type="text" class="form-control-sm borde-input text-center" style="width: 80px;">                     
                        </div>
                      </div>
                      <div class="col" style="max-width: 148px;">
                        <div class="form-group">
                          <small>Gto radi</small>
                          <input id="modalEditarCoberturaSocialGtoRadi" type="text" class="form-control-sm borde-input text-center" style="width: 80px;">                       
                        </div>
                      </div>
                      <div class="col" style="max-width: 175px;">
                        <div class="form-group">
                          <small>Paga categoria</small>
                          <input id="modalEditarCoberturaSocialPagaCategoria" type="text" class="form-control-sm borde-input text-center" style="width: 30px;">                       
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <small>Aumento en liq</small>
                          <input id="modalEditarCoberturaSocialAumentoEnLiq" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">                       
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col" style="max-width:195px;">
                        <div class="form-group">
                          <small>Porcentaje general</small>
                          <input id="modalEditarCoberturaSocialPorcentajeGral" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">                       
                        </div>
                      </div>
                      <div class="col" style="max-width: 214px;">
                          <div class="form-group">
                            <small>Porcentaje honorarios</small>
                            <input id="modalEditarCoberturaSocialPorcentajeHonorarios" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                          </div>
                      </div>
                      <div class="col" style="max-width: 197px;">
                        <div class="form-group">
                          <small>Porcentaje gastos</small>
                          <input id="modalEditarCoberturaSocialPorcentajeGastos" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 163px;">
                        <div class="form-group">
                          <small>Porcentaje N1</small>
                          <input id="modalEditarCoberturaSocialPorcentajeN1" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 167px;">
                        <div class="form-group">
                          <small>Porcentaje N2</small>
                          <input id="modalEditarCoberturaSocialPorcentajeN2" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 167px;">
                        <div class="form-group">
                          <small>Porcentaje N3</small>
                          <input id="modalEditarCoberturaSocialPorcentajeN3" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col" style="max-width: 197px;">
                        <div class="form-group">
                          <small>Modelo generación TXT</small>
                          <input id="modalEditarCoberturaSocialModeloTXT" type="text" class="form-control-sm borde-input text-center" style="width: 30px;">
                        </div>
                      </div>
                        <div class="col">
                            <div class="form-group">
                              <small>Long Orden</small>
                              <input id="modalEditarCoberturaSocialLongOrden" type="text" class="form-control-sm borde-input">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                              <small>Long N° Afi</small>
                              <input id="modalEditarCoberturaSocialLongNafi" type="text" class="form-control-sm borde-input">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                              <small>Long barra</small>
                              <input id="modalEditarCoberturaSocialLongBarra" type="text" class="form-control-sm borde-input">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                              <small>Observaciones</small>
                              <input id="modalEditarCoberturaSocialObservaciones" type="text" class="form-control-sm borde-input">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-4">
                        <div class="form-group">
                          <small>Alerta secrearia cirugia</small>
                          <textarea id="modalEditarCoberturaSocialAlertaCirugia" class="form-control borde-input" id=""></textarea>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                          <small>Alerta 2</small>
                          <textarea id="modalEditarCoberturaSocialAlertaSecundaria" class="form-control borde-input" id=""></textarea>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button id="modalEditarCoberturaSocialBoton" type="button" class="btn btn-success">Guardar</button>
                  </div>
                </div>
              </div>
            </div>
          <!--FIN MODAL EDITAR COBERTURA-->
          <!--MODAL VER COBERTURA-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalVerCoberturaSocial" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalVerCoberturaSocial" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Detalles de cobertura social</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                    <div class="row">
                      <div class="col text-right">
                        <div class="form-group">
                          <small class="mr-3">Activo <input disabled id="modalVerCoberturaSocialEstado" type="checkbox"></small>
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                        <div class="col" style="max-width: 180px;">
                          <div class="form-group">
                            <small>Código</small>
                            <input disabled id="modalVerCoberturaSocialCodigo" type="text" class="form-control-sm borde-input text-center" style="width: 100px;">
                          </div>
                        </div>
                        <div class="col" style="max-width: 451px;">
                          <div class="form-group">
                            <small>Descripción</small>
                            <input disabled id="modalVerCoberturaSocialDescripcion" type="text" class="form-control-sm borde-input" style="width:360px;">
                          </div>
                        </div>
                        <div class="col" style="max-width:125px;">
                          <div class="form-group">
                          <small>Plus</small>
                            <input disabled id="modalVerCoberturaSocialPlus" type="text" class="form-control-sm borde-input" style="width: 80px">
                          </div>
                        </div>
                        <div class="col" style="max-width:155px;">
                          <div class="form-group">
                            <small>Cupo por día</small>
                            <input disabled id="modalVerCoberturaSocialCupoPorDia" type="text" class="form-control-sm borde-input" style="width: 40px">
                          </div>
                        </div>
                    </div>

                    <div class="row">
                      <div class="col-12">
                        <span class="font-weight-bold">Domicilio</span>
                      </div>
                      <div class="col" style="max-width: 400px;">
                        <div class="form-group">
                          <small>Domicilio</small>
                          <input disabled id="modalVerCoberturaSocialDomicilio" type="text" class="form-control-sm borde-input" style="width:326px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 220px;">
                        <div class="form-group">
                          <small>Provincia</small>
                          <select disabled id="modalVerCoberturaSocialProvincia" class="form-control-sm custom-select-sm borde-input" id="">
                            <?php
                              $peticion = mysqli_query($veja, "SELECT * FROM provincias ORDER BY provincia ASC");
                              while($p = mysqli_fetch_assoc($peticion)){
                                echo '<option value="'.$p['id'].'">'.$p['provincia'].'</option>';
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-4" style="max-width: 310px;">
                        <div class="form-group">
                          <small>Localidad</small>
                          <select disabled id="modalVerCoberturaSocialLocalidad" class="form-control-sm custom-select-sm borde-input">
                            <?php
                              $peticion = mysqli_query($veja, "SELECT * FROM localidades ORDER BY localidad ASC");
                              while($l = mysqli_fetch_assoc($peticion)){
                                echo '<option value="'.$l['id'].'">'.$l['localidad'].'</option>';
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col" style="max-width: 112px;">
                        <div class="form-group">
                          <small>CP</small>
                          <input disabled id="modalVerCoberturaSocialCP" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-12">
                        <span class="font-weight-bold">Contacto</span>
                      </div>
                      <div class="col" style="max-width: 203px;">
                        <div class="form-group">
                          <small>Celular</small>
                          <input disabled id="modalVerCoberturaSocialCel" type="text" class="form-control-sm borde-input text-center" style="width: 140px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 181px;">
                        <div class="form-group">
                          <small>Teléfono</small>
                          <input disabled id="modalVerCoberturaSocialTel" type="text" class="form-control-sm borde-input text-center" style="width: 110px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 350px;">
                        <div class="form-group">
                          <small>email</small>
                          <input disabled id="modalVerCoberturaSocialEmail" type="text" class="form-control-sm borde-input" style="width: 257px;">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col" style="max-width: 175px;">
                        <div class="form-group">
                          <small>Tipo</small>
                          <select disabled id="modalVerCoberturaSocialTipo" class="form-control-sm custom-select-sm borde-input" id="">
                          <?php
                              $peticion = mysqli_query($veja, "SELECT * FROM tipos_de_cobertura");
                              while($t = mysqli_fetch_assoc($peticion)){
                                echo '<option value="'.$t['id'].'">'.$t['tipo'].'</option>';
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-5" style="max-width: 426px;">
                        <div class="form-group">
                          <small>Categoria IVA</small>
                          <select id="modalVerCoberturaSocialCategoriaIVA" class="form-control-sm custom-select-sm borde-input" id="">
                            <?php
                            $peticion = mysqli_query($veja, "SELECT * FROM categorias_iva ORDER BY razon_social ASC");
                            while($r = mysqli_fetch_assoc($peticion)){
                              echo '<option value="'.$r['id'].'">'.$r['razon_social'].'</option>';
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col" style="max-width: 156px;">
                        <div class="form-group">
                          <small>CUIT</small>
                          <input disabled id="modalVerCoberturaSocialCUIT" type="text" class="form-control-sm borde-input text-center" style="width: 105px;">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <small>Ingresos brutos</small>
                          <input disabled id="modalVerCoberturaSocialIngresosBrutos" type="text" class="form-control-sm borde-input text-center" style="width: 105px;">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                        <div class="col" style="max-width: 93px;">
                          <div class="form-group">
                            <small>Modulada <input disabled id="modalVerCoberturaSocialModulada" type="radio" name="modalAgregarCoberturaRadio"></small>
                          </div>
                        </div>
                        <div class="col" style="max-width:130px;">
                          <div class="form-group">
                            <small>No modulada <input disabled id="modalVerCoberturaSocialNoModulada" type="radio" name="modalAgregarCoberturaRadio"></small>
                          </div>
                        </div>
                    </div>

                    <div class="row">
                      <div class="col-12">
                        <span class="font-weight-bold">Texto</span>
                      </div>
                      <div class="col" style="max-width: 202px;">
                          <div class="form-group">
                          <small>Valor cononsulta</small>
                          <input disabled id="modalVerCoberturaSocialValCon" type="text" class="form-control-sm borde-input text-center" style="width: 80px;">                     
                        </div>
                      </div>
                      <div class="col" style="max-width: 144px;">
                        <div class="form-group">
                          <small>Gal Qui</small>
                          <input disabled id="modalVerCoberturaSocialGalQui" type="text" class="form-control-sm borde-input text-center" style="width: 80px;">                     
                        </div>
                      </div>
                      <div class="col" style="max-width: 145px;">
                        <div class="form-group">
                          <small>Gal Pra</small>
                          <input disabled id="modalVerCoberturaSocialGalPra" type="text" class="form-control-sm borde-input text-center" style="width: 80px;">                     
                        </div>
                      </div>
                      <div class="col" style="max-width: 157px;">
                        <div class="form-group">
                          <small>Gas Pens</small>
                          <input disabled id="modalVerCoberturaSocialGasPens" type="text" class="form-control-sm borde-input text-center" style="width: 80px;">                     
                        </div>
                      </div>
                      <div class="col" style="max-width: 145px;">
                        <div class="form-group">
                          <small>Gto Qui</small>
                          <input disabled id="modalVerCoberturaSocialGtoQui" type="text" class="form-control-sm borde-input text-center" style="width: 80px;">                     
                        </div>
                      </div>
                      <div class="col" style="max-width: 148px;">
                        <div class="form-group">
                          <small>Gto radi</small>
                          <input disabled id="modalVerCoberturaSocialGtoRadi" type="text" class="form-control-sm borde-input text-center" style="width: 80px;">                       
                        </div>
                      </div>
                      <div class="col" style="max-width: 175px;">
                        <div class="form-group">
                          <small>Paga categoria</small>
                          <input disabled id="modalVerCoberturaSocialPagaCategoria" type="text" class="form-control-sm borde-input text-center" style="width: 30px;">                       
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <small>Aumento en liq</small>
                          <input disabled id="modalVerCoberturaSocialAumentoEnLiq" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">                       
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-12">
                        <span class="font-weight-bold">Texto</span>
                      </div>
                      <div class="col" style="max-width:195px;">
                        <div class="form-group">
                          <small>Porcentaje general</small>
                          <input disabled id="modalVerCoberturaSocialPorcentajeGral" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">                       
                        </div>
                      </div>
                      <div class="col" style="max-width: 214px;">
                          <div class="form-group">
                            <small>Porcentaje honorarios</small>
                            <input disabled id="modalVerCoberturaSocialPorcentajeHonorarios" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                          </div>
                      </div>
                      <div class="col" style="max-width: 197px;">
                        <div class="form-group">
                          <small>Porcentaje gastos</small>
                          <input disabled id="modalVerCoberturaSocialPorcentajeGastos" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 163px;">
                        <div class="form-group">
                          <small>Porcentaje N1</small>
                          <input disabled id="modalVerCoberturaSocialPorcentajeN1" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 167px;">
                        <div class="form-group">
                          <small>Porcentaje N2</small>
                          <input disabled id="modalVerCoberturaSocialPorcentajeN2" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 167px;">
                        <div class="form-group">
                          <small>Porcentaje N3</small>
                          <input disabled id="modalVerCoberturaSocialPorcentajeN3" type="text" class="form-control-sm borde-input text-center" style="width: 60px;">
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-12">
                        <span class="font-weight-bold">Texto</span>
                      </div>
                      <div class="col" style="max-width: 197px;">
                        <div class="form-group">
                          <small>Modelo generación TXT</small>
                          <input disabled id="modalVerCoberturaSocialModeloTXT" type="text" class="form-control-sm borde-input text-center" style="width: 30px;">
                        </div>
                      </div>
                        <div class="col">
                            <div class="form-group">
                              <small>Long Orden</small>
                              <input disabled id="modalVerCoberturaSocialLongOrden" type="text" class="form-control-sm borde-input">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                              <small>Long N° Afi</small>
                              <input disabled id="modalVerCoberturaSocialLongNafi" type="text" class="form-control-sm borde-input">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                              <small>Long barra</small>
                              <input disabled id="modalVerCoberturaSocialLongBarra" type="text" class="form-control-sm borde-input">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                              <small>Observaciones</small>
                              <input disabled id="modalVerCoberturaSocialObservaciones" type="text" class="form-control-sm borde-input">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-12">
                        <span class="font-weight-bold">Texto</span>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                          <small>Alerta secrearia cirugia</small>
                          <textarea disabled id="modalVerCoberturaSocialAlertaCirugia" class="form-control borde-input" id=""></textarea>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="form-group">
                          <small>Alerta 2</small>
                          <textarea disabled id="modalVerCoberturaSocialAlertaSecundaria" class="form-control borde-input" id=""></textarea>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Listo</button>
                  </div>
                </div>
              </div>
            </div>
          <!--FIN MODAL VER COBERTURA-->
        <!-------------------FIN COBERTURA SOCIAL----------------->

        <!-------------------EDITAR PLUS----------------->
          <!--MODAL EDITAR PLUS-->
            <div class="modal fade" id="modalEditarPlus" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="modalEditarPlus" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarPlus">Editar plus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <label for="modalEditarPlusValor">Valor plus</label>
                          <input type="text" id="modalEditarPlusValor" class="form-control" placeholder="Valor plus">
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <label for="modalEditarPlusDescripcion">Descripción</label>
                          <textarea class="form-control" id="modalEditarPlusDescripcion"></textarea> 
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="modalEditarPlusBoton">Actualizar</button>
                  </div>
                </div>
              </div>
            </div>
          <!--FIN MODAL EDITAR PLUS-->
          <!--MODAL CONFIRMAR ASIGNAR TODO-->
            <div class="modal fade" id="modalConfirmarAsignarTodo" tabindex="-1" role="dialog" aria-labelledby="modalConfirmarAsignarTodoLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalConfirmarAsignarTodoLabel">Confirme la asignación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="modalConfirmarAsignarTodoSelect">Confirme la asignación de todas las coberturas sociales a <b id="modalConfirmarAsignarTodoNombreMedico"></b></label>
                          <select class="form-control" id="modalConfirmarAsignarTodoSelect">
                            <option value="0">NO</option>
                            <option value="1">SI</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="modalConfirmarAsignarTodoBoton">Asignar</button>
                  </div>
                </div>
              </div>
            </div>
          <!--FIN MODAL CONFIRMAR ASIGNAR TODO-->
        <!-------------------EDITAR FOTO----------------->

        <!-------------------PRESTACIÓN----------------->
          <!--MODAL NUEVA PRESTACIÓN-->
            <div class="modal fade" id="modalNuevaPrestacion" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalNuevaPrestacionLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevaPrestacionLabel">Nueva prestación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <small>Descripción</small>
                          <input type="text" id="modalNuevaPrestacionDescripcion" class="form-control-sm borde-input text-center text-center" placeholder="Descripción" style="width: 470px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 235px;">
                        <div class="form-group">
                          <small>Código</small>
                          <input type="text" id="modalNuevaPrestacionCodigo" class="form-control-sm borde-input text-center text-center" placeholder="Código" style="width:150px;">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col" style="max-width:84px;">
                        <div class="form-group">
                          <small>Nivel</small>
                          <input type="text" id="modalNuevaPrestacionNivel" class="form-control-sm borde-input text-center" style="width:35px;">
                        </div>
                      </div>
                      <div class="col" style="max-width:136px;">
                        <div class="form-group">
                          <small>Complejidad</small>
                          <input type="text" id="modalNuevaPrestacionComplejidad" class="form-control-sm borde-input text-center" style="width:40px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 159px;">
                        <div class="form-group">
                          <small>Expediente OSP</small>
                          <input type="text" id="modalNuevaPrestacionExpediente" class="form-control-sm borde-input text-center" style="width: 40px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 200px;">
                        <div class="form-group">
                          <small>Un. Medico</small>
                          <input type="text" id="modalNuevaPrestacionUMedico" class="form-control-sm borde-input text-center" style="width: 110px;">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <small>Un. Gastos</small>
                          <input type="text" id="modalNuevaPrestacionUGastos" class="form-control-sm borde-input text-center" style="width: 110px;">
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col text-right">
                        <div class="form-group">
                          <small style="padding-right: 24px;">Asociar a OS <input type="checkbox" id="modalNuevaPrestacionAsociarOS"></small>
                        </div>
                      </div>
                    </div>


                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="modalNuevaPrestacionBoton">Guardar</button>
                  </div>
                </div>
              </div>
            </div>
          <!--FIN MODAL NUEVA PRESTACIÓN-->
          <!--MODAL CONFIRMAR ELIMINAR TURNO-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalEliminarPaciente" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEliminarPrestacionLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalEliminarPrestacionLabel">Confirmación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body text-center">
                    <h5 class="text-danger">¿Confirma la eliminación de la prestanción seleccionada?</h5>
                    <div class="form-group">
                      <label for="modalEliminarPrestacionConfirmacion"></label>
                      <select class="form-control custom-select" id="modalEliminarPrestacionConfirmacion">
                        <option value="0">NO</option>
                        <option value="1">SI</option>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button id="modalEliminarPrestacionBoton" type="button" class="btn btn-danger btn-sm" disabled>Quitar prestación</button>
                  </div>
                </div>
              </div>
            </div>
          <!--MODAL FIN CONFIRMAR ELIMINAR TURNO-->
          <!--MODAL EDITAR PRESTACIÓN-->
            <div class="modal fade" id="modalEditarPrestacion" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEditarPrestacionLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarPrestacionLabel">Nueva prestación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <small>Descripción</small>
                          <input type="text" id="modalEditarPrestacionDescripcion" class="form-control-sm borde-input text-center text-center" placeholder="Descripción" style="width: 470px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 235px;">
                        <div class="form-group">
                          <small>Código</small>
                          <input type="text" id="modalEditarPrestacionCodigo" class="form-control-sm borde-input text-center text-center" placeholder="Código" style="width:150px;">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col" style="max-width:84px;">
                        <div class="form-group">
                          <small>Nivel</small>
                          <input type="text" id="modalEditarPrestacionNivel" class="form-control-sm borde-input text-center" style="width:35px;">
                        </div>
                      </div>
                      <div class="col" style="max-width:136px;">
                        <div class="form-group">
                          <small>Complejidad</small>
                          <input type="text" id="modalEditarPrestacionComplejidad" class="form-control-sm borde-input text-center" style="width:40px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 159px;">
                        <div class="form-group">
                          <small>Expediente OSP</small>
                          <input type="text" id="modalEditarPrestacionExpediente" class="form-control-sm borde-input text-center" style="width: 40px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 200px;">
                        <div class="form-group">
                          <small>Un. Medico</small>
                          <input type="text" id="modalEditarPrestacionUMedico" class="form-control-sm borde-input text-center" style="width: 110px;">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <small>Un. Gastos</small>
                          <input type="text" id="modalEditarPrestacionUGastos" class="form-control-sm borde-input text-center" style="width: 110px;">
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-3">
                        <div class="form-group">
                          <small style="padding-right: 24px;">Estado</small>
                          <select class="form-control custom-select-sm borde-input" id="modalEditarPrestacionEstado" style="width: 100px;">
                            <option value="0">Inactivo</option>
                            <option value="1">Activo</option>
                          </select>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="modalEditarPrestacionBoton">Guardar</button>
                  </div>
                </div>
              </div>
            </div>
          <!--FIN MODAL EDITAR PRESTACIÓN-->
          <!--VER PRESTACION-->
            <div class="modal fade" id="modalVerPrestacion" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalVerPrestacionLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalVerPrestacionLabel">Detalles de la prestación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <small>Descripción</small>
                          <input disabled type="text" id="modalVerPrestacionDescripcion" class="form-control-sm borde-input text-center text-center" placeholder="Descripción" style="width: 470px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 235px;">
                        <div class="form-group">
                          <small>Código</small>
                          <input disabled type="text" id="modalVerPrestacionCodigo" class="form-control-sm borde-input text-center text-center" placeholder="Código" style="width:150px;">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col" style="max-width:84px;">
                        <div class="form-group">
                          <small>Nivel</small>
                          <input disabled type="text" id="modalVerPrestacionNivel" class="form-control-sm borde-input text-center" style="width:35px;">
                        </div>
                      </div>
                      <div class="col" style="max-width:136px;">
                        <div class="form-group">
                          <small>Complejidad</small>
                          <input disabled type="text" id="modalVerPrestacionComplejidad" class="form-control-sm borde-input text-center" style="width:40px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 159px;">
                        <div class="form-group">
                          <small>Expediente OSP</small>
                          <input disabled type="text" id="modalVerPrestacionExpediente" class="form-control-sm borde-input text-center" style="width: 40px;">
                        </div>
                      </div>
                      <div class="col" style="max-width: 200px;">
                        <div class="form-group">
                          <small>Un. Medico</small>
                          <input disabled type="text" id="modalVerPrestacionUMedico" class="form-control-sm borde-input text-center" style="width: 110px;">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <small>Un. Gastos</small>
                          <input disabled type="text" id="modalVerPrestacionUGastos" class="form-control-sm borde-input text-center" style="width: 110px;">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Listo</button>
                  </div>
                </div>
              </div>
            </div>
          <!--FIN VER PRESTACION-->
        <!-------------------FIN PRESTACIÓN----------------->
        
        <!-------------------COBERTURA SOCIAL----------------->
          <!--MODAL CONFIRMAR ELIMINAR COBERTURA SOCIAL-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalEliminarCoberturaSocial" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEliminarCoberturaSocialLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalEliminarCoberturaSocialLabel">Confirmación</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body text-center">
                      <h5 class="text-danger">¿Confirma la eliminación de a cobertura seleccionada?</h5>
                      <div class="form-group">
                        <label for="modalEliminarCoberturaSocialConfirmacion"></label>
                        <select class="form-control custom-select" id="modalEliminarCoberturaSocialConfirmacion">
                          <option value="0">NO</option>
                          <option value="1">SI</option>
                        </select>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button id="modalEliminarCoberturaSocialBoton" type="button" class="btn btn-danger btn-sm" disabled>Quitar turno</button>
                    </div>
                  </div>
                </div>
            </div>
          <!--MODAL FIN CONFIRMAR ELIMINAR COBERTURA SOCIAL-->
        <!-------------------FIN COBERTURA SOCIAL----------------->

        <!-------------------CONVENIOS----------------->
          <!--MODAL CREAR CONVENIO-->
            <div class="modal fade" id="modalNuevoConvenio" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="modalNuevoConvenio" aria-hidden="true">
              <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevoConvenioLabel">Convenio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                    <div class="row">
                      <div class="col" style="max-width:307px;">
                        <div class="form-group">
                          <small>Fecha De Convenio</small>
                          <input id="modalNuevoConvenioFecha" type="date" class="form-conrtol-sm borde-input" style="width: 155px;"> 
                        </div>
                      </div>
                      <div class="col" style="max-width:347px;">
                        <div class="form-group">
                          <small>Vencimiento Del Convenio</small>
                          <input id="modalNuevoConvenioVencimiento" type="date" class="form-conrtol-sm borde-input" style="width: 155px;"> 
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <small>Obra social</small>
                          <select class="form-control-sm borde-input" id="modalNuevoConvenioCobertura" style="width: 294px;">
                            <option value="0">Seleccione una cobertura</option>
                            <?php
                              $peticion = mysqli_query($veja, "SELECT codigo, cobertura_social FROM coberturas_sociales WHERE tipo = '1' ORDER BY cobertura_social ASC");
                              while($c = mysqli_fetch_assoc($peticion)){
                                echo '<option value="'.$c['codigo'].'">'.$c['cobertura_social'].'</option>';
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <!-- <div class="row">
                      <div class="col text-right">
                      <i tittle="Buscar convenio" role="button" class="fas fa-search text-info h4 mr-3"></i>
                      <i tittle="Imprimir" role="button" class="fas fa-print text-info h4"></i>
                      </div>
                    </div> -->
                    <table class="table table-hover table-bordered tabla-convenioPrestaciones" id="tabla-convenioPrestaciones">
                        <thead>
                          <tr>
                            <th class="text-center">Descripción</th>
                            <th class="text-center" style="width:145px;">Código Obra social</th>
                            <th class="text-center" style="width:75px;">Precio fijo</th>
                          </tr>
                        </thead>
                        <tbody id="modalNuevoConvenioDetalles"></tbody>
                    </table>


                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success btn-sm" id="modalNuevoConvenioBoton">Generar</button>
                  </div>
                </div>
              </div>
            </div>
          <!--FIN MODAL CREAR CONVENIO-->
          <!--MODAL CONFIRMAR ELIMINAR CONVENIO-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalEliminarConvenio" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEliminarConvenioLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Eliminar convenio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body text-center">
                    <h5 class="text-danger">¿Confirma la eliminación del convenio?</h5>
                    <div class="form-group">
                      <label for="modalEliminarConvenioConfirmacion"></label>
                      <select class="form-control custom-select" id="modalEliminarConvenioConfirmacion">
                        <option value="0">NO</option>
                        <option value="1">SI</option>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button id="modalEliminarConvenioBoton" type="button" class="btn btn-danger btn-sm" disabled>Eliminar convenio</button>
                  </div>
                </div>
              </div>
            </div>
          <!--MODAL FIN CONFIRMAR ELIMINAR CONVENIO-->
        <!-------------------FIN CONVENIOS----------------->

        <!-------------------FERIADOS----------------->
          <!--MODAL CONFIRMAR ELIMINAR MENSAJE-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalEliminarFeriado" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEliminarFeriadoLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Eliminar feriado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body text-center">
                    <h5 class="text-danger">¿Confirma la eliminación del feriado?</h5>
                    <div class="form-group">
                      <label for="modalEliminarFeriadoConfirmacion"></label>
                      <select class="form-control custom-select" id="modalEliminarFeriadoConfirmacion">
                        <option value="0">NO</option>
                        <option value="1">SI</option>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button id="modalEliminarFeriadoBoton" type="button" class="btn btn-danger btn-sm" disabled>Eliminar feriado</button>
                  </div>
                </div>
              </div>
            </div>
          <!--MODAL FIN CONFIRMAR ELIMINAR MENSAJE-->
        <!-------------------FIN FERIADOS----------------->


          <!--MODAL CONFIRMAR ELIMINAR COBERTURA-->
            <div class="modal fade animate__animated animate__bounceInUp" id="modalEliminarHorarioSinAtencion" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEliminarHorarioSinAtencionLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Eliminar horario sin atención</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body text-center">
                    <h5 class="text-danger">¿Confirma la eliminación del horario?</h5>
                    <div class="form-group">
                      <label for="modalEliminarHorarioSinAtencionConfirmacion"></label>
                      <select class="form-control custom-select" id="modalEliminarHorarioSinAtencionConfirmacion">
                        <option value="0">NO</option>
                        <option value="1">SI</option>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button id="modalEliminarHorarioSinAtencionBoton" type="button" class="btn btn-danger btn-sm" disabled>Eliminar horario</button>
                  </div>
                </div>
              </div>
            </div>
          <!--MODAL FIN CONFIRMAR ELIMINAR COBERTURA-->



      <!--FIN MODALS-->
    <!--header area start-->
    <?php
    if($_SESSION['stock'] == 0){
      echo '<div class="header">
        <div class="row">
          <div class="col text-left">
            <span id="veja_moreno">Veja Moreno</span>
            <span role="button" class="fas fa-hospital-alt h5 ml-4 text-light" style="display: none;"></span>
          </div>
          <div class="col text-right usuario">
            <div class="user-sign">
              <small class="ml-1">';
              echo $_SESSION['apellido'].", ".$_SESSION['nombre'];
              echo '</small>
              <small class="ml-1"><a href="../php/signout.php" class="mr-auto">Cerrar sesión</a></small>
            </div>
            <img src="../img/users/'; echo $_SESSION['avatar']; echo '" class="img-fluid">
            <div class="contenedorMensajes" id="notificaciones">
              <i id="sobre" role="button" 
                class="fas fa-envelope" 
                data-container="body"
                data-toggle="popover"
                data-content=""></i>
              <span id="numeroMensajes" class="badge badge-danger oscilar"></span>
            </div>
          </div>
        </div>
      </div>';
    }
    ?>
    <div class="content">
      <!--MENU GENERAL-->
        <div id="menuGeneral">
          <div class="row">
            <div class="col-md-3 columnaItem">
              <div class="categoria text-center mb-5 animate__animated animate__jackInTheBox">
                  <div class="categoria-icono">
                    <a id="principalItem" data-toggle="collapse" href="#seccionPrincipal" role="button" aria-expanded="false" aria-controls="seccionPrincipal"><i class="fas fa-home" ></i></a>
                  </div>
                  <div class="categoria-nombre mt-2">
                    <span class="font-weight-bold">Principal</span>
                  </div>
              </div>

            </div>
            <div class="col-md-3 columnaItem">
              <div class="categoria text-center mb-5 animate__animated animate__jackInTheBox">
                <div class="categoria-icono">
                  <a id="ABMMedic" data-toggle="collapse" href="#seccionABMMedicos" role="button" aria-expanded="false" aria-controls="seccionABMMedicos"><i class="fas fa-user-tie"></i></a>
                </div>
                <div class="categoria-nombre mt-2">
                  <span class="font-weight-bold">Recepción</span>
                </div>
              </div>

            </div>
            <div class="col-md-3 columnaItem">
              <div class="categoria text-center mb-5 animate__animated animate__jackInTheBox">
                <div class="categoria-icono">
                  <a id="clinicHistoryItem" data-toggle="collapse" href="#seccionHistoriaClinica" role="button" aria-expanded="false" aria-controls="seccionHistoriaClinica"><i class="fas fa-book-medical"></i></a>
                </div>
                <div class="categoria-nombre mt-2">
                  <span class="font-weight-bold">Historias Clinicas</span>
                </div>
              </div>
            </div>

            <div class="col-md-3 columnaItem">
                <div class="categoria text-center mb-5 animate__animated animate__jackInTheBox">
                  <div class="categoria-icono">
                    <a id="bilingItem" data-toggle="collapse" href="#seccionFacturacion" role="button" aria-expanded="false" aria-controls="seccionFacturacion"><i class="fas fa-file-invoice-dollar"></i></a> 
                  </div>
                  <div class="categoria-nombre mt-2">
                    <span class="font-weight-bold">Facturación</span>
                  </div>
                </div>
            </div>

            <div class="col-md-3 columnaItem">
                <div class="categoria text-center mb-5 animate__animated animate__jackInTheBox">
                  <div class="categoria-icono">
                    <a id="administrationItem" data-toggle="collapse" href="#seccionAdministracion" role="button" aria-expanded="false" aria-controls="seccionAdministracion"><i class="fas fa-cogs"></i></a>
                  </div>
                  <div class="categoria-nombre mt-2">
                    <span class="font-weight-bold">Administración</span>
                  </div>
                </div>
            </div>

            <div class="col-md-3 columnaItem">
                <div class="categoria text-center mb-5 animate__animated animate__jackInTheBox">
                  <div class="categoria-icono">
                    <a id="stockItem" data-toggle="collapse" href="#seccionStock" role="button" aria-expanded="false" aria-controls="seccionStock"><i class="fas fa-box-open"></i></a>
                  </div>
                  <div class="categoria-nombre mt-2">
                    <span class="font-weight-bold">Stock</span>
                  </div>
                </div>
            </div>

            <div class="col-md-3 columnaItem">
                <div class="categoria text-center mb-5 animate__animated animate__jackInTheBox">
                  <div class="categoria-icono">
                    <a id="tesoreriaItem" data-toggle="collapse" href="#seccionTesoreria" role="button" aria-expanded="false" aria-controls="seccionTesoreria"><i class="fas fa-coins"></i></a>
                  </div>
                  <div class="categoria-nombre mt-2">
                    <span class="font-weight-bold">Tesoreria</span>
                  </div>
                </div>
            </div>

          </div>
        </div>
      <!--FIN MENU GENERAL-->
      <!--PRINCIPAL-->
        <div class="collapse" id="seccionPrincipal">
          <div class="row">
              <div class="col">
                <div class="card">
                  <div class="card-body">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="#"><i class="fas fa-home"></i> Principal</i></a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                          <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavDropdown">
                          <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Mensajes
                              </a>
                              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#" id="notificaciones">Notificaciones</a>
                                <a class="dropdown-item disabled" href="#">Chat</a>
                              </div>
                            </li>
                            <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                ejemplo
                              </a>
                              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item disabled" href="#">item 1</a>
                                <a class="dropdown-item disabled" href="#">item 2</a>
                              </div>
                            </li>
                            <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                ejemplo
                              </a>
                              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item disabled" href="#">item 1</a>
                                <a class="dropdown-item disabled" href="#">item 2</a>
                              </div>
                            </li>
                          </ul>
                        </div>
                    </nav>
                    <!--CONTENIDO DE SECCION-->
                      <div id="contenedorCategoriaPrincipal">
                        <div class="posRelativa">
                          <img src="../img/actives/vejaMoreno.png" class="ajustarCentro img-fluid animate__animated animate__zoomInUp">
                        </div>
                      </div>
                    <!--FIN CONTENIDO DE SECCION-->
                  </div>
                </div>
              </div>
            </div>
        </div>
      <!--FIN PRINCIPAL-->
      <!--RECEPCIÓN-->
        <div class="collapse" id="seccionABMMedicos">
          <div class="row">
            <div class="col">
              <div class="card">
                <div class="card-body">
                  <nav class="navbar navbar-expand-lg navbar-light">
                      <a class="navbar-brand" href="#"><i class="fas fa-user-tie"></i> Recepción</i></a>
                      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                      <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                          <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Administración
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                              <a class="dropdown-item" href="#" id="recepcionABMMedicos">Medicos</a>
                              <a class="dropdown-item disabled" href="#">Especialidad</a>
                              <a class="dropdown-item" href="#" id="ABMFeriados">Feriados / Institucionales</a>
                              <a class="dropdown-item" href="#" id="recepcionPacientes">Pacientes</a>
                            </div>
                          </li>
                          <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Turnos
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                              <a class="dropdown-item" href="#" id="asignarTurno">Asignar turno</a>
                            </div>
                          </li>
                          <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Estadísticas
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                              <a class="dropdown-item disabled" href="#">Medicos</a>
                              <a class="dropdown-item disabled" href="#">Especialidad</a>
                              <a class="dropdown-item disabled" href="#">Feriados</a>
                              <a class="dropdown-item disabled" href="#">Pacientes</a>
                              <a class="dropdown-item disabled" href="#">Turnos</a>
                              <a class="dropdown-item disabled" href="#">Días sin atención por medico</a>
                            </div>
                          </li>
                        </ul>
                      </div>
                  </nav>

                  <!--CONTENIDO DE SECCION-->
                    <div id="contenedorCategoriaRecepcion">
                      <div class="posRelativa">
                        <img src="../img/actives/vejaMoreno.png" class="ajustarCentro img-fluid animate__animated animate__zoomInUp">
                      </div>
                    </div>
                  <!--FIN CONTENIDO DE SECCION-->

                </div>
              </div>
            </div>
          </div>
        </div>
      <!--FIN RECEPCION-->
      <!--HISTORIACLICNICA-->
        <div class="collapse" id="seccionHistoriaClinica">
          <div class="card card-body">
            <div class="text-center">
              <h4>HISTORIA CLINICA</h4>
            </div>
            <div class="row">
      
              <div class="col-md-4">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Turnos</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Consulta o reserva turnos</h6>
                    <p class="card-text">Texto de ejemplo. Descripción</p>
                    <button class="btn btn-dark btn-block">Reservar nuevo turno</button>
                    <button class="btn btn-dark btn-block">Consultar turno</button>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="card"">
                  <div class="card-body">
                    <h5 class="card-title">Consultas rápidas</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Pacientes - Doctores</h6>
                    <p class="card-text">Texto de ejemplo. Descripción</p>
                    <button class="btn btn-dark btn-block">Datos de pacientes</button>
                    <button class="btn btn-dark btn-block">Datos de doctores</button>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      <!--FIN HISTORIA CLICNICA-->
      <!--FACTURACION-->
        <div class="collapse" id="seccionFacturacion">
          <div class="row">
              <div class="col">
                <div class="card">
                  <div class="card-body">
                    <nav class="navbar navbar-expand-lg navbar-light">
                      <a class="navbar-brand" href="#"><i class="fas fa-file-invoice-dollar"></i> Facturación</i></a>
                      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                      <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                          <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Administración
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                              <a class="dropdown-item" href="#" id="facturacionEntradaDatos">Nomenclador / PMO</a>
                              <a class="dropdown-item" href="#" id="facturacionCoberturasMedicas">Coberturas sociales</a>
                              <a class="dropdown-item" href="#" id="facturacionABMMedicos">Médicos</a>
                              <a class="dropdown-item" href="#" id="facturacionConvenios">Convenios</a>
                              <a class="dropdown-item disabled" href="#" id="">Entidades</a>
                              <a class="dropdown-item" href="#" id="facturacionAsignarTurno">Turnos</a>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </nav>

                    <!--CONTENIDO DE SECCION-->
                      <div id="contenedorCategoriaFacturacion">
                        <div class="posRelativa">
                          <img src="../img/actives/vejaMoreno.png" class="ajustarCentro img-fluid animate__animated animate__zoomInUp">
                        </div>
                      </div>
                      <!-- FIN CONTENIDO DE SECCION-->



              
                </div>
              </div>
            </div>
          </div>
        </div>
      <!--FIN FACTURACION-->
      <!--ADMINISTRACION-->
        <div class="collapse" id="seccionAdministracion">
          <div class="row">
              <div class="col">
                <div class="card">
                  <div class="card-body">
                    <nav class="navbar navbar-expand-lg navbar-light">
                      <a class="navbar-brand" href="#"><i class="fas fa-cogs"></i> Administración general</i></a>
                      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                      <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                          <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Ajustes
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                              <a class="dropdown-item" href="#" id="administracionTema">Ajustar tema</a>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </nav>

                    <!--CONTENIDO DE SECCION-->
                      <div id="contenedorCategoriaConfiguracionGeneral">
                        <div class="posRelativa">
                          <img src="../img/actives/vejaMoreno.png" class="ajustarCentro img-fluid animate__animated animate__zoomInUp">
                        </div>
                      </div>
                      <!-- FIN CONTENIDO DE SECCION-->



              
                </div>
              </div>
            </div>
          </div>
        </div>
      <!--FIN ADMINISTRACION-->
      <!--STOCK-->
        <div class="collapse" id="seccionStock">
          <div class="row">
              <div class="col">
                <div class="card" id="cardStock">
                  <div class="card-body">
                  <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="#"><img src="../img/actives/icon.png" width="30px"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Administración
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="#" id="rubros">Rubros</a>
                                    <a class="dropdown-item" href="#" id="insumos">Grupos</a>
                                    <a class="dropdown-item" href="#" id="articulos">Artículos</a>
                                    <a class="dropdown-item" href="#" id="proveedores">Proveedores</a>
                                    <a class="dropdown-item disabled" href="#" id="dioptrias">Dioptrias</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Stock
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <!-- <a class="dropdown-item" href="#" id="entradasSalidas">Formulario de entradas y salidas</a> -->
                                    <a class="dropdown-item" href="#" id="motivoMovimiento">Motivo movimientos</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Informes
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" target="_blank" href="../php/pdf/insumos.php" id="lista_insumos">Listado insumos</a>
                                    <a class="dropdown-item" target="_blank" href="../php/pdf/proveedores.php" id="lista_proveedores">Listado proveedores</a>
                                    <a class="dropdown-item" target="_blank" href="../php/pdf/productos.php" id="lista_productos">Listado productos</a>
                                    <a class="dropdown-item disabled" href="#" id="lista_vencimientos">Listado vencimientos</a>
                                </div>
                            </li>
                            <div class="d-block d-sm-block d-md-none">
                              <li class="nav-item">
                                  <a class="nav-link" href="../php/stock/stock/salirMovil.php">
                                      Salir
                                  </a>
                              </li>
                            </div>
                        </ul>
                    </div>
                  </nav>

                    <!--CONTENIDO DE SECCION-->
                      <section class="container" id="usuariosConectados"></section>
                      <div id="contenedorCategoriaStock">
                        <div class="posRelativa">
                          <img src="../img/actives/vejaMoreno.png" class="ajustarCentro img-fluid img-fluid animate__animated animate__zoomInUp">
                        </div>
                      </div>
                      <!-- FIN CONTENIDO DE SECCION-->



              
                </div>
              </div>
            </div>
          </div>
        </div>
      <!--FIN STOCK-->
      <!--TESORERIA-->
        <div class="collapse" id="seccionTesoreria">
          <div class="row">
            <div class="col">
              <div class="card">
                <div class="card-body">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="#"><i class="fas fa-home"></i> Tesoreria</i></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                      <ul class="navbar-nav">

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Administración
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#" id="bancos">Bancos</a>
                                <a class="dropdown-item" href="#" id="facturacionOpcionesCobroPago">Formas de cobros y pagos</a>
                            </div>
                        </li>
                      </ul>
                    </div>
                </nav>
                  <!--CONTENIDO DE SECCION-->
                    <div id="contenedorCategoriaTesoreria">
                      <div class="posRelativa">
                        <img src="../img/actives/vejaMoreno.png" class="ajustarCentro img-fluid animate__animated animate__zoomInUp">
                      </div>
                    </div>
                  <!--FIN CONTENIDO DE SECCION-->
                </div>
              </div>
            </div>
          </div>
        </div>
      <!--FIN TESORERIA-->
      <div class="row">
        <div class="col-12">
          <div id="ohsnap"></div> 
        </div>
      </div>
    </div>
    <script src="../js/principal.js"></script>
    <script src="../js/soloRecepcion.js"></script>
    <script src="../js/soloPrincipal.js"></script>
    <script src="../js/soloFacturacion.js"></script>
    <script src="../js/soloAdministracionGeneral.js"></script>
    <script src="../js/soloStock.js"></script>
    <script src="../php/stock/loginStockApp.js"></script>
    <?php
    if($_SESSION['stock'] == "1"){
    echo '<script>
    mostrarSoloStock();

    //registrar service worker de stock
    // if ("serviceWorker" in navigator) {
    //   navigator.serviceWorker
    //     .register("../php/stock/swStock.js")
    //     .then(() => console.log("ServiceWorker en principal registrado"))
    //     .catch(() => console.log("serviceWorker en principal no registrado"));
    // }

    </script>';
    }else{
      echo '<script>
      //cargarMensajes
      cargarMensajes();
      </script>';
    }
    ?>
  </body>
</html>
<?php
}
?>