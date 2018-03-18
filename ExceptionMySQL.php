<?php

namespace GIndie\Platform;

/**
 * Description of ExceptionMySQL
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 * 
 * @version GIP.00.01
 */
class ExceptionMySQL extends \Exception
{

    /**
     * 
     * @param type $exc
     * @return string
     * @edit 18-03-13
     * - Handle range error
     * @edit 18-03-15
     * - Handle reference error
     */
    public static function handleException($exc)
    {
        $rtnSrt = "";
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
        if (Current::hasRole(["AS"])) {
            $rtnSrt .= "<br><br> Error original: ";
            $rtnSrt .= \addslashes($exc->getMessage());
            $rtnSrt .= "<br>";
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
