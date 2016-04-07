<?php

namespace Puko\Core\Auth;

use Puko\Modules\AuthenticationModules;

class Authentication extends AuthenticationModules
{

    public static $Instance = null;
    private static $authCodes;

    static function GetInstance($authCode)
    {
        @session_start();
        if (!isset(self::$Instance) && !is_object(self::$Instance)) {
            self::$Instance = new Authentication();
        }

        self::$authCodes = $authCode;
        return self::$Instance;
    }

    function IsAuthenticated()
    {
        if (!isset($_SESSION['PukoAuth'])) {
            return false;
        }

        return true;
    }

    function Authenticate($username, $password)
    {
        $_SESSION['PukoAuth'] = $this->CustomAuthentication($username, $password);
        $_SESSION['UID'] = uniqid();
    }

    function GetUserData()
    {
        return $_SESSION['PukoAuth'];
    }

    function RemoveAuthentication()
    {
        session_destroy();
    }
}

