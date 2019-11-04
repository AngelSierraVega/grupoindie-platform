<?php

/**
 * GIplatform - Platform 
 *
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 *
 * @package GIndie\Platform\Controller\Instance
 * 
 * @version 0C.FB
 * @since 17-05-22
 */

namespace GIndie\Platform\Controller;

use GIndie\Platform\View;
use GIndie\Platform\Current;
use GIndie\ScriptGenerator\HTML5;
use GIndie\ScriptGenerator\Bootstrap3;

//use \GIndie\Generator\DML\HTML5;
//use \GIndie\Generator\DML\HTML5\Bootstrap3;
//use \GIndie\Platform\Model\Datos\mr_sesion;
//use \GIndie\Platform\Current;

/**
 *
 * @edit 18-01-14
 * - Bitácora restaurada
 * @edit 18-03-14
 * - Moved methods to trait Platform/ToUpgrade or Platform/ToDeprecate
 * @uses \GIndie\Platform\Controller\Platform\Deprecated
 * @edit 18-11-05
 * - Restored methods from Platform/ToUpgrade
 * - Removed use of deprecated libs
 * - Removed Straffsa\SII dependancy
 */
abstract class Platform
{

    /**
     * @since 18-03-14
     * @edit 18-06-24
     * - Added Platform\Deprecated
     * @edit 18-11-05
     * - Merged Platform\ToUpgrade
     */
    use Platform\ToDeprecate;
    use Platform\ToUpgrade;
    use Platform\Upgrading;
    use Platform\Deprecated;

    /**
     * @since 18-06-24
     * @return \GIndie\Platform\View\Document
     */
    protected function cnstrctDocument()
    {
        $document = new View\Document();
        //$document->setContainer($this->load("container"));
        return $document;
    }

    /**
     * @since 18-06-24
     * @return \GIndie\Platform\View\Document\Container
     */
    protected function cnstrctContainer()
    {
        $container = new View\Document\Container();
        $widgets = Current::Module()->getWidgets();
        $widgets = \array_keys($widgets);
        foreach ($widgets as $id) {
            $container->addWidget($id, Current::Module()->getWidget($id) != NULL ?
                            Current::Module()->run("widget-reload", $id, \NULL, \NULL) : \NULL);
        }
        return $container;
    }

    /**
     * @since ??-??-??
     * @deprecated since ??-??-??
     * @todo A VERIFICAR SI SE DEPRECA DEFINITIVAMENTE
     * @param string $id
     * @return mixed
     */
    protected function setController($id)
    {
        $id = urldecode($id);
        if (\class_exists($id)) {
            $instance = new $id();
            \GIndie\Platform\Current::setModule($instance);
            return static::run("load", "container", \NULL, \NULL);
        } else {
            \trigger_error("Unable to set controller {$id}", E_USER_ERROR);
        }
    }

    /**
     * @since ??-??-??
     * @param string $id
     * @return mixed
     * @throws \Exception
     * @edit 18-11-05
     * - Removed use of deprecated libs
     * - Removed Straffsa\SII dependancy
     * @edit 19-04-08
     * @edit 19-06-10
     * - Use of Node->removeContents()
     * @edit 19-07-25
     * - Default use of password
     */
    protected function load($id)
    {
        switch ($id)
        {
            case "loginDPR":
                return new \GIndie\Platform\View\Login();
            case "document":
                $document = new \GIndie\Platform\View\Document();
                if (\GIndie\Platform\Current::User()->getValueOf("password_su") !== \NULL) {
                    $document->addScriptOnDocumentReady("$('#gip-modal').modal('show');");
                    $document->getGIPModal()->removeContents();
                    switch (\get_class(Current::Instance()))
                    {
                        case "GIndie\Empresarial\AreaClientes\Controlador":
                        case "MunicipioMineralReforma\Predial":
                        case "GIndie\FrameworkInstance\ProjectHandler\Instance":
                        default:
//                            $record = \MunicipioMineralReforma\Predial\ModeloDatos\Plataforma\Compuesto\UsuarioContrasenaFinal::findById(\GIndie\Platform\Current::User()->getId());
                            $record = \GIndie\Platform\DataModel\Platform\UserFinalPassword::findById(\GIndie\Platform\Current::User()->getId());
                            $form = new \GIndie\Platform\View\Form($record);
                            $modalContent = View\Modal\Content::warning("Necesita definir contraseña de usuario final", $form);
                            $form->setAttribute("gip-action", "gip-edit");
                            $form->setAttribute("gip-action-class", \GIndie\Platform\DataModel\Platform\UserFinalPassword::class);
                            break;
//                        default:
//                            \trigger_error("To handle single_use for class " . \get_class(Current::Instance()), \E_USER_ERROR);
//                            break;
                    }
                    $form->setAttribute("gip-action-id", \GIndie\Platform\Current::User()->getId());
                    $btn = new Bootstrap3\Component\Button("Definir contraseña", Bootstrap3\Component\Button::TYPE_SUBMIT);
                    $btn->setForm($form->getId())->setValue("Submit");
                    $btn->setContext(Bootstrap3\Component\Button::$COLOR_SUCCESS);
                    $modalContent->addFooterButton($btn);
                    $document->getGIPModal()->addContent($modalContent);
                }
                $document->setContainer($this->load("container"));
                return $document;
            case "container":
                return $this->cnstrctContainer();
            default:
                trigger_error("Unable to run load: gip-action-id={$id}", E_USER_ERROR);
                throw new \Exception("Unable to run.");
                break;
        }
    }

    /**
     * @since ??-??-??
     * @param string $id
     * @return mixed
     * @edit 18-03-18
     * @edit 18-11-05
     * - Removed use of deprecated libs
     * - Removed Straffsa\SII dependancy
     */
    protected function modal($id)
    {
        switch ($id)
        {
            case "config-sesion":
                $configSesionForm = new \GIndie\Platform\View\Form();
                $configSesionForm->setAttribute("gip-action", "submit");
                $configSesionForm->setAttribute("gip-action-id", "config-sesion");
                $rolesCompletos = new \GIndie\Platform\DataModel\Resources\GIPList\Roles([]);
                foreach ($rolesCompletos->getElements() as $element) {
                    $value = $rolesCompletos->getElementAt($element)->getValue();
                    //$configSesionForm->addContent("<h3>$element</h3>");
                    $checked = "";
                    if (\GIndie\Platform\Current::hasRole($element)) {
                        $checked = "checked";
                    }
                    $configSesionForm->addContent("<input type=\"checkbox\" name=\"{$element}\" value=\"rol\" $checked> {$value} <br><br>");
                }
                $modalContent = View\Modal\Content::primary("Roles de la sesión actual", $configSesionForm);
                $btn = new Bootstrap3\Component\Button("Guardar", Bootstrap3\Component\Button::TYPE_SUBMIT);
                $btn->setForm($configSesionForm->getId())->setValue("Submit");
                $btn->setContext(Bootstrap3\Component\Button::$COLOR_SUCCESS);
                $modalContent->addFooterButton($btn);
                return $modalContent;
            case "acerca-de":
                $acerca = new \GIndie\Platform\View\Form("gip-tabla-bitacora");
                $acerca->addContent("<h3>En desarrollo</h3>");
                $roles = \GIndie\Platform\Current::Roles();
                $acerca = new \GIndie\Platform\View\Widget\WidgetList($roles);
                $rtn = new Bootstrap3\Component\Modal\Content("Acerca de", $acerca);
                return $rtn;
                break;
            case "tabla-bitacora":
                $beginOfDay = \DateTime::createFromFormat('Y-m-d H:i:s', (new \DateTime())->setTimestamp(\time())->format('Y-m-d 00:00:00'))->getTimestamp();
                $endOfDay = \DateTime::createFromFormat('Y-m-d H:i:s', (new \DateTime())->setTimestamp(\time())->format('Y-m-d 23:59:59'))->getTimestamp();
                $restrictions = "pltfrm_cta_fk='" . Current::User()->getId();
                $restrictions .= "' AND timestamp > " . $beginOfDay;
                switch (\get_class(Current::Instance()))
                {
                    case "MunicipioMineralReforma\Predial":
                        $bitacora = new View\Tables\Table(\MunicipioMineralReforma\Predial\ModeloDatos\Plataforma\Base\BitacoraUsuario::class);
                        $bitacora->readFromDB(\MunicipioMineralReforma\Predial\ModeloDatos\Plataforma\Base\BitacoraUsuario::getSelectorsDisplay(), [$restrictions], ["ORDER BY timestamp DESC"]);
                        $modalContent = View\Modal\Content::primary("Bitácora de actividades", $bitacora);
                        break;
                    default:
                        \trigger_error("To handle log for class " . \get_class(Current::Instance()), \E_USER_ERROR);
                        break;
                }
                return $modalContent;
                break;
            case "form-logout":
                $form = new \GIndie\Platform\View\Form();
                $form->setAttribute("gip-action", "submit");
                $form->setAttribute("gip-action-id", "gip-logout");
                $form->addContent("<p>¿Está seguro que desea cerrar la sesión actual?</p>");
                $rtn = View\Modal\Content::warning("Cerrar sesión", $form);
                $btn = new Bootstrap3\Component\Button("Cerrar sesión", Bootstrap3\Component\Button::TYPE_SUBMIT);
                $btn->setForm($form->getId())->setValue("Submit");
                $btn->setContext(Bootstrap3\Component\Button::$COLOR_SUCCESS);
                $rtn->addFooterButton($btn);
                return $rtn;
                break;
            case "current_log":
                $rtn = new Bootstrap3\Component\Modal\Content("Bitácora de usuario");
                $rtn->addContent($_SESSION["gip-log"]);
                return $rtn;
            case "about":
                $rtn = new Bootstrap3\Component\Modal\Content("Acerca de...");
                $rtn->addContent("[La Plataforma]<br>[Información de sesión de usuario]");
                return $rtn;
            default:
                \trigger_error("No se encontró el modal solicitado {$id}", \E_USER_ERROR);
                //throw new \Exception("No se encontró el modal solicitado");
                $rtn = new Bootstrap3\Modal\Content("Error", "No se encontró el modal solicitado");
                return $rtn;
        }
    }

    /**
     * @since ??-??-??
     * @param type $action
     * @param type $id
     * @param type $class
     * @param type $selected
     * @edit 18-07-30
     * - No log on action: @selectRow
     * @edit 18-11-05
     * - Removed use of deprecated libs
     * - Removed Straffsa\SII dependancy
     */
    protected function _createLog($action, $id, $class, $selected)
    {
        switch ($action)
        {
            case "tableSearch":
            case "reportSearch":
            case "submit":
            case "config-sesion":
            case "get-input":
            case "load":
            case "form-create":
            case "form-edit":
            case "form-delete":
            case "form-activate":
            case "form-deactivate":
            case "form-logout":
            case "gip-create":
            case "gip-edit":
            case "gip-delete":
            case "gip-activate":
            case "gip-deactivate":
            case "widget-reload":
            case "tabla-bitacora":
            case "acerca-de":
            case "mr-asignar-caja-usuario":
            case "@selectRow":
            case "REQUEST-PHAR":
                break;
            default:
                $data = [];
                $data['pltfrm_cta_fk'] = Current::User()->getId();
                $data['action'] = $action;
                $data['action-id'] = $id;
                $data['action-class'] = $class;
                $data['selected-id'] = $selected;
                $data['timestamp'] = \time();
                switch ($action)
                {
                    /**
                     * @edit 18-12-21
                     */
                    case "setController":
                        $moduleClass = \urldecode($id);
                        $moduleName = $moduleClass::name();
                        $moduleCategory = \is_null($moduleClass::category())?"":$moduleClass::category()."-";
                        $nota = "Ingresó al módulo {$moduleCategory}{$moduleName}";
                        unset($moduleClass);
                        unset($moduleName);
                        unset($moduleCategory);
                        break;
                    default:
                        var_dump($action);
                        \trigger_error("POR DEFINIR ACCION EN HISTORIAL. {$action}", \E_USER_ERROR);
                        break;
                }
                $data['notes'] = \filter_var($nota, \FILTER_SANITIZE_SPECIAL_CHARS);
                $bitacora = \GIndie\Platform\DataModel\Platform\LogUser::instance($data);
                $bitacora->run("gip-inner-create");
                break;
        }
    }

    /**
     * 
     * @since ??-??-??
     * 
     * @param string $action
     * @param string $id
     * 
     * @return mixed
     * @throws \Exception
     */
    protected function submit($id)
    {
        switch ($id)
        {
            case "config-sesion":
                $response = HTML5\Category\StylesSemantics::Span();
                $userId = \GIndie\Platform\Current::User()->getId();
                \GIndie\Platform\Current::Roles()->cleanData();
                $_rol = [];
                foreach ($_POST as $rol => $value) {
                    if (strcmp($value, "rol") == 0) {
                        \GIndie\Platform\Current::Roles()->addElement($rol, $userId);
                        //$_rolTemp = \Straffsa\SistemaIntegralIngresos\Datos\mr_sesion\rol\Registro::findById($rol);
                        $_rolTemp = \GIndie\Platform\DataModel\Platform\Role::findById($rol);
                        $_rol[] = $_rolTemp->getDisplay();
                    }
                }
                $tmp = \TRUE;
                if ($tmp) {
                    $response->addContent("¡Se actualizaron los permisos de sesión!");
                    $response->addScript("location.replace(location.pathname);");
                    $data = [];
                    $data['pltfrm_cta_fk'] = \GIndie\Platform\Current::User()->getId();
                    $data['action'] = "config-sesion";
                    $data['timestamp'] = \time();

                    $nota = "Modificó sus permisos de sesión: " . join(", ", $_rol);
                    $data['notes'] = \filter_var($nota, \FILTER_SANITIZE_SPECIAL_CHARS);
//                    $bitacora = \Straffsa\SistemaIntegralIngresos\Datos\mr_sesion\bitacora\Registro::instance($data);
                    $bitacora = \GIndie\Platform\DataModel\Platform\LogUser::instance($data);
                    $bitacora->run("gip-inner-create");
                } else {
                    $response->addContent("Failed");
                }
                return $response;
                break;
            case "gip-logout":
                $data = [];
                $data['pltfrm_cta_fk'] = \GIndie\Platform\Current::User()->getId();
                $tmp = \GIndie\Platform\Current::sessionDestroy();
                $response = HTML5\Category\StylesSemantics::Span();
                if ($tmp) {
                    $response->addContent("Cierre de sesión exitoso.");
                    $response->addScript("location.replace(location.pathname);");

                    /**
                     * @todo Verify plugin data
                     */
                    $sii = \GIndie\Platform\INIHandler::getCategoryValue("Plugins", "SistemaIntegralIngresos");
                    $sii = true;
                    if ($sii) {
                        $data['action'] = "gip-logout";
                        $data['timestamp'] = \time();
                        $nota = "Cerró su sesión";
                        $data['notes'] = \filter_var($nota, \FILTER_SANITIZE_SPECIAL_CHARS);
                        //$bitacora = \Straffsa\SistemaIntegralIngresos\Datos\mr_sesion\bitacora\Registro::instance($data);
                        $bitacora = \GIndie\Platform\DataModel\Platform\LogUser::instance($data);
                        $bitacora->run("gip-inner-create");
                    }
                } else {
                    $response->addContent("Failed");
                }
                return $response;
            default:
                \trigger_error("No se pudo ejecutar el comando submit. id {$id}", \E_USER_ERROR);
                throw new \Exception("No se pudo ejecutar el comando submit.");
                break;
        }
    }

    /**
     * 
     * @param GIndie\Platform\Model\Record $record
     * @param string $action
     * @return \GIndie\Platform\View\Form
     * @since ??-??-??
     */
    protected function _recordForm($record, $action)
    {
        $form = new \GIndie\Platform\View\Form($record);
        switch ($action)
        {
            case "form-edit":
                $form->setAttribute("gip-action", "gip-edit");
                break;
            case "form-create":
                $form->setAttribute("gip-action", "gip-create");
                break;
            case "form-delete":
                $form->setAttribute("gip-action", "gip-delete");
                break;
            case "form-deactivate":
                $form->setAttribute("gip-action", "gip-deactivate");
                break;
            case "form-activate":
                $form->setAttribute("gip-action", "gip-activate");
                break;
        }
        return $form;
    }

    /**
     * 
     * @param type $action
     * @param type $id
     * @param type $class
     * @return type
     * @throws \Exception
     * @since 18-03-14
     */
    protected function recordAction($action, $id, $class)
    {
        switch ($action)
        {
            case "gip-create":
                if ($record->create()) {
                    $response->addScript("$('#gip-modal .modal-body').html('Registro creado')");
                    $response->setAttribute("gip-success");
                } else {
                    $response->addContent("Failed");
                }
                return $response;
            case "gip-edit":
                if ($record->update()) {
                    $response->addScript("$('#gip-modal .modal-body').html('Registro actualizado.')");
                    $response->setAttribute("gip-success");
                } else {
                    $response->addContent("Hubo un error al actualizar, intentenlo de nuevo.");
                }
                return $response;
            case "gip-delete":
                try {
                    if ($record->delete()) {
                        $modalContent = new Bootstrap3\Component\Modal\Content("Registro eliminado con éxito");
                        $btnDismiss = new Bootstrap3\Component\Button("Cerrar", Bootstrap3\Component\Button::TYPE_BUTTON);
                        $btnDismiss->setAttribute("data-dismiss", "modal");
                        $modalContent->addFooterButton($btnDismiss);
                        $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
                        $response->setAttribute("gip-success");
                    } else {
                        $response->addContent("Hubo un error al eliminar, intentenlo de nuevo.");
                    }
                } catch (\GIndie\Platform\ExceptionMySQL $exc) {
//                    var_dump($exc->getCode()); //1451
//                    return $exc->getTraceAsString();
                    //$response->addScript("$('#gip-modal .modal-body .modal-footer').html('".\GIndie\Platform\ExceptionMySQL::handleException($exc)."');");
                    $modalContent = new Bootstrap3\Component\Modal\Content("Error al eliminar", \GIndie\Platform\ExceptionMySQL::handleException($exc));
                    $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
                    //$response->addScript("$('#gip-modal .modal-footer').html('TEST');");
                    //$response->addContent("Hubo un error al eliminar (1451), intentenlo de nuevo.");
                }

                return $response;
            default:
                trigger_error("Unable to run recordAction: gip-action={$action} gip-action-id={$id} gip-action-class={$class}", E_USER_ERROR);
                throw new \Exception("Unable to run.");
                break;
        }
    }

    /**
     * 
     * @since ??-??-??
     * 
     * @param string $action
     * @param string $id
     * 
     * @return mixed
     * @todo
     * - Handle expiration only when Plugin SistemaIntegralIngresos
     */
    public function run($action, $id, $class, $selected)
    {
        $expiracion = new \DateTime('2021-01-01');
        $expiracion = $expiracion->getTimestamp();
        if (\time() >= $expiracion) {
            throw new \Exception("La licencia de la aplicación ha expirado.");
        }
        switch ($action)
        {
            case "config-sesion":
            case "tabla-bitacora":
            case "acerca-de":
            case "perfil-usuario":
            case "form-logout":
                return $this->modal($action);
            case "loginDPR":
                return static::load($action);
            case "load":
                return static::load($id);
            case "getModalContentDPR":
            case "modalDPR":
                return static::modal($id);
            case "submit":
                return static::submit($id);
                break;
            case "setController":
                return static::setController($id);
            default:
                \trigger_error("Unable to run: gip-action={$action} gip-action-id={$id} gip-action-class={$class}", E_USER_ERROR);
                throw new \Exception("Unable to run.");
        }
    }

}
