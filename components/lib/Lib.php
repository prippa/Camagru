<?php

namespace app\components\lib;

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

    /**
     * @param $title - Title of page
     * @param $path_to_page_view - Path to HTML file
     */
    public static function renderPage(string $title, string $path_to_page_view) : void
    {
        require $path_to_page_view;
        exit();
    }

    public static function getUniqueToken(string $text) : string
    {
        return md5(time() . $text);
    }

    public static function mail(string $to, string $subject, string $message)
    {
        $header  = 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $header .= 'From: <prippa@student.42.fr>' . "\r\n";

        // Send mail
        mail($to, $subject, $message, $header);
    }
}
