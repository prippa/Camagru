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
     * @param $css_paths - Page css paths
     * @param $js_paths - Page js paths
     * @param $path_to_page_view - Path to HTML file
     */
    public static function renderPage(string $title,
                                      array $css_paths, array $js_paths,
                                      string $path_to_page_view) : void
    {
        $css = [];
        $js = [];

        foreach ($css_paths as $item)
            $css[] = "<link href=\"$item\" rel=\"stylesheet\">";
        foreach ($js_paths as $item)
            $js[] = "<script type=\"text/javascript\" src=\"$item\"></script>";

        require $path_to_page_view;
    }

    /**
     * Returning config array from config file
     * @param string $path_to_config_file
     * @return array
     */
    public static function getConfigArray(string $path_to_config_file) : array
    {
        return require $path_to_config_file;
    }
}
