<?php
/**
 * Created by IntelliJ IDEA.
 * User: bern
 * Date: 23/12/17
 * Time: 16:29
 */
foreach (glob(__DIR__ . "/src/*.php") as $filename) {
    require_once $filename;
}