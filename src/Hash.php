<?php

namespace PhpGene {
    class Hash
    {

        public static function unique()
        {
            return self::make(uniqid());
        }

        public static function make($string, $salt = '')
        {
            return hash('sha256', $string . $salt);
        }
    }
}
