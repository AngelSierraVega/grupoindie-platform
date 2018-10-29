<?php

/**
 * GI-Platform-DVLP - 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\View
 *
 * @version 0D.00
 * @since 
 */

namespace GIndie\Platform\View\Document\Topbar;

//use GIndie\Generator\DML\HTML5;
use GIndie\ScriptGenerator\HTML5;
use GIndie\ScriptGenerator\Bootstrap3;

/**
 * Description of ModuleMenu
 *
 * @edit 18-02-27
 * @edit 18-11-05
 * - Removed use of deprecated libs
 */
class ModuleMenu extends HTML5\Category\Lists\Unordered
{

    public function __construct()
    {//
        parent::__construct([]);
        $this->addClass("nav navbar-nav");
        $this->setAttribute("id", "gip-module-menu");
        $listControllers = \GIndie\Platform\Current::Instance()->getModules();
        $tmpGroup = \NULL;
        $dropdown = "";
        foreach ($listControllers as $controllerClass => $value) {
            /**
             * @todo Evaluar $controllerClass::REQUIRED_ROLES antes de agregar un 
             * elemento en el menú
             */
            if (\GIndie\Platform\Current::hasRole($controllerClass::RequiredRoles())) {
                switch (\TRUE)
                {
                    case (is_bool($value) == $value):
                        $this->addListElement(new HTML5\Category\Lists\ListItem([], ['<a gip-action="setController" gip-action-id="' .
                            urlencode($controllerClass) .
                            '" href="#">' . $controllerClass::NAME . '</a>']));
                        break;
//                case (is_bool($value) != $value):
//                    break;
                    default:
                        if ($tmpGroup !== $value) {
                            $dropdown = new Bootstrap3\Component\Dropdown($value, ['<a gip-action="setController" gip-action-id="' .
                                urlencode($controllerClass) .
                                '" href="#">' . $controllerClass::NAME . '</a>'], "a");
                            $dropdown->setTag("li");
                            $tmpRef = &$dropdown;
                            $this->addListElement($tmpRef);
                            $tmpGroup = $value;
                        } else {
                            $dropdown->addListElement(new HTML5\Category\Lists\ListItem([], ['<a gip-action="setController" gip-action-id="' .
                                urlencode($controllerClass) .
                                '" href="#">' . $controllerClass::NAME . '</a>']));
                        }
                        break;
                }
            }
        }
    }

    private function addController($controllerClass, $groupName)
    {
        
    }

}
