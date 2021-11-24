
<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    $carpeta = "../../../img/products/";
    if(move_uploaded_file($_FILES['file']['tmp_name'], $carpeta.$_FILES['file']['name'])){
        echo "1";
    }else{
        echo "0";
    }
}
?>
