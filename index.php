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

include "views/index.show.php";
?>
</body>
</html>
