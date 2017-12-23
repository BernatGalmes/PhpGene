<?php

namespace PhpGene;

class Redirect
{
    public static function forbiddenPage($origin, $flag = 1)
    {
        switch ($flag) {
            case 1:
                self::to(LINK_BASE_FORBIDDEN . '?origin=' . urlencode($origin));

                break;
            case 2:
                self::to(LINK_BASE_FORBIDDEN . '?origin=' . urlencode($origin) . '&causa=' . urlencode("No puedes editar un documento que no has creado tú"));
        }

    }

    public static function to($location = null)
    {
        if ($location) {
            if (!headers_sent()) {
                header('Location: ' . $location);

            } else {
                echo '<script type="text/javascript">';
                echo 'window.location.href="' . $location . '";';
                echo '</script>';
                echo '<noscript>';
                echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';
                echo '</noscript>';
                exit;
            }
        }
    }

    public static function refresh($msgs = null)
    {
        if (!empty($msgs)) {
            MissatgesSessio($msgs);
        }
        self::to($_SERVER['PHP_SELF']);
    }


}