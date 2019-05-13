<?php

require 'Post.php';

$filename = uploadImage($_FILES['image']);
addPost($_POST['title'], $_POST['content'], $filename);
header("Location: /");
