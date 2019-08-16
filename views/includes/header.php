<header>
    <a href="/" class="logo"><img class="logo-img" src="/template/images/logo.png" alt=""> Camagru</a>
    <div class="header-right">
        <a class="<?= $view_id == self::INDEX ? 'active' : '' ?>" href="/">Home Page</a>
        <a class="<?= $view_id == self::LOGIN ? 'active' : '' ?>" href="/login">Login</a>
        <a class="<?= $view_id == self::REGISTER ? 'active' : '' ?>" href="/register">Register</a>
    </div>
</header>