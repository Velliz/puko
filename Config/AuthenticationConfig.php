<?php

namespace Config;


abstract class AuthenticationConfig
{

    function CustomAuthentication($username, $password)
    {
        return array(
            'username' => 'Velliz',
            'email' => 'velliz@gmail.com'
        );
    }

}