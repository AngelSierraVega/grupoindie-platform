<?php

/**
 * GIplatform - ListSimple 2017-06-26
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.0?
 */

namespace GIndie\Platform\Model;

use GIndie\Platform\Current;

/**
 * Description of List
 *
 * @version     GIP.00.05
 *
 * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
abstract class ListSimple implements ListSimpleINT
{

    /**
     * The name of the attribute to perform the autonest
     *  @since  GIP.00.02
     */
    const ELEMENT_AUTONEST_ON = \NULL;

    /**
     * @since GIP.00.05
     * @return \GIndie\Platform\Model\Record
     */
    public static function DisplayKey()
    {
        $_record = static::RelatedRecord();
        return $_record::DISPLAY_KEY;
    }

    /**
     * @since GIP.00.05
     * @return \GIndie\Platform\Model\Record
     */
    public static function PrimaryKey()
    {
        $_record = static::RelatedRecord();
        return $_record::PRIMARY_KEY;
    }
    
    public static function getValidRolesFor($action){
        $_record = static::RelatedRecord();
        return $_record::getValidRolesFor($action);
    }

    /**
     * @since GIP.00.05
     * @return string
     */
    public static function Name()
    {
        $_record = static::RelatedRecord();
        return $_record::NAME;
    }

    /**
     * @since  GIP.00.01
     * @version GIP.00.05
     * @var \GIndie\Platform\Model\Record
     */
    private $_relatedRecordClass;

    /**
     * @since  GIP.00.01
     * @version GIP.00.05
     */
    public function __construct($conditions = [])
    {
//        static::ELEMENT_ID !== \NULL ?: trigger_error("Constant ELEMENT_ID must be defined inside class definition of: " . get_called_class(),
//                                                      \E_USER_ERROR);
//        static::ELEMENT_NAME !== \NULL ?: trigger_error("Constant ELEMENT_NAME must be defined inside class definition of: " . get_called_class(),
//                                                        \E_USER_ERROR);
//        static::RELATED_RECORD !== \NULL ?: trigger_error("Constant RELATED_RECORD must be defined inside class definition of: " . get_called_class(),
//                                                          \E_USER_ERROR);
        //var_dump($conditions);

        $_recordClass = static::RelatedRecord();
        $this->_relatedRecordClass = static::RelatedRecord();
        if (\is_string($conditions)) {
            //var_dump("ENTRO");
            if ($conditions == "gip-selected-id") {
                if (isset($_POST["gip-selected-id"])) {
                    $conditions = [[static::DisplayKey() => $_POST["gip-selected-id"]]];
                    // $conditions = [[static::ELEMENT_NAME => $_POST["gip-selected-id"]]];
                    // return $_POST["gip-selected-id"];
                    // $this->addElement(static::ELEMENT_ID,
                    // $_POST["gip-selected-id"]);
                    return $this->readFromDB($conditions);
                } else {
                    //throw new \Exception("TEST");
                }
                // return "NONE";
            } else {
                $conditions = [[static::PrimaryKey() => $conditions]];
                return $this->readFromDB($conditions);
//                $tmpRow = [$conditions];
//                $_class = static::RELATED_RECORD;
//                $_name = \is_array(static::ELEMENT_NAME) ?
//                        \array_keys(static::ELEMENT_NAME)[0] : static::ELEMENT_NAME;
//                $model = new $_class($conditions);
//                $this->addElement("RELATED_RECORD_NAME",
//                                  $model->getAttribute($_name)->getDisplay());
            }
        } else {
            try {
                if (static::ELEMENT_AUTONEST_ON !== \NULL) {
                    if ($this->_hasParentCondition($conditions) === \FALSE) {
                        $conditions[] = [static::ELEMENT_AUTONEST_ON => "NULL"];
                    }
                }
                return $this->readFromDB($conditions);
            } catch (\Exception $exc) {

                $tmpRow = [];
                foreach (array(static::PrimaryKey(), static::DisplayKey()) as $column) {
                    $tmpRow[$column] = $exc->getMessage();
                }
                $this->addElement("error", $exc->getMessage());
            }
        }
    }

    /**
     * Populates the found rows from the database.
     * 
     * @param array $conditions
     *
     * @version     GIP.00.05
     */
    private function readFromDB(array $conditions = [])
    {
        $_recordClass = static::RelatedRecord();
        $_resultSet = Current::Connection()->select([static::PrimaryKey(),
            static::DisplayKey()], $_recordClass::SCHEMA, $_recordClass::TABLE,
                                                    $conditions);
        if ($_resultSet) {
            while ($row = $_resultSet->fetch_assoc()) {
                $elementName = \is_array(static::DisplayKey()) ? \array_keys(static::DisplayKey())[0] : static::DisplayKey();
                if (static::ELEMENT_AUTONEST_ON !== \NULL) {
                    $key = $this->_hasParentCondition($conditions);
                    if ($key !== \FALSE) {
                        $conditions[$key] = [static::ELEMENT_AUTONEST_ON => $row[static::PrimaryKey()]];
                    }
                    //var_dump("ENTRO");
                    //$params = [static::ELEMENT_AUTONEST_ON . "='" . $row[static::PrimaryKey()] . "'"];
                    //$params = [[static::ELEMENT_AUTONEST_ON => $row[static::PrimaryKey()]]];
                    //$params = ["key"=>"columna","value"=>"condicion"]
                    //$conditions[]
                    static::addElement($row[static::PrimaryKey()],
                                      $row[$elementName], static::class,
                                      $conditions);
                } else {
                    static::addElement($row[static::PrimaryKey()],
                                      $row[$elementName]);
                }
            }
        }
        return $_resultSet;
    }

    private function _hasParentCondition(array $conditions)
    {
        foreach ($conditions as $conditionKey => $condition) {
            if (\is_array($condition)) {
                foreach ($condition as $attribute => $restriction) {
                    if (\strcmp($attribute, static::ELEMENT_AUTONEST_ON) == 0) {
                        return $conditionKey;
                    }
                }
            }
        }
        return \FALSE;
    }

//    protected $_createElement = \FALSE;
//    protected $_editElement = \FALSE;
//    protected $_deleteElement = \FALSE;
//    protected $_parent = "";
    //abstract protected function defineColumns();

    /**
     * @version     GIP.00.01
     * @return      \GIndie\Platform\Model\Table\Column
     */
    protected function defineColumnDPR($fieldName)
    {
        isset($this->_columns[$fieldName]) ?: $this->_columns[$fieldName] = new Table\Column($fieldName);
        $rtnElement = &$this->_columns[$fieldName];
        return $rtnElement;
    }

    /**
     * @since   GIP.00.02
     * @param   $attr1
     * @param   $attr2
     */
    public function addElement($elementId, $elementName, $chidClass = \NULL,
                               $childParams = \NULL)
    {
        $this->_data[$elementId] = new Element($elementId, $elementName);
        $this->_data[$elementId]->setValue($elementName);
        if ($chidClass !== \NULL) {
            $_child = new $chidClass($childParams);
            $this->_data[$elementId]->setNested($_child);
        }
    }

    /**
     * @since   GIP.00.01
     * @return array
     */
    public function getElements()
    {
        if (isset($this->_data)) {
            return \array_keys($this->_data);
        }
        return [];
    }

    protected $_data = [];

    public function cleanData()
    {
        $this->_data = [];
    }

    /**
     * @since GIP.00.01
     * @param $recordId
     * @return mixed
     */
    public function getElementAt($recordId)
    {
        return isset($this->_data[$recordId]) ? $this->_data[$recordId] : \FALSE;
    }

//    public function setOptions($create = \FALSE, $delete = \FALSE,
//            $edit = \FALSE) {
//        $this->_createElement = $create;
//        $this->_deleteElement = $delete;
//        $this->_editElement = $edit;
//    }
//
//    public function getCreateOption() {
//        return $this->_createElement;
//    }
//
//    public function getEditOption() {
//        return $this->_editElement;
//    }
//
//    public function getDeleteOption() {
//        return $this->_deleteElement;
//    }
//    
//    
//    
//    public function setParent($parentColumnName){
//        $this->_parent = $parentColumnName;
//    }
//
//    public function getParent(){
//        return $this->_parent;
//    }
}
