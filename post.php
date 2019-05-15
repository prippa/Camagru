<?php
require 'config/dirs.php';
require 'config/database.php';

function uploadImage($image)
{
    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . "." . $extension;
    move_uploaded_file($image['tmp_name'], UPLOADS_DIR . $filename);
    return $filename;
}

function addPost($title, $content, $filename)
{
    $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
    $sql = "INSERT INTO posts (title, content, image) VALUES (:title, :content, :image)";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(":title", $title);
    $statement->bindParam(":content", $content);
    $statement->bindParam(":image", $filename);
    $statement->execute();
}

function getPosts()
{
    $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
    $statement = $pdo->prepare("SELECT * FROM posts");
    $statement->execute();
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $posts;
}
