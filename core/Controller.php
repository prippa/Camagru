<?php

namespace app\core;

use app\core\View;

abstract class Controller
{
    public $view;

    public function __construct()
    {
        $this->view = new View();
    }
}
