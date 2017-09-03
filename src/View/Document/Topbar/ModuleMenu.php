<?php

/*
 * Copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * This software is protected under GNU: you can use, study and modify it
 * but not distribute it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 */

namespace GIndie\Platform\View\Document\Topbar;

use GIndie\Generator\DML\HTML5;

/**
 * Description of ModuleMenu
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class ModuleMenu extends HTML5\Category\Lists\Unordered
{

    public function __construct()
    {//
        parent::__construct([]);
        $this->addClass("nav navbar-nav");
        $this->setAttribute("id", "gip-module-menu");
        $listControllers = \GIndie\Platform\Current::Platform()->getModules();
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
                        $this->addListElement(new HTML5\Category\Lists\ListItem([],
                                                                                ['<a gip-action="setController" gip-action-id="' .
                            urlencode($controllerClass) .
                            '" href="#">' . $controllerClass::NAME . '</a>']));
                        break;
//                case (is_bool($value) != $value):
//                    break;
                    default:
                        if ($tmpGroup !== $value) {
                            $dropdown = new \GIndie\Generator\DML\HTML5\Bootstrap3\Component\Dropdown($value,
                                                                                                      ['<a gip-action="setController" gip-action-id="' .
                                urlencode($controllerClass) .
                                '" href="#">' . $controllerClass::NAME . '</a>'],
                                          "a");
                            $dropdown->setTag("li");
                            $tmpRef = &$dropdown;
                            $this->addListElement($tmpRef);
                            $tmpGroup = $value;
                        } else {
                            $dropdown->addListElement(new HTML5\Category\Lists\ListItem([],
                                                                                        ['<a gip-action="setController" gip-action-id="' .
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
