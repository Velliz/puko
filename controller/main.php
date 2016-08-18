<?php
namespace controller;

class main extends View implements Auth
{

    public function main()
    {
    }

    public function about()
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