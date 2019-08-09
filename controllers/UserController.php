<?php

namespace app\controllers;

use app\components\lib\Lib;
use app\models\User;

class UserController
{
    private function sendConfirmAccount(string $login, string $email, string $vkey) : void
    {
        $link = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/register/confirm/$vkey";
        $sybject = 'Camagru: confirm your email address';
        $message = require 'views/login_register_system/mail/confirm_account.php';

        Lib::mail($email, $sybject, $message);
    }

    private function sendConfirmPassword(string $email, string $vkey) : void
    {
        $link = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/password_reset/$vkey";
        $sybject = 'Camagru: please reset your password';
        $message = require 'views/login_register_system/mail/password_reset.php';

        Lib::mail($email, $sybject, $message);
    }

    public function actionRegister()
    {
        if (!User::isGuest())
            Lib::redirect();

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
                Lib::view('views/login_register_system/confirm_account.php', ['email' => $email], false);

                $vkey = Lib::getUniqueToken($login);
                User::add($login, $email, $password, $vkey);
                $this->sendConfirmAccount($login, $email, $vkey);
                exit();
            }
        }
        Lib::view('views/login_register_system/register.php',
            ['errors' => $errors, 'login' => $login, 'email' => $email]);
    }

    public function actionConfirmMail($vkey)
    {
        if (User::confirmMail($vkey))
            Lib::view('views/login_register_system/account_confirmed.php');
        else
            Lib::view('views/error_pages/something_went_wrong.php', ['error' => 'Invalid account']);
    }

    public function actionLogin()
    {
        if (!User::isGuest())
            Lib::redirect();

        $errors = null;
        $login = '';

        if (!empty($_POST))
        {
            $login = $_POST['login'];
            $password = $_POST['password'];

            $result = User::loginValidate($login, $password);
            if (isset($result['email']))
                Lib::view('views/login_register_system/confirm_account.php', ['email' => $result['email']]);
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

    public function actionPasswordReset()
    {
        $errors = null;
        $email = '';

        if (!empty($_POST))
        {
            $email = $_POST['email'];

            $result = User::passwordResetValidation($email);
            if (isset($result['account_email']))
                Lib::view('views/login_register_system/confirm_account.php', ['email' => $result['email']]);
            if (isset($result['password_email']))
                Lib::view('views/login_register_system/confirm_password.php', ['email' => $result['email']]);
            if (!$result)
            {
                Lib::view('views/login_register_system/confirm_password.php', ['email' => $email], false);

                $vkey = Lib::getUniqueToken($email);
                User::passwordResetAdd($email, $vkey);
                $this->sendConfirmPassword($email, $vkey);
                exit();
            }
            $errors = $result;
        }
        Lib::view('views/login_register_system/forgot_password.php',
            ['errors' => $errors, 'email' => $email]);
    }

    public function actionPasswordResetForm($vkey)
    {
        if (User::confirmMail($vkey))
            Lib::view('views/login_register_system/mail/confirm_success.php');
        else
            Lib::view('views/error_pages/something_went_wrong.php', ['error' => 'Invalid account']);
    }
}
