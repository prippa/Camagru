<?php

namespace app\models;

use app\components\DB;
use PDO;

class User
{
    public function hello()
    {
        echo 'Hello from User Class<br>';
        $db = DB::getConnection();

        $res = $db->query("SELECT * from names");
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $list = $res->fetchAll();
        echo $list[0]['name'];
    }
}
