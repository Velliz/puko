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
            if (!isset(self::$Instance) && !is_object(self::$Instance))
                self::$Instance = new Authentication();

            self::$authCodes = $authCode;
            return self::$Instance;
        }
    }

}