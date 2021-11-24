<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../");
}else{
    if(isset($_POST['m'])){
        $to = $_POST['m'];
        require_once("phpmailer/class.phpmailer.php");
        $mail = new PHPMailer();
        $mail->From = "turnos@clinicavejamoreno.com.ar";
        $mail->FromName = "Turnos - Veja Moreno";
        $mail->Subject = "Turno reservado VEJA MORENO Clínica Oftalmológica";
        $mail->isHTML(true);
        $mail->Body = '<!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
            </head>
            <body>
                <div class="text-center mt-2">
                    <p><h5>Turno reservado.</h5></p>
                    <p><h6>'.$_POST['msg'].'</h6></p>
                    <p><small>No comparta esta infomarción.</small></p>
                </div>
            </body>
            </html>';
        $mail->AddAddress($to);

        $mail->Send();
    }
}
?>