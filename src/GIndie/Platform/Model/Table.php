<?php

/*
 * Copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * This software is protected under GNU: you can use, study and modify it
 * but not distribute it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 */

namespace GIndie\Platform\Model;

use GIndie\Platform\Current;

/**
 * Description of Table
 * 
 * @version     GIP.00.06
 * @since       2017-06-26
 *
 * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
abstract class Table implements TableINT
{

    public static function Schema()
    {
        $_relatedRecord = static::RelatedRecord();
        return $_relatedRecord::SCHEMA;
    }

    public static function Table()
    {
        $_relatedRecord = static::RelatedRecord();
        return $_relatedRecord::TABLE;
    }

    public static function getValidRolesFor($command)
    {
        $_relatedRecord = static::RelatedRecord();
        return $_relatedRecord::getValidRolesFor($command);
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

    /**
     * @since GIP.00.05
     * @return string
     */
    public static function Name()
    {
        $_record = static::RelatedRecord();
        return $_record::NAME;
    }

    //const RELATED_RECORD = \NULL;
    //const ROW_ID = \NULL;

    /**
     * @todo private verification tag for inheritance.
     * @version     GIP.00.04
     */
    public function __construct(array $conditions = [])
    {
        $idTable = new Column(static::PrimaryKey());
        $idTable->excludeFromTable();
        $this->_columns[static::PrimaryKey()] = $idTable;
        $this->defineColumns();

        //parent::__construct();
        try {
            $this->readFromDB($conditions);
        } catch (\Exception $exc) {
            trigger_error($exc->getMessage() . " on " . get_called_class(),
                          \E_USER_ERROR);
            $tmpRow = [];
            foreach ($this->getColumnNames() as $column) {
                $tmpRow[$column] = $exc->getMessage();
            }
            $this->addRow($tmpRow);
        }
    }

    /**
     * Populates the found rows from the database.
     * 
     * @param array $conditions
     * 
     * @version     GIP.00.02
     */
    protected function readFromDB(array $conditions = [], array $params = [])
    {
        //var_dump(Current::Connection());
        $_relatedRecord = static::RelatedRecord();
        $_resultSet = Current::Connection()->select(static::ColumnNames(),
                                                    static::Schema(),
                                                    static::Table(),
                                                    $conditions, $params);
        //var_dump(Current::Connection());

        while ($row = $_resultSet->fetch_assoc()) {
            //var_dump($row);
            $this->addRowAssoc($row, $row[$_relatedRecord::PRIMARY_KEY]);
        }
        //var_dump($this->getRows());
//        return $_resultSet->num_rows < 1 ? FALSE : $_resultSet->fetch_assoc();
//
//        if ($_resultSet) {
//            foreach ($this->getAttributeNames() as $attr) {
//                $this->getAttribute($attr)->setValue($_resultSet[$attr]);
//            }
//        } else {
//            trigger_error("Error: Unable to find record '{$recordId}'",
//                    E_USER_ERROR);
//            throw new \Exception("Error: Unable to find record.");
//        }
//        foreach ($_resultSet as $_result) {
//            $this->addRow($_result);
//        }
    }

    /**
     * @var         array $_columns
     */
    private $_columns = [];

    protected function defineColumns()
    {
        $_relatedRecord = static::RelatedRecord();
        foreach ($_relatedRecord::getAttributesDisplay() as $attributeName) {
            //$this->defineColumn($attributeName) = $_relatedRecord::getAttribute($attributeName);
            $this->defineColumn($attributeName,
                                $_relatedRecord::getAttribute($attributeName));
        }
    }

    /**
     * @version     GIP.00.01
     * @return      \GIndie\Platform\Model\Attribute
     */
    protected function defineColumn($fieldName, $attribute)
    {
        //isset($this->_columns[$fieldName]) ?: $this->_columns[$fieldName] = new Column($fieldName);
        isset($this->_columns[$fieldName]) ?: $this->_columns[$fieldName] = $attribute;
        $rtnElement = &$this->_columns[$fieldName];
        return $rtnElement;
    }

    private $_rows = [];

    public function getDisplayOfDPR($rowId, $columnName)
    {
        
    }

    /**
     * 
     * @param string $attributeName
     * @since GIP.00.09
     */
    public function getDisplayOf($rowId, $attributeName)
    {
        switch ($this->getColumn($attributeName)->getType())
        {
            case Attribute::TYPE_PASSWORD:
                if ($this->getValueOf($rowId, $attributeName) == "") {
                    return "SD";
                }
                return "*********";
            case Attribute::TYPE_ENUM:
                $_typeOptions = $this->getColumn($attributeName)->getEnumOptions();
                return $_typeOptions[$this->getValueOf($rowId, $attributeName)];
            case Attribute::TYPE_FOREIGN_KEY:
                if ($this->getValueOf($rowId, $attributeName) == "") {
                    return "Sin definir";
                } else {
                    $list = $this->getColumn($attributeName)->getFkClass();
                    $list = new $list($this->getValueOf($rowId, $attributeName));
                    return $list->getElementAt($this->getValueOf($rowId,
                                                                 $attributeName))->getValue();
                }

            case Attribute::TYPE_TIMESTAMP:
                return \date("Y-m-d H:i:s",
                             $this->getValueOf($rowId, $attributeName));
//                return \date(\DateTime::COOKIE,
//                             $this->getValueOf($attributeName));
            case Attribute::TYPE_BOOLEAN:
                return $this->getValueOf($rowId, $attributeName) == "1" ? "Si" : "No";
            case Attribute::TYPE_CURRENCY:
                return "$ " . $this->getValueOf($rowId, $attributeName);
            default:
                return $this->getValueOf($rowId, $attributeName);
        }
    }

    /**
     * @since GIP.00.05
     * @param string $rowId
     * @param string $columnName
     * @return string
     */
    public function getValueOf($rowId, $columnName)
    {
        return isset($this->_rows[$rowId]) ?
                $this->_rows[$rowId]->getValue($columnName) :
                \trigger_error("Unable find value {$columnName}", \E_USER_ERROR);
    }

    /**
     * @deprecated since GIP.00.05
     * @param string $rowId
     * @param string $columnName
     * @return string
     */
    public function getValue($rowId, $columnName)
    {
        return $this->getValueOf($rowId, $columnName);
    }

    protected function addRowAssoc(array $row, $rowId = \NULL)
    {
        if ($rowId !== \NULL) {
            $this->_rows[$rowId] = new Row($row);
        } else {
            $this->_rows[] = new Row($row);
        }
        return $this;
    }

    /**
     * @return      array
     * @since       2017-08-14
     * @version     GIP.00.03
     */
    public function getColumnNames()
    {
        return static::ColumnNames();
    }

    /**
     * @return      array
     * @since       2017-04-27
     * @version     GIP.00.02
     */
    public function ColumnNames()
    {
        $_relatedRecord = static::RelatedRecord();
        return $_relatedRecord::getAttributeNames();
        $rtnIndex = [];
        foreach ($this->_columns as $key => $value) {
            //$value->isAction() ?: $rtnIndex[] = $key;
            $rtnIndex[] = $key;
        }
        return $rtnIndex;
        return array_keys($this->_columns);
    }

    /**
     * @return      array
     * @since       2017-06-21
     * @version     GIP.00.03
     */
    public function getColumns()
    {
        $_relatedRecord = static::RelatedRecord();
        return $_relatedRecord::getAttributesDisplay();
        $rtnIndex = [];
        foreach ($this->_columns as $key => $value) {
            $value->excludedFromDisplay() ?: $rtnIndex[] = $key;
        }
        return $rtnIndex;
    }

    /**
     * 
     * @param string $columnName
     * @return \GIndie\Platform\Model\Column
     * @since 2017-06-21
     * @version GIP.00.02
     */
    public function getColumn($columnName)
    {
        return $this->_columns[$columnName];
    }

    /**
     * 
     * @param string $columnName
     * @return      \GIndie\Platform\Model\Table\Column::getLabel()
     * @since       2017-04-27
     * @version     GIP.00.02
     */
    public function getLabel($columnName)
    {
        if (!\array_key_exists($columnName, $this->_columns)) {
            \trigger_error("Columna {$columnName} no definida en " . static::class,
                           \E_USER_ERROR);
        }
        return $this->_columns[$columnName]->getLabel();
    }

    /**
     * 
     * @return      array
     * @since       2017-04-27
     * @version     GIP.00.02
     */
    public function getRows()
    {
        return $this->_rows;
    }

//    public function RelatedRecord()
//    {
//        return static::RELATED_RECORD;
//    }
}
