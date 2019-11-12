<?php

namespace app\core;

use DB;

abstract class Modal
{
    private static $db = null;
    protected const FVR_PATH = 'config/form_validation_rules.php';
    protected const PASSWORD_HASH_TYPE = PASSWORD_DEFAULT;

    public static function db()
    {
        if (!self::$db) {
            self::$db = new DB();
        }

        return self::$db;
    }
}
