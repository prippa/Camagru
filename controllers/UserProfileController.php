<?php

namespace app\controllers;

use app\components\lib\Lib;
use app\components\lib\Mail;
use app\components\lib\View;
use app\models\EmailReset;
use app\models\Photo;
use app\models\User;

class UserProfileController
{
    //********************************************* Profile Settings ***************************************************
    private function psProcessLogin(array &$db_data, array $form_data, array &$messages) : void
    {
        if ($db_data['login'] == $form_data['login'])
         return ;

        if (User::checkLogin($form_data['login']))
        {
            User::updateLogin($db_data['id'], $form_data['login']);
            $db_data['login'] = $form_data['login'];
            $messages['success'][] = 'Login has been changed';
        }
        else
            $messages['errors']['login'][] = "<b>{$form_data['login']}</b> Invalid login";
    }

    private function psProcessEmail(array $db_data, array $form_data, array &$messages) : void
    {
        if ($db_data['email'] == $form_data['email'])
            return ;

        if (User::checkEmail($form_data['email']))
        {
            $messages['success'][] = 'Please confirm your new email address to change old. '.
                               "We just emailed you at <b>{$form_data['email']}</b>. ".
                               'Click the link in your email to confirm your new email. '.
                               "If you can't find the email check your spam folder.";

            if (EmailReset::checkEmail($form_data['email']))
                return ;

            $token = Lib::getUniqueToken($form_data['email']);

            EmailReset::add($form_data['email'], $token);
            Mail::changeEmailConfirm($db_data['login'], $form_data['email'], $token);
        }
        else
            $messages['errors']['email'][] = "<b>{$form_data['email']}</b> Invalid Email";
    }

    private function psProcessPassword(array $db_data, array $form_data, array &$messages) : void
    {
        if ($form_data['old_password'] == '')
            return ;

        if (password_verify($form_data['old_password'], $db_data['password']))
        {
            if (!User::checkPassword($form_data['password']))
                $messages['errors']['password'][] = 'New password is invalid';
            if ($form_data['password'] != $form_data['password_confirm'])
                $messages['errors']['password'][] = 'Passwords are not equal';
            if (!isset($messages['errors']['password']))
            {
                User::updatePassword($form_data['password'], User::getId());
                $messages['success'][] = 'Old password has been changed successfully.';
            }
        }
        else
            $messages['errors']['password'][] = 'Wrong old password';
    }

    private function psProcessNotifications(array &$db_data, array $form_data, array &$messages) : void
    {
        $notifications = isset($form_data['notifications']) ? '1' : '0';

        if ($db_data['notifications'] == $notifications)
            return ;

        if ($notifications == '1')
            $messages['success'][] = 'Notifications is on';
        else
            $messages['success'][] = 'Notifications is off';
        User::updateNotifications($notifications, User::getId());
        $db_data['notifications'] = $notifications;
    }

    public function actionProfileSettings()
    {
        User::redirectToLoginCheck();

        $messages = [];
        $user_data = User::getUserByID(User::getId());

        if (!empty($_POST))
        {
            $this->psProcessLogin($user_data, $_POST, $messages);
            $this->psProcessEmail($user_data, $_POST, $messages);
            $this->psProcessPassword($user_data, $_POST, $messages);
            $this->psProcessNotifications($user_data, $_POST, $messages);
        }

        $view_title = $user_data['login'] . ' • Settings';
        View::run(View::PROFILE_SETTINGS, ['messages' => $messages, 'user_data' => $user_data], $view_title);
    }

    public function actionConfirmNewMail($token)
    {
        $email = EmailReset::getEmailByToken($token);

        if (!$email)
            View::run(View::ERROR_SOMETHING_WENT_WRONG, ['error' => 'Unable to change email by this link']);

        $user_data = User::getUserByID(User::getId());
        $messages['success'][] = "Your old email - <b>{$user_data['email']}</b> ".
                                 "has been changed to the new one - <b>$email</b>";

        $user_data['email'] = $email;
        User::updateEmail($email, User::getId());
        EmailReset::deleteByEmail($email);
        View::run(View::PROFILE_SETTINGS, ['messages' => $messages, 'user_data' => $user_data]);
    }
    //******************************************************************************************************************

    public function actionProfileMyPhotos()
    {
        User::redirectToLoginCheck();

        $photos = Photo::getLastNUserPhotos(3, User::getId());
        Photo::preparePhotos($photos);

        $view_title = User::getLoginById(User::getId()) . ' • Photos';
        View::run(View::PROFILE_MY_PHOTOS, ['photos' => $photos], $view_title);
    }
}
