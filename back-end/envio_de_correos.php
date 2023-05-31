<?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
function enviarCorreo($email, $asunto, $mensaje){
    //Load Composer's autoloader
    require 'PHP MAILER/Exception.php';
    require 'PHP MAILER/PHPMailer.php';
    require 'PHP MAILER/SMTP.php';
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0; //0 no debug, 2 para debug                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'paginatiendapruebas@outlook.es';                     //SMTP username
        $mail->Password   = '1234pruebas';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        /*
            para el Host y el Port tienes que buscar en google el servicio que vas a utilizar, en mi caso outlook
            el smtp que utiliza
        */

        $mail->CharSet = 'UTF-8';
        //Recipients
        $mail->setFrom('paginatiendapruebas@outlook.es', 'SimplyMinimal'); //Add a recipient
        $mail->addAddress($email);               //Name is optional
        $mail->addAddress('paginatiendapruebas@outlook.es');

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $asunto;
        $mail->Body    = $mensaje;

        $mail->send();
        return 'enviado';
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>