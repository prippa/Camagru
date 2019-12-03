<div class="container">

    <div class="row mr-2 ml-2 justify-content-center">

        <div class="col-12 text-center">
            <h1>Change password for @<?= $data['login'] ?></h1>
        </div>

        <div class="col-12 mt-3 col-radius-form">

            <?php require 'views/includes/error_messages.php' ?>

            <form action="/password_reset/<?= $data['token'] ?>" method="post" id="form">
                <div class="form-row">

                    <div class="form-group col-12">
                        <label for="password-field">Password</label>
                        <input type="password" class="form-control" id="password-field"
                               name="password" required tabindex="1">
                        <div class="invalid-feedback" id="password-field-invalid"></div>
                    </div>

                    <div class="form-group col-12">
                        <label for="password-confirm-field">Password confirm</label>
                        <input type="password" class="form-control" id="password-confirm-field"
                               name="password_confirm" required tabindex="2">
                        <div class="invalid-feedback" id="password-confirm-field-invalid"></div>
                    </div>

                </div>
                <button type="submit" class="btn btn-primary btn-block" tabindex="3" id="form-submit-btn" disabled>
                    Change password
                </button>
            </form>

        </div>

    </div>

</div>

<script type="module">
    window.fv = <?= file_get_contents('config/fields_validation.json') ?>;
</script>
<script src="/template/js/reset_password.js" type="module"></script>
