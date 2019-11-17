<?php

namespace app\core;

/**
 * Class Modal
 * @package app\core
 */
abstract class Modal
{
    /**
     * @var DB object
     */
    private static $db = null;

    /**
     * Path to field regex validation
     */
    protected const FIELDS_VALIDATION_PATH = 'config/fields_validation.json';

    /**
     * DB password hash type
     */
    protected const PASSWORD_HASH_TYPE = PASSWORD_DEFAULT;

    /**
     * Get DB object
     * @return DB
     */
    public static function db()
    {
        if (!self::$db) {
            self::$db = new DB();
        }

        return self::$db;
    }
}
