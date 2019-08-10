<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/template/images/icon.png" type="image/x-icon"/>
    <link rel="stylesheet" href="/template/css/bootstrap.min.css">
    <link rel="stylesheet" href="/template/css/style.css">
    <link rel="stylesheet" href="/template/css/register_and_login.css">
    <title>Password has been changed</title>
    <style>
        p {
            font-size: 22px;
        }
    </style>
</head>
<body>

<div class="container text-center">

    <?php require 'views/login_register_system/includes/logo.php' ?>

    <p class="mt-5"><b>@<?= $data['login'] ?></b> your password has been changed!</p>
    <p class="text">You may now <a href="/login">Login</a> with new password</p>

</div>

</body>
</html>