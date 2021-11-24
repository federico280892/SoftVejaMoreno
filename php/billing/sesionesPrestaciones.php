<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    echo $_SESSION['resultado'];
}
?>