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
        setcookie( 'puko', '', time() - (86400 * 30), '/', $_SERVER['SERVER_NAME']);
    }

    private function encrypt($string)
    {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = '37360191345215';
        $secret_iv = 'pukoframework';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);

        return $output;
    }

    private function decrypt($string)
    {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = '37360191345215';
        $secret_iv = 'pukoframework';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

        return $output;
    }
}

