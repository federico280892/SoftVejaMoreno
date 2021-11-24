<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    require_once("../conn.php");
    if(mysqli_query($veja, "UPDATE users SET font_theme_color = '".$_POST['fontColor']."' WHERE id = '".$_POST['user']."' LIMIT 1")){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($veja);
}
?>