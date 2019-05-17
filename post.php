<?php

function uploadImage($image)
{
    require_once 'config/dirs.php';

    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . "." . $extension;
    move_uploaded_file($image['tmp_name'], UPLOADS_DIR . $filename);
    return $filename;
}

function addPost($title, $content, $filename)
{
    require 'config/database.php';

    $sql = "INSERT INTO posts (title, content, image) VALUES (:title, :content, :image)";
    $statement = $db->prepare($sql);
    $statement->bindParam(":title", $title);
    $statement->bindParam(":content", $content);
    $statement->bindParam(":image", $filename);
    $statement->execute();
}

function getPosts()
{
    require_once 'config/database.php';

    $statement = $db->prepare("SELECT * FROM posts");
    $statement->execute();
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $posts;
}
