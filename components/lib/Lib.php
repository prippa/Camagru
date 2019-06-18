<?php

namespace app\components\lib;

abstract class Lib
{
    /**
     * @param $url - Route
     */
    public static function redirect(string $url = '') : void
    {
        $request = $_SERVER['REQUEST_SCHEME'];
        $host = $_SERVER['HTTP_HOST'];

        header("Location: $request://$host/$url");
        exit();
    }

    /**
     * @param $title - Title of page
     * @param $style_paths - Page style paths
     * @param $path_to_page_view - Path to HTML file
     */
    public static function renderPage(string $title, array $style_paths, string $path_to_page_view) : void
    {
        $styles = [];

        foreach ($style_paths as $item)
            $styles[] = "<link href=\"$item\" rel=\"stylesheet\">";

        require $path_to_page_view;
    }
}
