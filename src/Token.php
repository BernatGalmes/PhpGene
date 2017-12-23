<?php

namespace PhpGene;

class Token
{
    private static $tokenName; // config::SESSION['token_name'];

    /**
     * @param mixed $tokenName
     */
    public static function setTokenName($tokenName)
    {
        self::$tokenName = $tokenName;
    }

    public static function generate()
    {
        return Session::put(self::$tokenName, md5(uniqid()));
    }

    public static function check($token)
    {
        $tokenName = self::$tokenName;

        if (Session::exists($tokenName) && $token === Session::get($tokenName)) {
            Session::delete($tokenName);
            return true;
        }
        return false;
    }
}
