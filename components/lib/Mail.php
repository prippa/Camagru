<?php

namespace app\components\lib;

/**
 * Class Mail
 * @package app\components\lib
 */
abstract class Mail
{
    /**
     * @param string $to
     * @param string $subject
     * @param string $message
     * @return void
     */
    private static function send(string $to, string $subject, string $message): void
    {
        $header = "From: Camagru <{$_SERVER['HTTP_HOST']}>\r\n";
        $header .= "Content-type: text/html; charset=utf-8\r\n";

        // Send mail
        mail($to, $subject, $message, $header);
    }

    /**
     * @param string $login
     * @param string $email
     * @param string $token
     * @return void
     */
    public static function confirmAccount(string $login, string $email, string $token): void
    {
        $link = Lib::getSiteUrl() . "/register/confirm/$token";
        $subject = 'Confirm your email address';
        $message = require 'views/login_register_system/mail/confirm_account.php';

        self::send($email, $subject, $message);
    }

    /**
     * @param string $login
     * @param string $email
     * @param string $token
     * @return void
     */
    public static function confirmPassword(string $login, string $email, string $token): void
    {
        $link = Lib::getSiteUrl() . "/password_reset/$token";
        $subject = 'Please reset your password';
        $message = require 'views/login_register_system/mail/password_reset.php';

        self::send($email, $subject, $message);
    }

    /**
     * @param string $login
     * @param string $email
     * @param string $token
     * @return void
     */
    public static function changeEmailConfirm(string $login, string $email, string $token): void
    {
        $link = Lib::getSiteUrl() . "/profile/settings/email_reset/$token";
        $subject = 'Confirm your new email address';
        $message = require 'views/mail/confirm_new_email.php';

        self::send($email, $subject, $message);
    }

    /**
     * @param string $login
     * @param string $email
     * @param int $photo_id
     * @return void
     */
    public static function notification(string $login, string $email, int $photo_id): void
    {
        $link = Lib::getSiteUrl() . "/photo/$photo_id";
        $subject = 'You have a new comment';
        $message = require 'views/mail/notification.php';

        self::send($email, $subject, $message);
    }
}
