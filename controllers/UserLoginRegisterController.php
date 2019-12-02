<?php

namespace app\controllers;

use app\components\lib\Lib;
use app\components\lib\Mail;
use app\models\PasswordReset;
use app\models\User;
use app\core\Controller;

/**
 * Class UserLoginRegisterController
 * @package app\controllers
 */
class UserLoginRegisterController extends Controller
{
    /**
     * @return void
     */
    public function actionRegister(): void
    {
        User::redirectToHomeCheck();

        $login = '';
        $email = '';

        if (!empty($_POST)) {
            $login = $_POST['login'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            $this->view->errors = User::registerValidate($login, $email, $password, $password_confirm);
            if (!$this->view->errors) {
                $vkey = Lib::getUniqueToken($login);

                User::insert($login, $email, $password, $vkey);
                Mail::confirmAccount($login, $email, $vkey);
                $this->view->run('login_register_system/confirm_account', ['email' => $email], 'Confirm Email');
            }
        }

        $this->view->run('login_register_system/register', ['login' => $login, 'email' => $email]);
    }

    /**
     * @param $vkey
     * @return void
     */
    public function actionConfirmMail($vkey): void
    {
        if (User::confirmMail($vkey)) {
            $this->view->run('login_register_system/account_confirmed');
        } else {
            $this->view->run('error_pages/something_went_wrong', ['error' => 'Invalid account'], 'Oops :(');
        }
    }

    /**
     * @return void
     */
    public function actionLogin(): void
    {
        User::redirectToHomeCheck();

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

            $this->view->errors = $result;
        }

        $this->view->run('login_register_system/login', ['login' => $login]);
    }

    /**
     * @return void
     */
    public function actionLogout(): void
    {
        User::logout();
        Lib::redirect();
    }

    /**
     * @return void
     */
    public function actionPasswordReset(): void
    {
        User::redirectToHomeCheck();

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

            $this->view->errors = $result;
        }

        $this->view->run('login_register_system/forgot_password', ['email' => $email], 'Forgot your password?');
    }

    /**
     * @param $token
     * @return void
     */
    public function actionPasswordResetForm($token): void
    {
        $email = PasswordReset::getEmailByToken($token);

        if (!$email) {
            $this->view->run('error_pages/something_went_wrong',
                ['error' => 'Unable to change password by this link'], 'Oops :(');
        }

        $login = User::getLoginByEmail($email);

        if (!empty($_POST)) {
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            $this->view->errors = PasswordReset::formValidation($password, $password_confirm);
            if (!$this->view->errors) {
                PasswordReset::deleteByEmail($email);
                User::updatePasswordByLogin($login, $password);
                $this->view->run('login_register_system/password_changed', ['login' => $login]);
            }
        }

        $this->view->run('login_register_system/password_reset_form',
            ['login' => $login, 'token' => $token], 'Change your password');
    }
}
