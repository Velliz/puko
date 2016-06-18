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

    /**
     * @var object
     */
    public static $Instance = null;

    static function GetInstance()
    {
        if (!isset(self::$Instance) && !is_object(self::$Instance)) {
            self::$Instance = new Authentication();
        }

        return self::$Instance;
    }

    public function IsAuthenticated()
    {
        if (!isset($_SESSION['PukoAuth'])) {
            return false;
        }

        return true;
    }

    function Authenticate($username, $password)
    {
        $secure = $this->encrypt($this->CustomAuthentication($username, $password));
        setcookie('puko', $secure, time() + (86400 * 30), "/", $_SERVER['SERVER_NAME']);
    }

    public function GetUserData()
    {
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
    }

    public function getSessionData($val)
    {
        return $this->decrypt($_COOKIE[$val]);
    }

    public function removeSessionData($key)
    {
        setcookie($key, '', time() - (86400 * 30), '/', $_SERVER['SERVER_NAME']);
    }

    private function encrypt($string)
    {
        $encrypt_method = "AES-256-CBC";
        $secret_key = '37360191345215';
        $secret_iv = 'pukoframework';

        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        return base64_encode($output);
    }

    private function decrypt($string)
    {
        $encrypt_method = "AES-256-CBC";
        $secret_key = '37360191345215';
        $secret_iv = 'pukoframework';

        $key = hash('sha256', $secret_key);

        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        return openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
}

