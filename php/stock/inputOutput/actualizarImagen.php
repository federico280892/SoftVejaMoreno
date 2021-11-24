<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $carpeta = "../../../img/products/";
    $flag = false;

        $peticion = mysqli_query($stock, "SELECT img FROM articulos WHERE id = '".$_POST['id']."' LIMIT 1");

        while($foto = mysqli_fetch_assoc($peticion)){
            if($foto['img'] != "default_product.jpg"){
                if(unlink($carpeta.$foto['img'])){
                    $flag = true;
                }else{
                    $flag = false;
                }
            }
        }
    
        if(move_uploaded_file($_FILES['file']['tmp_name'], $carpeta.$_FILES['file']['name'])){
            $flag = true;
        }else{
            $flag = false;
        }

        if(mysqli_query($stock, "UPDATE articulos SET img = '".$_FILES['file']['name']."' WHERE id = '".$_POST['id']."'")){
            $flag = true;
        }else{
            $flag = false;
        }
 
        if($flag){
            echo "1";
        }else{
            echo "0";
        }

    mysqli_close($stock);
}
?>
