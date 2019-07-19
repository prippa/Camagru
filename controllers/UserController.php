<?php

namespace app\controllers;

use app\components\lib\Lib;
use app\models\User;

class UserController
{
    private function sendConfirmMail(string $login, string $email, string $vkey) : void
    {
        $link = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/register/confirm/$vkey";
        $sybject = 'Camagru: confirm your email address';
        $message = require 'views/login_register_system/mail/confirm_mail.php';

        Lib::mail($email, $sybject, $message);
    }

    public function actionRegister()
    {
        if (!empty($_POST))
        {
            $login = $_POST['login'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            if (User::registerValidate($login, $email, $password, $password_confirm))
            {
                $vkey = Lib::getUniqueToken($login);

                User::add($login, $email, $password, $vkey);
                $this->sendConfirmMail($login, $email, $vkey);
                Lib::view('views/login_register_system/mail/confirm.php', ['email' => $email]);
            }
        }
        Lib::view('views/login_register_system/register.php');
    }

    public function actionConfirm($vkey)
    {
        if (User::confirmMail($vkey))
            Lib::view('views/login_register_system/mail/confirm_success.php');
        else
            Lib::view('views/error_pages/something_went_wrong.php', ['error' => 'Invalid account']);
    }

    public function actionLogin()
    {
        if (!empty($_POST))
        {
            $login = $_POST['login'];
            $password = $_POST['password'];

            if (User::login($login, $password))
                Lib::redirect();
        }
        Lib::view('views/login_register_system/login.php');
    }

    public function actionLogout()
    {
        echo 'actionLogout';
    }
}
