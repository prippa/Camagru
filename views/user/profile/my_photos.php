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
    <title><?= $data['login'] ?> • Photos</title>
</head>
<body>

<?php require 'views/includes/header.php' ?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <?php require 'aside.php' ?>
        </div>

        <div class="col-md-8">
            <h1 class="text-center">My Photos</h1>
        </div>
    </div>
</div>

<?php require 'views/includes/footer.php' ?>

</body>
</html>