<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    $carpeta = "../../img/users/";
    $peticion = mysqli_query($veja, "SELECT id FROM users WHERE avatar = '".$_FILES['file']['name']."'");
    if(mysqli_num_rows($peticion) > 0){
        echo "2"; // existe archivo
    }else{
        $consulta = mysqli_query($veja, "SELECT avatar FROM users WHERE id = '".$_POST['idUsuario']."' LIMIT 1");
        while($i = mysqli_fetch_assoc($consulta)){
            if($i['avatar'] != 'default_user.jpg'){
                unlink($carpeta.$i['avatar']);
            }
        }
        if(move_uploaded_file($_FILES['file']['tmp_name'], $carpeta.$_FILES['file']['name']) 
        &&
        mysqli_query($veja, "UPDATE users SET avatar = '".$_FILES['file']['name']."' WHERE id = '".$_POST['idUsuario']."' LIMIT 1")){
            echo "1"; //actualizacion completa
        }else{
            echo "0"; //no se udo actualizar
        }
    }
    mysqli_close($veja);
}
?>