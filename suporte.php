<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

if (isset($_POST['suporte'])) {

    $mail = new PHPMailer(true);

    try {
        
        $emailCliente = $_POST['email'];
        
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'jundismokesuporte@gmail.com';                     //SMTP username
        $mail->Password   = 'thpwdlwwpyeqzirt';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($emailCliente);
        $mail->addAddress('jundismokesuporte@gmail.com');     //Add a recipient
        $mail->addReplyTo('jundismokesuporte@gmail.com');

        $body = "Mensagem enviada por
                Nome: ". $_POST['nome']."<br>
                E-mail: ". $_POST['email']."<br>
                Mensagem: ". $_POST['mensagem']."<br>";

        $subjetct =$_POST['assunto'];

        //Attachments
        //$mail->addAttachment('./pedido.xls');         //Add attachments
 

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subjetct;
        $mail->Body    = $body;
       
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

}