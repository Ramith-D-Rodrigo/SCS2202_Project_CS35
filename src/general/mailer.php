<?php

    require('../../libs/PHPMailer/src/PHPMailer.php');
    require('../../libs/PHPMailer/src/SMTP.php');
    require('../../libs/PHPMailer/src/Exception.php');
    require_once('../../config.php');    //get the configuration file for the PHPMailer

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    class Mailer{
        public static function sendMail($recipient, $recipient_name, $subject, $body){  //no need to create an object to call this function
            try{
                $mail = new PHPMailer(true);    //Create a new PHPMailer instance
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

        public static function registerAccount($recipientEmail, $recipient_name, $mailVerificationCode){   //this function is used to send the verification code to the user's email upon registration
            $subject = "Account Registration";
            $body = "<p>Hi $recipient_name,</p>
                    <p>Thank you for registering with us. Your account is not activated yet. Please use the following verification code to activate your account.</p>
                    <p>Code : {$mailVerificationCode} </p>
                    <p>If you did not register with us, please ignore this email.</p>
                    <p>Regards,<br>Sportude Support</p>";
            return self::sendMail($recipientEmail, $recipient_name, $subject, $body);
        }

        public static function activateAccount($recipientEmail, $recipient_name, $mailVerificationCode){   //this function is used to send the verification code for account activation
            $subject = "Account Activation";
            $body = "<p>Hi $recipient_name,</p>
                    <p>Your account is not activated. Please use the following verification code to activate your account.</p>
                    <p>Code : {$mailVerificationCode} </p>
                    <p>If you did not request to activate your account, please ignore this email.</p>
                    <p>Regards,<br>Sportude Support</p>";
            return self::sendMail($recipientEmail, $recipient_name, $subject, $body);
        }

        public static function passwordReset($recipientEmail, $recipient_username, $verificationCode){   //this function is used to send the verification code for account activation
            $subject = "Password Reset Verification";
            $body = "<p>Hi $recipient_username,</p>
                    <p>You have requested to reset your password. Please use the following code to verify the action.</p>
                    <p>Code : {$verificationCode} </p>
                    <p>If you did not request to reset your password, please ignore this email.</p>
                    <p>Regards,<br>Sportude Support</p>";
            return self::sendMail($recipientEmail, $recipient_username, $subject, $body);
        }

        public static function deactivateAccount($recipientEmail, $recipientUsername, $verifcationCode){
            $subject = "Account Deactivation Verification";
            $body = "<p>Hi $recipientUsername,</p>
                    <p>You have requested to deactivate your account. Please use the following code to verify the action.</p>
                    <p>Code : {$verifcationCode} </p>
                    <p>If you did not request to deactivate your account, please ignore this email.</p>
                    <p>Regards,<br>Sportude Support</p>";
            return self::sendMail($recipientEmail, $recipientUsername, $subject, $body);
        }

        public static function deactivateAccountNotification($recipientEmail, $recipientUsername){
            $subject = "Your Sportude Account Deactivation";
            $body = "<p>Hi $recipientUsername,</p>
                    <p>It is sad to see you go, Thank you for being part of our website.</p>
                    <p>If you want to reactivate your account in the future, log in with the same credentials and follow the shown process.</p>
                    <p>Until next time, Thank you.</p>
                    <p>Regards,<br>Sportude Support</p>";
                    
            return self::sendMail($recipientEmail, $recipientUsername, $subject, $body);
        }

        public static function onlineReservationPayment($recipientEmail, $recipientUsername, $branchName, $sportName, $courtName, $date, $startingTime, $endingTime, $amount, $currency){
            $subject = "Online Reservation";
            $body = "<p>Hi $recipientUsername,</p>
                    <p>Thank you for making a reservation at our place! Your payment has been processed successfully and the reservation details are as follows.</p>
                    <p>Branch : $branchName</p>
                    <p>Sport : $sportName</p>
                    <p>Court : $courtName</p>
                    <p>Date : $date</p>
                    <p>Time Period : $startingTime - $endingTime</p>
                    <p>Payment Amount : $currency $amount</p>
                    <br>
                    <p>If you want to cancel your reservation, please use our website.</p>
                    <p>We will be expecting you.</p>
                    <p>Regards,<br>Sportude Support</p>";
                    
            return self::sendMail($recipientEmail, $recipientUsername, $subject, $body);
        }
    }
?>