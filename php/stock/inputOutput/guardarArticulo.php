<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $flagInsertar = false;

    if(mysqli_query($stock, "INSERT INTO articulos VALUES(NULL, 
        '".$_POST['grupo']."',
        '".$_POST['rubro']."',
        '".$_POST['codBarras']."',
        '".strtoupper($_POST['nombre'])."',
        '0',
        '-',
        '-',
        '-',
        '".$_POST['img']."',
        '".$_POST['stockMin']."',
        '".strtoupper($_POST['observaciones'])."',
        '".$_POST['activo']."')")){
        $flagInsertar = true;
    }else{
        $flagInsertar = false;
    }

    $peticion = mysqli_query($stock, "SELECT 
    id 
    FROM articulos 
    WHERE nombre = '".$_POST['nombre']."' 
    AND codigo_barra = '".$_POST['codBarras']."'
    ORDER BY id DESC
    LIMIT 1");
    while($a = mysqli_fetch_assoc($peticion)){
        if(mysqli_query($stock, "INSERT INTO existencias VALUES(NULL, '".$a['id']."', '0')")){
            if($_POST['rubro'] == "2"){
                mysqli_query($stock, "INSERT INTO lentes VALUES(NULL,
                '".$a['id']."',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0'
                )");
            }
            $flagInsertar = true;
        }else{
            $flagInsertar = false;
        }
    }
    if($flagInsertar){
        echo "1";
    }else{
        echo "0";
    }
    mysqli_close($stock);
}
?>