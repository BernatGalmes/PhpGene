<?php

namespace PhpGene;

/**
 * Class Cookie
 * Ease cookie management
 * @package PhpGene
 */
class Cookie
{

    /**
     * Check if the specified cookie exists
     * @param $name String Name of the cookie
     * @return bool
     */
    public static function exists($name)
    {
        return isset($_COOKIE[$name]);
    }

    /**
     * Get the specified Cookie
     * @param $name String
     * @return mixed Cookie content
     */
    public static function get($name)
    {
        return $_COOKIE[$name];
    }

    /**
     * Remove the specified cookie
     * @param $name String
     */
    public static function delete($name)
    {
        self::put($name, '', time() - 1);
    }

    /**
     * Set a new cookie content
     * @param $name String name of the cookie
     * @param $value String content to set
     * @param $expiry int time to expire
     * @return bool If output exists prior to calling this function, setcookie() will fail and return FALSE.
     *              If setcookie() successfully runs, it will return TRUE.
     *              This does not indicate whether the user accepted the cookie.
     */
    public static function put($name, $value, $expiry)
    {
        return setcookie($name, $value, time() + $expiry, "/");
    }
}
