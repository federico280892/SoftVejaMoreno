<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    if($_SESSION['resultado'] == 0){
        echo "1";
    }
}
?>