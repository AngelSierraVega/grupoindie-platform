<?php

/**
 * GI-Platform-DVLP - 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\View
 *
 * @version 0D.10
 * @since 17-04-21
 */

namespace GIndie\Platform\View\Document\Topbar;

//use GIndie\Generator\DML\HTML5\Bootstrap3;
use GIndie\ScriptGenerator\Bootstrap3;

//use GIndie\ScriptGenerator\Bootstrap3\Component\Dropdown;

/**
 * UserMenu
 * @edit 18-08-27
 * @edit 18-11-05
 * - Removed use of deprecated libs
 */
class UserMenu extends Bootstrap3\Component\Dropdown
{

    public function __construct()
    {
        $brand = \GIndie\Platform\Current::User()->getValueOf("user");

        $perfil = \GIndie\ScriptGenerator\HTML5\Category\Links::hyperlink("#", "Perfil usuario");
        $perfil->setAttribute("gip-action", "form-edit");
        $perfil->setAttribute("gip-action-id", \GIndie\Platform\Current::User()->getId());
        $perfil->setAttribute("gip-action", "form-edit");
        $perfil->setAttribute("gip-modal", "1");
        $perfil->setAttribute("gip-action-class", urlencode(\GIndie\Platform\DataModel\Platform\UserProfile::class));

        $listElements = [$perfil];

        $cta = \GIndie\Platform\Current::User()->getId();
        $listTemp = new \GIndie\Platform\Model\Datos\mr_sesion\usuario_cuenta_rol\Lista(["pltfrm_rol_fk='AS'", "pltfrm_cta_fk='{$cta}'"]);
        if ($listTemp->getElementAt("AS") !== \FALSE) {
            $configuracionSesion = \GIndie\ScriptGenerator\HTML5\Category\Links::hyperlink("#", "Configuración de sesión");
            $configuracionSesion->setAttribute("gip-action", "config-sesion");
            $configuracionSesion->setAttribute("gip-modal", "1");
            $listElements[] = $configuracionSesion;
        }
        $cerrar = \GIndie\ScriptGenerator\HTML5\Category\Links::hyperlink("logout", "Cerrar sesión");
        $cerrar->setAttribute("gip-action", "form-logout");
        $cerrar->setAttribute("gip-modal", "1");
        $listElements[] = $cerrar;
        parent::__construct($brand, $listElements, $customToggleTag = "a");
        $this->setTag("li");
    }

}
