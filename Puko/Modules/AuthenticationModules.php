<?php

namespace Puko\Modules;

class AuthenticationModules
{
    /**
     * @param $username
     * @param $password
     *
     * @return int
     */
    protected function CustomAuthentication($username, $password)
    {
        // todo : your authentication code belongs here.

        // todo : return your session ID.
        return 1;
    }

    protected function FetchUserData($uid)
    {
        // todo : get userdata from session ID.
        return 1;
    }
}