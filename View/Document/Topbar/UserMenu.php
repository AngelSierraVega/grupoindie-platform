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

use GIndie\Generator\DML\HTML5\Bootstrap3;

/**
 * UserMenu
 * 
 * @since       2017-04-21
 * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @version     GIP.00
 */
class UserMenu extends Bootstrap3\Component\Dropdown
{

    public function __construct()
    {
//        if (\GIndie\Platform\Current::IsAuthenticated()) {
//            $brand = \GIndie\Platform\Current::User()->getValueOf("user");
//
//            $perfil = Bootstrap3\Factory::Hyperlink("#", "Perfil usuario");
//            $perfil->setAttribute("gip-action","form-edit");
//            $perfil->setAttribute("gip-action-id", \GIndie\Platform\Current::User()->getId());
//            $perfil->setAttribute("gip-action","form-edit");
//            $perfil->setAttribute("gip-modal","1");
//            $perfil->setAttribute("gip-action-class", urlencode("Straffsa\SistemaIntegralIngresos\Datos\mr_catalogos\usuario_perfil\Registro"));
//
//            $listElements = [$perfil];
//
//            $listElements[] = Bootstrap3\Factory::Hyperlink("#",
//                            "Configuración de sesión");
//            $cerrar = Bootstrap3\Factory::Hyperlink("logout", "Cerrar sesión");
//            //$cerrar->addClass($classnames);
//            $cerrar->setAttribute("gip-action", "form-logout");
//            $cerrar->setAttribute("gip-modal", "1");
//            $listElements[] = $cerrar;
//        } else {
//            $brand = "Invitado";
//            $listElements = [];
//        }
        $brand = \GIndie\Platform\Current::User()->getValueOf("user");

        $perfil = Bootstrap3\Factory::Hyperlink("#", "Perfil usuario");
        $perfil->setAttribute("gip-action", "form-edit");
        $perfil->setAttribute("gip-action-id",
                              \GIndie\Platform\Current::User()->getId());
        $perfil->setAttribute("gip-action", "form-edit");
        $perfil->setAttribute("gip-modal", "1");
        $perfil->setAttribute("gip-action-class",
                              urlencode("Straffsa\SistemaIntegralIngresos\Datos\mr_catalogos\usuario_perfil\Registro"));

        $listElements = [$perfil];

        $cta = \GIndie\Platform\Current::User()->getId();
        $listTemp = new \GIndie\Platform\Model\Datos\mr_sesion\usuario_cuenta_rol\Lista(["fk_rol='AS'", "fk_usuario_cuenta='{$cta}'"]);
        if ($listTemp->getElementAt("AS") !== \FALSE) {
            $configuracionSesion = Bootstrap3\Factory::Hyperlink("#",
                                                                 "Configuración de sesión");
            $configuracionSesion->setAttribute("gip-action", "config-sesion");
            $configuracionSesion->setAttribute("gip-modal", "1");
            $listElements[] = $configuracionSesion;
        }
//        if (\GIndie\Platform\Current::hasRole("AS")) {
//            $configuracionSesion = Bootstrap3\Factory::Hyperlink("#",
//                                                                 "Configuración de sesión");
//            $configuracionSesion->setAttribute("gip-action", "config-sesion");
//            $configuracionSesion->setAttribute("gip-modal", "1");
//            $listElements[] = $configuracionSesion;
//        }

        $cerrar = Bootstrap3\Factory::Hyperlink("logout", "Cerrar sesión");
        $cerrar->setAttribute("gip-action", "form-logout");
        $cerrar->setAttribute("gip-modal", "1");
        $listElements[] = $cerrar;
        parent::__construct($brand, $listElements, $customToggleTag = "a");
        $this->setTag("li");
    }

    /**
     * 
     * @final
     * @since       2017-01-05
     * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
     * 
     * @version     beta.00.01
     */
    final public function __construct2()
    {

        $this->_userMenu = new Bootstrap3\Dropdown($name, $_dropdownList, "a");
        $this->_userMenu->setAttribute("gip-action", "modal");
        $this->_userMenu->setTag("li");
    }

}
