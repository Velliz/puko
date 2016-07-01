<?php
/**
 * Database class for Puko Framework
 *
 * @author Didit Velliz <diditvelliz@gmail.com>
 * @link http://github.com/Velliz/puko
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since version 0.92
 * @package Puko Core
 */
namespace Puko\Core\Backdoor;

use Exception;
use PDO;

abstract class Data
{

    public static $Instance = null;

    public $query;
    public $arrData;
    public $tableName;

    protected $pdo;
    protected $queryPattern = '#@([0-9]+)#';
    protected $queryParams = null;

    protected function __construct($tablename = null)
    {
        $db = include(FILE . '/config/database.php');
        if (!$db) {
            throw new Exception("Can't connect to database.");
        }
        $this->pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbName'],
            $db['user'],
            $db['pass']
        );

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->tableName = $tablename;
    }

    public static function To($tablename)
    {
        if (!isset(self::$Instance) && !is_object(self::$Instance)) {
            self::$Instance = new Model($tablename);
        }
        return self::$Instance;
    }

    public static function From($query)
    {
        if (!isset(self::$Instance) && !is_object(self::$Instance)) {
            self::$Instance = new Model($query);
        }
        self::$Instance->query = $query;
        return self::$Instance;
    }

    protected abstract function Save($array);

    protected abstract function Delete($arrWhere);

    protected abstract function Update($id, $array);

    protected abstract function FetchAll();

    protected abstract function Fetch();

    protected function queryParseReplace($key)
    {
        $aKey = ((int)$key[1] - 1);
        if (isset($this->queryParams[$aKey])) {
            $var = $this->queryParams[$aKey];
            if (is_string($var)) {
                return ("'" . $var . "'");
            } else {
                if (is_bool($var)) {
                    return ($var ? '1' : '0');
                } else {
                    if (is_array($var)) {
                        $s = '';
                        foreach ($var as $item) {
                            if (is_string($item)) {
                                $s .= (",'" . $item . "'");
                            } else {
                                $s .= (',' . $item);
                            }
                        }
                        $s[0] = '(';
                        return ($s . ')');
                    } else {
                        return $var;
                    }
                }
            }
        }
        return '';
    }
}