<?php

/**
 * GIplatform - Platform 
 */

namespace GIndie\Platform\Controller;

use \GIndie\Generator\DML\HTML5;
use \GIndie\Generator\DML\HTML5\Bootstrap3; 
//use \GIndie\ScriptGenerator\Bootstrap3;
use \GIndie\Platform\Model\Datos\mr_sesion;
use \GIndie\Platform\Current;

//use GIndie\Generator\DML\HTML5\Bootstrap3;

/**
 * Description of Platform
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @since GIP.00.00 2017-05-22
 * @version GIP.00.03
 * @edit GIP.00.04 18-01-14
 * - Bitácora restaurada
 */
abstract class Platform
{

    /**
     * @deprecated since GIP.00.02 
     * @todo A VERIFICAR SI SE DEPRECA DEFINITIVAMENTE
     * @param string $id
     * @return mixed
     * @since GIP.00.01
     * @version GIP.00.03
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
     * 
     * @param string $id
     * @return mixed
     * @throws \Exception
     * @since GIP.00.01
     */
    protected function load($id)
    {
        switch ($id)
        {
            case "loginDPR":
                return new \GIndie\Platform\View\Login();
            case "document":
            case "bodyDPR":
                $document = new \GIndie\Platform\View\Document();
            case "document":
                if (\GIndie\Platform\Current::User()->getValueOf("password_su") !== \NULL) {
                    $document->addScriptOnDocumentReady("$('#gip-modal').modal('show');");
                    $document->getGIPModal()->removeContent();
                    $record = mr_sesion\usuario_cuenta\ContrasenaUsuario::findById(\GIndie\Platform\Current::User()->getId());
//                    $record = new mr_sesion\usuario_cuenta\ContrasenaUsuario();
                    $form = new \GIndie\Platform\View\Form($record);
                    $modalContent = new Bootstrap3\Component\Modal\Content("Necesita definir contraseña de usuario final", $form);
                    $form->setAttribute("gip-action", "gip-edit");
                    $form->setAttribute("gip-action-class", mr_sesion\usuario_cuenta\ContrasenaUsuario::class);
                    $form->setAttribute("gip-action-id", \GIndie\Platform\Current::User()->getId());

                    $btn = new Bootstrap3\Component\Button("Definir contraseña", Bootstrap3\Component\Button::TYPE_SUBMIT);
                    $btn->setForm($form->getId())->setValue("Submit");
                    $btn->setContext(Bootstrap3\Component\Button::$COLOR_SUCCESS);
                    $modalContent->addFooterButton($btn);
                    $document->getGIPModal()->addContent($modalContent);
                }

                return $document;
            case "bodyDPR":
                return $document->getBody();
            case "container":
                $container = new \GIndie\Platform\View\Document\Container();
                $widgets = \GIndie\Platform\Current::Module()->getWidgets();
                $widgets = array_keys($widgets);
                foreach ($widgets as $id) {
//                    $container->addWidget($id,
//                                          \GIndie\Platform\Current::Controller()->getWidget($id)
//                            != NULL ? \GIndie\Platform\Current::Controller()->getWidget($id)->call(\NULL) : \NULL);
                    $container->addWidget($id, \GIndie\Platform\Current::Module()->getWidget($id) != NULL ? \GIndie\Platform\Current::Module()->run("widget-reload", $id, \NULL, \NULL) : \NULL);
                }
//                foreach ($this->WidgetsDefinition as $id) {
//                    $container->addWidget($id,
//                            $this->getWidget($id) != NULL ? $this->getWidget($id)->call() : NULL);
//                }
                return $container;
            default:
                trigger_error("Unable to run load: gip-action-id={$id}", E_USER_ERROR);
                throw new \Exception("Unable to run.");
                break;
        }
    }

    /**
     * @since GIP.00.01
     * @param string $id
     * @return mixed
     */
    protected function modal($id)
    {
        switch ($id)
        {
            case "config-sesion":
                $configSesionForm = new \GIndie\Platform\View\Form();
                $configSesionForm->setAttribute("gip-action", "submit");
                $configSesionForm->setAttribute("gip-action-id", "config-sesion");
                $rolesCompletos = new \AdminIngresos\Datos\mr_sesion\rol\Lista([]);
                foreach ($rolesCompletos->getElements() as $element) {
                    $value = $rolesCompletos->getElementAt($element)->getValue();
                    //$configSesionForm->addContent("<h3>$element</h3>");
                    $checked = "";
                    if (\GIndie\Platform\Current::hasRole($element)) {
                        $checked = "checked";
                    }
                    $configSesionForm->addContent("<input type=\"checkbox\" name=\"{$element}\" value=\"rol\" $checked> {$value} <br><br>");
                }
                $modalContent = new Bootstrap3\Component\Modal\Content("Roles de la sesión actual", $configSesionForm);
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
                /**
                 * @todo Verify plugin data
                 */
                $sii = \GIndie\Platform\INIHandler::getCategoryValue("Plugins", "SistemaIntegralIngresos");
                if ($sii) {
                    $beginOfDay = \DateTime::createFromFormat('Y-m-d H:i:s', (new \DateTime())->setTimestamp(\time())->format('Y-m-d 00:00:00'))->getTimestamp();
                    $endOfDay = \DateTime::createFromFormat('Y-m-d H:i:s', (new \DateTime())->setTimestamp(\time())->format('Y-m-d 23:59:59'))->getTimestamp();
                    $restrictions = "fk_usuario_cuenta='" . Current::User()->getId();
                    //$restrictions .= "' AND timestamp < 1601539400";
                    $restrictions .= "' AND timestamp > " . $beginOfDay;
                    //$restrictions .= "' AND timestamp < " . $endOfDay;
                    $bitacora = new \GIndie\Platform\View\TableSimple(new \AdminIngresos\Datos\mr_sesion\bitacora\Tabla(
                            [$restrictions]));
                    $modalContent = $this->_modalWrap("Bitácora de actividades", $bitacora);
                } else {
                    $modalContent = $this->_modalWrap("Bitácora de actividades", "@todo");
                }

                return $modalContent;

                break;
            case "form-logout":
                $form = new \GIndie\Platform\View\Form();
                $form->setAttribute("gip-action", "submit");
                $form->setAttribute("gip-action-id", "gip-logout");
                $form->addContent("<p>¿Está seguro que desea cerrar la sesión actual?</p>");
                $rtn = new Bootstrap3\Component\Modal\Content("Cerrar sesión", $form);
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
     * 
     * @param type $action
     * @param type $id
     * @param type $class
     * @param type $selected
     * 
     * @edit GIP.00.04
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

                break;
            default:
                /**
                 * @todo Verify plugin data
                 */
                $sii = \GIndie\Platform\INIHandler::getCategoryValue("Plugins", "SistemaIntegralIngresos");
                if ($sii) {
                    $data = [];
                    $data['fk_usuario_cuenta'] = \GIndie\Platform\Current::User()->getId();
                    $data['action'] = $action;
                    $data['action-id'] = $id;
                    $data['action-class'] = $class;
                    $data['selected-id'] = $selected;
                    $data['timestamp'] = \time();
                    switch ($action)
                    {
                        case "setController":
                            $modulo = \urldecode($id);
                            $nota = "Ingresó al módulo " . $modulo::NAME;
                            break;
                        default:
                            \trigger_error("POR DEFINIR ACCION EN HISTORIAL. {$action}", \E_USER_ERROR);
                            break;
                    }
                    $data['notas'] = \filter_var($nota, \FILTER_SANITIZE_SPECIAL_CHARS);
                    $bitacora = \AdminIngresos\Datos\mr_sesion\bitacora\Registro::instance($data);
                    $bitacora->run("gip-inner-create");
                }
                break;
        }
    }

    /**
     * 
     * @since GIP.00.01
     * 
     * @param string $action
     * @param string $id
     * 
     * @return mixed
     * @throws \Exception
     * @edit GIP.00.04
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
                        $_rolTemp = \AdminIngresos\Datos\mr_sesion\rol\Registro::findById($rol);
                        $_rol[] = $_rolTemp->getDisplay();
                    }
                }
                $tmp = \TRUE;
                if ($tmp) {
                    $response->addContent("¡Se actualizaron los permisos de sesión!");
                    $response->addScript("location.replace(location.pathname);");
                    $data = [];
                    $data['fk_usuario_cuenta'] = \GIndie\Platform\Current::User()->getId();
                    $data['action'] = "config-sesion";
                    $data['timestamp'] = \time();

                    $nota = "Modificó sus permisos de sesión: " . join(", ", $_rol);
                    $data['notas'] = \filter_var($nota, \FILTER_SANITIZE_SPECIAL_CHARS);
                    $bitacora = \AdminIngresos\Datos\mr_sesion\bitacora\Registro::instance($data);
                    $bitacora->run("gip-inner-create");
                } else {
                    $response->addContent("Failed");
                }
                return $response;
                break;
            case "gip-logout":
                $data = [];
                $data['fk_usuario_cuenta'] = \GIndie\Platform\Current::User()->getId();
                $tmp = \GIndie\Platform\Current::sessionDestroy();
                $response = HTML5\Category\StylesSemantics::Span();
                if ($tmp) {
                    $response->addContent("Cierre de sesión exitoso.");
                    $response->addScript("location.replace(location.pathname);");

                    /**
                     * @todo Verify plugin data
                     */
                    $sii = \GIndie\Platform\INIHandler::getCategoryValue("Plugins", "SistemaIntegralIngresos");
                    if ($sii) {
                        $data['action'] = "gip-logout";
                        $data['timestamp'] = \time();
                        $nota = "Cerró su sesión";
                        $data['notas'] = \filter_var($nota, \FILTER_SANITIZE_SPECIAL_CHARS);
                        $bitacora = \AdminIngresos\Datos\mr_sesion\bitacora\Registro::instance($data);
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
     * @param string $modalTitle
     * @param mixed $modalContent
     * @param boolean $closeButton
     * @return \GIndie\Generator\DML\HTML5\Bootstrap3\Component\Modal\Content
     */
    protected function _modalWrap($modalTitle, $modalContent, $closeButton = \TRUE)
    {
        //$modalContent = new Bootstrap3\Component\Modal\Content($modalTitle, $modalContent);
        $modalContent = new Bootstrap3\Component\Modal\Content($modalTitle, $modalContent);
        if ($closeButton === \TRUE) {
            $btnDismiss = new Bootstrap3\Component\Button("Cerrar", Bootstrap3\Component\Button::TYPE_BUTTON);
            $btnDismiss->setAttribute("data-dismiss", "modal");
            $modalContent->addFooterButton($btnDismiss);
        }
        return $modalContent;
    }

    /**
     * 
     * @param GIndie\Platform\Model\Record $record
     * @param string $action
     * @return \GIndie\Platform\View\Form
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
     * @since GIP.00.01
     * 
     * @param string $action
     * @param string $id
     * 
     * @return mixed
     * @version GIP.00.02
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
