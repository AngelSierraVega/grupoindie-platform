<?php

/**
 * GI-Platform-DVLP - 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\View
 *
 * @version 0C.00
 * @since 17-04-21
 */

namespace GIndie\Platform\View\Document\Topbar;

use GIndie\Generator\DML\HTML5\Bootstrap3;

/**
 * UserMenu
 * @edit 18-08-27
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
        $perfil->setAttribute("gip-action-id", \GIndie\Platform\Current::User()->getId());
        $perfil->setAttribute("gip-action", "form-edit");
        $perfil->setAttribute("gip-modal", "1");
        $perfil->setAttribute("gip-action-class", urlencode(\GIndie\Platform\DataModel\Platform\UserProfile::class));

        $listElements = [$perfil];

        $cta = \GIndie\Platform\Current::User()->getId();
        $listTemp = new \GIndie\Platform\Model\Datos\mr_sesion\usuario_cuenta_rol\Lista(["pltfrm_rol_fk='AS'", "pltfrm_cta_fk='{$cta}'"]);
        if ($listTemp->getElementAt("AS") !== \FALSE) {
            $configuracionSesion = Bootstrap3\Factory::Hyperlink("#", "Configuración de sesión");
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
     * @deprecated since 18-05-20
     * @todo 
     * - Delete
     */
    final public function __construct2DPR()
    {

        $this->_userMenu = new Bootstrap3\Dropdown($name, $_dropdownList, "a");
        $this->_userMenu->setAttribute("gip-action", "modal");
        $this->_userMenu->setTag("li");
    }

}
