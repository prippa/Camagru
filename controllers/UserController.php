<?php

namespace app\controllers;

use app\components\lib\Lib;
use app\components\lib\Mail;
use app\models\PasswordReset;
use app\models\User;

class UserController
{
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
                $vkey = Lib::getUniqueToken($login);

                User::add($login, $email, $password, $vkey);
                Mail::ConfirmAccount($login, $email, $vkey);
                Lib::view('views/login_register_system/confirm_account.php', ['email' => $email]);
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
        if (!User::isGuest())
            Lib::redirect();

        $errors = null;
        $email = '';

        if (!empty($_POST))
        {
            $email = $_POST['email'];

            $result = PasswordReset::validation($email);
            if (!$result)
            {
                $vkey = Lib::getUniqueToken($email);

                PasswordReset::add($email, $vkey);
                Mail::ConfirmPassword($email, $vkey);
                Lib::view('views/login_register_system/confirm_password.php', ['email' => $email]);
            }
            if (in_array('account_email', $result))
                Lib::view('views/login_register_system/confirm_account.php', ['email' => $email]);
            if (in_array('password_email', $result))
                Lib::view('views/login_register_system/confirm_password.php', ['email' => $email]);
            $errors = $result;
        }
        Lib::view('views/login_register_system/forgot_password.php',
            ['errors' => $errors, 'email' => $email]);
    }

    public function actionPasswordResetForm($token)
    {
        $email = PasswordReset::getEmailByToken($token);

        if (!$email)
            Lib::view('views/error_pages/something_went_wrong.php',
                ['error' => 'Unable to change password by this link']);

        $login = User::getLoginByEmail($email);
        $errors = null;

        if (!empty($_POST))
        {
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            $errors = PasswordReset::formValidation($password, $password_confirm);
            if (!$errors)
            {
                PasswordReset::deleteByEmail($email);
                User::changePasswordByLogin($login, $password);
                Lib::view('views/login_register_system/password_changed.php', ['login' => $login]);
            }
        }
        Lib::view('views/login_register_system/password_reset_form.php',
            ['errors' => $errors, 'login' => $login, 'token' => $token]);
    }
}
