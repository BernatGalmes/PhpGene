<?php
/**
 * Created by IntelliJ IDEA.
 * User: bernat
 * Date: 3/09/17
 * Time: 17:10
 */

namespace PhpGene;


class xml_data
{
    protected $dom;

    private $filename;

    function __construct($filename)
    {
        $this->filename = $filename;
        $this->dom = simplexml_load_file($filename);
    }

    function saveChanges()
    {
        $this->dom->asXML($this->filename);
    }
}