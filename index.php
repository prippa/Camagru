<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Camagru Project</title>
</head>
<body>
<?php
//echo dirname(dirname(__FILE__)) . '/';
require 'post.php';

$posts = getPosts();

require "views/index.show.php";
?>
</body>
</html>
