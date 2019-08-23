<?php

namespace app\components\lib;

use app\models\User;

abstract class View
{
    public const INDEX = 1001;
    public const LOGIN = 1002;
    public const REGISTER = 1003;
    public const CONFIRM_ACCOUNT = 1004;
    public const ACCOUNT_CONFIRMED = 1005;
    public const CONFIRM_PASSWORD = 1006;
    public const FORGOT_PASSWORD = 1007;
    public const PASSWORD_CHANGED = 1008;
    public const PASSWORD_RESET_FORM = 1009;
    public const MAKE_PHOTO = 1010;
    public const PROFILE = 1011;
    public const PROFILE_SETTINGS = 1012;
    public const PROFILE_MY_PHOTOS = 1013;
    public const PROFILE_END = 1014;


    public const ERROR_400 = 400;
    public const ERROR_404 = 404;
    public const ERROR_500 = 500;
    public const ERROR_SOMETHING_WENT_WRONG = 42;

    private const VIEWS_PATH_MAP = [
        self::INDEX => ['layout' => 'views/layouts/default.php',
            'page' => 'views/index.php', 'title' => 'Camagru'],
        self::LOGIN => ['layout' => 'views/layouts/default.php',
            'page' => 'views/login_register_system/login.php', 'title' => 'Login'],
        self::REGISTER => ['layout' => 'views/layouts/default.php',
            'page' => 'views/login_register_system/register.php', 'title' => 'Register'],
        self::CONFIRM_ACCOUNT => ['layout' => 'views/layouts/default.php',
            'page' => 'views/login_register_system/confirm_account.php', 'title' => 'Confirm Email'],
        self::ACCOUNT_CONFIRMED => ['layout' => 'views/layouts/default.php',
            'page' => 'views/login_register_system/account_confirmed.php', 'title' => 'Account confirmed'],
        self::FORGOT_PASSWORD => ['layout' => 'views/layouts/default.php',
            'page' => 'views/login_register_system/forgot_password.php', 'title' => 'Forgot your password?'],
        self::CONFIRM_PASSWORD => ['layout' => 'views/layouts/default.php',
            'page' => 'views/login_register_system/confirm_password.php', 'title' => 'Confirm Email'],
        self::PASSWORD_CHANGED => ['layout' => 'views/layouts/default.php',
            'page' => 'views/login_register_system/password_changed.php', 'title' => 'Password has been changed'],
        self::PASSWORD_RESET_FORM => ['layout' => 'views/layouts/default.php',
            'page' => 'views/login_register_system/password_reset_form.php', 'title' => 'Change your password'],
        self::PROFILE => ['layout' => 'views/layouts/default.php',
            'page' => 'views/user/profile/settings.php', 'title' => 'Profile'],
        self::PROFILE_SETTINGS => ['layout' => 'views/layouts/default.php',
            'page' => 'views/user/profile/settings.php', 'title' => 'Settings'],
        self::PROFILE_MY_PHOTOS => ['layout' => 'views/layouts/default.php',
            'page' => 'views/user/profile/my_photos.php', 'title' => 'My Photos'],

        self::MAKE_PHOTO => ['layout' => 'views/layouts/default.php',
            'page' => 'views/photo/make_photo.php', 'title' => 'Make Photo'],

        self::ERROR_SOMETHING_WENT_WRONG => ['layout' => 'views/layouts/default.php',
            'page' => 'views/error_pages/something_went_wrong.php', 'title' => 'Oops :('],
        self::ERROR_400 => ['layout' => 'views/layouts/default.php',
            'page' => 'views/error_pages/400.php', 'title' => '400'],
        self::ERROR_404 => ['layout' => 'views/layouts/default.php',
            'page' => 'views/error_pages/404.php', 'title' => '404'],
        self::ERROR_500 => ['layout' => 'views/layouts/default.php',
            'page' => 'views/error_pages/500.php', 'title' => '500'],
    ];

    private static function getAdditionalData() : array
    {
        $base_date = [ 'is_logged' => User::isLogged(), 'current_year' => date("Y")];

        if ($base_date['is_logged'])
            $base_date['header_login'] = User::getLoginById(User::getId());
        return $base_date;
    }

    /**
     * @param int $view_id
     * @param array $data
     * @param string|null $title
     * @param bool $is_exit
     */
    public static function run(int $view_id, array $data=[], string $title=null, bool $is_exit=true) : void
    {
        $data += self::getAdditionalData();
        $view_elem = self::VIEWS_PATH_MAP[$view_id];
        $page = $view_elem['page'];
        if (!$title)
            $title = $view_elem['title'];

        require $view_elem['layout'];

        if ($is_exit)
            exit();
    }
}
