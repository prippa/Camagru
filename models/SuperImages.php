<?php

namespace app\models;

use app\core\Modal;
use PDO;

abstract class SuperImages extends Modal
{
    static function getImagesByType(string $type): ?array
    {
        $sql = 'SELECT id, file FROM super_images WHERE type = :type';

        $result = DB::execute($sql, [':type' => $type]);

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}
