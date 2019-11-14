<?php

namespace app\models;

use app\core\Modal;

/**
 * Class SuperImages
 * @package app\models
 */
abstract class SuperImages extends Modal
{
    /**
     * Table name
     */
    private const TABLE = 'super_images';

    /**
     * @param string $type
     * @return array|null
     */
    static function getImagesByType(string $type): ?array
    {
        return self::db()->selectRows(self::TABLE, ['id', 'file'], ['type', $type]);
    }
}
