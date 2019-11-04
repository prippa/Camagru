<?php

namespace app\core;

use app\models\User;

class View
{
    public $layout;

    public function __construct()
    {
        $this->layout = 'default';
    }

    private function getAdditionalData(): array
    {
        $data = [];
        $data['is_logged'] = User::isLogged();
        $data['current_year'] = date("Y");
        $data['login'] = '';

        if ($data['is_logged']) {
            $data['login'] = User::getLoginById(User::getId());
            $data['header_login'] = $data['login'];

            if (strlen($data['login']) > 12) {
                $data['header_login'] = substr($data['login'], 0, 11) . '.';
            }
        }

        return $data;
    }

    private function getTitleByFilename($path)
    {
        $title = strrchr($path, "/");
        if (!$title) {
            $title = $path;
        } else {
            $title = substr($title, 1);
        }
        $title = ucfirst(str_replace('_', ' ', $title));

        return $title;
    }

    /**
     * @param string $path
     * @param array $data
     * @param string|null $title
     */
    public function run(string $path, array $data = [], string $title = null): void
    {
        $data += $this->getAdditionalData();
        $page = 'views/' . $path . '.php';

        if (!$title) {
            $title = $this->getTitleByFilename($path);
        }

        require 'views/layouts/' . $this->layout . '.php';

        exit();
    }
}
