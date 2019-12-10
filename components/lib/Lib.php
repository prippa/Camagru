<?php

namespace app\components\lib;

/**
 * Class Lib
 * @package app\components\lib
 */
abstract class Lib
{
    /**
     * @param string|null $url - Route
     * @return void
     */
    public static function redirect(string $url = null): void
    {
        $request = self::getRequestSchene();
        $host = $_SERVER['HTTP_HOST'];

        header("Location: $request://$host/$url");
        exit();
    }

    /**
     * @return string
     */
    public static function getSiteUrl(): string
    {
        $request = self::getRequestSchene();
        $url = "$request://{$_SERVER['HTTP_HOST']}";

        return $url;
    }

    /**
     * @param string $text
     * @return string
     */
    public static function getUniqueToken(string $text): string
    {
        $s = 'My super secret token';
        $token = md5(time() . $text . $s);

        return $token;
    }

    /**
     * @param $data
     * @param bool $is_exit
     * @return void
     */
    public static function debug($data, bool $is_exit = true): void
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';

        if ($is_exit) {
            exit();
        }
    }

    /**
     * @param string $message
     * @param string $filename
     * @param string $rights
     * @return void
     */
    public static function fwrite(string $message, string $filename = 'test.txt', string $rights = 'a+'): void
    {
        $fd = fopen($filename, $rights);
        fwrite($fd, $message);
        fclose($fd);
    }

    private static function getRequestSchene(): string
    {
        $reques_scheme = (isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'http');

        return $reques_scheme;
    }
}
