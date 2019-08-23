<div class="container">

    <div class="row mr-2 ml-2 justify-content-center">

        <div class="col-12 text-center">
            <h1>Reset your password</h1>
        </div>

        <div class="col-12 mt-3 col-radius-form">

            <?php require 'views/login_register_system/includes/print_errors.php' ?>

            <form action="/password_reset" method="post">
                <div class="form-row">

                    <div class="form-group col-12">
                        <label for="email-field">
                            Enter your email address and we will send you a link to reset your password.
                        </label>
                        <input placeholder="Enter your email address" type="email"
                               class="form-control" id="email-field"
                               name="email" required tabindex="1" value="<?= $data['email'] ?>">
                    </div>

                </div>
                <button type="submit" class="btn btn-primary btn-block" tabindex="2">Send password reset email</button>
            </form>

        </div>

    </div>

</div>