<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    echo '<div class="animate__animated">
    <h4>Feriados / Institucionales</h4>
        <div class="row">

                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="feriadoDia">Día</label>
                                <input type="date" id="feriadoDia" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="feriadoObservacion">Observación</label>
                                <textarea id="feriadoObservacion" placeholder="Observación" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button id="feriadosGuardar" class="btn btn-success btn-block">Guardar</button>  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Observación</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="listaFeriados">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

        </div>  
    </div>
    ';
}
?>