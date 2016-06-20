<?php
/**
 * Model class for Puko Framework
 *
 * @author Didit Velliz <diditvelliz@gmail.com>
 * @link http://github.com/Velliz/puko
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since version 0.92
 * @package Puko Core
 */
namespace Puko\Core\Backdoor;

use PDO;

class Model extends Data
{
    /**
     * Model constructor.
     */
    protected function __construct()
    {
        parent::__construct();
    }

    public function Save($array)
    {
        $insert_text = "INSERT INTO `$this->tableName`";
        $keys = array();
        $values = array();
        foreach ($array as $k => $v) {
            $keys[] = $k;
            $values[] = $v;
        }
        $key_string = "(";
        foreach ($keys as $key) {
            $key_string = $key_string . "`" . $key . "`, ";
        }
        $key_string = substr($key_string, 0, -2);
        $insert_text = $insert_text . " " . $key_string . ")";
        $insert_text = $insert_text . " VALUES ";
        $value_string = "(";

        foreach ($keys as $key) {
            $value_string = $value_string . ":" . $key . ", ";
        }
        $value_string = substr($value_string, 0, -2);
        $insert_text = $insert_text . $value_string . ");";

        $statement = $this->pdo->prepare($insert_text);

        foreach ($keys as $no => $key) {
            if (strpos($key, 'file') !== false) {
                $blob = file_get_contents($values[$no], 'rb');
                $statement->bindParam(':' . $key, $blob, PDO::PARAM_LOB);
            } else {
                $statement->bindParam(':' . $key, $values[$no]);
            }
        }

        if ($statement->execute()) {
            return $this->pdo->lastInsertId();
        } else {
            return false;
        }

    }

    public function Delete($arrWhere)
    {
        $del_text = "DELETE FROM `$this->tableName` WHERE ";
        foreach ($arrWhere as $col => $value) {
            $del_text .= "`" . $col . "`" . " = '" . $value . "' AND ";
        }
        $del_text = substr($del_text, 0, -4);

        $statement = $this->pdo->prepare($del_text);
        return $statement->execute($arrWhere);
    }

    public function Update($id, $array)
    {
        $array = array_merge($id, $array);

        $update_text = "UPDATE `$this->tableName` SET ";

        $key_string = "";
        $key_where = " WHERE ";

        foreach ($array as $key => $val) {
            $key_string = $key_string . "`" . $key . "` = :" . $key . ", ";
        }
        $key_string = substr($key_string, 0, -2);

        foreach ($id as $key => $val) {
            $key_where = $key_where . "`" . $key . "` = :" . $key . " AND ";
        }
        $key_where = substr($key_where, 0, -4);

        $update_text = $update_text . " " . $key_string . $key_where;

        $statement = $this->pdo->prepare($update_text);
        return $statement->execute($array);
    }

    public function FetchAll()
    {
        $parameters = func_get_args();
        $argCount = count($parameters);
        if ($argCount > 0) {
            $this->queryParams = $parameters;
            $this->query = preg_replace_callback(
                $this->queryPattern, array($this, 'queryParseReplace'), $this->query);
        }
        $statement = $this->pdo->prepare($this->query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Fetch()
    {
        $parameters = func_get_args();
        $argCount = count($parameters);
        if ($argCount > 0) {
            $this->queryParams = $parameters;
            $this->query = preg_replace_callback(
                $this->queryPattern, array($this, 'queryParseReplace'), $this->query);
        }
        $statement = $this->pdo->prepare($this->query);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}