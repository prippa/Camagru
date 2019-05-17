<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Posts</title>
</head>
<body>
<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'post.php';

$posts = getPosts();

require_once "index.show.php";
?>
</body>
</html>
