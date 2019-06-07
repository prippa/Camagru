<?php

namespace app\components\lib;

class RenderPage
{
    /**
     * @var string Title of page
     */
    private $title;

    /**
     * @var array Page style paths
     */
    private $style_paths;

    /**
     * @var string Path to HTML file
     */
    private $path_to_page_view;

    /**
     * RenderPage constructor.
     * @param string $title
     * @param array $style_paths
     * @param string $path_to_page_view
     */
    public function __construct($title, $style_paths, $path_to_page_view)
    {
        $this->title = $title;
        $this->style_paths = $style_paths;
        $this->path_to_page_view = $path_to_page_view;
    }

    public function render()
    {
        $title = $this->title;
        $styles = [];

        foreach ($this->style_paths as $item)
            $styles[] = "<link href=\"$item\" rel=\"stylesheet\">";

        require $this->path_to_page_view;
    }
}
