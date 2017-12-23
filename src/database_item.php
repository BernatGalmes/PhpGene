<?php

namespace PhpGene;

/**
 * Class database_item
 * Represents an row of a database item
 *
 * @package PhpGene
 */
class database_item
{
    /**
     * @var array item attributes
     * key: attribute name
     * value: attribute value
     */
    protected $_data;

    /**
     * Get the identifier of the item
     * @return int|string Id of the item
     */
    public function getID()
    {
        return $this->getAttr('id');
    }

    /**
     * Get the specified attribute of the item
     * @param $name string name of the attribute
     * @return mixed|string attribute value, empty string if attribute not found
     */
    public function getAttr($name)
    {
        if (isset($this->_data[$name])) {
            return $this->_data[$name];
        }
        return '';
    }
}