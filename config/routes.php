<?php

return [
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

    'api/LikeDislikePOST' => 'Api/LikeDislikePOST',
    'api/AddNewComment' => 'Api/AddNewComment',
    'api/GetMorePhotos' => 'Api/GetMorePhotos',
    'api/GetAllLogin' => 'Api/GetAllLogin',
    'api/GetAllEmail' => 'Api/GetAllEmail',
    'api/DeletePhotoById' => 'Api/DeletePhotoById',
    'api/UploadPhotos' => 'Api/UploadPhotos',
    'make_photo' => 'Photo/MakePhoto',
    'photo/(.+)' => 'Photo/SinglePhoto/$1'
];
