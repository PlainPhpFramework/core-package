<?php

// Variables used in the email template
$config->email_logo_path = ROOT.'/public/assets/logo.email.png';
$config->email_logo_width = 171;
$config->email_logo_height = 25;

// @See: https://github.com/PHPMailer/PHPMailer
// @See: https://github.com/PHPMailer/PHPMailer/tree/master/examples

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Create an instance of PHP Mailer adding the method message; passing `true` enables exceptions
$mail = new class (true) {

    function message($view, array $params = []) 
    {
        extract($params);
        ob_start();
        require $view;
        $this->msgHTML(ob_get_clean());
    }

} extends PHPMailer;

//Server settings
$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'user@example.com';                     //SMTP username
$mail->Password   = 'secret';                               //SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

//Recipients
$mail->setFrom('from@example.com', 'Mailer');
$mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
$mail->addAddress('ellen@example.com');               //Name is optional
$mail->addReplyTo('info@example.com', 'Information');
$mail->addCC('cc@example.com');
$mail->addBCC('bcc@example.com');

return $mail;

/*
//Attachments
$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name


//Content   
$mail->isHTML(true); //Set email format to HTML
$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
$mail->send();

// Usage in a controller
function sendEmail() 
{
    $mailer = (require 'config/mailer.php')
        ->addAddress($user->email, $user->name);

    $mailer->subject = 'Welcome'
    $mailer->message('view/user.registration.email.php', ['user' => $user]);

    $mailer->send();
    return true;
}
*/



