<?php

namespace core\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Class Email
 * @package core\classes
 */
class Email
{


    /**
     * @param $toEmail
     * @param $toName
     * @param $subject
     * @param $bod
     * @return bool
     */
    public function enviar_email($toEmail, $toName, $subject, $bod): bool
    {

        //Import PHPMailer classes into the global namespace
        //These must be at the top of your script, not inside a function

        //Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        $toEmail = mb_strtolower((trim($toEmail)));

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = APP_EMAIL_SMTP;                             //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = APP_EMAIL_ADDRESS;                     //SMTP username
            $mail->Password = APP_EMAIL_PASS;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->CharSet = "UTF-8";

            //Recipients
            $mail->setFrom(APP_EMAIL_ADDRESS, "PHP Loja");
            $mail->addAddress($toEmail, $toName);

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $bod;

            $mail->send();

            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return true;
        }
    }

}