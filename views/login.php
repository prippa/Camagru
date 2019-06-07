<?php require VIEWS . 'includes/head_html.php' ?>

<div class="container-fluid">
    <header class="row justify-content-center">
        <img src="/images/icon.png" alt="Logo">
    </header>
</div>

<div class="container">
    <h1>Login to Camagru</h1>
    <div class="row justify-content-center">
        <div class="login-radius">
            <div class="row justify-content-center">
                <form class="login-form" action="login" method="post">
                    <div class="row">
                        <label for="login-field">Username</label>
                    </div>
                    <div class="row">
                        <input size="30" id="login-field" type="text" name="login" required>
                    </div>
                    <div class="row justify-content-between">
                        <label for="password-field">Password</label>
                        <a href="#">Forgot?</a>
                    </div>
                    <div class="row">
                        <input size="30" id="password-field" type="password" name="password" required>
                    </div>
                    <div class="row">
                        <input class="btn btn-success btn-block" type="submit" value="Login">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require VIEWS . 'includes/tail_html.php' ?>