<?php

/**
 * GI-Platform-DVLP - Attribute
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform
 *
 * @version DEPRECATED
 * @since 17-04-23
 * @todo Upgrade class
 */

namespace GIndie\Platform\Model;

/**
 * Description of Attribute
 * 
 * @todo check deprecated
 * 
 * @edit 17-04-23
 */
class Column
{

    /**
     * @var int TYPE_STRING
     */
    const TYPE_STRING = 0;

    /**
     * @var int TYPE_BOOLEAN
     */
    const TYPE_BOOLEAN = 1;

    /**
     * @var int TYPE_FOREIGN_KEY
     */
    const TYPE_FOREIGN_KEY = 2;

    /**
     * @var int TYPE_ACTIONS
     */
    const TYPE_ACTIONS = 3;

    /**
     * @var int TYPE_PASSWORD
     */
    const TYPE_PASSWORD = 4;

    /**
     * @var int TYPE_TIMESTAMP
     */
    const TYPE_TIMESTAMP = 5;

    /**
     * @var int TYPE_ENUM
     */
    const TYPE_ENUM = 6;

    /**
     * @var int TYPE_CURRENCY
     */
    const TYPE_CURRENCY = 7;

    /**
     * 
     * @param type $name
     */
    public function __construct($name)
    {
        $this->_label = $name;
    }

    private $_label;

    /**
     * @param       type $label
     * @return      \GIndie\Platform\Model\Attribute
     */
    public function setLabel($label)
    {
        $this->_label = $label;
        return $this;
    }

    private $_excluded = \FALSE;

    /**
     * 
     * @return GIndie\Platform\Model\Table\Column
     */
    public function excludeFromTable($value = \TRUE)
    {
        $this->_excluded = $value;
        return $this;
    }

    public function isAction()
    {
        switch ($this->_type)
        {
            case "action-delete":
                return \TRUE;

            default:
                return \FALSE;
        }
    }

    /**
     * 
     * @return boolean
     */
    public function isExcluded()
    {
        return $this->_excluded;
    }

    /**
     * @version     GIP.00.01
     */
    public function getLabel()
    {
        return $this->_label;
    }

    //private $_value = "";

    /**
     * @deprecated since 17-04-23
     * @param       type $value
     * @return      \GIndie\Platform\Model\Attribute
     */
    public function setValueDPR($value)
    {
        $this->_value = $value;
        return $this;
    }

    /**
     * @deprecated since 17-04-23
     */
    public function getValueDPR()
    {
        return $this->_value;
    }

    private $_type = "string";

    /**
     * @param       type $type
     * @return      \GIndie\Platform\Model\Attribute
     */
    public function setType($type)
    {
        $this->_type = $type;
        return $this;
    }

    private $_fk_class = \NULL;
    private $_fk_column = \NULL;

    /**
     * @todo Evaluar que $className herede o sea de tipo Record
     * @param type $className
     * @return $this
     */
    public function setTypeDelete($className)
    {
        $this->_type = "action-delete";
        $this->_fk_class = $className;
        return $this;
    }

    /**
     * @todo Evaluar que $className herede o sea de tipo Record
     * @param type $className
     * @return $this
     */
    public function setTypeFK($listClass, $columnName = \NULL)
    {
        $this->_type = static::TYPE_FOREIGN_KEY;
        $this->_fk_class = $listClass;
        $this->_fk_column = $columnName;
        return $this;
    }

    private $_enumOptions = [];

    /**
     * @todo Evaluar que $className herede o sea de tipo Record
     * @param type $className
     * @return $this
     */
    public function setTypeEnum($enumOptions)
    {
        $this->_type = static::TYPE_ENUM;
        $this->_enumOptions = $enumOptions;
        return $this;
    }

    public function getEnumOptions()
    {
        return $this->_enumOptions;
    }

    public function getFkClass()
    {
        return $this->_fk_class;
    }

    public function getFkColumn()
    {
        return $this->_fk_column;
    }

    /**
     */
    public function getType()
    {
        return $this->_type;
    }

}
