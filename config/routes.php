<?php

return array(
    '' => 'site/index',
    'news' => 'news/index',
    'news/([0-9]+)' => 'news/view/$1',
    'register' => 'user/register',
    'login' => 'user/login',
    'logout' => 'user/logout',
);
