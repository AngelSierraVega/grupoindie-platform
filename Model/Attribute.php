<?php

/**
 * GI-Platform-DVLP - Attribute
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\Model
 *
 * @version 0C.30
 * @since 17-04-23
 * @todo Upgrade class
 */

namespace GIndie\Platform\Model;

//use GIndie\DBHandler\MySQL57\Instance\ColumnDefinition;
//use GIndie\DBHandler\MySQL57\Instance\DataType;

/**
 * Description of Attribute
 * @edit 18-10-28
 * - Created addInputAttribute(), setVirtualColmn()
 */
class Attribute //extends ColumnDefinition
{

    /**
     * @var         type TYPE_STRING
     */
    const TYPE_STRING = 0;

    /**
     * @var         type TYPE_NUMERIC
     */
    const TYPE_NUMERIC = 1;

    /**
     * @var         type TYPE_BOOLEAN
     */
    const TYPE_BOOLEAN = 2;

    /**
     * @var         type TYPE_DATE
     */
    const TYPE_DATE = 3;

    /**
     * @var         type TYPE_FOREIGN_KEY
     */
    const TYPE_FOREIGN_KEY = 4;

    /**
     * @var         type TYPE_PASSWORD
     */
    const TYPE_PASSWORD = 5;

    /**
     * @var         int TYPE_EMAIL
     */
    const TYPE_EMAIL = 6;

    /**
     * @since       GIP.00.03
     * @var         int TYPE_TIMESTAMP
     */
    const TYPE_TIMESTAMP = 7;

    /**
     * @since       GIP.00.03
     * @var         int TYPE_OPTIONGROUP
     */
    const TYPE_OPTIONGROUP = 8;

    /**
     * @since       GIP.00.05
     * @var         int TYPE_OPTIONGROUP
     */
    const TYPE_ENUM = 9;

    /**
     * @since GIP.00.07
     * @var int TYPE_HIDDEN
     */
    const TYPE_HIDDEN = 10;

    /**
     * @since GIP.00.08
     * @var int TYPE_CURRENCY
     */
    const TYPE_CURRENCY = 11;

    /**
     * @var int TYPE_LINK
     */
    const TYPE_LINK = 12;

    /**
     * @version     GIP.00.03
     * @since       2017-04-29
     *
     * @var string 
     */
    private $_recordClass;

    /**
     * 
     * @param type $name
     */
    public function __construct($name, $recordClass)
    {
        $this->_label = $name;
        $this->_name = $name;
        $this->_recordClass = $recordClass;
    }

    public function getRecordClass()
    {
        return $this->_recordClass;
    }

    /**
     * @since 17-08-22
     *
     * @var string 
     */
    private $_help = \NULL;

    /**
     * @since 17-08-22
     */
    public function getHelp()
    {
        return $this->_help;
    }

    /**
     * @since 17-08-22
     * @return \GIndie\Platform\Model\Attribute
     */
    public function setHelp($text)
    {
        $this->_help = $text;
        return $this;
    }

    /**
     * @since 17-08-03
     *
     * @var string 
     */
    private $_size = "col-xs-12";

    /**
     * @since 17-08-03
     */
    public function getSize()
    {
        return $this->_size;
    }

    /**
     * @since 17-08-03
     * @return      \GIndie\Platform\Model\Attribute
     */
    public function setSize($size)
    {
        $this->_size = $size;
        return $this;
    }

    /**
     * @since 17-04-29
     *
     * @var string 
     */
    private $_name;

    /**
     * @since 17-04-29
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * 
     * @param boolean $value
     * @return \GIndie\Platform\Model\Attribute
     * @since 18-10-28
     */
    public function setVirtualColmn($value = true)
    {
        $this->isVirtualColumn = $value;
        return $this;
    }

    /**
     *
     * @var boolean
     * @since 18-10-28
     */
    private $isVirtualColumn = false;

    /**
     * 
     * @return boolean
     * @since 18-10-28
     */
    public function isVirtualColumn()
    {
        return $this->isVirtualColumn;
    }

    /**
     *
     * @var string 
     */
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

    /**
     */
    public function getLabel()
    {
        return $this->_label;
    }

    private $_restrictions = [];

    public function setRestrictions($restrictions = [])
    {
        $this->_restrictions = $restrictions;
    }

    /**
     * 
     * @param string $name
     * @param string $value
     * @since 18-10-28
     */
    public function addInputAttribute($name, $value)
    {
        $this->_restrictions[$name] = $value;
    }

    /**
     *
     * @var boolean
     * @todo
     * - Deprecate var 
     */
    private $_notNull = false;

    /**
     * If neither NULL nor NOT NULL is specified, the column is treated as though NULL had 
     * been specified.
     * 
     * @param boolean $value 
     * @return \Self
     * 
     * @since 18-08-18
     */
    public function setNotNull($value = true)
    {
        $this->_notNull = $value;
        return $this;
    }

    public function getNotNull()
    {
        return $this->_notNull;
    }

    public function getRestrictions()
    {
        return $this->_restrictions;
    }

    private $_restriction_required = \FALSE;

    /**
     * 
     * @param type $value
     * @return $this
     * 
     * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
     */
    public function setRestrictionRequired($value = \TRUE)
    {
        $this->_restriction_required = $value;
        return $this;
    }

    public function getRestrictionRequired()
    {
        return $this->_restriction_required;
    }

    /**
     *
     * @var type 
     * @since GIP.00.01
     */
    private $_type = 0;

    /**
     *
     * @var type 
     * @since GIP.00.04
     */
    private $_typeOptions;

    /**
     * @param       type $type
     * @return      \GIndie\Platform\Model\Attribute
     */
    public function setType($type, $typeOptions = null)
    {
        $this->_type = $type;
        $this->_typeOptions = $typeOptions;
//        switch ($type)
//        {
//            case static::TYPE_STRING:
//                parent::__construct(new DataType(DataType::text()));
//                break;
//            case static::TYPE_NUMERIC:
//                parent::__construct(new DataType(DataType::integer()));
//                break;
//            case static::TYPE_BOOLEAN:
//                parent::__construct(new DataType(DataType::tinyint(1)));
//                break;
//            case static::TYPE_DATE:
//                parent::__construct(new DataType(DataType::date()));
//                break;
//            case static::TYPE_FOREIGN_KEY:
//                throw new \Exception("@todo");
//                break;
//            case static::TYPE_PASSWORD:
//                parent::__construct(new DataType(DataType::varchar(300)));
//                break;
//            case static::TYPE_EMAIL:
//                parent::__construct(new DataType(DataType::varchar(500)));
//                break;
//            case static::TYPE_TIMESTAMP:
//                parent::__construct(new DataType(DataType::timestamp()));
//                break;
//            case static::TYPE_OPTIONGROUP:
//                throw new \Exception("@todo");
//                break;
//            case static::TYPE_ENUM:
//                parent::__construct(new DataType(DataType::enum($typeOptions)));
//                break;
//            case static::TYPE_HIDDEN:
//                throw new \Exception("@todo");
//                break;
//            case static::TYPE_CURRENCY:
//                parent::__construct(new DataType(DataType::decimal(12, 2)));
//                break;
//            default:
//                throw new \Exception("@todo type: {$type}");
//                break;
//        }

        return $this;
    }

    private $_enumOptions = \NULL;

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

    /**
     *
     * @var array 
     */
    private $_fk_restrictions = [];

    /**
     * @param string $listClass
     * @param array $restrictions
     * @return $this
     */
    public function setTypeFK($listClass, array $restrictions = [])
    {
        $this->_type = static::TYPE_FOREIGN_KEY;
        if (!\is_subclass_of($listClass, ListSimple::class, \TRUE)) {
            \trigger_error($listClass . " no es de tipo ListSimple en " . get_called_class(), \E_USER_ERROR);
        }
        $this->_fk_class = $listClass;
        //$this->_fk_column = $columnName;
        $this->_fk_restrictions = $restrictions;
        return $this;
    }

    private $_slave = \NULL;

    public function setSlave($attributeName)
    {
        $this->_slave = $attributeName;
    }

    public function getSlave()
    {
        return $this->_slave;
    }

    private $_fk_class = \NULL;

    public function getFkClass()
    {
        return $this->_fk_class;
    }

    private $_fk_column = \NULL;

    public function getFkColumnDPR()
    {
        return $this->_fk_column;
    }

    public function getFkRestrictions()
    {
        return $this->_fk_restrictions;
    }

    /**
     * 
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     */
    public function getTypeOptions()
    {
        return $this->_typeOptions;
    }

    private $_exclude_form = \FALSE;

    /**
     * 
     * @param boolean $value
     */
    public function excludeFromForm($value = \TRUE)
    {
        $this->_exclude_form = $value;
        return $this;
    }

    /**
     * 
     * @return boolean
     */
    public function excludedFromForm()
    {
        return $this->_exclude_form;
    }

    /**
     *
     * @var type 
     */
    private $_exclude_display = \FALSE;

    /**
     * 
     * @param boolean $value
     * 
     * @since GIP.00.05
     */
    public function excludeFromDisplay($value = \TRUE)
    {
        $this->_exclude_display = $value;
        return $this;
    }

    /**
     * 
     * @since GIP.00.05
     */
    public function excludedFromDisplay()
    {
        return $this->_exclude_display;
    }

}
