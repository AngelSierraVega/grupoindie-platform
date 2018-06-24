<?php

/**
 * GIplatform - Record 2017-??-??
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.0?
 */

namespace GIndie\Platform\Model;

use GIndie\Platform\Current;
use \GIndie\Generator\DML\HTML5\Bootstrap3;

/**
 * Description of Record
 *
 * @since       2017-04-23
 * @version     GIP.00.10
 * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @edit GIP.00.11 18-01-14
 * - Update getDisplayOf()
 * 
 * @todo
 * - Move \Straffsa\SistemaIntegralIngresos funcionality 
 */
abstract class Record implements RecordINT
{

    /**
     * @var boolean
     * @since 18-03-13
     */
    const IS_VIEW = false;

    /**
     * The name of the record
     * @var string NAME
     * @since GIP.00.02
     */
    const NAME = "UNDEFINED";

    /**
     * @var string ICON
     * @since GIP.00.0?
     */
    const ICON = "glyphicon glyphicon-th-list";

    /**
     * The name of the database storing the record.
     * @version GIP.00.10
     */
    const SCHEMA = "mr_ingresos";
    //"mr_ingresos"
    //"mmr_prdl"
    //"straffon_ingresos";
    //"grupoind_ingresos"
    //"grupoind_prdl"

    /**
     * The name of the table storing the the record.
     * @version GIP.00.10
     */
    const TABLE = \NULL;

    /**
     * The primary key of the record.
     * @version GIP.00.10
     */
    const PRIMARY_KEY = "id";

    /**
     * If the primary key is autoincremented
     * @version GIP.00.10
     */
    const AUTOINCREMENT = \TRUE;

    /**
     * The key used for displaying the record to the user
     * @version GIP.00.10
     */
    const DISPLAY_KEY = \NULL;
    const STATE_ATTRIBUTE = \NULL;

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
     * @since GIP.00.08
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
     * @since GIP.00.08
     * @return \GIndie\Platform\Model\Record
     */
    public static function instance(array $data = [])
    {
        static::configAttributes();
        \array_key_exists(static::PRIMARY_KEY, $data) ?: $data[static::PRIMARY_KEY] = "GIP-UNDEFINED";
        foreach (\array_keys(static::$_attribute[static::class]) as $attribute) {
            \array_key_exists($attribute, $data) ?: $data[$attribute] = "";
        }
        return new static($data);
    }

    /**
     * @version     GIP.00.08
     */
    private function __construct($data)
    {
//        static::SCHEMA !== \NULL ?: trigger_error(\get_called_class() . " Necesita definir la constante SCHEMA",
//                                                  E_USER_ERROR);
        static::TABLE !== \NULL ?: trigger_error(\get_called_class() . " Necesita definir la constante TABLE", E_USER_ERROR);
        static::DISPLAY_KEY !== \NULL ?: trigger_error(\get_called_class() . " Necesita definir la constante DISPLAY_KEY", E_USER_ERROR);

        $this->_recordId = $data[static::PRIMARY_KEY];
        $this->_updatedFields = [];
        foreach ($data as $attribute => $value) {
            $this->setValueOf($attribute, $value);
        }
//        if (static::AUTOINCREMENT) {
//            static::attribute(static::PRIMARY_KEY)->excludeFromForm()->excludeFromDisplay();
//        }
//        if ($recordId !== "CREATE" && $recordId !== "DELETE" && $recordId !== "NONE") {
//            try {
//                $this->readFromDB($recordId);
//                //var_dump($this->readFromDB($recordId));
//            } catch (\Exception $exc) {
//                foreach ($this->_data as $key => $value) {
//                    $this->_data[$key]->setValue($exc->getMessage());
//                }
//            }
//        }
    }

    /**
     * Sets data from DB connection
     * @param string $recordId
     * @since GIP.00.08
     * @return \GIndie\Platform\Model\Record
     */
    public static function findById($recordId)
    {
        static::configAttributes();
        //var_dump(static::$_attribute);
        //var_dump(get_called_class());
        $connection = Current::Connection();
        $_resultSet = $connection->findByPK(static::PRIMARY_KEY, $recordId, static::getAttributeNames(), static::SCHEMA, static::TABLE);
        if ($_resultSet) {
            return static::instance($_resultSet);
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
     * Sets data from DB connection
     * @param string $recordId
     * @since GIP.00.08
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
        $_resultSet = $connection->select(static::getAttributeNames(), $schema, $table, $conditions, ["Limit 1"]);
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
     * @version     GIP.00.02
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
            $data['fk_usuario_cuenta'] = \GIndie\Platform\Current::User()->getId();
            $data['action'] = "gip-delete";
            $data['timestamp'] = \time();
            $nota = static::NAME . " eliminado(a): " . $this->getDisplay();
            $data['notas'] = \filter_var($nota, \FILTER_SANITIZE_SPECIAL_CHARS);
            $bitacora = \Straffsa\SistemaIntegralIngresos\Datos\mr_sesion\bitacora\Registro::instance($data);
            $bitacora->run("gip-inner-create");
        }
        return $action;
    }

    /**
     * Creates a new record on the database
     *
     * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
     * @version     GIP.00.03
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
            $tmp = $connection->select([static::PRIMARY_KEY], static::SCHEMA, static::TABLE, [[static::PRIMARY_KEY => $recordId]]);
            $tmp = $tmp->fetch_array()[0];
            $nota = "Creación de '" . static::NAME . "' con los datos ";
            switch (static::TABLE)
            {
                case "bitacora_usuario":
                case "sesion":
                    break;
                case "caja_usuarios":
                    $nota = "Asignación de caja a un usuario con los datos ";
                default:
                    $data = [];
                    $data['fk_usuario_cuenta'] = \GIndie\Platform\Current::User()->getId();
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
                    $data['notas'] = \filter_var($nota, \FILTER_SANITIZE_SPECIAL_CHARS);
                    $bitacora = \Straffsa\SistemaIntegralIngresos\Datos\mr_sesion\bitacora\Registro::instance($data);
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
     * @version GIP.00.02
     */
    protected function _update($postReading = \TRUE)
    {
        $connection = Current::Connection();
        if ($postReading) {
            $this->_handleBooleanPost();
        }
        $id = isset($_POST["gip-action-id"]) ? $_POST["gip-action-id"] : \NULL;
        $action = $connection->update($this, $id);
        /**
         * @todo
         * - Move \Straffsa\SistemaIntegralIngresos funcionality 
         */
        switch (static::TABLE)
        {
            case "bitacora_usuario":
            case "sesion":
                break;
            default:
                $data = [];
                $data['fk_usuario_cuenta'] = \GIndie\Platform\Current::User()->getId();
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
                $data['notas'] = \filter_var($nota, \FILTER_SANITIZE_SPECIAL_CHARS);
                $bitacora = \Straffsa\SistemaIntegralIngresos\Datos\mr_sesion\bitacora\Registro::instance($data);
                $bitacora->run("gip-inner-create");
        }
//        if ($action) {
//            
//        }
        return $action;
    }

    /**
     * @version GIP.00.01
     * @return \GIndie\Platform\Model\Attribute
     */
    protected static function attribute($fieldName)
    {
        isset(static::$_attribute[static::class][$fieldName]) ?: static::$_attribute[static::class][$fieldName]
                        = new Attribute($fieldName, static::class);
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
                    \trigger_error("Constant STATE_ATTRIBUTE must be declared in " . static::class, \E_USER_ERROR);
                }
                static::setValueOf(static::STATE_ATTRIBUTE, "0", \FALSE);
                return static::_update(\FALSE);
            case "gip-activate":
                if (static::STATE_ATTRIBUTE == \NULL) {
                    \trigger_error("Constant STATE_ATTRIBUTE must be declared in " . static::class, \E_USER_ERROR);
                }
                static::setValueOf(static::STATE_ATTRIBUTE, "1", \FALSE);
                return static::_update(\FALSE);
            case "gip-edit":
                return static::_update(\TRUE);
            case "gip-inner-edit":
                return static::_update(\FALSE);
            case "gip-inner-create":
                return static::_create(\FALSE);
            case "gip-create":
                return static::_create(\TRUE);
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
     * @version     GIP.00.08
     * @return      array
     */
    final public static function getAttributeNames()
    {
        static::configAttributes();
        if (!\array_key_exists(static::PRIMARY_KEY, static::$_attribute[static::class])) {
            //if (!Current::hasRole("DEV")) {
            static::attribute(static::PRIMARY_KEY)->excludeFromDisplay(\TRUE);
            //}
        }
        return \array_keys(static::$_attribute[static::class]);
    }

    /**
     * @version     GIP.00.05
     * @return      array
     */
    final public static function getAttributesForm()
    {
        $rtnArray = [];
        foreach (static::$_attribute[static::class] as $attrName => $attr) {
            if (static::getAttribute($attrName)->excludedFromForm() !== \TRUE) {
                $rtnArray[] = $attrName;
            }
        }
        return $rtnArray;
    }

    /**
     * @version     GIP.00.02
     * @return      array
     */
    final public static function getAttributesDisplay()
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
     * @since GIP.00.08
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
            if (\strcmp($this->_data[static::SCHEMA][static::TABLE][$this->_recordId][$attributeName], $value)
                    != 0) {
                $this->_updatedFields[] = $attributeName;
            }
        }
        $this->_data[static::SCHEMA][static::TABLE][$this->_recordId][$attributeName] = $value;

        return $this;
    }

    /**
     * 
     * @param string $attributeName
     * @since GIP.00.09
     */
    public function getLabelOf($attributeName)
    {
        return static::attribute($attributeName)->getLabel();
    }

    /**
     * 
     * @since GIP.00.10
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

    public function getName()
    {
        return static::NAME;
    }

    /**
     * 
     * @param string $attributeName
     * @since GIP.00.09
     * @edit GIP.00.11
     * - Attribute::TYPE_ENUM returns empty string if no value
     */
    public function getDisplayOf($attributeName)
    {
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
                return "$ " . $this->getValueOf($attributeName);
            default:
                return $this->getValueOf($attributeName);
        }
    }

    /**
     * 
     * @param string $attributeName
     * @return mixed
     * @since GIP.00.08
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
        if (!\array_key_exists($attributeName, $this->_data[static::SCHEMA][static::TABLE][$this->_recordId])) {
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
            \trigger_error("Constant STATE_ATTRIBUTE must be declared in " . static::class, \E_USER_ERROR);
        }
        return static::getValueOf(static::STATE_ATTRIBUTE);
    }

    /**
     * @version     GIP.00.08
     * @return      \GIndie\Platform\Model\Attribute
     * @param       string $attributeName The name of the attribute
     */
    final public static function getAttribute($attributeName)
    {
        if (isset(static::$_attribute[static::class][$attributeName])) {
            return static::$_attribute[static::class][$attributeName];
        } else {
            return \FALSE;
            \trigger_error("Atributo " . static::class . "-" . $attributeName . " no declarado", \E_USER_ERROR);
        }
        //return isset(static::$_attribute[static::class][$attributeName]) ? static::$_attribute[static::class][$attributeName] : \FALSE;
    }

    /**
     * @abstract
     * @version     GIP.00.06
     */
    public static function defineRecordRestrictions()
    {
        //static::requireRoles($command, $roles)
    }

    protected static $_restrictions = [];

    /**
     * @todo interal store for command - roles
     * @version     GIP.00.00
     */
    protected static function requireRoles($command, array $roles)
    {
        if (!\array_key_exists(static::class, static::$_restrictions)) {
            static::$_restrictions[static::class] = [];
        }
        static::$_restrictions[static::class][$command] = $roles;
    }

    /**
     * @todo interal store for command - roles
     * @version     GIP.00.00
     */
    protected static function excludeRoles($command, array $roles)
    {
        
    }

    /**
     * @todo interal return for command - roles
     * @version     GIP.00.00
     */
    public static function getValidRolesFor($command)
    {
        if (!\array_key_exists(static::class, static::$_restrictions)) {
            static::defineRecordRestrictions();
        }
        if (!\array_key_exists(static::class, static::$_restrictions)) {
            \trigger_error("El registro " . \get_called_class() . " no tiene definida la restricción para el comando '{$command}'. Utilice la función static::requireRoles(command,roles)", \E_USER_ERROR);
        }
        if (!\array_key_exists($command, static::$_restrictions[static::class])) {
            \trigger_error("El registro " . \get_called_class() . " no tiene definida la restricción para el comando '{$command}'. Utilice la función static::requireRoles(command,roles)", \E_USER_ERROR);
        }
        return static::$_restrictions[static::class][$command];
        //
    }

}
