<?php
/**
 * Authentication class for Puko Framework
 *
 * @author Didit Velliz <diditvelliz@gmail.com>
 * @link http://github.com/Velliz/puko
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since version 0.92
 * @package Puko Core
 */
namespace Puko\Core\Auth;

use Puko\Modules\AuthenticationModules;

class Authentication extends AuthenticationModules
{

    private static $method;
    private static $key;
    private static $identifier;

    /**
     * @var object
     */
    public static $Instance = null;

    static function GetInstance()
    {
        if (!isset(self::$Instance) && !is_object(self::$Instance)) {
            self::$Instance = new Authentication();
            $encript = include(FILE . '/config/encription.php');
            self::$method = $encript['method'];
            self::$key = $encript['key'];
            self::$identifier = $encript['identifier'];
        }

        if (!isset($_COOKIE['token'])) {
            if (function_exists('mcrypt_create_iv')) {
                $csrf = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
                setcookie('token', $csrf, time() + (86400 * 30), '/', $_SERVER['SERVER_NAME']);
                $_COOKIE['token'] = $csrf;
            } else {
                $csrf = bin2hex(openssl_random_pseudo_bytes(32));
                setcookie('token', $csrf, time() + (86400 * 30), '/', $_SERVER['SERVER_NAME']);
                $_COOKIE['token'] = $csrf;
            }
        }

        return self::$Instance;
    }

    public function IsAuthenticated()
    {
        if (!isset($_COOKIE['puko'])) {
            return false;
        }

        return true;
    }

    function Authenticate($username, $password)
    {
        $secure = $this->encrypt($this->CustomAuthentication($username, $password));
        setcookie('puko', $secure, time() + (86400), "/", $_SERVER['SERVER_NAME']);
    }

    public function GetUserData()
    {
        if (!isset($_COOKIE['puko'])) return false;
        $secure = $this->decrypt($_COOKIE['puko']);
        return $this->FetchUserData($secure);
    }

    public function RemoveAuthentication()
    {
        setcookie('puko', '', time() - (86400 * 30), '/', $_SERVER['SERVER_NAME']);
    }

    public function setSessionData($key, $val)
    {
        $secure = $this->encrypt($val);
        setcookie($key, $secure, time() + (86400 * 30), "/", $_SERVER['SERVER_NAME']);
        if ($key == 'lang') $_COOKIE['lang'] = $secure;
    }

    public function getSessionData($val)
    {
        if (!isset($_COOKIE[$val])) return false;
        return $this->decrypt($_COOKIE[$val]);
    }

    public function removeSessionData($key)
    {
        setcookie($key, '', time() - (86400 * 30), '/', $_SERVER['SERVER_NAME']);
    }

    private function encrypt($string)
    {
        $key = hash('sha256', self::$key);
        $iv = substr(hash('sha256', self::$identifier), 0, 16);

        $output = openssl_encrypt($string, self::$method, $key, 0, $iv);
        return base64_encode($output);
    }

    private function decrypt($string)
    {
        $key = hash('sha256', self::$key);

        $iv = substr(hash('sha256', self::$identifier), 0, 16);
        return openssl_decrypt(base64_decode($string), self::$method, $key, 0, $iv);
    }
}

