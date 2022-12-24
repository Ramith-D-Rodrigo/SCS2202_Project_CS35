<?php

    require('../../libs/PHPMailer/src/PHPMailer.php');
    require('../../libs/PHPMailer/src/SMTP.php');
    require('../../libs/PHPMailer/src/Exception.php');
    require('../../config.php');    //get the configuration file for the PHPMailer

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    class Mailer{
        public static function sendMail($recipient, $recipient_name, $subject, $body){  //no need to create an object to call this function
            try{
                $mail = new PHPMailer();    //Create a new PHPMailer instance
                $mail -> isSMTP();     // Set mailer to use SMTP
                $mail -> Host = PHPMAILER_HOST;    // Specify main and backup SMTP servers
                $mail -> SMTPAuth = "true";     // Enable SMTP authentication
                $mail -> SMTPSecure  = PHPMAILER_SMTP_SECURE;    // Enable TLS encryption, `ssl` also accepted
                $mail -> Port = PHPMAILER_PORT;    // TCP port to connect to
                $mail -> Username = PHPMAILER_USERNAME;    // SMTP username
                $mail -> Password = PHPMAILER_PASSWORD;    // SMTP password
                $mail -> setFrom(PHPMAILER_FROM, PHPMAILER_FROM_NAME);    //Set who the message is to be sent from
                $mail -> addAddress($recipient, $recipient_name);    //Set who the message is to be sent to
                $mail -> Subject = $subject;    //Set the subject line
                $mail -> Body = $body;    //Set the body of the message
                $mail -> isHTML(true);    //Set the message format to HTML

                $mail -> send();
                //echo "Message has been sent";
                return true;
            }
            catch(Exception $e){
                //echo "Message could not be sent. Mailer Error: {$this -> mail -> ErrorInfo}";
                return false;
            }
        }
    }
?>