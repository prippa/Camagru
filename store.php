<?php

require 'post.php';
require 'config/dirs.php';

$filename = uploadImage($_FILES['image']);
addPost($_POST['title'], $_POST['content'], $filename);
header("Location: /Camagru");
