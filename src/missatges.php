<?php

namespace PhpGene;

class Missatges
{
    private static $debugMode; // Config::DEBUG
    private $error;
    private $ok;
    private $debug;

    /**
     * @param boolean $debugMode
     */
    public static function setDebugMode($debugMode)
    {
        self::$debugMode = $debugMode;
    }

    function __construct()
    {
        $this->buida();
    }

    public function buida()
    {
        $this->error = [];
        $this->ok = [];
        if (self::$debugMode) {
            $this->debug = [];
        }
    }

    public static function debugVar($var)
    {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }

    public function posa_ok($msg)
    {
        $this->ok [] = $msg;
    }

    public function posa_error($msg)
    {
        $this->error [] = $msg;
    }

    public function debug($msg)
    {
        if (self::$debugMode) {
            $this->debug [] = $msg;
        }
    }

    /**
     * @param $msgs Missatges
     */
    public function merge($msgs)
    {
        $this->error = array_merge($this->error, $msgs->getError());
        $this->ok = array_merge($this->ok, $msgs->getOk());
        $this->debug = array_merge($this->debug, $msgs->getDebug());
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return mixed
     */
    public function getOk()
    {
        return $this->ok;
    }

    /**
     * @return mixed
     */
    public function getDebug()
    {
        return $this->debug;
    }

    public function mostra_taula_missatges()
    {
        echo $this->html();
    }

    public function html()
    {
        $html = '';
        if (!empty($this->error)) {
            $html = "<div class='alert alert-danger fade in' role='alert'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
            $html .= '<ul>';
            foreach ($this->error as $error) {
                if (is_array($error)) {
                    $html .= '<li>' . $error[0] . '</li>';
                    $html .= '<script>jQuery("document").ready(function(){jQuery("#' . $error[1] . '").parent().closest("div").addClass("has-error");});</script>';
                } else {
                    $html .= '<li>' . $error . '</li>';
                }

            }
            $html .= '</ul></div>';

        }
        if (!empty($this->ok)) {
            $html .= "<div class='alert alert-success fade in' role='alert'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
            $html .= '<ul>';
            foreach ($this->ok as $success) {
                $html .= '<li>' . $success . '</li>';
            }
            $html .= '</ul></div>';
        }
        if (self::$debugMode) {
            if (!empty($this->debug)) {
                $html .= "<div class='alert alert-info fade in' role='alert'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
                $html .= '<ul>';
                foreach ($this->debug as $success) {
                    $html .= '<li>' . $success . '</li>';
                }
                $html .= '</ul></div>';
            }
        }
        return $html;
    }

    public function darrerOkMissatge()
    {
        $iDarrer = count($this->ok) - 1;
        if ($iDarrer == -1) return "";

        return $this->ok[$iDarrer];
    }

    public function hiHaErrors()
    {
        return (!empty($this->error));
    }

    public function json()
    {
        return json_encode(
            [
                'errors' => $this->error,
                'success' => $this->ok,
                'debug' => $this->debug,

            ]
        );
    }
}
