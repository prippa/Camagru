<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Camagru Project</title>
</head>
<body>
<?php
require 'Post.php';

$posts = getPosts();
foreach ($posts as $post)
{
    echo "<h2>" . $post['title'] . "</h2>";
    echo "<p>" . $post['content'] . "</p>";
    echo "<img src=" . "uploads/" . $post['image'] . "width=\"50\">";
}

//include "views/index.show.php";
?>
</body>
</html>
