<?php

namespace app\components\lib;

use app\models\User;

abstract class Lib
{
    /**
     * @param $url - Route
     */
    public static function redirect(string $url = null) : void
    {
        $request = $_SERVER['REQUEST_SCHEME'];
        $host = $_SERVER['HTTP_HOST'];

        header("Location: $request://$host/$url");
        exit();
    }

    public static function getUniqueToken(string $text) : string
    {
        return md5(time() . $text);
    }

    public static function debug($data, bool $is_exit=true) : void
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';

        if ($is_exit)
            exit();
    }
}
