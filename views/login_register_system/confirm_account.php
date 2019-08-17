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
    <title>Register</title>
</head>
<body>

<?php require 'views/includes/header.php' ?>

<div class="container text-center">
    <h1>Please confirm your email address</h1>
    <img class="img-fluid" src="/template/images/mail.png" width="500" alt="">
    <p>We just emailed you at <b><?= $data['email'] ?></b>.</p>
    <p>Click the link in your email to confirm your account.</p>
    <p>If you can't find the email check your spam folder.</p>
</div>

<?php require 'views/includes/footer.php' ?>

</body>
</html>