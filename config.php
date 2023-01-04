<?php
    //any server configuration goes here
    //this script should be included in every script that needs to use the following constants

    //make sure that this file in not in the repository
    //this file should be in the .gitignore file

    //PHPMailer configuration goes here
    define('PHPMAILER_HOST', 'smtp.gmail.com');
    define('PHPMAILER_PORT', 587);
    define('PHPMAILER_USERNAME', '');   //add the google account
    define('PHPMAILER_PASSWORD', '');   //add the password you set in the google account (app password)
    define('PHPMAILER_FROM', 'noreply@sportude.com');
    define('PHPMAILER_FROM_NAME', 'Sportude Support');
    define('PHPMAILER_SMTP_SECURE', 'tls');

?>