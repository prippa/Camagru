<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Camagru Project</title>
</head>
<body>
<?php
require_once 'post.php';

$posts = getPosts();

require_once "views/index.show.php";
?>
</body>
</html>
