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

    public const ERROR_400 = 400;
    public const ERROR_404 = 404;
    public const ERROR_500 = 500;
    public const ERROR_SOMETHING_WENT_WRONG = 42;

    private const VIEWS_PATH_MAP = [
        self::INDEX => 'views/index.php',
        self::LOGIN => 'views/login_register_system/login.php',
        self::REGISTER => 'views/login_register_system/register.php',
        self::CONFIRM_ACCOUNT => 'views/login_register_system/confirm_account.php',
        self::ACCOUNT_CONFIRMED => 'views/login_register_system/account_confirmed.php',
        self::FORGOT_PASSWORD => 'views/login_register_system/forgot_password.php',
        self::CONFIRM_PASSWORD => 'views/login_register_system/confirm_password.php',
        self::PASSWORD_CHANGED => 'views/login_register_system/password_changed.php',
        self::PASSWORD_RESET_FORM => 'views/login_register_system/password_reset_form.php',
        self::ERROR_SOMETHING_WENT_WRONG => 'views/error_pages/something_went_wrong.php',
        self::ERROR_400 => 'views/error_pages/400.php',
        self::ERROR_404 => 'views/error_pages/404.php',
        self::ERROR_500 => 'views/error_pages/500.php',
    ];

    private static function getAdditionalData() : array
    {
        $base_date = [ 'is_logged' => User::isLogged(), 'current_year' => date("Y")];

        return $base_date;
    }

    /**
     * @param int $view_id
     * @param array|null $data
     * @param bool $is_exit
     */
    public static function run(int $view_id, array $data=[], bool $is_exit=true) : void
    {
        $data += self::getAdditionalData();
        require self::VIEWS_PATH_MAP[$view_id];
        if ($is_exit)
            exit();
    }
}
