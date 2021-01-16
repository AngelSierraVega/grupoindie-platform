<?php

/**
 * GI-Platform-DVLP - ListSimple
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\Model
 *
 * @version 0C.80
 * @since 17-06-26
 * @todo Upgrade class
 */

namespace GIndie\Platform\Model;

use GIndie\Platform\Current;

/**
 * Description of List
 * @edit 18-01-17
 * - Updated readFromDB()
 * - Cleaned deprecated code
 * @edit 18-02-27
 */
abstract class ListSimple implements ListSimpleINT
{

    /**
     * The name of the attribute to perform the autonest
     */
    const ELEMENT_AUTONEST_ON = \NULL;

    /**
     * @return \GIndie\Platform\Model\Record
     */
    public static function DisplayKey()
    {
        $_record = static::RelatedRecord();
        return $_record::DISPLAY_KEY;
    }

    /**
     * @return \GIndie\Platform\Model\Record
     */
    public static function PrimaryKey()
    {
        $_record = static::RelatedRecord();
        return $_record::PRIMARY_KEY;
    }

    public static function getValidRolesFor($action)
    {
        $_record = static::RelatedRecord();
        return $_record::getValidRolesFor($action);
    }

    /**
     * @return string
     */
    public static function Name()
    {
        $_record = static::RelatedRecord();
        return $_record::NAME;
    }

    /**
     * @var \GIndie\Platform\Model\Record
     */
    private $_relatedRecordClass;

    /**
     * 
     * @param array $conditions
     * @return type
     * @edit 19-12-24
     */
    public function __construct($conditions = [], $params = [])
    {
        //$_recordClass = static::RelatedRecord();
        $this->_relatedRecordClass = static::RelatedRecord();
        if (\is_string($conditions)) {
            if ($conditions == "gip-selected-id") {
                if (isset($_POST["gip-selected-id"])) {
                    $conditions = [[static::DisplayKey() => $_POST["gip-selected-id"]]];
                    return $this->readFromDB($conditions, $params);
                } else {
                    
                }
            } else {
                $conditions = [[static::PrimaryKey() => $conditions]];
                return $this->readFromDB($conditions, $params);
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
     * @param array $params
     * @edit 18-01-17
     * - Protected method
     * - Param $params added
     */
    protected function readFromDB(array $conditions = [], array $params = [])
    {
        $_recordClass = static::RelatedRecord();
        $_resultSet = Current::Connection()->select([static::PrimaryKey(),
            static::DisplayKey()], $_recordClass::SCHEMA, $_recordClass::TABLE, $conditions, $params);
        if ($_resultSet) {
            while ($row = $_resultSet->fetch_assoc()) {
                $elementName = \is_array(static::DisplayKey()) ? \array_keys(static::DisplayKey())[0] : static::DisplayKey();
                if (static::ELEMENT_AUTONEST_ON !== \NULL) {
                    $key = $this->_hasParentCondition($conditions);
                    if ($key !== \FALSE) {
                        $conditions[$key] = [static::ELEMENT_AUTONEST_ON => $row[static::PrimaryKey()]];
                    }
                    static::addElement($row[static::PrimaryKey()], $row[$elementName], static::class, $conditions);
                } else {
                    static::addElement($row[static::PrimaryKey()], $row[$elementName]);
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

    /**
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
    public function addElement($elementId, $elementName, $chidClass = \NULL, $childParams = \NULL)
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

}
