<?php require VIEWS . 'includes/head_html.php' ?>

<div class="container">

    <div class="row mt-5 text-center">
        <div class="col-12">
            <a href="#"><img class="logo-img" src="/images/logo.svg" alt=""></a>
        </div>
    </div>

    <div class="row mt-5 mr-2 ml-2 justify-content-center">

        <div class="col-12 text-center">
            <h1>Login</h1>
        </div>

        <div class="col-12 mt-3 col-radius-form">
            <form action="login" method="post">
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="username-field">Username</label>
                        <input type="text" class="form-control" id="username-field"
                               name="username" required tabindex="1">
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

<?php require VIEWS . 'includes/tail_html.php' ?>