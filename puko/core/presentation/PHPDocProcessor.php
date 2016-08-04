<?php
/**
 * HTML view based data parser for Puko Framework
 *
 * @author Didit Velliz <diditvelliz@gmail.com>
 * @link http://github.com/Velliz/puko
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since version 0.92
 * @package Puko Core
 */
namespace puko\core\presentation;

use DateTime;
use puko\core\auth\Authentication;
use puko\core\Puko;

/**
 * Class View
 * @package Puko\Core\Presentation\Html
 *
 * @property-read Authentication $PukoAuthObject
 */
class PHPDocProcessor implements PHPDoc
{

    protected $arrDoc = array();

    /**
     * Service constructor.
     * @param $rawDocs
     */
    public function __construct($rawDocs)
    {
        $this->PukoAuthObject = Authentication::GetInstance();
        $this->arrDoc = $this->DocParser($rawDocs);
    }

    /**
     * @param $StrDoc
     * @return mixed
     */
    public function DocParser($StrDoc)
    {
        preg_match_all('(#[ a-zA-Z0-9-:./]+)', $StrDoc, $result, PREG_PATTERN_ORDER);
        return $result;
    }

    public function Value($key, $val)
    {
        return array(
            $key => $val
        );
    }

    public function User($key, $val)
    {
        if (strtolower($key) == 'authentication' && strtolower($val) == 'true') {
            if (!$this->PukoAuthObject->IsAuthenticated()) {
                if (strcmp(Puko::$Environment, 'dev') == 0) {
                    die('Not Authenticated');
                } else {
                    header($_SERVER["SERVER_PROTOCOL"] . " 401 Unauthorized", true, 401);
                    include PAGE_401;
                    die();
                }
            }
        }
    }

    public function Date($key, $val)
    {
        $today = date("d-m-Y H:i:s");
        $day = (new DateTime($val))->format("d-m-Y H:i:s");
        //after 12-06-2017 00:00:00
        switch ($key) {
            case 'before':
                if ($today > $day) {
                    if (strcmp(Puko::$Environment, 'dev') == 0) {
                        die('URL available before ' . $val);
                    } else {
                        header($_SERVER["SERVER_PROTOCOL"] . " 401 Unauthorized", true, 401);
                        include PAGE_401;
                        die();
                    }
                }
                break;
            case 'after':
                if ($today < $day) {
                    if (strcmp(Puko::$Environment, 'dev') == 0) {
                        die('URL available after ' . $val);
                    } else {
                        header($_SERVER["SERVER_PROTOCOL"] . " 401 Unauthorized", true, 401);
                        include PAGE_401;
                        die();
                    }
                }
                break;
        }
    }

    public function Throws($key, $val)
    {
        // TODO: Implement Throws() method.
    }

    public function Validation($key, $val)
    {
        // TODO: Implement Validation() method.
        // #Validation name required,number,min[30],max[40] ??
        if(isset($_POST[$key])){
            if($_POST[$key] == '') {
                return array(
                    $key => $val
                );
            }
        }
    }

    public function View($key, $val)
    {
        // TODO: Implement View() method.
        return array(
            $key => $val
        );
    }


    public function Output(&$data = array())
    {
        if (sizeof($this->arrDoc[0]) > 0) {
            foreach ($this->arrDoc[0] as $k => $v) {
                $preg = explode(' ', $v);
                $functionName = str_replace('#', '', $preg[0]);
                $keyWord = $preg[1];
                $params = null;
                foreach ($preg as $key => $val) {
                    switch ($key) {
                        case 0:
                            break;
                        case 1:
                            break;
                        default:
                            if ($key != sizeof($preg) - 1) {
                                $params .= $val . ' ';
                            } else {
                                $params .= $val;
                            }
                            break;
                    }
                }
                $result = $this->$functionName($keyWord, $params);
                if (is_array($data) && is_array($result)) {
                    foreach ($result as $key => $val) {
                        $data[$key] = $val;
                    }
                }
            }
        }
    }
}