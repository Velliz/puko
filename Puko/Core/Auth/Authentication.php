<?php

namespace Puko\Core\Auth {

    use Config\AuthenticationConfig;

    class Authentication extends AuthenticationConfig
    {

        public static $Instance = null;
        private static $authCodes;

        /**
         * Authentication constructor.
         */
        private function __construct()
        {

        }

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
            if(!isset($_SESSION['PukoAuth']))
                return false;

            return true;
        }

        function Authenticate($username, $password){
            $authData = $this->CustomAuthentication($username, $password);
            $_SESSION['PukoAuth'] = $authData;
        }
    }

}