<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    echo '<script>
        $("#modalAgregarDatosPacienteDNISolicitante").mask("00000000", {placeholder: "00000000"});
        //tabla pmo
        $("#tabla-pmo").DataTable({
            paging: false,
            ordering: false,
            searching: false,
            info: false,
            "language": {
                "zeroRecords": "Sin prestaciones cargadas",
            },
        });

        //tabla formas de pago
        $("#tabla-formas-de-pago").DataTable({
            paging: false,
            ordering: false,
            searching: false,
            info: false,
            "language": {
                "zeroRecords": "Sin registros",
            },
        });
    </script>';
    echo '<div class="animate__animated">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="agregarTurno-tab" data-toggle="tab" href="#agregarTurno" role="tab" aria-controls="agregarTurno" aria-selected="true"><i class="fas fa-plus-circle"></i> Agregar un turno</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="turnosReservados-tab" data-toggle="tab" href="#turnosReservados" role="tab" aria-controls="turnosReservados" aria-selected="false"><i class="far fa-calendar-check"></i> Turnos reser<b>v</b>ados</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="export-tab" data-toggle="tab" href="#export" role="tab" aria-controls="export" aria-selected="false"><i class="fas fa-info-circle"></i> Informes</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active mt-4" id="agregarTurno" role="tabpanel" aria-labelledby="agregarTurno-tab">

            <div class="container" >
                <div class="row">   
                    <div class="col shadow" style="background-color: rgb(246, 246, 246); padding: 2rem; margin-right: 2rem; border-radius: 1.5rem;">
                        <section class="paciente">
                            <p><b>Buscar solicitante:</b><p>
                            <div class="form-group">
                                <p>DNI del solicitante:</p>
                                <input style="box-shadow: 0px 0px 3px grey;" type="text" id="modalAgregarDatosPacienteDNISolicitante" class="form-control" placeholder="Ingrese DNI">
                            </div>
                            <div class="form-group">
                                <p>Apellido Y Nombre:</p>';
                                //echo '<input id="foo" type="text" class="form-control">';
                                echo '<input autocomplete="off" style="box-shadow: 0px 0px 3px grey;" type="text" id="modalAgregarDatosDelPacienteApyNom" class="form-control" placeholder="Apellido y nombre">
                                <div id="resultadoPacientes"></div>';
                                echo '
                            </div>
                            <p><b>Ingresar nuevo solicitante:</b><p>
                            <button type="button" class="btn btn-primary shadow">Nuevo paciente</button>
                        </section>
                    </div> 
                    <div class="col shadow" style="background-color: rgb(246, 246, 246); padding: 2rem; border-radius: 1.5rem;">
                        <section class="profesional">
                            <p><b>Seleccionar profesional:</b><p>
                            <div class="form-group">
                                <p>Matricula</p>
                                <input style="box-shadow: 0px 0px 3px grey;" type="text" id="nuevoTurnoMedicoMatricula"  placeholder="Matricula" style="text-aling: left;" class="form-control">                              
                            </div>         
                            <div class="form-group">
                                <p>Médico:</p>
                                <select style="box-shadow: 0px 0px 3px grey;" id="nuevoTurnoMedicoNombre" class="form-control custom-select">
                                <option data-matricula="-" value="0">Seleccione médico</option>';
                                $peticion = mysqli_query($veja, "SELECT id, apellido, nombre, codigo FROM medicos WHERE activo = 'true' ORDER BY apellido ASC");
                                while($m = mysqli_fetch_assoc($peticion)){
                                    echo '<option data-matricula="'.$m['codigo'].'" value="'.$m['id'].'">'.$m['apellido'].' '.$m['nombre'].'</option>';
                                }
                                echo '</select>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 shadow" style="background-color: rgb(246, 246, 246); padding: 2rem; margin-right: 2rem; margin-top: 2rem; border-radius: 1.5rem;">
                        <p><b>Datos del paciente:</b><p>
                        <section id="detallesPacienteTurno"class="detalle-paciente">
                        </section> 
                        <hr>
                        <p><b>Solicitud turno:</b><p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Presencial
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Vía telefónica
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Vía Web
                            </label>
                        </div>
                    </div>
                    <div  class="col" id="contendedorCalendario" >
                        <div class="row" style="widht: 100%; height: 100%;">
                            <div class="col shadow" style="background-color: rgb(246, 246, 246); padding: 2rem; margin-top: 2rem; margin-right:2rem; border-radius: 1.5rem;" id="calendario" ></div>
                            <div class="col shadow" style="background-color: rgb(246, 246, 246); padding: 2rem; margin-top: 2rem; border-radius: 1.5rem;" id="calendarioDetalles"></div>                          
                        </div>
                    </div>                          
                </div>
            </div>

            

                        

             
                        


            

                   
                    
   



            </div>
            <div class="tab-pane fade mt-4" id="turnosReservados" role="tabpanel" aria-labelledby="turnosReservados-tab">
                <div class="row">
                    <div class="col collapse" id="formularioCobrarTurno">
                        <div class="row">
                            <div class="col">
                                <h5>Cobrar turno</h5>
                            </div>
                        </div>
                        <div class="row" style="font-size: 12px">
                            <div class="col" style="max-width: 160px;">
                                <div class="form-group">
                                    <small">N° cobro</small>';
                                    
                                    $ultimoCobro = mysqli_query($veja, "SELECT num_cobro FROM pagos ORDER BY id DESC LIMIT 1");
                                    if(mysqli_num_rows($ultimoCobro) > 0){
                                        while($nC = mysqli_fetch_assoc($ultimoCobro)){
                                            $numero_cobro = ($nC['num_cobro'] + 1);
                                        }
                                    }else{
                                        $numero_cobro = 1000000;
                                    }
                                    echo '<input disabled id="modalCobrarTurnoNumCobro" type="text" value="'.$numero_cobro.'" class="form-control-sm text-center" style="width: 80px;">';
                                    
                                echo '</div>
                            </div>
                            <div class="col" style="max-width: 145px;">
                                <div class="form-group">
                                    <small>Turno N°</small>
                                    <input id="modalCobrarTurnoNTurno" disabled type="text" class="form-control-sm text-center" style="width: 70px;">
                                </div>
                            </div>
                            <div class="col" style="max-width:175px;">
                                <div class="form-group">
                                    <small>Fecha turno</small>
                                    <input id="modalCobrarTurnoFechaTurno" disabled type="text" class="form-control-sm text-center" style="width: 85px;">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <small>Medico</small>
                                    <input id="modalCobrarTurnoFechaTurnoMedico" disabled class="form-control-sm" style="width: 215px">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <small>Paciente</small>
                                    <input id="modalCobrarTurnoNPaciente" disabled type="text" class="form-control-sm" style="width: 210px;">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                <small>Fecha de cobro</small>
                                <input type="date" class="form-control-sm text-center borde-input" id="modalCobrarTurnoFechaActual">
                                </div>
                            </div>
                                
                        </div>
                        <div class="row">                            
                            <div class="col text-right" style="margin-right: 25px;">
                                <small for="">Control</small>
                                <input type="checkbox" id="modalCobrarTurnoControl">
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
                                    <select id="modalCobrarTurnoCoberturaSocial" class="form-control-sm custom-select-sm borde-input" style="width: 100%;">';
                                        
                                        $peticion = mysqli_query($veja, "SELECT codigo, cobertura_social FROM coberturas_sociales WHERE activo = '1' AND tipo = '1' ORDER BY cobertura_social ASC");
                                        while($o = mysqli_fetch_assoc($peticion)){
                                            echo '<option class="cobertura" data-buscar="'.$o['cobertura_social'].'" value="'.$o['codigo'].'">'.$o['cobertura_social'].'</option>';
                                        }
                                        
                                    echo '</select>
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
                                    <select id="modalCobrarTurnoCoseguro" class="form-control-sm custom-select-sm borde-input" id="" style="width: 100%;">';
                                        
                                            $peticion = mysqli_query($veja, "SELECT codigo, cobertura_social FROM coberturas_sociales WHERE activo = '1' AND tipo = '2' ORDER BY cobertura_social ASC");
                                            while($o = mysqli_fetch_assoc($peticion)){
                                            echo '<option value="'.$o['codigo'].'">'.$o['cobertura_social'].'</option>';
                                            }
                                        
                                    echo '</select>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>
                            <div class="col-4">
                            <div class="row">
                                <div class="col-12">
                                <div class="form-group">
                                    <input type="text" id="modalCobrarTurnoFiltrarCoberturas" class="form-control-sm borde-input" style="width: 360px;">
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
                                <input type="text" class="form-control-sm borde-input" style="width: 1157px;" id="modalCobrarTurnoObservaciones">
                            </div>
                            </div>
                        </div>

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
                <div id="listaTurnosReservados">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <small>Buscar turnos por doctor</small><br>
                                <select class="form-control-sm custom-select-sm borde-input" id="selectTurnosPorDoctor">
                                    <option value="0">Seleccione un médico</option>';
                                $peticion = mysqli_query($veja, "SELECT id, apellido, nombre FROM medicos ORDER BY apellido ASC");
                                    while($d = mysqli_fetch_assoc($peticion)){
                                        echo '<option value="'.$d['id'].'">'.$d['apellido'].' '.$d['nombre'].'</option>'; 
                                    }
                                echo '</select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <small>Fecha del turno</small><br>
                                <input type="date" class="form-control-sm borde-input" id="inputFechaABuscar">      
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <small>Busqueda rápida</small><br>
                            <input type="search" id="buscarTurnoReservado" class="form-control-sm borde-input" placeholder="¿Qué busca?" style="width: 300px;">
                            </div> 
                        </div>
                        <div class="col-md-4">
                            <div class="form-group text-left" id="barraHerramientasTurnosTomados">
                                <small>Herramientas</small><br>
                                <i role="button" title="Actualizar tabla" id="actualizarGrilla" class="fas fa-search text-info mr-3" style="font-size: 20px;"></i>
                                <i role="button" title="Confirmar turno" id="marcarConfirmado" class="fas fa-check text-success mr-3" style="display:none;font-size: 20px;"></i>
                                <i role="button" title="Pegar turno" id="pegarTurno" class="fas fa-paste text-info mr-3" onclick="pegarTurno()" style="display: none;font-size: 20px;"></i>
                                <i role="button" title="Cortar turno" id="cortarTurno" class="fas fa-cut text-info mr-3" style="display:none;font-size: 20px;"></i>
                                <i role="button" title="Eliminar turno" id="botonEliminarTurno" class="fas fa-trash text-danger mr-3" style="display: none;font-size: 20px;"></i>
                                <i role="button" title="Editar turno" id="opcionEditarTurno" class="fas fa-edit text-info mr-3" style="display: none;font-size: 20px;"></i>
                                <i data-toggle="collapse" href="#formularioCobrarTurno" role="button" aria-expanded="false" aria-controls="formularioCobrarTurno" role="button" title="Cobrar turno" id="opcionCobrarTurno" class="fas fa-hand-holding-usd text-success mr-3" style="display: none;font-size: 20px;"></i>
                                <i role="button" title="Historial de turnos" id="opcionHistorialDeTurnos" class="fas fa-book-medical text-info mr-3" style="display: none;font-size: 20px;"></i>
                                <i role="button" title="Editar paciente" id="opcionEditarPaciente" class="fas fa-male text-info mr-3" style="display: none;font-size: 20px;"></i>
                            </div>
                        </div>



                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="bg-info" style="color: aliceblue; height:25px;">
                                    <th class="align-middle text-center"><span style="width: 17px;">#</span></th>
                                    <th class="align-middle text-center"><span style="width: 42px;">Inicio</span></th>
                                    <th class="align-middle text-center"><span style="width: 175px;">Paciente</span></th>
                                    <th class="align-middle text-center"><span style="width: 100px;">Cobertura social</span></th>
                                    <th class="align-middle text-center"><span style="width: 80px;">Estado</span></th>
                                    <th class="align-middle text-center"><span style="width: 330px;">Teléfonos</span></th>
                                    <th class="align-middle text-center"><span style="width: 145px;">Llegada</span></th>
                                    <th class="align-middle text-center"><span style="width: 45px;">Salida</span></th>
                                    <th class="align-middle text-center"><span style="width: 35px;">Pagó</span></th>
                                    <th class="align-middle text-center"><span style="width: 75px;">Confirmado</span></th>
                                    <th class="align-middle text-center"><span style="width: 160px;">Motivo</span></th>
                                    <th class="align-middle text-center"><span style="width: 160px;">Observación</span></th>
                                    <th class="align-middle text-center"><span style="width: 100px;">Cobertura Pago</span></th>
                                    <th class="align-middle text-center"><span style="width: 150px;">Cobró</span></th>
                                    <th class="align-middle text-center"><span style="width: 90px;">Número cobro</span></th>
                                    <th class="align-middle text-center"><span style="width: 140px;">Fecha de registro</span></th>
                                    <th class="align-middle text-center"><span style="width: 35px;">Otros</span></th>
                                </tr>
                            </thead>
                            <tbody id="respuestaTurnosReservados"><tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-2"><small class="badge consulta badge-pill">Consultas: <b id="cantidadConsultas"></b></small></div>
                            <div class="col-md-2"><small class="badge estudio badge-pill">Estudios: <b id="cantidadEstudios"></b></small></div>
                            <div class="col-md-2"><small class="badge cirugia badge-pill">Cirugias: <b id="cantidadCirugias"></b></small></div>
                            <div class="col-md-2"><small class="badge urgencia badge-pill">Urgencia: <b id="cantidadUrgencias"></b></small></div>
                            <i role="button" title="Marcar llegada" id="opcionMarcarLlegada" class="fas fa-arrow-down text-success" style="display: none;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade mt-4" id="export" role="tabpanel" aria-labelledby="export-tab">
                <div class="row">
                    <div class="col">
                        <small>Informes</small>
                    </div>
                </div>
            
            </div>
        </div>
    </div>';
}

?>