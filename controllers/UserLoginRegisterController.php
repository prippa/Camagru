<?php

namespace app\controllers;

use app\components\lib\Lib;
use app\components\lib\Mail;
use app\models\PasswordReset;
use app\models\User;
use app\core\Controller;

class UserLoginRegisterController extends Controller
{
    public function actionRegister()
    {
        User::redirectToHomeCheck();

        $errors = null;
        $login = '';
        $email = '';

        if (!empty($_POST)) {
            $login = $_POST['login'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            $errors = User::registerValidate($login, $email, $password, $password_confirm);
            if (!$errors) {
                $vkey = Lib::getUniqueToken($login);

                User::insert($login, $email, $password, $vkey);
                Mail::confirmAccount($login, $email, $vkey);
                $this->view->run('login_register_system/confirm_account', ['email' => $email], 'Confirm Email');
            }
        }

        $this->view->run('login_register_system/register',
            ['errors' => $errors, 'login' => $login, 'email' => $email]);
    }

    public function actionConfirmMail($vkey)
    {
        if (User::confirmMail($vkey)) {
            $this->view->run('login_register_system/account_confirmed');
        } else {
            $this->view->run('error_pages/something_went_wrong', ['error' => 'Invalid account'], 'Oops :(');
        }
    }

    public function actionLogin()
    {
        User::redirectToHomeCheck();

        $errors = null;
        $login = '';

        if (!empty($_POST)) {
            $login = $_POST['login'];
            $password = $_POST['password'];

            $result = User::loginValidate($login, $password);
            if (isset($result['email'])) {
                $this->view->run('login_register_system/confirm_account',
                    ['email' => $result['email']], 'Confirm Email');
            }
            if (isset($result['id'])) {
                User::login($result['id']);
                Lib::redirect();
            }

            $errors = $result;
        }

        $this->view->run('login_register_system/login', ['errors' => $errors, 'login' => $login]);
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

        if (!empty($_POST)) {
            $email = $_POST['email'];

            $result = PasswordReset::validation($email);
            if (!$result) {
                $vkey = Lib::getUniqueToken($email);

                PasswordReset::insert($email, $vkey);
                Mail::confirmPassword(User::getLoginByEmail($email), $email, $vkey);
                $this->view->run('login_register_system/confirm_password', ['email' => $email]);
            }
            if (in_array('account_email', $result)) {
                $this->view->run('login_register_system/confirm_account', ['email' => $email], 'Confirm Email');
            }
            if (in_array('password_email', $result)) {
                $this->view->run('login_register_system/confirm_password', ['email' => $email]);
            }

            $errors = $result;
        }

        $this->view->run('login_register_system/forgot_password',
            ['errors' => $errors, 'email' => $email], 'Forgot your password?');
    }

    public function actionPasswordResetForm($token)
    {
        $email = PasswordReset::getEmailByToken($token);

        if (!$email) {
            $this->view->run('error_pages/something_went_wrong',
                ['error' => 'Unable to change password by this link'], 'Oops :(');
        }

        $login = User::getLoginByEmail($email);
        $errors = null;

        if (!empty($_POST)) {
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            $errors = PasswordReset::formValidation($password, $password_confirm);
            if (!$errors) {
                PasswordReset::deleteByEmail($email);
                User::updatePasswordByLogin($login, $password);
                $this->view->run('login_register_system/password_changed', ['login' => $login]);
            }
        }

        $this->view->run('login_register_system/password_reset_form',
            ['errors' => $errors, 'login' => $login, 'token' => $token], 'Change your password');
    }
}
