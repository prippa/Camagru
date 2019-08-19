<?php

namespace app\controllers;

use app\components\lib\Lib;
use app\components\lib\Mail;
use app\models\PasswordReset;
use app\models\User;
use app\components\lib\View;

class UserController
{
    // ****************************************** Register and Login system ******************************************
    public function actionRegister()
    {
        User::redirectToHomeCheck();

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
                View::run(View::CONFIRM_ACCOUNT, ['email' => $email]);
            }
        }
        View::run(View::REGISTER, ['errors' => $errors, 'login' => $login, 'email' => $email]);
    }

    public function actionConfirmMail($vkey)
    {
        if (User::confirmMail($vkey))
            View::run(View::ACCOUNT_CONFIRMED);
        else
            View::run(View::ERROR_SOMETHING_WENT_WRONG, ['error' => 'Invalid account']);
    }

    public function actionLogin()
    {
        User::redirectToHomeCheck();

        $errors = null;
        $login = '';

        if (!empty($_POST))
        {
            $login = $_POST['login'];
            $password = $_POST['password'];

            $result = User::loginValidate($login, $password);
            if (isset($result['email']))
                View::run(View::CONFIRM_ACCOUNT, ['email' => $result['email']]);
            if (isset($result['id']))
            {
                User::login($result['id']);
                Lib::redirect();
            }
            $errors = $result;
        }
        View::run(View::LOGIN, ['errors' => $errors, 'login' => $login]);
    }

    public function actionLogout()
    {
        User::logout();
        Lib::redirect();
    }

    public function actionPasswordReset()
    {
        User::redirectToHomeCheck();

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
                View::run(View::CONFIRM_PASSWORD, ['email' => $email]);
            }
            if (in_array('account_email', $result))
                View::run(View::CONFIRM_ACCOUNT, ['email' => $email]);
            if (in_array('password_email', $result))
                View::run(View::CONFIRM_PASSWORD, ['email' => $email]);
            $errors = $result;
        }
        View::run(View::FORGOT_PASSWORD, ['errors' => $errors, 'email' => $email]);
    }

    public function actionPasswordResetForm($token)
    {
        $email = PasswordReset::getEmailByToken($token);

        if (!$email)
            View::run(View::ERROR_SOMETHING_WENT_WRONG, ['error' => 'Unable to change password by this link']);

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
                View::run(View::PASSWORD_CHANGED, ['login' => $login]);
            }
        }
        View::run(View::PASSWORD_RESET_FORM, ['errors' => $errors, 'login' => $login, 'token' => $token]);
    }
    // ***************************************************************************************************************

    public function actionProfileSettings()
    {
        User::redirectToLoginCheck();

        $errors = null;
        $user_data = User::getUserByID(User::getId());

        if (!empty($_POST))
        {
            Lib::debug($_POST);
        }
        View::run(View::PROFILE_SETTINGS, ['errors' => $errors, 'user_data' => $user_data]);
    }

    public function actionProfileMyPhotos()
    {
        User::redirectToLoginCheck();

        View::run(View::PROFILE_MY_PHOTOS);
    }
}
