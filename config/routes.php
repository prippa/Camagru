<?php

return array(
    '' => 'Site/Index',

    'register' => 'User/Register',
    'register/confirm/(.+)' => 'User/ConfirmMail/$1',
    'login' => 'User/Login',
    'logout' => 'User/Logout',
    'password_reset' => 'User/PasswordReset',
    'password_reset/(.+)' => 'User/PasswordResetForm/$1',
    'profile' => 'User/ProfileSettings',
    'profile/settings' => 'User/ProfileSettings',
    'profile/my_photos' => 'User/ProfileMyPhotos',

    'make_photo' => 'Photo/MakePhoto',
);
