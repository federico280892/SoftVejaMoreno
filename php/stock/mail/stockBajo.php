<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../../");
}else{
    require_once("../../conn.php");
    $peticion = mysqli_query($stock, "SELECT articulos.nombre, existencias.cantidad FROM articulos INNER JOIN existencias ON existencias.id_articulo = articulos.id WHERE existencias.cantidad < 21");
       
    if(mysqli_num_rows($peticion) > 0){
        $insumosBajos = '<ul class="list-group">';
        while($i = mysqli_fetch_assoc($peticion)){
            $insumosBajos .= "<li class='list-group-item'>".$i['nombre'].": ".$i['cantidad']." unidades</li>";
        }
        $insumosBajos .= '</ul>';
        
        $flag = true;

    }else{
        $flag = false;
    }

    if($flag){

        $desde = "administracion@clinicavejamoreno.com.ar";
        $enviadoPor = "VEJA MORENO - Stock";
        $asunto = "Stock Bajo";
        $mensaje = '<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body>
            <div style="text-align:left;font-size:1.1rem;">
                <p style="font-size: 25px;font-weight: bold;margin-bottom: 10px;">Unidades Bajas. Por Favor Controle Sus Existencias.</p>
                '.$insumosBajos.'
            </div>
        </body>
        </html>';

        $to = "administracion@clinicavejamoreno.com.ar";

        require_once("phpmailer/class.phpmailer.php");
        $mail = new PHPMailer();
        $mail->From = $desde;
        $mail->FromName = $enviadoPor;
        $mail->Subject = $asunto;
        $mail->isHTML(true);
        $mail->Body = $mensaje;
        $mail->AddAddress($to);

        $mail->Send();
        echo "1";
    }else{
        echo "0";
    }
  
    mysqli_close($stock);
}
?>