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
    <title>Login</title>
</head>
<body>

<div class="container">

    <div class="row mt-5 text-center">
        <div class="col-12">
            <a href="#"><img class="logo-img" src="/template/images/logo.svg" alt=""></a>
        </div>
    </div>

    <div class="row mt-5 mr-2 ml-2 justify-content-center">

        <div class="col-12 text-center">
            <h1>Login</h1>
        </div>

        <div class="col-12 mt-3 col-radius-form">

            <?php if ($data['errors']): ?>
                <div class="error-box">
                    <ul class="error-list">
                        <?php foreach ($data['errors'] as $item): ?>
                            <li class="error-item"><?= $item ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>

            <form action="login" method="post">
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="username-field">Username</label>
                        <input type="text" class="form-control" id="username-field"
                               name="login" required tabindex="1" value="<?= $data['login'] ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <div class="row">
                            <div class="col-6">
                                <label for="password-field">Password</label>
                            </div>
                            <div class="col-6 text-right">
                                <a href="#" tabindex="4">Forgot?</a>
                            </div>
                        </div>
                        <input type="password" class="form-control" id="password-field"
                               name="password" required tabindex="2">
                    </div>

                </div>
                <button type="submit" class="btn btn-primary btn-block" tabindex="3">LOGIN</button>
            </form>
        </div>

        <div class="col-12 mt-4 mr-2 ml-2 col-radius-reg text-center">
            <div class="no-ac-text">No account yet? <a href="register">Register</a></div>
        </div>

    </div>

</div>

<script type="text/javascript" src="/template/js/register_and_login.js"></script>
</body>
</html>