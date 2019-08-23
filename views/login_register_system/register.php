<div class="container">

    <div class="row mr-2 ml-2 justify-content-center">

        <div class="col-12 text-center">
            <h1>Register</h1>
        </div>

        <div class="col-12 mt-3 col-radius-form">

            <?php require 'views/login_register_system/includes/print_errors.php' ?>

            <form action="/register" method="post">
                <div class="form-row">

                    <div class="form-group col-12">
                        <label for="username-field">Username</label>
                        <input type="text" class="form-control" id="username-field"
                               name="login" required tabindex="1" value="<?= $data['login'] ?>">
                    </div>

                    <div class="form-group col-12">
                        <label for="email-field">Email address</label>
                        <input type="email" class="form-control" id="email-field"
                               name="email" required tabindex="2" value="<?= $data['email'] ?>">
                    </div>

                    <div class="form-group col-12">
                        <label for="password-field">Password</label>
                        <input type="password" class="form-control" id="password-field"
                               name="password" required tabindex="3">
                    </div>

                    <div class="form-group col-12">
                        <label for="password-confirm-field">Password confirm</label>
                        <input type="password" class="form-control" id="password-confirm-field"
                               name="password_confirm" required tabindex="4">
                    </div>

                </div>
                <button type="submit" class="btn btn-primary btn-block" tabindex="5">Register</button>
            </form>
        </div>

    </div>

    <div class="row mt-4 mr-2 ml-2 justify-content-center">
        <div class="col-12 col-radius-reg text-center">
            <div class="no-ac-text">Already have an account? <a href="login">Login</a></div>
        </div>
    </div>

</div>