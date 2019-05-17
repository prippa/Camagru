<?php
require 'posts_database.php';

function uploadImage($image)
{
    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . "." . $extension;
    move_uploaded_file($image['tmp_name'], 'uploads/' . $filename);
    return $filename;
}

function addPost($title, $content, $filename)
{
    $db = new PDO(DB_POSTS_DSN, DB_POSTS_USER, DB_POSTS_PASSWORD,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $sql = "INSERT INTO posts (title, content, image) VALUES (:title, :content, :image)";
    $statement = $db->prepare($sql);
    $statement->bindParam(":title", $title);
    $statement->bindParam(":content", $content);
    $statement->bindParam(":image", $filename);
    $statement->execute();
}

function getPosts()
{
    $db = new PDO(DB_POSTS_DSN, DB_POSTS_USER, DB_POSTS_PASSWORD,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $statement = $db->prepare("SELECT * FROM posts");
    $statement->execute();
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $posts;
}
