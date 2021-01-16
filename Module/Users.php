<?php

/**
 * GI-Platform-DVLP - Users
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2019 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\Module
 *
 * @version 0B.00
 * @since 19-02-13
 */

namespace GIndie\Platform\Module;

use GIndie\ScriptGenerator\Bootstrap3;
use GIndie\Platform\View\Widget\Buttons;
//use MunicipioMineralReforma\Predial\ModeloDatos\Plataforma\Base;
//use MunicipioMineralReforma\Predial\ModeloDatos\Plataforma\Compuesto;
use GIndie\Platform\View;

//use MunicipioMineralReforma\Predial\ModeloDatos\Respaldo;

/**
 * Description of Users
 *
 * @edit 19-02-13
 * - Se copió código de MunicipioMineralReforma\Predial\Modulo\Sistema\Usuarios
 */
class Users extends \GIndie\Platform\Controller\Module
{

    /**
     * {@inheritdoc}
     * @since 19-02-13
     */
    public static function name()
    {
        return "Usuarios";
    }

    /**
     * {@inheritdoc}
     * @since 19-02-13
     */
    public static function description()
    {
        return "Este módulo administra los usuarios del sistema.";
    }

    /**
     * {@inheritdoc}
     * @since 19-02-13
     */
    public static function categoryDPR()
    {
        return "Sistema";
    }

    /**
     * {@inheritdoc}
     * 
     * @since 19-02-13
     */
    public function configPlaceholders()
    {
//        $this->placeholder("i-iii-i")->listSimple(Compuesto\UsuariosLista::class);
        $this->placeholder("i-iii-i")->typeCallable([$this, "wdgtUsuarios"]);
        $this->placeholder("i-iii-ii")->typeRecordDynamic(\GIndie\Platform\DataModel\Platform\User::class);
        $this->placeholder("i-iii-ii")->addButton(Buttons::$COLOR_PRIMARY, "Contraseña",
            "form-reestablecer-contraseña", "gip-selected-id", true,
            urlencode(\GIndie\Platform\DataModel\Platform\UserResetPassword::class));
        $this->placeholder("i-iii-ii")->addButton(Buttons::$COLOR_PRIMARY, "Roles",
            "mr-asignar-rol", "gip-selected-id", \TRUE,
            urlencode(\GIndie\Platform\DataModel\Platform\UserRole::class));
        $this->placeholder("i-iii-iii")->typeRecordDynamic(\GIndie\Platform\DataModel\Platform\UserProfile::class);
        $this->placeholder("i-iii-i")->addSlave("i-iii-ii")->addSlave("i-iii-iii");
//        $this->placeholder("ii-i-i")->typeCallable([$this, "wdgtUsuariosSistemaAnterior"]);
    }

    /**
     * {@inheritdoc}
     * @since 19-02-13
     */
    public static function configActions()
    {
        static::setActionCustom("@desactivarUsuario", "Desactivar un usuario",
            View\Icons::eyeClose(), "default", ["AS"]);
        static::setActionHelp("@desactivarUsuario", 1, "Desde 'Sistema - Usuarios'",
            "Usuarios_acceso");
        static::setActionHelp("@desactivarUsuario", 2,
            "El panel 'Cuentas de usuario' contiene la lista completa de los usuarios del sistema. Haga click sobre uno para seleccionarlo.",
            "Usuarios_wdgtListaUsuarios");
        $context = static::getHelpTopic("@desactivarUsuario")["actionContext"];
        $icon = static::getHelpTopic("@desactivarUsuario")["actionDisplay"];
        static::setActionHelp("@desactivarUsuario", 3,
            "Desde el panel 'Cuenta de usuario' haga click en el botón " . Buttons::Custom($context,
                $icon, "NA"), "Usuarios_wdgtCuentaUsuario_activo");
        static::setActionHelp("@desactivarUsuario", 4,
            "En la ventana 'Desactivar Cuenta de usuario ...' haga click sobre el botón " . Buttons::Custom("warning",
                "Desactivar", "NA"), "Usuarios_mdlDesactivarUsuario");
        static::setActionHelp("@desactivarUsuario", 5,
            "En la ventana 'Registro desactivado' haga click sobre el botón " . Buttons::Custom("default",
                "Cerrar ventana", "NA"), "Usuarios_mdlDesactivarUsuario_confirmacion");
        static::setActionHelp("@desactivarUsuario", 6,
            "En el panel 'Cuenta de usuario' puede verificar que el usuario esté desactivado (Activo = No) ",
            "Usuarios_wdgtCuentaUsuario_inactivo");

        static::setActionCustom("@activarUsuario", "Activar un usuario", View\Icons::eyeOpen(),
            "success", ["AS"]);
        static::setActionHelp("@activarUsuario", 1, "Desde 'Sistema - Usuarios'", "Usuarios_acceso");
        static::setActionHelp("@activarUsuario", 2,
            "El panel 'Cuentas de usuario' contiene la lista completa de los usuarios del sistema. Haga click sobre uno para seleccionarlo.",
            "Usuarios_wdgtListaUsuarios");
        $context = static::getHelpTopic("@activarUsuario")["actionContext"];
        $icon = static::getHelpTopic("@activarUsuario")["actionDisplay"];
        static::setActionHelp("@activarUsuario", 3,
            "Desde el panel 'Cuenta de usuario' haga click en el botón " . Buttons::Custom($context,
                $icon, "NA"), "Usuarios_wdgtCuentaUsuario_inactivo");
        static::setActionHelp("@activarUsuario", 4,
            "En la ventana 'Activar Cuenta de usuario ...' haga click sobre el botón " . Buttons::Custom("success",
                "Activar", "NA"), "Usuarios_mdlActivarUsuario");
        static::setActionHelp("@activarUsuario", 5,
            "En la ventana 'Registro desactivado' haga click sobre el botón " . Buttons::Custom("default",
                "Cerrar ventana", "NA"), "Usuarios_mdlActivarUsuario_confirmacion");
        static::setActionHelp("@activarUsuario", 6,
            "En el panel 'Cuenta de usuario' puede verificar que el usuario esté activado (Activo = Si) ",
            "Usuarios_wdgtCuentaUsuario_activo");
    }

    /**
     * 
     * @return \GIndie\Platform\View\Widgets\Table
     * @since 19-02-13
     */
    public function wdgtUsuarios()
    {
//        Compuesto\UsuarioExtra::columns();
        $widget = new View\Widgets\Table(\GIndie\Platform\DataModel\Platform\User::class);
        $widget->getHeading()->setTitle("Cuentas de usuario");
        return $widget;
    }

    /**
     * 
     * {@inheritdoc}
     * @since 19-02-13
     */
    public static function requiredRoles()
    {
        return ["AS"];
    }

    /**
     * 
     * {@inheritdoc}
     * @since 19-02-13
     */
    protected function _createLog($action, $id, $class, $selected)
    {
        switch ($action)
        {
            case "mr-asignar-rol":
                break;
            default:
                return parent::_createLog($action, $id, $class, $selected);
        }
    }

    /**
     * 
     * {@inheritdoc}
     * @since 19-02-13
     */
    protected function runRecordActionGipDelete($action, $id, $class)
    {
        $rtn = parent::runRecordActionGipDelete($action, $id, $class);
        return $rtn;
    }

    /**
     * 
     * {@inheritdoc}
     * @since 19-02-13
     */
    public function run($action, $id, $class, $selected)
    {
        switch ($action)
        {
            case "widget-reload":
                switch ($id)
                {
                    case "i-iii-ii":
                        $placeholder = parent::run($action, $id, $class, $selected);
//                        $tabla = new \MunicipioMineralReforma\Predial\ModeloDatos\Recursos\Tabla\UsuarioRoles(["pltfrm_cta_fk='" . $selected . "'"]);
                        $tabla = new \GIndie\Platform\DataModel\Resources\GIPTable\UserRole(["pltfrm_cta_fk='" . $selected . "'"]);
                        $vistaTable = new \GIndie\Platform\View\TableSimple($tabla, \FALSE);
//                        $vistaTable = new View\Tables\Table(\MunicipioMineralReforma\Predial\ModeloDatos\Recursos\Tabla\UsuarioRoles::class)
                        $placeholder->setBodyFooter($vistaTable);
                        return $placeholder;
                    default:
                        return parent::run($action, $id, $class, $selected);
                }
            case "form-reestablecer-contraseña":
                $record = $class::findById($id);
                $form = static::_recordForm($record, "form-edit");
                $form->setAttribute("gip-action-class", $class);
                $form->setAttribute("gip-action-id", $id);
                $modalContent = \GIndie\Platform\View\Modal\Content::warning("Reestablecer contraseña",
                        $form);
                $btn = new Bootstrap3\Component\Button("Reestablecer",
                    Bootstrap3\Component\Button::TYPE_SUBMIT);
                $btn->setForm($form->getId())->setValue("Submit");
                $btn->setContext(Bootstrap3\Component\Button::$COLOR_SUCCESS);
                $modalContent->addFooterButton($btn);
                return $modalContent;
                return parent::run("form-edit", $id, $class, $selected);
                break;
            default:
                return parent::run($action, $id, $class, $selected);
        }
    }

}
