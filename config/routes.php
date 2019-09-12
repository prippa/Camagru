<?php

return array(
    '' => 'Site/Index',
    'LikeDislikePOST' => 'Site/LikeDislikePOST',
    'AddNewComment' => 'Site/AddNewComment',

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
);
