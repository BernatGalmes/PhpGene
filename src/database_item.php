<?php

namespace PhpGene;

/**
 * Class database_item
 * Represents an row of a database item
 *
 * @package PhpGene
 */
abstract class database_item
{
    const ID_NAME = "id";

    /**
     * @var string Database item table name
     */
    protected $_db_table;

    /**
     * @var array item attributes
     * key: attribute name
     * value: attribute value
     */
    protected $_data;

    /**
     * database_item constructor.
     * @param array|int|null $item data(associative array) or identifier(int) of the item to build.
     *                              If null, data is not filled.
     * @param string $db_table Database table of the item
     * @throws \Exception item not found in database
     */
    function __construct($item, $db_table)
    {
        $this->_db_table = $db_table;
        if (is_array($item)){ // item is data
            $this->_data = $item;

        }elseif (is_numeric($item)){ //item is identifier
            if (!$this->__build_from_db($item)){
                throw new \Exception("item not found in database");
            }
        }
    }

    /**
     * Your own logic to fill the $_data attribute from database
     * @param int|string $id identifier of item in database
     * @return bool
     */
    protected abstract function __build_from_db($id);

    /**
     * Update the database data with the current object data
     * @return true
     * @throws \Exception item can't be updated
     */
    public abstract function update();

    /**
     * Remove the item in the database
     * @return bool
     * @throws \Exception item can't be deleted
     */
    public abstract function remove();


    /**
     * Get the identifier of the item
     * @return int|string Id of the item
     */
    public function getID()
    {
        return $this->getAttr(self::ID_NAME);
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