<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../..");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "SELECT * FROM usuarios_conectados GROUP BY id_usuario ORDER BY nombre ASC");

    echo '<div class="row">
        <div class="col">
            <div class="usuarios">';
                while($u = mysqli_fetch_assoc($peticion)){
                    echo '<div class="usuario text-center">
                        <span class="usuarioInicial">'.$u['nombre'][0].'</span>
                        <span class="usuarioNombre">'.$u['nombre'].'</span>
                    </div>';
                }

            echo '</div>
        </div>
    </div>';


}
?>