<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/template/css/bootstrap.min.css">
    <link rel="stylesheet" href="/template/css/style.css">
    <link rel="stylesheet" href="/template/css/register_and_login.css">
    <title>Change your password</title>
</head>
<body>

<div class="container">

    <?php require 'views/login_register_system/includes/logo.php' ?>

    <div class="row mt-5 mr-2 ml-2 justify-content-center">

        <div class="col-12 text-center">
            <h1>Change password for @<?= $data['login'] ?></h1>
        </div>

        <div class="col-12 mt-3 col-radius-form">

            <?php require 'views/login_register_system/includes/print_errors.php' ?>

            <form action="<?= $data['token'] ?>" method="post">
                <div class="form-row">

                    <div class="form-group col-12">
                        <label for="password-field">Password</label>
                        <input type="password" class="form-control" id="password-field"
                               name="password" required tabindex="1">
                    </div>

                    <div class="form-group col-12">
                        <label for="password-confirm-field">Password confirm</label>
                        <input type="password" class="form-control" id="password-confirm-field"
                               name="password_confirm" required tabindex="2">
                    </div>

                </div>
                <button type="submit" class="btn btn-primary btn-block" tabindex="3">Change password</button>
            </form>

        </div>

    </div>

</div>

<script type="text/javascript" src="/template/js/register_and_login.js"></script>
</body>
</html>