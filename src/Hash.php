<?php

namespace PhpGene {

    /**
     * Class Hash
     * Ease hash
     * @package PhpGene
     */
    class Hash
    {

        const HASH_ALGH = 'sha256';

        /**
         * Get a unique hash value
         * @return string
         */
        public static function unique()
        {
            return self::make(uniqid());
        }

        /**
         *
         * @param $string
         * @param string $salt
         * @return string
         */
        public static function make($string, $salt = '')
        {
            return hash(self::HASH_ALGH, $string . $salt);
        }
    }
}
