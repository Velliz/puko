<?php
namespace model;

use pukoframework\pda\DBI;

class Example
{

    public static function Create($data)
    {
        return DBI::Prepare('table_name')->Save($data);
    }

    public static function Update($where, $data)
    {
        return DBI::Prepare('table_name')->Update($where, $data);
    }

    public static function GetAll()
    {
        return DBI::Prepare("SELECT * FROM `table_name`")->GetData();
    }

    public static function GetID($id)
    {
        return DBI::Prepare("SELECT * FROM `table_name` WHERE `id` = @1")->GetData($id);
    }

}