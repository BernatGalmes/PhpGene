<?php

namespace PhpGene;

class Input
{
    public static function exists($type = 'post')
    {
        switch ($type) {
            case 'post':
                return (!empty($_POST)) ? true : false;
                break;

            case 'get':
                return (!empty($_GET)) ? true : false;

            default:
                return false;
                break;
        }
    }

    public static function getAllPost($type = 'post')
    {
        if (empty($_POST)) {
            return [];
        }

        $data = [];
        foreach ($_POST as $key => $value) {
            $data[$key] = self::get($key);
        }
        return $data;
    }

    public static function get($item)
    {
        if (isset($_POST[$item])) {
            /*
            If the $_POST item is an array, process each item independently, and return array of sanitized items.
            */
            if (is_array($_POST[$item])) {
                $postItems = array();
                foreach ($_POST[$item] as $postItem) {
                    $postItems[] = self::sanitize($postItem);
                }
                return $postItems;
            } else {
                return self::sanitize($_POST[$item]);
            }

        } elseif (isset($_GET[$item])) {
            /*
            If the $_GET item is an array, process each item independently, and return array of sanitized items.
            */
            if (is_array($_GET[$item])) {
                $getItems = array();
                foreach ($_GET[$item] as $getItem) {
                    $getItems[] = self::sanitize($getItem);
                }
                return $getItems;
            } else {
                return self::sanitize($_GET[$item]);
            }
        }
        return '';
    }

    public static function sanitize($string)
    {
        return trim(htmlentities($string, ENT_QUOTES, 'UTF-8'));
    }

    public static function get_assoc($item)
    {
        if (isset($_POST[$item])) {
            /*
            If the $_POST item is an array, process each item independently, and return array of sanitized items.
            */
            if (is_array($_POST[$item])) {
                return self::create_structure($_POST[$item]);
            } else {
                return self::sanitize($_POST[$item]);
            }

        } elseif (isset($_GET[$item])) {
            /*
            If the $_GET item is an array, process each item independently, and return array of sanitized items.
            */
            if (is_array($_GET[$item])) {
                return self::create_structure($_GET[$item]);
            } else {
                return self::sanitize($_GET[$item]);
            }
        }
        return '';
    }

    private static function create_structure($data)
    {
        if (is_array($data)) {
            $dataPosted = [];
            foreach ($data as $key => $item) {
                $dataPosted[$key] = self::create_structure($item);
            }
            return $dataPosted;
        } else {
            return self::sanitize($data);
        }
    }
}
