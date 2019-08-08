<?php

return array(
    '' => 'Site/Index',
    'news' => 'News/Index',
    'news/([0-9]+)' => 'News/View/$1',
    'register' => 'User/Register',
    'register/confirm/(.+)' => 'User/Confirm/$1',
    'login' => 'User/Login',
    'logout' => 'User/Logout',
    'password_reset' => 'User/PasswordReset',
);
