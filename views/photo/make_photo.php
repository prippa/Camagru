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
    <title>Make Photo</title>
</head>
<body>

<?php require 'views/includes/header.php' ?>

<div class="container">

    <div class="row">
        <div class="col">
            <?php require 'views/includes/success_message.php' ?>

            <form action="/make_photo" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="user_file">Pick a photo from your device</label>
                    <input name="image" type="file" class="form-control-file"
                           id="user_file" accept="image/*" tabindex="1" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block" tabindex="2">Upload</button>
            </form>
        </div>
    </div>

</div>

<?php require 'views/includes/footer.php' ?>

</body>
</html>