<?php

if (isset($_SESSION['user']))
    echo "Welcome!";
else
    echo 'Who are you? <a href="login">Login</a>';
