<?php

namespace app\components\lib;

abstract class Mail
{
    private static function send(string $to, string $subject, string $message)
    {
        $encoding = "utf-8";

        // Set preferences for Subject field
        $subject_preferences = array(
            "input-charset" => $encoding,
            "output-charset" => $encoding,
            "line-length" => 76,
            "line-break-chars" => "\r\n"
        );

        // Set mail header
        $header = "Content-type: text/html; charset=".$encoding." \r\n";
        $header .= "From: <prippa@student.42.fr> \r\n";
        $header .= "MIME-Version: 1.0 \r\n";
        $header .= "Content-Transfer-Encoding: 8bit \r\n";
        $header .= "Date: ".date("r (T)")." \r\n";
        $header .= iconv_mime_encode("Subject", $subject, $subject_preferences);

        // Send mail
        mail($to, $subject, $message, $header);
    }

    public static function confirmAccount(string $login, string $email, string $token) : void
    {
        $link = HOST_NAME . "/register/confirm/$token";
        $subject = 'Camagru: confirm your email address';
        $message = require 'views/login_register_system/mail/confirm_account.php';

        self::send($email, $subject, $message);
    }

    public static function confirmPassword(string $login, string $email, string $token) : void
    {
        $link = HOST_NAME . "/password_reset/$token";
        $subject = 'Camagru: please reset your password';
        $message = require 'views/login_register_system/mail/password_reset.php';

        self::send($email, $subject, $message);
    }

    public static function changeEmailConfirm(string $login, string $email, string $token) : void
    {
        $link = HOST_NAME . "/profile/settings/email_reset/$token";
        $subject = 'Camagru: confirm your new email address';
        $message = require 'views/mail/confirm_new_email.php';

        self::send($email, $subject, $message);
    }
}
