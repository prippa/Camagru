<?php require VIEWS . 'includes/head_html.php' ?>

<div class="container">

    <div class="row mt-5 text-center">
        <div class="col-12">
            <img class="logo-img" src="/images/logo.svg" alt="">
        </div>
    </div>

    <div class="row mt-5 justify-content-center">

        <div class="col-12 text-center">
            <h1>Login</h1>
        </div>

        <div class="col-auto mt-3 form-radius">
            <form action="login" method="post">
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="username-field">Username</label>
                        <input type="text" class="form-control" id="username-field" name="username">
                    </div>

                    <div class="form-group col-md-6">
                        <div class="row">
                            <div class="col-6">
                                <label for="password-field">Password</label>
                            </div>
                            <div class="col-6 text-right">
                                <a href="#">Forgot?</a>
                            </div>
                        </div>
                        <input type="password" class="form-control" id="password-field" name="password">
                    </div>

                </div>
                <button type="submit" class="btn btn-primary btn-block">Sign in</button>
            </form>
        </div>

    </div>

    <div class="row mt-4">
        <div class="col">
            <h1>REGISTER</h1>
        </div>
    </div>

</div>

<?php require VIEWS . 'includes/tail_html.php' ?>