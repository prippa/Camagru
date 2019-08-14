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
     * Call the View html
     * @param $title - Title of page
     * @param $path_to_page_view - Path to HTML file
     */
    public static function view(string $path_to_page_view, array $data=null, bool $is_exit=true) : void
    {
        require $path_to_page_view;
        if ($is_exit)
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
