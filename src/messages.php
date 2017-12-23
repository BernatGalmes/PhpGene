<?php

namespace PhpGene;

/**
 * Class Messages
 * Class that helps to show messages in an application.
 * Very useful to show messages before processing a form.
 * @package PhpGene
 */
class Messages
{
    /**
     * @var bool Indicate if debugging messages has to be shown.
     * Always false in production mode.
     */
    private static $debugMode = false; // Config::DEBUG
    private $error;
    private $ok;
    private $debug;

    /**
     * Set the debug mode.
     * Call this method when initialize your app.
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

    /**
     * Clear all messages
     */
    public function buida()
    {
        $this->error = [];
        $this->ok = [];
        if (self::$debugMode) {
            $this->debug = [];
        }
    }

    /**
     * Add a positive message
     * @param string $msg
     */
    public function posa_ok($msg)
    {
        $this->ok [] = $msg;
    }

    /**
     * Add a negative message
     * @param string $msg
     */
    public function posa_error($msg)
    {
        $this->error [] = $msg;
    }

    /**
     * Add a debug message
     * @param string $msg
     */
    public function debug($msg)
    {
        if (self::$debugMode) {
            $this->debug [] = $msg;
        }
    }

    /**
     * Merge self object content with other.
     * @param $msgs Messages
     */
    public function merge($msgs)
    {
        $this->error = array_merge($this->error, $msgs->getError());
        $this->ok = array_merge($this->ok, $msgs->getOk());
        $this->debug = array_merge($this->debug, $msgs->getDebug());
    }

    /**
     * @return string[]
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return string[]
     */
    public function getOk()
    {
        return $this->ok;
    }

    /**
     * @return string[]
     */
    public function getDebug()
    {
        return $this->debug;
    }

//    /**
//     * print the
//     */
//    public function mostra_taula_missatges()
//    {
//        echo $this->html();
//    }

    /**
     * Get an html representation of the messages.
     * @return string html object representation.
     */
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

    /**
     * Get the messages as a json object
     * @return string
     */
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

    /**
     * Print a variable representation
     * @param mixed $var
     */
    public static function debugVar($var)
    {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
}
