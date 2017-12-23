<?php
/**
 * Created by IntelliJ IDEA.
 * User: bernat
 * Date: 3/09/17
 * Time: 17:10
 */

namespace PhpGene;

/**
 * Class xml_data
 * Ease xml management.
 * @package PhpGene
 */
class xml_data
{
    protected $dom;

    private $filename;

    /**
     * xml_data constructor.
     * @param string $filename path of an xml file.
     */
    function __construct($filename)
    {
        $this->filename = $filename;
        $this->dom = simplexml_load_file($filename);
    }

    /**
     * Save the dom changes in the same file.
     */
    function saveChanges()
    {
        $this->dom->asXML($this->filename);
    }
}