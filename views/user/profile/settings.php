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
    <title><?= $data['login'] ?> • Settings</title>
</head>
<body>

<?php require 'views/includes/header.php' ?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <?php require 'aside.php' ?>
        </div>

        <div class="col-md-8">
            <h1 class="text-center mb-5">Settings</h1>

            <form action="/profile/settings" method="post">
                <div class="row mr-2 ml-2 justify-content-center">
                    <div class="col-12">
                        <h2 class="text-center">Change Username</h2>
                    </div>

                    <div class="col-12 mt-2 mb-4 col-radius-form">
                        <?php if (isset($data['errors']['username'])): ?>
                            <div class="error-box">
                                <ul class="error-list">
                                    <?php foreach ($data['errors']['username'] as $item): ?>
                                        <li class="error-item"><?= $item ?></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        <?php endif ?>

                        <div class="form-group">
                            <label for="username-field">Username</label>
                            <input type="text" class="form-control" id="username-field"
                                   name="login" required tabindex="1" value="<?= $data['user_data']['login'] ?>">
                        </div>
                    </div>

                    <div class="col-12">
                        <h2 class="text-center">Change Email</h2>
                    </div>

                    <div class="col-12 mt-2 mb-4 col-radius-form">
                        <?php if (isset($data['errors']['email'])): ?>
                            <div class="error-box">
                                <ul class="error-list">
                                    <?php foreach ($data['errors']['email'] as $item): ?>
                                        <li class="error-item"><?= $item ?></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        <?php endif ?>

                        <div class="form-group">
                            <label for="email-field">Email address</label>
                            <input type="email" class="form-control" id="email-field"
                                   name="email" required tabindex="2" value="<?= $data['user_data']['email'] ?>">
                        </div>
                    </div>

                    <div class="col-12">
                        <h2 class="text-center">Change Password</h2>
                    </div>

                    <div class="col-12 mt-2 mb-4 col-radius-form">
                        <?php if (isset($data['errors']['password'])): ?>
                            <div class="error-box">
                                <ul class="error-list">
                                    <?php foreach ($data['errors']['password'] as $item): ?>
                                        <li class="error-item"><?= $item ?></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        <?php endif ?>

                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="old-password-field">Old Password</label>
                                <input type="password" class="form-control" id="old-password-field"
                                       name="old_password" tabindex="3">
                            </div>

                            <div class="form-group col-12">
                                <label for="password-field">New Password</label>
                                <input type="password" class="form-control" id="password-field"
                                       name="password" tabindex="4">
                            </div>

                            <div class="form-group col-12">
                                <label for="password-confirm-field">New Password confirm</label>
                                <input type="password" class="form-control" id="password-confirm-field"
                                       name="password_confirm" tabindex="5">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-2 mb-4 col-radius-form">
                        <div class="form-check">
                            <input name="notifications" type="checkbox"
                                   class="form-check-input" id="notifications-field"
                                <?= $data['user_data']['notifications'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="notifications-field">Notifications</label>
                        </div>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary btn-block" tabindex="7">Update profile</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require 'views/includes/footer.php' ?>

</body>
</html>