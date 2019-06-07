<?php

namespace app\components\lib;

abstract class Lib
{
    public static function redirect($url = '')
    {
        $request = $_SERVER['REQUEST_SCHEME'];
        $host = $_SERVER['HTTP_HOST'];

        header("Location: $request://$host/$url");
        exit();
    }
}
