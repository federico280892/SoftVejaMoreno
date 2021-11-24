<?php
session_start();
if(isset($_SESSION['id'])){
    require_once("../conn.php");

    if(mysqli_query($veja, "UPDATE otros_horarios SET 
    apLun = '".$_POST['oHApLun1']."', 
    ciLun = '".$_POST['oHCiLun1']."', 
    apMar = '".$_POST['oHApMar1']."', 
    ciMar = '".$_POST['oHCiMar1']."', 
    apMie = '".$_POST['oHApMie1']."', 
    ciMie = '".$_POST['oHCiMie1']."', 
    apJue = '".$_POST['oHApJue1']."', 
    ciJue = '".$_POST['oHCiJue1']."', 
    apVie = '".$_POST['oHApVie1']."', 
    ciVie = '".$_POST['oHCiVie1']."', 
    apSab = '".$_POST['oHApSab1']."', 
    ciSab = '".$_POST['oHCiSab1']."', 
    apDom = '".$_POST['oHApDom1']."', 
    ciDom = '".$_POST['oHCiDom1']."',
    desde = '".$_POST['desde']."',
    hasta = '".$_POST['hasta']."'
    WHERE turno = '1' AND id_medico = '".$_POST['idMedico']."' LIMIT 1")
    &&
    mysqli_query($veja, "UPDATE otros_horarios SET 
    apLun = '".$_POST['oHApLun2']."', 
    ciLun = '".$_POST['oHCiLun2']."', 
    apMar = '".$_POST['oHApMar2']."', 
    ciMar = '".$_POST['oHCiMar2']."', 
    apMie = '".$_POST['oHApMie2']."', 
    ciMie = '".$_POST['oHCiMie2']."', 
    apJue = '".$_POST['oHApJue2']."', 
    ciJue = '".$_POST['oHCiJue2']."', 
    apVie = '".$_POST['oHApVie2']."', 
    ciVie = '".$_POST['oHCiVie2']."', 
    apSab = '".$_POST['oHApSab2']."', 
    ciSab = '".$_POST['oHCiSab2']."', 
    apDom = '".$_POST['oHApDom2']."', 
    ciDom = '".$_POST['oHCiDom2']."',
    desde = '".$_POST['desde']."',
    hasta = '".$_POST['hasta']."'
    WHERE turno = '2' AND id_medico = '".$_POST['idMedico']."' LIMIT 1")){
        echo "1";
    }else{
        echo "0";
    }

    mysqli_close($veja);
}else{
 header("Location: ../../");   
}
?>