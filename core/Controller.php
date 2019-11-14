<?php

namespace app\core;

/**
 * Class Controller
 * @package app\core
 */
abstract class Controller
{
    public $view;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->view = new View();
    }
}
