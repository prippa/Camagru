<?php

if (isset($_SESSION['user']))
{
    echo '<pre>';
    echo "Welcome!" . PHP_EOL;
    echo '<a href="logout">Logout?</a>';
    echo '</pre>';
}
else
{
    echo '<pre>';
    echo "Who are you?!" . PHP_EOL;
    echo '<a href="login">Login!</a>';
    echo '</pre>';
}

//\app\components\lib\Lib::view('views/login_register_system/mail/confirm_success.php');
