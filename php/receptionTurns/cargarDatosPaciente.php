<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
  echo '<script>
  $("#modalEditarPacienteCelular").mask("(000)0-000-000", {placeholder: "(000)0-000-000"});
  $("#modalEditarPacienteDNI").mask("00000000", {placeholder: "00000000"});
  </script>';
    require_once("../conn.php");
    $peticion = mysqli_query($veja, "SELECT * FROM pacientes WHERE id = '".$_POST['id']."' LIMIT 1");

        while($p = mysqli_fetch_assoc($peticion)){
            $fecha_nacimiento = new DateTime(date('Y-m-d', strtotime($p['fecha_nacimiento'])));
            $hoy = new DateTime();
            $edad = $hoy->diff($fecha_nacimiento);
            echo '<div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <small for="modalEditarPacienteDNI">DNI</small>
                    <input type="text" value="'.$p['id'].'" id="modalEditarPacienteId" hidden>
                    <input type="text" value="'.$p['DNI'].'" class="form-control" id="modalEditarPacienteDNI" placeholder="DNI">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                      <small for="modalEditarPacienteApellido">Apellido</small>
                      <input type="text" value="'.$p['apellido'].'" class="form-control" id="modalEditarPacienteApellido" placeholder="Apellido">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <small for="modalEditarPacienteNombre">Nombre</small>
                    <input type="text" value="'.$p['nombre'].'" class="form-control" id="modalEditarPacienteNombre" placeholder="Nombre">
                  </div>
                </div>
                <div class="col-md-3" style="max-width: 230px;">
                  <div class="form-group">
                      <small for="modalEditarPacienteFechaNacimiento">Fecha De Nacimiento</small>
                      <input type="date" value="'.$p['fecha_nacimiento'].'" class="form-control" id="modalEditarPacienteFechaNacimiento">
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                      <small for="modalEditarPacienteEdad">Edad</small>
                      <input disabled type="text" value="'.$edad->y.'" class="form-control" id="modalEditarPacienteEdad">
                  </div>
                </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="form-group">
                    <small for="modalEditarPacienteDomicilio">Domicilio</small>
                    <input type="text" value="'.$p['domicilio'].'" class="form-control" id="modalEditarPacienteDomicilio" placeholder="Domicilio">
                </div>
              </div>
              <div class="col-md-3" style="max-width: 220px;">
                <div class="form-group">
                    <small for="modalEditarPacienteProvincia">Provincia</small>
                    <select id="modalEditarPacienteProvincia" class="form-control custom-select">';

                        $provincias = mysqli_query($veja, "SELECT * FROM provincias ORDER BY provincia ASC");
                        while($l = mysqli_fetch_assoc($provincias)){
                          if($p['provincia'] == $l['id']){
                            echo '<option selected value="'.$l['id'].'">'.strtoupper($l['provincia']).'</option>';
                          }else{
                              echo '<option value="'.$l['id'].'">'.strtoupper($l['provincia']).'</option>';
                          }
                          
                        }
                      
                    echo'</select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                    <small for="modalEditarPacienteLocalidad">Localidad</small>
                    <select id="modalEditarPacienteLocalidad" class="form-control custom-select">';
                        $localidades = mysqli_query($veja, "SELECT * FROM localidades ORDER BY localidad ASC");
                        while($l = mysqli_fetch_assoc($localidades)){
                          if($p['localidad'] == $l['id']){
                              echo '<option selected value="'.$l['id'].'">'.strtoupper($l['localidad']).'</option>';
                          }else{
                              echo '<option value="'.$l['id'].'">'.strtoupper($l['localidad']).'</option>';
                          }
                        }
                    echo '</select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <small for="modalEditarPacienteSexo">Sexo</small>
                  <select class="form-control custom-select" id="modalEditarPacienteSexo">';
                    if($p['sexo'] == "0"){
                      echo '<option selected value="0">MASCULINO</option>
                      <option value="1">FEMENINO</option>';
                    }else{
                      echo '<option value="0">MASCULINO</option>
                      <option selected value="1">FEMENINO</option>';
                    }
                  echo '</select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <small for="modalEditarPacienteTelFijo1">Teléfono Fijo 1 (Opcional)</small>
                  <input type="text" value="'.$p['tel1'].'" class="form-control" laceholder="Teléfono fijo 1" id="modalEditarPacienteTelFijo1">
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <small for="modalEditarPacienteTelFijo2">Teléfono Fijo 2 (Opcional)</small>
                  <input type="text" value="'.$p['tel2'].'" placeholder="Teléfono fijo 2" id="modalEditarPacienteTelFijo2" class="form-control">
                </div>
              </div>
              <div class="col-md-3" style="max-width:240px">
                <div class="form-group">
                  <small for="modalEditarPacienteCelular">Celular</small>
                  <input type="text" value="'.$p['cel'].'" id="modalEditarPacienteCelular" class="form-control">
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                  <small for="modalEditarPacienteEmail">Email</small>
                  <input type="text" value="'.$p['email'].'" id="modalEditarPacienteEmail" class="form-control" placeholder="Email">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <small for="modalEditarPacienteCobrtura">Cobertura social</small>
                  <select class="form-control custom-select" id="modalEditarPacienteCobrtura">
                    <option value="0">Seleccione cobertura social</option>';
                      $cobertura = mysqli_query($veja, "SELECT codigo, cobertura_social FROM coberturas_sociales WHERE activo = '1' AND tipo = '1' ORDER BY cobertura_social ASC");
                      while($c = mysqli_fetch_assoc($cobertura)){
                          if($p['cobertura_social'] == $c['codigo']){
                              echo '<option selected value="'.$c['codigo'].'">'.$c['cobertura_social'].'</option>';
                          }else{
                              echo '<option value="'.$c['codigo'].'">'.$c['cobertura_social'].'</option>';
                          }
                      }

                  echo '</select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                    <small for="modalEditarPacienteN_carnet">N° carnet</small>
                    <input class="form-control" type="text" id="modalEditarPacienteN_carnet" value="'.$p['n_carnet'].'" placeholder="N° carnet">  
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                    <small for="modalEditarPacienteCoseguro">Coseguro</small>
                    <select class="form-control" id="modalEditarPacienteCoseguro">
                      <option value="0">NINGUNO</option>';
                      $coseguro = mysqli_query($veja, "SELECT codigo, cobertura_social FROM coberturas_sociales WHERE activo = '1' AND tipo = '2' ORDER BY cobertura_social ASC");
                        while($c = mysqli_fetch_assoc($coseguro)){
                          if($p['coseguro'] == $c['codigo']){
                            echo '<option selected value="'.$c['codigo'].'">'.$c['cobertura_social'].'</option>';
                          }else{
                            echo '<option value="'.$c['codigo'].'">'.$c['cobertura_social'].'</option>';
                          }
                        }
                      
                    echo '</select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                    <small for="modalEditarPacienteCarnetCoseguro">N° coseguro</small>
                    <input type="text" id="modalEditarPacienteCarnetCoseguro" class="form-control" value="'.$p['n_carnet_coseguro'].'" placeholder="N° de carnet coseguro">  
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <small for="modalEditarPacienteObservacion">Observaciones</small>
                  <textarea class="form-control" id="modalEditarPacienteObservacion">'.$p['observacion'].'</textarea>
                </div>
              </div>
            </div>';
        }

    mysqli_close($veja);
}
?>