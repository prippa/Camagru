<?php

return array(
    '' => 'Site/Index',

    'register' => 'UserLoginRegister/Register',
    'register/confirm/(.+)' => 'UserLoginRegister/ConfirmMail/$1',
    'login' => 'UserLoginRegister/Login',
    'logout' => 'UserLoginRegister/Logout',
    'password_reset' => 'UserLoginRegister/PasswordReset',
    'password_reset/(.+)' => 'UserLoginRegister/PasswordResetForm/$1',

    'profile' => 'UserProfile/ProfileSettings',
    'profile/settings' => 'UserProfile/ProfileSettings',
    'profile/settings/email_reset/(.+)' => 'UserProfile/ConfirmNewMail/$1',
    'profile/my_photos' => 'UserProfile/ProfileMyPhotos',

    'make_photo' => 'Photo/MakePhoto',
    'LikeDislikePOST' => 'Photo/LikeDislikePOST',
    'AddNewComment' => 'Photo/AddNewComment',
    'photo/(.+)' => 'Photo/SinglePhoto/$1'
);
