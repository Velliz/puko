<?php

namespace plugins;

use DateTime;

/**
 * Trait Utility
 * @package plugins
 */
trait Utility
{

    /**
     * @param DateTime $datetime
     * @param false $full
     * @return string
     */
    public static function time_elapsed_string(DateTime $datetime, $full = false)
    {
        $now = new DateTime;
        $ago = $datetime;
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'tahun',
            'm' => 'bulan',
            'w' => 'minggu',
            'd' => 'hari',
            'h' => 'jam',
            'i' => 'menit',
            's' => 'detik',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v;
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' lalu' : 'baru';
    }

    /**
     * @param $raw_password
     * @return false|string|null
     */
    public static function password_hash($raw_password)
    {
        return password_hash($raw_password, PASSWORD_DEFAULT);
    }

    /**
     * @param $raw_password
     * @param $hash
     * @return bool
     */
    public static function password_verify($raw_password, $hash)
    {
        return password_verify($raw_password, $hash);
    }

}
