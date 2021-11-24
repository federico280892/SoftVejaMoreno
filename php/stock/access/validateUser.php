<?php
require_once("../conn.php");
$peticion = mysqli_query($stock, "SELECT id, email, nombre, avatar, observacion FROM usuarios WHERE pass = BINARY '".$_POST['pass']."' AND email = BINARY '".$_POST['email']."' AND activo = '1'");
if(mysqli_num_rows($peticion) == 1){
    while($u = mysqli_fetch_assoc($peticion)){
        session_start();
        $_SESSION['id'] = $u['id'];
        $_SESSION['email'] = $u['email'];
        $_SESSION['nombre'] = $u['nombre'];
        $_SESSION['avatar'] = $u['avatar'];
        $_SESSION['observacion'] = $u['observacion'];
        mysqli_query($stock, "INSERT INTO usuarios_conectados VALUES(NULL, '".$_SESSION['id']."', '".$_SESSION['nombre']."')");
    }
    mysqli_close($stock);
    echo "1";
}else{
    echo "0";
}
?>