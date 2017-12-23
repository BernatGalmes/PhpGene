<?php
/**
 * Created by IntelliJ IDEA.
 * User: bernat
 * Date: 2/07/17
 * Time: 12:13
 */

namespace PhpGene;


class database_item
{
    protected $_data;

    public function getID()
    {
        return $this->getAttr('id');
    }

    public function getAttr($name)
    {
        if (isset($this->_data[$name])) {
            return $this->_data[$name];
        }
        return '';
    }
}