<?php

namespace app\components;

use app\models\User;

class Router
{
    public function run()
    {
        $user = new User();

        $user->hello();
    }
}
