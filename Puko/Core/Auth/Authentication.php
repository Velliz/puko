<?php

namespace Puko\Core\Auth;

use Puko\Modules\AuthenticationModules;

class Authentication extends AuthenticationModules
{

    /**
     * @var null
     */
    public static $Instance = null;

    static function GetInstance()
    {
        @session_start();
        if (!isset(self::$Instance) && !is_object(self::$Instance)) {
            self::$Instance = new Authentication();
        }

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
        @session_destroy();
    }
}

