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
        $errors = null;
        $login = '';
        $email = '';

        if (!empty($_POST))
        {
            $login = $_POST['login'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            $errors = User::registerValidate($login, $email, $password, $password_confirm);
            if (!$errors)
            {
                $vkey = Lib::getUniqueToken($login);

                User::add($login, $email, $password, $vkey);
                $this->sendConfirmMail($login, $email, $vkey);
                Lib::view('views/login_register_system/mail/confirm.php', ['email' => $email]);
            }
        }
        Lib::view('views/login_register_system/register.php',
            ['errors' => $errors, 'login' => $login, 'email' => $email]);
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
        $errors = null;
        $login = '';

        if (!empty($_POST))
        {
            $login = $_POST['login'];
            $password = $_POST['password'];

            $result = User::loginValidate($login, $password);
            if (isset($result['email']))
                Lib::view('views/login_register_system/mail/confirm.php', ['email' => $result['email']]);
            if (isset($result['id']))
            {
                User::login($result['id']);
                Lib::redirect();
            }
            $errors = $result;
        }
        Lib::view('views/login_register_system/login.php',
            ['errors' => $errors, 'login' => $login]);
    }

    public function actionLogout()
    {
        User::logout();
        Lib::redirect();
    }
}
