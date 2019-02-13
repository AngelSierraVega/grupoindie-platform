<?php

/**
 * GIplatform - Record 2017-??-??
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
 *
 * @package GIndie\Platform\Model
 *
 * @version 0D.70
 * @since 17-04-23
 */

namespace GIndie\Platform\Model;

use GIndie\Platform\Current;
use GIndie\Generator\DML\HTML5\Bootstrap3;
//use GIndie\DBHandler\MySQL56;
use GIndie\DBHandler\MySQL57;
use GIndie\Platform\DataModel;
use GIndie\DBHandler\MySQL57\Instance\DataType;
use GIndie\DBHandler\MySQL57\Statement;
use GIndie\Common\Parser\Moneda;
use GIndie\Platform\DataModel\Command;
use GIndie\Platform\View\Icons;

/**
 * Description of Record
 * 
 * @edit 18-01-14
 * - Update getDisplayOf()
 * @edit 18-10-27
 * - Removed TABLE
 * - DISPLAY_KEY defaults to "id"
 * @edit 18-10-28
 * - Created configAttributesFromColumnDefinition()
 * @edit 18-11-03
 * - Removed default SCHEMA
 * @edit 18-11-05
 * - Created getSelectorsDisplay()
 * - Removed \Straffsa\SistemaIntegralIngresos dependency
 * - 
 */
abstract class Record extends MySQL57\Instance\Table implements RecordINT
{

    /**
     * @return int
     * @since 18-12-26
     */
    public static function countRows()
    {
        $result = \GIndie\DBHandler\MySQL57::query(Statement\DataManipulation::select(
                    ["COUNT(" . static::PRIMARY_KEY . ")"], static::getTableReference()));
        return (int) $result->fetch_row()[0];
    }

    /**
     * 
     * @param type $className
     * @return \GIndie\DBHandler\MySQL57\Instance\DataType
     * @since 18-11-20
     */
    protected static function getPKDataType($className = null)
    {
        if (!\is_null($className)) {
            if (!\is_subclass_of($className, \GIndie\DBHandler\MySQL57\Instance\Table::class)) {
                \trigger_error("{$className} Is not subclass of \\GIndie\\DBHandler\\MySQL57\\Instance\\Table",
                    \E_USER_ERROR);
            }
            $instance = $className::instance();
            $instance->columns();
//            $dataType = $instance::columnDefinition($instance::PRIMARY_KEY)->getDataType();
        } else {
//            \trigger_error(static::class,\E_USER_ERROR);
            $instance = static::instance();
            $instance->columns();
        }
        $dataType = $instance::columnDefinition($instance::PRIMARY_KEY)->getDataType();
        switch ($dataType->getDatatype())
        {
            case DataType::DATATYPE_SERIAL:
                $dataType = DataType::serializedBigint();
                break;
        }
        return $dataType;
    }

    /**
     * const JQVALIDATOR_MAY_SIN_COMILLAS = "texto_simple_mayusculas_sin_comillas";
      public static $jqvalidatorMaySinComillas = "texto_simple_mayusculas_sin_comillas";
     */

    /**
     * @since 18-08-20
     * @deprecated since 18-11-02
     * @todo
     * - Remove from class
     */
    protected static function tableDefinitionDPR()
    {
        
    }

    /**
     * 
     * @return string
     * @since 18-08-19
     * - Remove or upgrade
     * @deprecated since 18-11-02
     */
    public static function databaseClassnameDPR()
    {
        return DataModel\TmpDatabasePredial::class;
    }

    /**
     * The name of the database storing the record.
     * @deprecated since 18-11-03
     * 
     */
    const SCHEMA_DPR = "mmr_prdl";

    //"mr_ingresos"
    //"mmr_prdl"
    //"straffon_ingresos";
    //"grupoind_ingresos"
    //"grupoind_prdl"

    /**
     * 
     * @return string
     * @since 18-08-18
     */
    public static function name()
    {
        return static::TABLE;
    }

    /**
     * @var boolean
     * @since 18-03-13
     */
    const IS_VIEW = false;

    /**
     * The name of the record
     * @var string NAME
     */
    const NAME = "UNDEFINED";

    /**
     * @var string ICON
     */
    const ICON = "glyphicon glyphicon-th-list";

    /**
     * If the primary key is autoincremented
     */
    const AUTOINCREMENT = true;

    /**
     * The primary key of the record.
     */
    const PRIMARY_KEY = "id";

    /**
     * The key used for displaying the record to the user
     * @edit 18-10-27
     * - Default "id"
     */
    const DISPLAY_KEY = "id";

    /**
     * 
     */
    const STATE_ATTRIBUTE = null;

    /**
     * @var array $_data
     */
    protected $_data = [];

    /**
     * Stores attribute definition
     * @var array 
     */
    protected static $_attribute = [];

    /**
     * The value of the record ID
     * @var string 
     */
    private $_recordId;

    /**
     * @deprecated ?
     */
    //const RELATED_RECORD = \NULL;

    /**
     * Sets data from an associative array
     * @param array $data
     * @return \GIndie\Platform\Model\Record
     * @edit 18-10-28
     * - configAttributes() is called only when class hasn't defined attributes
     */
    public static function instance(array $data = [])
    {
        if (!isset(static::$_attribute[static::class])) {
            static::configAttributes();
        }
//        static::configAttributes();
        //static::tableDefinition();
        \array_key_exists(static::PRIMARY_KEY, $data) ?: $data[static::PRIMARY_KEY] = "GIP-UNDEFINED";
        foreach (\array_keys(static::$_attribute[static::class]) as $attribute) {
            \array_key_exists($attribute, $data) ?: $data[$attribute] = "";
        }
        return new static($data);
    }

    /**
     * @edit 18-10-27
     * - Updated constants validation
     */
    private function __construct($data)
    {
        \defined("static::SCHEMA") ?: trigger_error(\get_called_class() . " Necesita definir la constante SCHEMA",
                    \E_USER_ERROR);
        \defined("static::TABLE") ?: trigger_error(\get_called_class() . " Necesita definir la constante TABLE",
                    \E_USER_ERROR);
        \defined("static::DISPLAY_KEY") ?: trigger_error(\get_called_class() . " Necesita definir la constante DISPLAY_KEY",
                    \E_USER_ERROR);
        \defined("static::PRIMARY_KEY") ?: \trigger_error(\get_called_class() . " Necesita definir la constante PRIMARY_KEY",
                    \E_USER_ERROR);
        $this->_recordId = $data[static::PRIMARY_KEY];
        $this->_updatedFields = [];
        foreach ($data as $attribute => $value) {
            $this->setValueOf($attribute, $value);
        }
    }

    /**
     * Sets data from DB connection
     * @param string $recordId
     * @return \GIndie\Platform\Model\Record
     */
    public static function findById($recordId)
    {
        static::configAttributes();
        //var_dump(static::$_attribute);
        //var_dump(get_called_class());
        $connection = Current::Connection();
        $_resultSet = $connection->findByPK(static::PRIMARY_KEY, $recordId,
            static::getAttributeNames(), static::SCHEMA, static::TABLE);
//        $query = static::sttmtSelect(static::getSelectorsDisplay());
//        $query->setTableReferences(static::getTableReference());
//        $query->addConditionEquals(static::TABLE . "." . static::PRIMARY_KEY, $recordId);
//        $connection = MySQL57::getConnection();
//        $_resultSet = MySQL57::query($query)->fetch_assoc();
//        $conditions = [[static::TABLE . "." . static::PRIMARY_KEY => $recordId]];
//        $_resultSet = static::fetchAssoc(static::getSelectorsDisplay(), $conditions);
//        $_resultSet = $connection->query($query."")->fetch_assoc();
//        var_dump($_resultSet);
        if ($_resultSet) {
            return static::instance($_resultSet);
            return static::instance(\array_pop($_resultSet));
            //return new static($_resultSet);
//            foreach ($this->getAttributeNames() as $attr) {
//                $this->getAttribute($attr)->setValue($_resultSet[$attr]);
//            }
        } else {
//            var_dump(Current::Connection()->getLastError());
            return static::instance([static::PRIMARY_KEY => "GIP-UNDEFINED"]);
            \trigger_error("Error: Unable to find record '{$recordId}'", \E_USER_ERROR);
            //return static::instance([]);
            //return new static([]);

            throw new \Exception("Error: Unable to find record.");
        }
    }

    /**
     * Automatically defines attributes from column definition
     * @since 18-10-28
     * @edit 18-11-01
     * - Temporarly handles DATATYPE_DATETIME, DATATYPE_TIMESTAMP
     * @edit 18-11-06
     * - Handles DataType::DATATYPE_ENUM
     * @edit 18-11-10
     * - Handles DataType::DATATYPE_CHAR
     * 
     * @todo Explode method
     */
    public static function configAttributesFromColumnDefinition()
    {
        foreach (static::columns() as $attr => $columnDefinition) {
            //Handle datatype
            switch ($columnDefinition->getDataType()->getDatatype())
            {
                case DataType::DATATYPE_BIGINT:
                case DataType::DATATYPE_DEC:
                case DataType::DATATYPE_DECIMAL:
                case DataType::DATATYPE_DOUBLE:
                case DataType::DATATYPE_DOUBLE_PRECISION:
                case DataType::DATATYPE_FLOAT:
                case DataType::DATATYPE_INT:
                case DataType::DATATYPE_INTEGER:
                case DataType::DATATYPE_NUMERIC:
                case DataType::DATATYPE_REAL:
                case DataType::DATATYPE_SERIAL:
                case DataType::DATATYPE_SMALLINT:
                    static::attribute($attr)->setType(Attribute::TYPE_NUMERIC);
//                    $columnDefinition->getAutoIncrement();
                    break;
                case DataType::DATATYPE_TINYINT:
                    static::attribute($attr)->setType(Attribute::TYPE_BOOLEAN);
//                    static::attribute($attr)->excludeFromForm();
                    break;
                case DataType::DATATYPE_TEXT:
                case DataType::DATATYPE_VARCHAR:
                case DataType::DATATYPE_CHAR:
                    static::attribute($attr)->setType(Attribute::TYPE_STRING);
                    break;
                case DataType::DATATYPE_TIME:
                case DataType::DATATYPE_DATE:
                case DataType::DATATYPE_DATETIME:
                    static::attribute($attr)->setType(Attribute::TYPE_STRING);
                    break;
                case DataType::DATATYPE_TIMESTAMP:
                    static::attribute($attr)->setType(Attribute::TYPE_TIMESTAMP);
                    break;
                case DataType::DATATYPE_ENUM:
                    $enum = [];
                    foreach ($columnDefinition->getDataType()->getValuesUnformatted() as $value) {
                        $enum[$value] = $value;
                    }
                    static::attribute($attr)->setTypeEnum($enum);
                    break;
                default:
                    \trigger_error("@todo handle DATATYPE_" . $columnDefinition->getDataType()->getDatatype(),
                        \E_USER_ERROR);
            }
            //
            /**
             * handle hidden on autoincrement
             * @edit 19-02-15
             * - Handle required on non autoincremented primary key
             */
            if (\strcmp(static::PRIMARY_KEY, $attr) == 0) {
                if (static::AUTOINCREMENT == true) {
                    static::attribute($attr)->excludeFromDisplay();
                    static::attribute($attr)->excludeFromForm();
                } else {
                    static::attribute($attr)->setRestrictionRequired();
                }
            }
            //Handle label and help
            $tmp = \explode(" NOTAS: ", $columnDefinition->getComment());
            static::attribute($attr)->setLabel($tmp[0]);
            if (isset($tmp[1])) {
                static::attribute($attr)->setHelp($tmp[1]);
            } else {
                $tmp2 = \explode(" NOTES: ", $columnDefinition->getComment());
                static::attribute($attr)->setLabel($tmp2[0]);
                if (isset($tmp2[1])) {
                    static::attribute($attr)->setHelp($tmp2[1]);
                }
            }
            //Handle restriction required
            if ($columnDefinition->getNotNull() === true) {
                static::attribute($attr)->setRestrictionRequired();
                static::attribute($attr)->setNotNull();
            }
            //Handle virtual attribute|column
            if ($columnDefinition->isGenerated() === true) {
                static::attribute($attr)->setVirtualColmn();
                static::attribute($attr)->excludeFromForm();
            }
            //Handle other attributes and restrictions
            switch ($columnDefinition->getDataType()->getDatatype())
            {
                case DataType::DATATYPE_BIGINT:
                case DataType::DATATYPE_INT:
                case DataType::DATATYPE_INTEGER:
                case DataType::DATATYPE_SERIAL:
                case DataType::DATATYPE_SMALLINT:
                    static::attribute($attr)->addInputAttribute("step", "1");
                    //"max" => $columnDefinition->getDataType()->getM(),
                    if ($columnDefinition->getDataType()->getUnsigned() === true) {
                        static::attribute($attr)->addInputAttribute("min", "0");
                    }
                    break;
                case DataType::DATATYPE_DEC:
                case DataType::DATATYPE_DECIMAL:
                case DataType::DATATYPE_DOUBLE:
                case DataType::DATATYPE_DOUBLE_PRECISION:
                case DataType::DATATYPE_FLOAT:
                case DataType::DATATYPE_NUMERIC:
                case DataType::DATATYPE_REAL:
//                    static::attribute($attr)->setRestrictions([
//                        "max" => $columnDefinition->getDataType()->getM(),
//                        "min" => "18",
//                        "step" => ($columnDefinition->getDataType()->getD() / 100)
//                    ]);
//                    $d = $columnDefinition->getDataType()->getD();
//                    $step = 1 / (10 ** $d);
//                    static::attribute($attr)->addInputAttribute("step", $step);
                    if ($columnDefinition->getDataType()->getUnsigned() === true) {
                        static::attribute($attr)->addInputAttribute("min", "0");
                    }
                    break;
                case DataType::DATATYPE_CHAR:
                case DataType::DATATYPE_VARCHAR:
                    static::attribute($attr)->setRestrictions([
//                        "minlength" => "12",
                        "maxlength" => $columnDefinition->getDataType()->getM()
                    ]);
                    break;
                case DataType::DATATYPE_TINYINT:
                case DataType::DATATYPE_TEXT:
                case DataType::DATATYPE_TIME:
                case DataType::DATATYPE_DATE:
                case DataType::DATATYPE_DATETIME:
                case DataType::DATATYPE_TIMESTAMP:
                case DataType::DATATYPE_ENUM:
                    break;
                default:
                    \trigger_error("@todo handle DATATYPE_" . $columnDefinition->getDataType()->getDatatype(),
                        \E_USER_ERROR);
            }
        }
    }

    /**
     * Sets data from DB connection
     * @param string $recordId
     * @return \GIndie\Platform\Model\Record
     */
    public static function findBy($attribute, $value)
    {
        static::configAttributes();
        $table = static::TABLE;
        $schema = static::SCHEMA;
        $selectors = [static::PRIMARY_KEY, $attribute];
        $connection = Current::Connection();
        $conditions = ["`{$table}`.`{$attribute}`='{$value}'"];
        $_resultSet = $connection->select(static::getAttributeNames(), $schema, $table,
            $conditions, ["Limit 1"]);
        //var_dump($_resultSet);
        if ($_resultSet->num_rows != 0) {
            return static::instance($_resultSet->fetch_assoc());
        } else {
            return static::instance([static::PRIMARY_KEY => "GIP-UNDEFINED"]);
        }
    }

    /**
     * Delete a record on the database
     * 
     * @author      Izmir Sanchez Juarez <izmirreffi@gmail.com
     * @edit 18-03-15
     * - 
     */
    protected function _delete()
    {
        $connection = Current::Connection();
        $action = $connection->delete($this);
//        try {
//            
//        } catch (\GIndie\Platform\ExceptionMySQL $exc) {
//            return \GIndie\Platform\ExceptionMySQL::handleException($exc);
//        }
        /**
         * @todo
         * - Move \Straffsa\SistemaIntegralIngresos funcionality 
         */
        if ($action) {
            $data = [];
            $data['pltfrm_cta_fk'] = \GIndie\Platform\Current::User()->getId();
            $data['action'] = "gip-delete";
            $data['timestamp'] = \time();
            $nota = static::NAME . " eliminado(a): " . $this->getDisplay();
            $data['notes'] = \filter_var($nota, \FILTER_SANITIZE_SPECIAL_CHARS);
//            $bitacora = \Straffsa\SistemaIntegralIngresos\Datos\mr_sesion\bitacora\Registro::instance($data);
            $bitacora = DataModel\Platform\LogUser::instance($data);
            $bitacora->run("gip-inner-create");
        }
        return $action;
    }

    /**
     * Creates a new record on the database
     *
     * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
     * @todo Upgrade bitacora
     */
    protected function _create($postReading = \TRUE)
    {
        $connection = Current::Connection();
        if (static::AUTOINCREMENT !== \FALSE) {
            $this->setValueOf(static::PRIMARY_KEY, 0, \FALSE);
        }
        if ($postReading) {
            $this->_handleBooleanPost();
        }
        /**
         * @todo
         * - Move \Straffsa\SistemaIntegralIngresos funcionality 
         */
        $_resultSet = $connection->create($this);
        if ($_resultSet) {
            $recordId = Current::Connection()->insert_id();
            if ($recordId == 0) {
                $recordId = $this->getId();
            }
            $tmp = $connection->select([static::PRIMARY_KEY], static::SCHEMA, static::TABLE,
                [[static::PRIMARY_KEY => $recordId]]);
            $tmp = $tmp->fetch_array()[0];
            $nota = "Creación de '" . static::NAME . "' con los datos ";
            switch (static::TABLE)
            {
                case "bitacora_usuario":
                case "pltfrm_cta_log":
                case "pltfrm_ssn":
                case "sesion":
                    break;
                case "caja_usuarios":
                    $nota = "Asignación de caja a un usuario con los datos ";
                default:
                    $data = [];
                    $data['pltfrm_cta_fk'] = \GIndie\Platform\Current::User()->getId();
                    $data['action'] = "gip-create";
                    $data['timestamp'] = \time();
                    foreach ($this->getAttributeNames() as $key) {
                        switch ($key)
                        {
                            case static::PRIMARY_KEY:
                                break;
                            default:
                                $nota .= " '" . $this->getLabelOf($key) . "'='" . $this->getDisplayOf($key) . "' ";
                                break;
                        }
                    }
                    $data['notes'] = \filter_var($nota, \FILTER_SANITIZE_SPECIAL_CHARS);
                    $bitacora = DataModel\Platform\LogUser::instance($data);
                    //$bitacora = \Straffsa\SistemaIntegralIngresos\Datos\mr_sesion\bitacora\Registro::instance($data);
                    $bitacora->run("gip-inner-create");
                    break;
            }
            $this->_recordId = $tmp;
            $this->setValueOf(static::PRIMARY_KEY, $this->_recordId);
        }
        return $_resultSet;
    }

    private function _handleBooleanPost()
    {
        foreach (static::getAttributesForm() as $attr) {
            $attribute = static::getAttribute($attr);
            if ($attribute->getType() == Attribute::TYPE_BOOLEAN) {
                if (isset($_POST[$attr])) {
                    $this->setValueOf($attribute->getName(), "1", \FALSE);
                } else {
                    $this->setValueOf($attribute->getName(), "0", \FALSE);
                }
            }
        }
        foreach ($_POST as $key => $value) {
            if (($attribute = static::getAttribute($key)) !== \FALSE) {
                if ($attribute->getType() == Attribute::TYPE_BOOLEAN) {
                    
                } else {
                    $this->setValueOf($attribute->getName(), $_POST[$key], \TRUE);
                }
            }
        }
    }

    /**
     * Update a record on the database
     * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
     * @edit Izmir Sanchez Juarez <izmirreffi@gmail.com>
     */
    protected function _update($postReading = true)
    {
        $connection = Current::Connection();
        if ($postReading) {
            $this->_handleBooleanPost();
        }
        $id = isset($_POST["gip-action-id"]) ? $_POST["gip-action-id"] : null;
        switch ($id)
        {
            case "undefined":
                $id = null;
                break;
        }
        $action = $connection->update($this, $id);
        /**
         * @todo
         * - Move \Straffsa\SistemaIntegralIngresos funcionality 
         */
        switch (static::TABLE)
        {
            case "bitacora_usuario":
            case "sesion":
            case "pltfrm_cta_log":
            case "pltfrm_ssn":
                break;
            default:
                $data = [];
                $data['pltfrm_cta_fk'] = \GIndie\Platform\Current::User()->getId();
                $data['action'] = "gip-edit";
                $data['timestamp'] = \time();
                $nota = static::NAME . " actualizado(a): " . $this->getDisplay() . " con los datos";
                foreach ($this->_updatedFields as $key) {
                    switch ($key)
                    {
                        case static::PRIMARY_KEY:
                            break;
                        default:
                            $nota .= " '" . $this->getLabelOf($key) . "'='" . $this->getDisplayOf($key) . "' ";
                            break;
                    }
                }
                $data['notes'] = \filter_var($nota, \FILTER_SANITIZE_SPECIAL_CHARS);
//                $bitacora = \Straffsa\SistemaIntegralIngresos\Datos\mr_sesion\bitacora\Registro::instance($data);
                $bitacora = DataModel\Platform\LogUser::instance($data);
                $bitacora->run("gip-inner-create");
        }
//        if ($action) {
//            
//        }
        return $action;
    }

    /**
     * @return \GIndie\Platform\Model\Attribute
     */
    protected static function attribute($fieldName)
    {
        isset(static::$_attribute[static::class][$fieldName]) ?: static::$_attribute[static::class][$fieldName] = new Attribute($fieldName,
                static::class);
        $rtnElement = &static::$_attribute[static::class][$fieldName];
        return $rtnElement;
    }

    protected static function unsetAttribute($fieldName)
    {
        unset(static::$_attribute[static::class][$fieldName]);
        //return static::$_attribute[static::class][$fieldName] = \NULL;
    }

    public function run($action, $actionId = \NULL, $selectedId = \NULL)
    {
        switch ($action)
        {
            case "gip-deactivate":
                if (static::STATE_ATTRIBUTE == \NULL) {
                    \trigger_error("Constant STATE_ATTRIBUTE must be declared in " . static::class,
                        \E_USER_ERROR);
                }
                static::setValueOf(static::STATE_ATTRIBUTE, "0", \FALSE);
                return static::_update(\FALSE);
            case "gip-activate":
                if (static::STATE_ATTRIBUTE == \NULL) {
                    \trigger_error("Constant STATE_ATTRIBUTE must be declared in " . static::class,
                        \E_USER_ERROR);
                }
                static::setValueOf(static::STATE_ATTRIBUTE, "1", \FALSE);
                return static::_update(false);
            case "gip-edit":
                return static::_update(true);
            case "gip-inner-edit":
                return static::_update(false);
            case "gip-inner-create":
                return static::_create(false);
            case "gip-create":
                return static::_create(true);
            case "gip-delete":
                return static::_delete();
            default:
                \trigger_error("Unable to run: "
                    . "gip-action= {$action} "
                    . "gip-action-id= {$actionId} "
                    . "gip-selected-id= {$selectedId} ", E_USER_ERROR);
                throw new \Exception("Unable to run.");
                break;
        }
    }

    /**
     * @return      array
     * @edit 18-10-28
     * - configAttributes() is called only when class hasn't defined attributes
     */
    public static function getAttributeNames()
    {
        if (!isset(static::$_attribute[static::class])) {
            static::configAttributes();
        }
        if (!\array_key_exists(static::PRIMARY_KEY, static::$_attribute[static::class])) {
            //if (!Current::hasRole("DEV")) {
            static::attribute(static::PRIMARY_KEY)->excludeFromDisplay(\TRUE);
            //}
        }
        return \array_keys(static::$_attribute[static::class]);
    }

    /**
     * @return      array
     */
    final public static function getAttributesForm()
    {
        if (!isset(static::$_attribute[static::class])) {
            static::configAttributes();
        }
        $rtnArray = [];
        foreach (static::$_attribute[static::class] as $attrName => $attr) {
            if (static::getAttribute($attrName)->excludedFromForm() !== \TRUE) {
                $rtnArray[] = $attrName;
            }
        }
        return $rtnArray;
    }

    /**
     * @return array
     * @since 18-11-05
     */
    public static function getSelectorsDisplay()
    {
        $rtnArray = [];
        if (static::AUTOINCREMENT == true) {
//            $rtnArray = [static::SCHEMA => static::PRIMARY_KEY];
//            $rtnArray = [static::PRIMARY_KEY];
        }
        foreach (static::getAttributeNames() as $attributeName) {
            if (static::PRIMARY_KEY == $attributeName) {
                $rtnArray[static::name()] = [static::PRIMARY_KEY];
            } elseif (static::getAttribute($attributeName)->excludedFromDisplay() !== true) {
                $rtnArray[static::name()][] = $attributeName;
//                $rtnArray = [static::SCHEMA => $attributeName];
            }
        }
        return $rtnArray;
    }

    /**
     * @return      array
     */
    public static function getAttributesDisplay()
    {
        $rtnArray = [];
        foreach (static::getAttributeNames() as $attributeName) {
            if (static::getAttribute($attributeName)->excludedFromDisplay() !== \TRUE) {
                $rtnArray[] = $attributeName;
//                if (strcmp(static::PRIMARY_KEY, $attributeName) !== 0) {
//                    $rtnArray[] = $attributeName;
//                }
            }
        }
        return $rtnArray;
    }

    private $_updatedFields = [];

    /**
     * 
     * @param string $attributeName
     * @param string $value
     */
    public function setValueOf($attributeName, $value, $sanitize = \FALSE)
    {
//        if ($value == \FALSE) {
//            $this->_data[static::SCHEMA][static::TABLE][$this->_recordId][$attributeName]
//                    = \NULL;
//        } else {
//            
//        }
        if ($sanitize) {
            $value = \GIndie\Platform\Current::Connection()->sanitize($value);
        }
        if (isset($this->_data[static::SCHEMA][static::TABLE][$this->_recordId][$attributeName])) {
            if (\strcmp($this->_data[static::SCHEMA][static::TABLE][$this->_recordId][$attributeName],
                    $value) != 0) {
                $this->_updatedFields[] = $attributeName;
            }
        }
        $this->_data[static::SCHEMA][static::TABLE][$this->_recordId][$attributeName] = $value;

        return $this;
    }

    /**
     * 
     * @param string $attributeName
     */
    public function getLabelOf($attributeName)
    {
        return static::attribute($attributeName)->getLabel();
    }

    /**
     * 
     * @return mixed
     */
    public function getDisplay()
    {
        if (\is_array(static::DISPLAY_KEY)) {
            $rtnDisplay = "";
            foreach (static::DISPLAY_KEY[\array_keys(static::DISPLAY_KEY)[0]] as $key => $value) {
                if (\strcmp($value, "string") == 0) {
                    $rtnDisplay .= $key;
                } else {
                    $rtnDisplay .= static::getDisplayOf($key);
                }
            }
            return $rtnDisplay;
        }
        return static::getDisplayOf(static::DISPLAY_KEY);
    }

    /**
     * 
     * @return string
     * @since 18-12-26
     */
    public static function getName()
    {
        return static::NAME;
    }

    /**
     * 
     * @param string $attributeName
     * @edit 18-01-14
     * - Attribute::TYPE_ENUM returns empty string if no value
     * @edit 18-11-05
     * - Handle error on no defined attribute
     */
    public function getDisplayOf($attributeName)
    {
        if ((static::getAttribute($attributeName) == false)) {
            \trigger_error("Attribute {$attributeName} is false. Called in " . \get_called_class(),
                \E_USER_ERROR);
        }
        switch (static::getAttribute($attributeName)->getType())
        {
            case Attribute::TYPE_LINK:
                switch ($this->getValueOf($attributeName))
                {
                    case "":
                        return "";
                        break;
                    default:
                        return "<a href='" . $this->getValueOf($attributeName) . "' download>Click para descargar</a>";
                        break;
                }
            case Attribute::TYPE_PASSWORD:
                if ($this->getValueOf($attributeName) == "") {
                    return "SD";
                }
                return "*********";
            case Attribute::TYPE_ENUM:
                if ($this->getValueOf($attributeName) == "") {
                    return "";
                }
                $_typeOptions = $this->getAttribute($attributeName)->getEnumOptions();
                return $_typeOptions[$this->getValueOf($attributeName)];
            case Attribute::TYPE_FOREIGN_KEY:
                if ($this->getValueOf($attributeName) == "") {
                    return "Sin definir";
                } else {
                    $list = $this->getAttribute($attributeName)->getFkClass();
                    $list = new $list($this->getValueOf($attributeName));
                    $value = $list->getElementAt($this->getValueOf($attributeName));
                    if ($value == \NULL) {
                        return "Sin definir";
                        trigger_error(" es Nulo " . \get_called_class(), \E_USER_ERROR);
                    } else {
                        return $value->getValue();
                    }
                }

            case Attribute::TYPE_TIMESTAMP:
                return \date("Y-m-d H:i:s", $this->getValueOf($attributeName));
//                return \date(\DateTime::COOKIE,
//                             $this->getValueOf($attributeName));
            case Attribute::TYPE_BOOLEAN:
                return $this->getValueOf($attributeName) == "1" ? "Si" : "No";
            case Attribute::TYPE_CURRENCY:
                return Moneda::contable($this->getValueOf($attributeName));
//                return "$ " . $this->getValueOf($attributeName);
            default:
                return $this->getValueOf($attributeName);
        }
    }

    /**
     * 
     * @param string $attributeName
     * @return mixed
     */
    public function getValueOf($attributeName)
    {
        if (!\array_key_exists(static::SCHEMA, $this->_data)) {
            \trigger_error("SCHEMA not found", \E_USER_ERROR);
        }
        if (!\array_key_exists(static::TABLE, $this->_data[static::SCHEMA])) {
            \trigger_error("TABLE not found", \E_USER_ERROR);
        }
        if (!\array_key_exists($this->_recordId, $this->_data[static::SCHEMA][static::TABLE])) {
            \trigger_error("_recordId {$this->_recordId} not found", \E_USER_ERROR);
        }
        if (!\array_key_exists($attributeName,
                $this->_data[static::SCHEMA][static::TABLE][$this->_recordId])) {
            \trigger_error("attribute {$attributeName} not found", \E_USER_ERROR);
        }
        //var_dump($this->_data[static::SCHEMA][static::TABLE]);
        return $this->_data[static::SCHEMA][static::TABLE][$this->_recordId][$attributeName];
    }

    public function getId()
    {
        return $this->_recordId;
    }

    public function getState()
    {
        if (static::STATE_ATTRIBUTE == \NULL) {
            \trigger_error("Constant STATE_ATTRIBUTE must be declared in " . static::class,
                \E_USER_ERROR);
        }
        return static::getValueOf(static::STATE_ATTRIBUTE);
    }

    /**
     * @return      \GIndie\Platform\Model\Attribute
     * @param       string $attributeName The name of the attribute
     */
    final public static function getAttribute($attributeName)
    {
        if (isset(static::$_attribute[static::class][$attributeName])) {
            return static::$_attribute[static::class][$attributeName];
        } else {
            return \FALSE;
            \trigger_error("Atributo " . static::class . "-" . $attributeName . " no declarado",
                \E_USER_ERROR);
        }
        //return isset(static::$_attribute[static::class][$attributeName]) ? static::$_attribute[static::class][$attributeName] : \FALSE;
    }

    /**
     * @todo
     * @since 18-10-28
     * @edit 19-03-27
     * - Functional method
     */
    protected static function defineCommands()
    {
        static::commandDefinition("gip-create", "Nuevo(a) " . static::NAME);
        static::commandDefinition("gip-create")->definePrerequisites(["AS"]);
//        static::commandDefinition("gip-create", ["AS"], null, "Crear", "success",
//            \GIndie\Platform\View\Icons::Create(), true);
//        static::commandDefinition("form-edit", ["AS"], null, "Editar " . static::NAME, "success",
//            \GIndie\Platform\View\Icons::Edit(), "lg");
        static::commandDefinition("gip-edit", "Editar " . static::NAME);
        static::commandDefinition("gip-edit")->setAccess("success", Icons::Edit(), "lg");
        static::commandDefinition("gip-edit")->definePrerequisites(["AS"]);
//        static::requireRoles();
//        static::requireRoles("gip-edit", ["AS"]);
//        static::requireRoles("gip-delete", ["AS"]);
        static::commandDefinition("gip-delete", "Eliminar " . static::NAME);
        static::commandDefinition("gip-delete")->setAccess("danger", Icons::Delete(), "lg");
        static::commandDefinition("gip-delete")->definePrerequisites(["AS"]);
        if (!\is_null(static::STATE_ATTRIBUTE)) {
//            static::commandDefinition("gip-state", ["AS"]);
            static::commandDefinition("gip-state", "Estado");
            static::commandDefinition("gip-state")->setAccess("default", Icons::eyeClose(), "lg");
            static::commandDefinition("gip-state")->definePrerequisites(["AS"]);
        } else {
            static::commandDefinition("gip-state", "Estado");
            static::commandDefinition("gip-state")->setAccess("default", Icons::eyeClose(), "lg");
            static::commandDefinition("gip-state")->definePrerequisites(["NONE"]);
        }
//        \trigger_error("@todo", \E_USER_ERROR);
    }

    /**
     * 
     * @param string $commandId
     * @param string|null $name
     * 
     * @return \GIndie\Platform\DataModel\Command
     * @since 19-03-27
     * @edit 19-03-28
     */
    protected static function commandDefinition($commandId, $name = null)
    {
        if (!is_null($name)) {
            self::$commands[static::class][$commandId] = new Command($commandId, static::class,
                $name);
        }
        if (!isset(self::$commands[static::class][$commandId])) {
            static::defineCommands();
        }
        return self::$commands[static::class][$commandId];
    }

    /**
     *
     * @var array|\GIndie\Platform\Model\Record\Command
     * @edit 19-03-21
     * - Visibility to private.
     * - Renamed var from _restrictions to $commandRoles
     * @edit 19-03-27
     * - Remade var to $commands
     */
    private static $commands = [];

    /**
     * @todo interal store for command - roles
     * @deprecated since 19-03-27 Use commandDefinition() instead
     */
    protected static function requireRoles($command, array $roles)
    {
        \trigger_error("deprecated since 19-03-27 Use commandDefinition() instead", \E_USER_ERROR);
//        if (!\array_key_exists(static::class, self::$commands)) {
//            self::$commands[static::class] = [];
//        }
//        self::$commands[static::class][$command] = $roles;
    }

    /**
     * Returns an array of the commands of the class.
     * @return array
     * @since 19-03-21
     */
    public static function commands()
    {
        if (!isset(self::$commands[static::class])) {
            static::defineCommands();
        }
//        return isset(self::$commands[static::class]) ? \array_keys(self::$commands[static::class]) : [];
        return isset(self::$commands[static::class]) ? self::$commands[static::class] : [];
    }

    /**
     * @since 18-11-29
     * @deprecated since 09-03-27 Use defineCommands() instead
     */
    public static function defineRecordRestrictions()
    {
        var_dump(static::class);
        \trigger_error("defineRecordRestrictions() deprecated since 19-03-27 Use defineCommands() instead",
            \E_USER_ERROR);

//        
    }

//    public static function 

    /**
     * @todo interal store for command - roles
     */
    protected static function excludeRoles($command, array $roles)
    {
        
    }

    /**
     * @todo interal return for command - roles
     * @edit 19-03-27
     * - Use of defineCommands()
     * - Use of Record\Commnad->getRequiredRoles()
     */
    public static function getValidRolesFor($command)
    {
        if (!\array_key_exists(static::class, self::$commands)) {
            static::defineCommands();
        }
        if (!\array_key_exists(static::class, self::$commands)) {
            \trigger_error("El registro " . \get_called_class() . " no tiene definida la restricción para el comando '{$command}'. Utilice la función commandDefinition()",
                \E_USER_ERROR);
        }
        if (!\array_key_exists($command, self::$commands[static::class])) {
            \trigger_error("El registro " . \get_called_class() . " no tiene definida la restricción para el comando '{$command}'. Utilice la función commandDefinition()",
                \E_USER_ERROR);
        }
        return self::$commands[static::class][$command]->getRequiredRoles();
        //
    }

    /**
     * @since 18-11-29
     */
    public static function configAttributes()
    {
        static::configAttributesFromColumnDefinition();
    }

}
