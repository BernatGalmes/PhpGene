<?php

namespace PhpGene;
use PhpOffice\PhpSpreadsheet\Exception;

/**
 * Class database_item
 * Represents an row of a database item
 *
 * @package PhpGene
 */
abstract class database_item
{
    const ACTION_INSERT = 'insert';
    const ACTION_UPDATE = 'update';
    const ACTION_REMOVE = 'remove';

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
     * @var Messages instance to keep the validation messages
     */
    protected $_msgs;

    /**
     * database_item constructor.
     * @param array|int|null $item data(associative array) or identifier(int) of the item to build.
     *                              If null, data is not filled.
     * @param string $db_table Database table of the item
     * @throws \Exception item not found in database
     */
    function __construct($item, $db_table)
    {
        if (!is_string($db_table)){
            throw new \Exception("incorrect table name");
        }
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
     */
    public abstract function update();

    /**
     * Remove the item in the database
     * @return bool
     */
    public abstract function remove();


    /**
     * Insert item in database
     * @return bool
     */
    public abstract function insert();

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

    public function setAttr($attr, $value)
    {
        $this->_data[$attr] = $value;
    }



    public function getMessages()
    {
        if (!isset($this->_msgs)) {
            $this->_msgs = new Messages();
        }
        return $this->_msgs;
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->_data)){
            return $this->_data;
        }
        return [];
    }

    public function setData($data)
    {
        foreach ($data as $key => $camp) {
            $this->_data[$key] = $camp;
        }
    }

    /**
     * @param $action
     * @return bool|true
     */
    public function performAction($action){
        switch ($action){
            case self::ACTION_INSERT:
                $stat = $this->insert();
                if ($stat){
                    $this->_msgs->posa_ok("Item inserted correctly.");
                }else{
                    $this->_msgs->posa_error("Error inserting item.");
                }
                break;
            case self::ACTION_UPDATE:
                $stat = $this->update();
                if ($stat){
                    $this->_msgs->posa_ok("Item updated correctly.");
                }else{
                    $this->_msgs->posa_error("Error updating item.");
                }
                break;
            case self::ACTION_REMOVE:
                $stat = $this->remove();
                if ($stat){
                    $this->_msgs->posa_ok("Item removed successfully.");
                }else{
                    $this->_msgs->posa_error("Error deleting item.");
                }
                break;
            default:
                return false;
        }
        return $stat;
    }
}
