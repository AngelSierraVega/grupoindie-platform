<?php

/**
 * @copyright (c) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 * 
 * @version GIP.00.01
 */

namespace GIndie\Platform;

/**
 * Description of ExceptionMySQL
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class ExceptionMySQL extends \Exception
{

    public static function handleException($exc)
    {
        //return "TEST";
        $rtnSrt = "";
        switch ($exc->getCode())
        {
            case 1451:
                $rtnSrt .= "Existe un registro dependiente.";
                break;
            case 1048:
                $rtnSrt .= "El campo no puede estar \"sin definir\".";
                break;
            case 1062:
                $rtnSrt .= "El registro ya existe.";
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
        //$rtnSrt .= "El registro no se puede eliminar.";
        //return $rtnSrt;
    }

    private $_customMsg;

    public function __construct($message, $code, \Throwable $previous = \null)
    {
        $this->_customMsg = $message;
        parent::__construct($message, $code, $previous);
    }

    public function getErrorMessage()
    {
        return $this->_customMsg;
    }

}
