<header>
    <a href="/" class="logo"><img class="logo-img" src="/template/images/logo.png" alt=""> Camagru</a>
    <nav>
        <a class="<?= $path == 'index' ? 'active' : '' ?>" href="/">☀️Home</a>
        <?php if ($data['is_logged']): ?>
            <a class="<?= $path == 'make_photo' ? 'active' : '' ?>" href="/make_photo">Make Photo</a>
            <a class="<?= strstr($path, 'profile/') ? 'active' : '' ?>"
               href="/profile"><b><?= $data['header_login'] ?></b> • Profile</a>
            <a href="/logout">Logout</a>
        <?php else: ?>
            <a class="<?= $path == 'login_register_system/login' ? 'active' : '' ?>" href="/login">Login</a>
            <a class="<?= $path == 'login_register_system/register' ? 'active' : '' ?>" href="/register">Register</a>
        <?php endif ?>
    </nav>
</header>
