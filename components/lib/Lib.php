<?php

namespace app\components\lib;

use app\models\User;

abstract class Lib
{
    /**
     * @param $url - Route
     */
    public static function redirect(string $url = null): void
    {
        $request = $_SERVER['REQUEST_SCHEME'];
        $host = $_SERVER['HTTP_HOST'];

        header("Location: $request://$host/$url");
        exit();
    }

    public static function getUniqueToken(string $text): string
    {
        $s = 'My super secret token';
        $token = md5(time() . $text . $s);

        return $token;
    }

    public static function debug($data, bool $is_exit = true): void
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';

        if ($is_exit) {
            exit();
        }
    }

    public static function fwrite(string $message, string $filename = 'test.txt', string $rights = 'a+')
    {
        $fd = fopen($filename, $rights);
        fwrite($fd, $message);
        fclose($fd);
    }
}
