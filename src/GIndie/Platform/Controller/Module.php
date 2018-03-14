<?php

/**
 * GIplatform - Module
 */

namespace GIndie\Platform\Controller;

use GIndie\Platform\Model\Datos\mr_sesion;
use GIndie\Platform\View;
use GIndie\Platform\View\Widget;
use GIndie\ScriptGenerator\HTML5;
use GIndie\ScriptGenerator\Bootstrap3;

/**
 * Description of Module
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 * @version GIP.00.00 17-05-23
 * @version GIP.00.0?
 * @edit GIP.00.07
 * @edit GIP.00.08 18-03-05
 * - Created widgetTableFromModel()
 */
abstract class Module extends Platform implements ModuleINT
{

    /**
     * @since 18-03-13
     * @edit 18-03-14
     */
    use Module\ToUpgrade;
    use Module\ToDeprecate;
    use Module\Upgrading;

    /**
     * 
     * @param string $action
     * @return strin|null
     * @since 18-03-14
     */
    public static function getActionName($action)
    {
        $rntValue = null;
        switch ($action)
        {
            case "form-edit":
                $rntValue = "Guardar datos";
                break;
            case "form-create":
                $rntValue = "Crear";
                break;
            case "form-activate":
                $rntValue = "Activar";
                break;
            case "form-delete":
                $rntValue = "Eliminar";
                break;
            case "form-deactivate":
                $rntValue = "Desactivar";
                break;
        }
        return $rntValue;
    }

    /**
     * 
     * @param string $action
     * @return string|null
     * @since 18-03-14
     */
    public static function getActionContext($action)
    {
        $rntValue = null;
        switch ($action)
        {
            case "form-edit":
            case "form-create":
            case "form-activate":
                $rntValue = Bootstrap3\Component\Button::$COLOR_SUCCESS;
                break;
            case "form-delete":
                $rntValue = Bootstrap3\Component\Button::$COLOR_DANGER;
                break;
            case "form-deactivate":
                $rntValue = Bootstrap3\Component\Button::$COLOR_WARNING;
                break;
        }
        return $rntValue;
    }

    /**
     *
     * @var array 
     * @since 18-03-13
     */
    protected $searchValues = [];

    /**
     * 
     * @param type $classname
     * @param type $attribute
     * @return string|null
     * @since 18-03-13
     */
    protected function getSearchValue($classname, $attribute)
    {
        $rntValue = null;
        if (isset($this->searchValues[$classname][$attribute])) {
            $rntValue = $this->searchValues[$classname][$attribute];
        }
        return $rntValue;
    }

    /**
     * @version     GIP.00.02
     * @since       2017-04-23
     * @var         string 
     */
    const NAME = "UnnamedModule";

    /**
     * @version     GIP.00.03
     * @since       2017-04-21
     */
    public function __construct()
    {
        $this->config();
    }

    /**
     * [description]
     * @abstract
     * @version     GIP.00.03
     * @since       2017-04-28
     */
    abstract public function config();
}
