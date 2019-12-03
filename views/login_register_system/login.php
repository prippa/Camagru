<div class="container">

    <div class="row mr-2 ml-2 justify-content-center">

        <div class="col-12 text-center">
            <h1>Login</h1>
        </div>

        <div class="col-12 mt-3 col-radius-form">

            <?php require 'views/includes/error_messages.php' ?>

            <form action="/login" method="post" id="form">
                <div class="form-row">

                    <div class="form-group col-12">
                        <label for="username-field">Username</label>
                        <input type="text" class="form-control" id="username-field"
                               name="login" required tabindex="1" value="<?= $data['login'] ?>">
                        <div class="invalid-feedback" id="username-field-invalid"></div>
                    </div>

                    <div class="form-group col-12">
                        <div class="row">
                            <div class="col-6">
                                <label for="password-field">Password</label>
                            </div>
                            <div class="col-6 text-right">
                                <a href="password_reset" tabindex="4">Forgot?</a>
                            </div>
                        </div>
                        <input type="password" class="form-control" id="password-field"
                               name="password" required tabindex="2">
                        <div class="invalid-feedback" id="password-field-invalid"></div>
                    </div>

                </div>
                <button type="submit" class="btn btn-primary btn-block" tabindex="3" id="form-submit-btn" disabled>
                    Login
                </button>
            </form>

        </div>

    </div>

    <div class="row mt-4 mr-2 ml-2 justify-content-center">
        <div class="col-12 col-radius-reg text-center">
            <div class="no-ac-text">No account yet? <a href="register">Register</a></div>
        </div>
    </div>

</div>

<script type="module">
    window.fv = <?= file_get_contents('config/fields_validation.json') ?>;
</script>
<script src="/template/js/login.js" type="module"></script>
