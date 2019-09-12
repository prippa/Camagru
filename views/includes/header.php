<header>
    <a href="/" class="logo"><img class="logo-img" src="/template/images/logo.png" alt=""> Camagru</a>
    <nav>
        <a class="<?= $view_id == self::INDEX ? 'active' : '' ?>" href="/">☀️Home</a>
        <?php if ($data['is_logged']): ?>
            <a class="<?= $view_id == self::MAKE_PHOTO ? 'active' : '' ?>" href="/make_photo">Make Photo</a>
            <a class="<?= $view_id >= self::PROFILE && $view_id <= self::PROFILE_END ? 'active' : '' ?>"
               href="/profile"><b><?= $data['header_login'] ?></b> • Profile</a>
            <a href="/logout">Logout</a>
        <?php else: ?>
            <a class="<?= $view_id == self::LOGIN ? 'active' : '' ?>" href="/login">Login</a>
            <a class="<?= $view_id == self::REGISTER ? 'active' : '' ?>" href="/register">Register</a>
        <?php endif ?>
    </nav>
</header>
