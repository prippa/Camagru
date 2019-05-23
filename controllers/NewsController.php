<?php

namespace app\controllers;

class NewsController
{
    public function actionIndex()
    {
        echo 'NewsController indexAction';
    }

    public function actionView($id)
    {
        echo $id . '<br>';
    }
}
