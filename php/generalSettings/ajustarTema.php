<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $colorTema = array(array("255, 165, 0", "Orange"), array("70, 130, 180", "Steelblue"), array("102, 51, 153", "Rebeccapurple"), array("46, 139, 87", "Seagreen"));
    $colorFuente = array(array("240, 248, 255", "Aliceblue"), array("50, 50, 50", "Black"));
    echo '<div class="animate__animated">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="ajustarTema-tab" data-toggle="tab" href="#ajustarTema" role="tab" aria-controls="ajustarTema" aria-selected="true"><i class="fas fa-paint-roller"></i> Ajustar tema</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active mt-4" id="ajustarTema" role="tabpanel" aria-labelledby="ajustarTema-tab">
    
            







                <div class="row">

                    <div class="col-12">
                        <h4 class="mb-4">Ajustar tema</h4>
                    </div>    

                </div>';

                echo '<div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="colorTema">Cambiar tema</label>
                            <select id="colorTema" data-user="'.$_SESSION['id'].'" class="form-control">';
                            $peticion = mysqli_query($veja, "SELECT theme_color FROM users WHERE id = '".$_SESSION['id']."'");
                            while($c = mysqli_fetch_assoc($peticion)){
                                for($i = 0; $i < count($colorTema); $i++){
                                    if($c['theme_color'] == $colorTema[$i][0]){
                                        echo '<option value="'.$colorTema[$i][0].'" selected>'.$colorTema[$i][1].'</option>';
                                    }else{
                                        echo '<option value="'.$colorTema[$i][0].'" >'.$colorTema[$i][1].'</option>';
                                    }
                                }
                            }
                            echo '</select>  
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="colorFont">Color de fuente</label>
                            <select id="colorFont" data-user="'.$_SESSION['id'].'" class="form-control">';
                            $peticion = mysqli_query($veja, "SELECT font_theme_color FROM users WHERE id = '".$_SESSION['id']."'");
                            while($c = mysqli_fetch_assoc($peticion)){
                                for($i = 0; $i < count($colorFuente); $i++){
                                    if($c['font_theme_color'] == $colorFuente[$i][0]){
                                        echo '<option value="'.$colorFuente[$i][0].'" selected>'.$colorFuente[$i][1].'</option>';
                                    }else{
                                        echo '<option value="'.$colorFuente[$i][0].'" >'.$colorFuente[$i][1].'</option>';
                                    }
                                }
                            }
                            echo '</select>    
                        </div> 
                    </div>
                </div>







            </div>

        </div>
    </div>';
}

?>