<?php

/**
 * GI-Platform-DVLP - SessionHandler
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\Model
 *
 * @version 0C.40
 * @since 17-01-15
 * @todo Upgrade class
 */

namespace GIndie\Platform\Model\Database;

/**
 * Defines a connection to the database.
 * 
 * @abstract
 * @edit 18-10-28
 * - Handle virtual column
 */
abstract class Connection
{

    /**
     * The php mysql connection object.
     * 
     * @var         \mysqli 
     */
    private $_conection;

    /**
     * The name of the host to connect.
     * 
     * @var         string 
     */
    private static $HOST = "localhost";

    /**
     * @internal private static $USERNAME must be defined in inherit class.
     * @deprecated since 18-07-26 Use username() instead
     */
    protected static $USERNAME = null;

    /**
     * @internal private static $PASSWORD must be defined in inherit class.
     * @deprecated since 18-07-26 Use password() instead
     */
    protected static $PASSWORD = null;

    /**
     * The database username to be used in the connection.
     * @return string
     * @since 18-07-26
     */
    protected static function username()
    {
        //var_dump(\GIndie\DBHandler\INIHandler::getMainUsername());
        \GIndie\DBHandler\INIHandler::getMainUsername();
    }

    /**
     * The user password to be used in the connection.
     * @return string
     * @since 18-07-26
     * 
     */
    protected static function password()
    {
        \GIndie\DBHandler\INIHandler::getMainPassword();
    }

    /**
     * Creates (opens) the connection to the database.
     * 
     * @throws      \Exception
     * 
     */
    function __construct()
    {
        $this->_conection = \GIndie\DBHandler\MySQL57::getConnection();
//        $this->_conection = new \mysqli("p:" . \GIndie\DBHandler\INIHandler::getHost(), \GIndie\DBHandler\INIHandler::getMainUsername(), \GIndie\DBHandler\INIHandler::getMainPassword());
//        $this->_conection->set_charset("utf8");
//        if (\mysqli_connect_errno()) {
//            trigger_error(\mysqli_connect_errno() .
//                    ". Unnable to create connection " .
//                    mysqli_connect_error(), E_USER_ERROR);
//            throw new \Exception("Unnable to create connection " . mysqli_connect_error());
//        }
    }

    /**
     * 
     * Performs a query on the connection.
     * 
     * @param string $query
     * 
     * @return \mysqli_result|boolean 
     *                  <b>FALSE</b> on failure. For SELECT, SHOW, DESCRIBE or EXPLAIN 
     *                  will return a <b>\Traversable</b> object. For other successful 
     *                  queries will return <b>TRUE</b>.
     */
    public function query($query)
    {
//        var_dump($query);
//        \print_r($query);
        //var_dump($this->_conection);
        $result = $this->_conection->query($query);

        //var_dump($result);
//        var_dump($result);
//        \mysqli_result::class;
        if ($result !== \FALSE) {
            return $result;
        } else {
            //var_dump($this->_conection->error);
            if (isset($this->_conection->error)) {
                $error = $this->_conection->error;
            } else {
                $error = "error not setted";
            }
            //$error = "TEST error";
            //var_dump($this->_conection);
//            throw new \Exception($error, $this->_conection->errno);
            //var_dump($this->_conection);
            throw new \GIndie\Platform\ExceptionMySQL($error,
                                                      $this->_conection->errno);
            \trigger_error("" . $this->_conection->error . "\n Query: {$query} ",
                           \E_USER_ERROR);
            //var_dump($result);
            //var_dump($this->_conection);

            return FALSE;
        }
        if ($result == \NULL) {
//            var_dump($this->_conection->errno);
//            var_dump($this->_conection->error_list);
        }
    }

    public function getLastError()
    {
        return $this->_conection->error;
    }

    /**
     * Performs a select query.
     * 
     * @param array $selectors
     * @param string|\NULL $schema
     * @param string|\NULL $table
     * @param array $where
     * @param array $params
     * @return \Traversable|boolean
     *                  <b>FALSE</b> on error. Otherwize will return a 
     *                  <b>\Traversable</b> object.
     */
    public function select(array $selectors, $schema = \NULL, $table = \NULL, array $conditions = [], array $params = [])
    {
        //$selectors = ["*"];
        $joins = [];
        if ($table !== \NULL) {
            $tmpSelectors = [];
            foreach ($selectors as $selector) {
                if (\is_array($selector)) {
                    $selectorCmp = \array_keys($selector)[0];
                    $concatValues = [];
                    foreach ($selector[$selectorCmp] as $tmpSelector => $key) {
                        switch ($key)
                        {
                            case "gip-model":
                                $concatValues[] = "`{$table}`.`{$tmpSelector}`";
                                break;
                            default:
                                $concatValues[] = "'{$tmpSelector}'";
                                break;
                        }
                    }
                    $concat = "CONCAT(" . join(",", $concatValues) . ")";
                    $tmpSelectors[] = "{$concat} AS {$selectorCmp}";
                } else {
                    switch (true)
                    {
                        case (\substr_count($selector, " AS ") > 0):
                            $tmpSelectors[] = "{$selector}";
                            break;
                        case (\substr_count($selector, "`.`") > 0):
                            $tmpSelectors[] = "{$selector}";
                            $tmpExpl = \explode("`.`", $selector);
//                            var_dump($tmpExpl);
                            if (isset($tmpExpl[1])) {
                                $tmpTable = \substr($tmpExpl[0], 1);
                                if ($tmpTable == $table) {
                                    
                                } else {
                                    $joins[] = $tmpTable;
                                }
                            }
                            break;
                        default:
                            $tmpSelectors[] = "`{$table}`.`{$selector}`";
                            break;
                    }
                }
            }
            $selectors = $tmpSelectors;
        }
        $_strQuery = "SELECT " . \join(",", $selectors);
        if (($schema !== \NULL) && ($table !== \NULL)) {
            $_strQuery .= " FROM `{$schema}`.`{$table}`";
            if (count($joins) > 0) {
                $_strQuery .= " JOIN `{$schema}`.`" . $joins[0] . "`";
            }
            if (!empty($conditions)) {
                $_where = [];
                foreach ($conditions as $condition) {
                    if (is_array($condition)) {
                        //var_dump($condition);
                        foreach ($condition as $key => $value) {
                            $_whereString = "`{$table}`.`{$key}`";
                            switch ($value)
                            {
                                case "NULL":
                                case "NOT NULL":
                                    $_whereString .= " IS {$value}";
                                    break;
                                default:
                                    $_whereString .= "='{$this->_evalSelectedId($value)}'";
                                    break;
                            }
                            $_where[] = $_whereString;
                        }
                    } else {
                        $_where[] = $condition;
                    }
                }
                //var_dump($_where);
                $_strQuery .= " WHERE " . \join(" AND ", $_where);
            }
        }
        !empty($params) ? $_strQuery .= " " . \join(" ", $params) : \NULL;
        $_strQuery .= ";";
//        if (strcmp($table, "cobros") == 0) {
//        var_dump($_strQuery);
//        trigger_error($_strQuery, \E_USER_ERROR);
//        }
        return $this->query($_strQuery);
    }

    private function _evalSelectedId($value)
    {
        switch (0)
        {
            case \strcmp($value, "gip-selected-id"):
                if (isset($_POST["gip-selected-id"])) {
                    return $_POST["gip-selected-id"];
                }
                return "NONE";
            case \strcmp($value, "gip-action-id"):
                if (isset($_POST["gip-action-id"])) {
                    return $_POST["gip-action-id"];
                }
                return "NONE";
            default:
                return $value;
        }
    }

    /**
     * Performs an update query.
     *
     * @param GIndie\Platform\Model\Database\Record $newRecordData 
     * @return \Traversable|boolean
     *                  <b>FALSE</b> on error. Otherwize will return a
     *                  <b>\Traversable</b> object.
     * @author Izmir Sanchez Juarez <izmirreffi@gmail.com>
     * @edit Angel Sierra Vega <angel.sierra.vega@gmail.com>
     *      - update funcional
     * @edit 18-10-28
     * - Skip SQL attribute if is virtual column
     */
    public function update(\GIndie\Platform\Model\Record $newRecordData, $id)
    {
        $PKname = $newRecordData::PRIMARY_KEY;
        switch (true)
        {
            case \is_null($id):
                $PKvalue = $newRecordData->getValueOf($PKname);
//                var_dump($PKvalue);
                break;
            default:
                $PKvalue = $id;
//                var_dump($PKvalue);
                break;
        }
        
        $schema = $newRecordData::SCHEMA;
        $table = $newRecordData::TABLE;
        $attribute_pairs = array();
        foreach ($newRecordData->getAttributeNames() as $attribute) {
            if ($newRecordData->getAttribute($attribute)->isVirtualColumn() === true) {
                
            } else {
                $attr = "`{$table}`.`" . $attribute . "`";
                $value = $newRecordData->getValueOf($attribute);
                if ($value == "NULL") {
                    $attribute_pairs[] = "$attr=$value";
                } elseif ($value == "NOW()") {
                    $attribute_pairs[] = "$attr=$value";
                } else {
                    $attribute_pairs[] = "$attr='$value'";
                }
            }
        }

        if (strcmp($newRecordData::TABLE, "orden_pago") == 0) {
            $attribute_pairs[] = "gip_holder='" . \GIndie\Platform\Current::User()->getId() . "'";
        }
//        if (strcmp($newRecordData::TABLE, "usuario_cuenta") == 0) {
//            
//        }
//        if (strcmp($newRecordData::TABLE, "usuario_cuenta_rol") == 0) {
//            $attribute_pairs[] = "gip_holder='" . \GIndie\Platform\Current::User()->getId() . "'";
//        }

        $sql = "UPDATE `{$schema}`.`{$table}` SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE `{$table}`.`{$PKname}` = '{$PKvalue}' ";
        $sql .= ";";
//        var_dump($sql);
        //var_dump(" WHERE `{$table}`.`{$PKname}` = '{$PKvalue}' ");
//        print_r($PKvalue);
//        print_r($sql);
        return $this->query($sql);
    }

    /**
     * Performs a delete query.
     *
     * @param object    $newRecordData -> GIndie\Platform\Model\Database\Record
     * @return          \Traversable|boolean
     *                  <b>FALSE</b> on error. Otherwize will return a
     *                  <b>\Traversable</b> object.
     * @author          Izmir Sanchez Juarez <izmirreffi@gmail.com>
     */
    public function delete($deleteRecord)
    {
        $setString = "";

        $PKname = $deleteRecord::PRIMARY_KEY;
        $PKvalue = $deleteRecord->getValueOf($deleteRecord::PRIMARY_KEY);
        $schema = $deleteRecord::SCHEMA;
        $table = $deleteRecord::TABLE;


        $_strQuery = "DELETE FROM `{$schema}`.`{$table}` WHERE `{$table}`.`{$PKname}` = '{$PKvalue}' ";
        //$attribute_pairs[] = "gip_holder='".\GIndie\Platform\Current::User()->getId()."'";
        $_strQuery .= ";";
        //echo $_strQuery;
        return $this->query($_strQuery);
    }

    /**
     * Performs an create query.
     *
     * @param object    $newRecordData -> GIndie\Platform\Model\Database\Record
     * @return          \Traversable|boolean
     *                  <b>FALSE</b> on error. Otherwize will return a
     *                  <b>\Traversable</b> object.
     * @author          Angel Sierra Vega <angel.sierra@grupoindie.com>
     * @edit 18-10-28
     * - Skip virtual column
     */
    public function create(\GIndie\Platform\Model\Record $newRecordData)
    {
//        static::columnDefinition("nmbr_cmplt")
        //var_dump($newRecordData);
        $PKname = $newRecordData::PRIMARY_KEY;
        $PKvalue = $newRecordData->getValueOf($newRecordData::PRIMARY_KEY);
        $schema = $newRecordData::SCHEMA;
        $table = $newRecordData::TABLE;

        $attribute_pairs = array();
        foreach ($newRecordData->getAttributeNames() as $attribute) {
            if ($newRecordData->getAttribute($attribute)->isVirtualColumn() === true) {
                
            } else {
                $key = $newRecordData->getAttribute($attribute)->getName();
                $key = $attribute;
                $key = "`{$table}`.`{$key}`";
                $value = $newRecordData->getValueOf($attribute);
                if ($value == "NULL") {
                    $attribute_pairs[$key] = $value;
                } elseif ($value == "NOW()") {
                    $attribute_pairs[$key] = $value;
                } else {
                    $attribute_pairs[$key] = "'{$value}'";
                }
            }
        }

        if (strcmp($newRecordData::TABLE, "orden_pago") == 0) {
            $attribute_pairs["gip_holder"] = "'" . \GIndie\Platform\Current::User()->getId() . "'";
        }
//        if (strcmp($newRecordData::TABLE, "usuario_cuenta_rol") == 0) {
//            $attribute_pairs["gip_holder"] = "'" . \GIndie\Platform\Current::User()->getId() . "'";
//        }

        $_strQuery = "INSERT INTO `{$schema}`.`{$table}` (";
        $_strQuery .= join(", ", array_keys($attribute_pairs));
        $_strQuery .= ") VALUES (";
        $_strQuery .= join(", ", array_values($attribute_pairs));
        $_strQuery .= ");";
//        if (strcmp($table, "orden_pago") == 0) {
//            var_dump($_strQuery);
//        }
        //var_dump($_strQuery);
        $result = $this->query($_strQuery);

//        var_dump($this->insert_id());
        return $result;
    }

    /**
     * 
     * @param type $PKname
     * @param type $PKvalue
     * @param array $selectors
     * @param type $schema
     * @param type $table
     * @return array
     */
    public function findByPK($PKname, $PKvalue, array $selectors, $schema, $table)
    {
        $conditions = ["`{$table}`.`{$PKname}`='{$PKvalue}'"];
        $_resultSet = $this->select($selectors, $schema, $table, $conditions,
                                    ["Limit 1"]);
        return $_resultSet->num_rows < 1 ? \FALSE : $_resultSet->fetch_assoc();
//        if ($_resultSet->num_rows < 1) {
//            trigger_error("Error: Unable to find record '{$recordId}'",
//                    E_USER_ERROR);
//            throw new \Exception("Error: Unable to find record.");
//        }
//        return \TRUE;
//        else {
//            foreach ($this->getAttributeNames() as $attr) {
//                $_resultSet = $_resultSet->fetch_assoc();
//                $this->getAttribute($attr)->setValue($_resultSet[$key]);
//            }
//        }
    }

    public function sanitize($string)
    {
        return $this->_conection->real_escape_string($string);
    }

    public function close()
    {
        return $this->_conection->close();
    }

    public function insert_id()
    {
        //var_dump($this->_conection->insert_id);
        return $this->_conection->insert_id;
    }

    public static function getUser()
    {
        return static::username();
        return static::$USERNAME;
    }

    public static function getPassword()
    {
        return static::password();
        return static::$PASSWORD;
    }

}
