<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/template/images/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="/template/css/bootstrap.min.css">
    <link rel="stylesheet" href="/template/css/style.css">
    <title>Camagru</title>
    <style>
        .test {
            border: 1px solid #919191;
        }
    </style>
</head>
<body>

<?php require 'views/includes/header.php' ?>

<div class="container">

    <div class="row">
        <?php foreach ($data['posts'] as $item): ?>
            <div class="col-lg-6 test">
                <p>By: <?=  $item['login'] ?></p>
                <img class="img-fluid" src="/uploads/<?= $item['filename'] ?>" alt="">
            </div>
        <?php endforeach ?>
    </div>

</div>

<?php require 'views/includes/footer.php' ?>

</body>
</html>