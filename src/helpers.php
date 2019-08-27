<?php

function currentDateFormated($format='d-m-Y')
{
    $date = new \DateTime();
    return $date->format($format);
}

function cdate()
{
    $date = new \DateTime();
    return $date->getTimestamp();
}

function getTimeStamp($date, $format='d-m-Y')
{
    if ($dt = \DateTime::createFromFormat($format, $date)) {
        return $dt->getTimestamp();
    }
    return false;
}

function MissatgesSessio($msgs)
{
    $_SESSION['msgs'] = $msgs->html();
}

function MostraMissatgesSessio()
{
    if (!empty($_SESSION['msgs'])) {
        echo $_SESSION['msgs'];
        unset($_SESSION['msgs']);
    }
}

function rrmdir($dir)
{
    if (!is_dir($dir)) {
        throw new \Exception("Error! path carpeta incorrecte", 1);

    }
    $objects = scandir($dir);
    foreach ($objects as $object) {
        if ($object != "." && $object != "..") {
            if (is_dir($dir . "/" . $object))
                rrmdir($dir . "/" . $object);
            else
                unlink($dir . "/" . $object);
        }
    }
    rmdir($dir);
}

function rm_file($filename){
    if (file_exists($filename)){
        return unlink($filename);
    }
    return true;
}

function sanitize($string)
{
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function cleanText($text)
{
    return utf8_decode(html_entity_decode($text, ENT_QUOTES));
}
