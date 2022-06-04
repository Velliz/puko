<?php

namespace plugins;

use DateTime;

/**
 * Trait Utility.
 */
trait Utility
{

    /**
     * @param $raw_password
     *
     * @return false|string|null
     */
    public static function password_hash($raw_password)
    {
        return password_hash($raw_password, PASSWORD_DEFAULT);
    }

    /**
     * @param $raw_password
     * @param $hash
     *
     * @return bool
     */
    public static function password_verify($raw_password, $hash)
    {
        return password_verify($raw_password, $hash);
    }

}
