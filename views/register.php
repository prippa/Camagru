<?php require VIEWS . 'includes/head_html.php' ?>

<div class="container">

    <div class="row mt-5 text-center">
        <div class="col-12">
            <a href="#"><img class="logo-img" src="/images/logo.svg" alt=""></a>
        </div>
    </div>

    <div class="row mt-5 mr-2 ml-2 justify-content-center">

        <div class="col-12 text-center">
            <h1>Register</h1>
        </div>

        <div class="col-12 mt-3 col-radius-form">
            <form action="register" method="post">
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="username-field">Username</label>
                        <input type="text" class="form-control" id="username-field"
                               name="username" required tabindex="1">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="email-field">Email address</label>
                        <input type="email" class="form-control" id="email-field"
                               name="email" required tabindex="2">
                    </div>

                    <div class="form-group col-12">
                        <label for="password-field">Password</label>
                        <input type="password" class="form-control" id="password-field"
                               name="password" required tabindex="3">
                    </div>

                    <div class="form-group col-12">
                        <label for="password-confirm-field">Password confirm</label>
                        <input type="password" class="form-control" id="password-confirm-field"
                               name="password-confirm" required tabindex="4">
                    </div>

                </div>
                <button type="submit" class="btn btn-primary btn-block" tabindex="5">REGISTER</button>
            </form>
        </div>

        <div class="col-12 mt-4 mr-2 ml-2 col-radius-reg text-center">
            <div class="no-ac-text">Already have an account? <a href="login">Login</a></div>
        </div>

    </div>

</div>

<?php require VIEWS . 'includes/tail_html.php' ?>