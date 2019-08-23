<div class="container">

    <div class="row mr-2 ml-2 justify-content-center">

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