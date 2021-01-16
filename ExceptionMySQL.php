<?php

/**
 * GI-Platform-DVLP - ExceptionMySQL
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform
 *
 * @version 0C.D0
 */

namespace GIndie\Platform;

/**
 * Description of ExceptionMySQL
 */
class ExceptionMySQL extends \Exception
{

    /**
     * 
     * @return string
     * @since 18-03-20
     */
    private static function parseForeingKeyError($msj)
    {
        $tmpSrt = \explode(",", $msj);
        $tmpSrt = \explode("(", $tmpSrt[0]);
        return "Llave foránea con <i>" . $tmpSrt[1] . "</i>";
    }

    /**
     * 
     * @return string
     * @since 18-03-20
     */
    private static function parseSQLError($exc)
    {
        $rtnSrt = "";
        switch ($exc->getCode())
        {
            case 1451:
                $rtnSrt .= static::parseForeingKeyError($exc->getMessage());
                break;
            default:
                $rtnSrt .= "Mensaje SQL: " . \addslashes($exc->getMessage());
                break;
        }
        return $rtnSrt;
    }

    /**
     * 
     * @param type $exc
     * @return string
     * @edit 18-03-13
     * - Handle range error
     * @edit 18-03-15
     * - Handle reference error
     * @edit 18-03-20
     * - Updated visual info for AS
     * - Exploded method into parseSQLError() and parseForeingKeyError()
     * @edit 18-12-16
     * - Handle error 1452
     */
    public static function handleException($exc)
    {
        $rtnSrt = "";
        if (Current::hasRole(["AS"])) {
            $rtnSrt .= "<div class=\"well well-sm\">";
            $rtnSrt .= "<p class=\"text-info\">";
            $rtnSrt .= static::parseSQLError($exc);
            $rtnSrt .= "</p>";
            $usuario = Current::User()->getValueOf("user");
            $rtnSrt .= "<p class=\"text-muted text-right\"><small>Administrador del Sistema: {$usuario}</small></p>";
            $rtnSrt .= "</div>";
        }
        switch ($exc->getCode())
        {
            case 0:
                $rtnSrt .= $exc->getMessage();
                break;
            case 1451:
                $rtnSrt .= "<p>Su solicitud no puede ser completada debido a la <em>Integridad de la Base de Datos</em>.</p>";
                $rtnSrt .= "<p>Esta es una funcionalidad del sistema que impide que se eliminen o editen registros que de algún modo están presentes en otras tablas (como la bitácora).</p>";
                $rtnSrt .= "<p>Si considera necesaria la eliminación/edición del registro contacte al administrador del sistema para posibles alternativas.</p>";
                break;
            case 1452:
//                $sqlMsj = $exc->getMessage();
//                $rfrncName = \explode("REFERENCES `", $sqlMsj);
                $rtnSrt .= "<p>Falló una referencia foránea</p>";
                break;
            case 1048:
                $rtnSrt .= "<p>El campo no puede estar \"sin definir\".</p>";
                break;
            case 1062:
                $rtnSrt .= "<p>El registro ya existe.</p>";
                break;
            case 1264:
                $rtnSrt .= "<p>Rango no válido.</p>";
                break;
            default:
                $rtnSrt .= "SD: " . $exc->getCode();
                break;
        }
        return $rtnSrt;
    }

    /**
     *
     * @var type 
     * @since 17-??-??
     */
    private $_customMsg;

    /**
     * 
     * @param type $message
     * @param type $code
     * @param \Throwable $previous
     * @since 17-??-??
     */
    public function __construct($message, $code, \Throwable $previous = \null)
    {
        $this->_customMsg = $message;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @since 17-??-??
     * @return type
     */
    public function getErrorMessage()
    {
        return $this->_customMsg;
    }

}
