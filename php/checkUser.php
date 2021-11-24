<?php
require_once("conn.php");
$peticion = mysqli_query($veja, "SELECT id, stat, apellido, nombre, avatar FROM users WHERE user = BINARY '".$_POST['user']."' AND pass = BINARY '".$_POST['pass']."'");
if(mysqli_num_rows($peticion) == 1){
    session_start();
    $_SESSION['stock'] = $_POST['stock'];
    while($u = mysqli_fetch_assoc($peticion)){
        ////////////////////////////////////USUARIO////////////////////////////////////
        $_SESSION['id'] = $u['id'];
        $_SESSION['stat'] = $u['stat'];
        $_SESSION['apellido'] = $u['apellido'];
        $_SESSION['nombre'] = $u['nombre'];
        $_SESSION['avatar'] = $u['avatar'];

        ////////////////////////////////////COBRAR TURNO////////////////////////////////////
        $_SESSION['prestacion'] = array();
        $_SESSION['datosFormaPago'] = array();
        $_SESSION['total'] = 0.00;
        $_SESSION['resultado'] = 0.00;
        $_SESSION['ajuste'] = 0.00;

        ////////////////////////////////////STOCK////////////////////////////////////
        $_SESSION['listaArticulos'] = array();
    }
    echo "1";
}else{
    echo "0";
}
mysqli_close($veja);
?>