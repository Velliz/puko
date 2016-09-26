<?php
namespace controller;

use pukoframework\auth\Auth;
use pukoframework\pte\View;

class main extends View implements Auth
{

    public function main()
    {
    }

    #region auth
    public function Login($username, $password)
    {
        return 1;
    }

    public function Logout()
    {

    }

    public function GetLoginData($id)
    {
    }
    #end region auth
}