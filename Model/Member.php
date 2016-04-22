<?php

namespace Model;

use Puko\Core\Backdoor\Model;

class Member extends Model
{

    public static function GetFamily($id)
    {
        return Member::From("SELECT * FROM FAMILY WHERE ID = @1")->FetchAll($id);
    }

}