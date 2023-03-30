<?php
require '../../assets/PHPMailer/src/PHPMailer.php';
require '../../assets/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class EmailSender
{
    /**
     * Function taht sends the email when a new account is created
     * @param $email string, the email of the user
     * @param $password string, the password in plaintext of the account
     * @return string|true an error string
     *                      or true if the email is sent
     */
    static function sendNewAccount($email, $password)
    {
        $mail = new PHPMailer(true);
        try{
            $mail->CharSet = 'UTF-8';
            $mail->setFrom('admin@training.trasis.com');
            $mail->addAddress($email);
            $mail->addReplyTo('no-reply@training.trasis.com');
            $mail->isHTML(false);
            $mail->Subject = 'Access Trasis Training';
            $mail->Body = 'Hello, here are your access credentials for your account on Trasis Training \r\n'
                . "Email : " . $email . "\r\nPassword : " . $password
                . "\r\nPlease don\'t forget to change your password when you log in for the first time.";
            $mail->send();
            return true;
        } catch (Exception $e){
            return 'Erreur survenue lors de l\'envoi de l\'email.'.$mail->ErrorInfo;
        }
    }
}