<?php

namespace app\models;

use app\core\Modal;

abstract class SuperImages extends Modal
{
    private const TABLE = 'super_images';

    static function getImagesByType(string $type): ?array
    {
        return self::db()->selectRows(self::TABLE, ['id', 'file'], ['type', $type]);
    }
}
