<?php

namespace GIndie\Platform\Controller\Module;

use GIndie\ScriptGenerator\HTML5;
use GIndie\ScriptGenerator\Bootstrap3;
use GIndie\Platform\Model;
use GIndie\Platform\View;
use GIndie\Generator\DML\HTML5\Bootstrap3 AS Bootstrap3ToDeprecate;
use GIndie\Generator\DML\HTML5 AS HTML5ToDeprecate;

/**
 * GI-Platform-DVLP - Upgrading
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version A0
 * @since 18-03-14
 */
trait Upgrading
{

    /**
     * 
     * 
     * @since       2017-01-05
     * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
     * 
     * @version     GIP.00.07 
     * - use widgetReload on $action = widget-reload
     * 
     * @param       string $action
     * @param       string $id
     * @return      mixed
     * @edit 18-03-15
     */
    public function run($action, $id, $class, $selected)
    {
        $this->_createLog($action, $id, $class, $selected);
        switch ($action)
        {
            case "reportSearch":
                $_table = $this->_searchTable($class);
                return new \GIndie\Platform\View\TableReport($_table);
            case "tableSearch":
                return static::tableSearch($class);
            case "get-input":
                $record = $class::findById($_POST["gip-record-id"]);
                $attribute = $record->getAttribute($id);
                return $form_element = \GIndie\Platform\View\Input::selectFromAttribute($attribute, $record->getValueOf($attribute->getName()), $_POST["gip-record-id"]);
                return \GIndie\Platform\View\Input::formGroup($attribute, $form_element);
            case "form-create":
            case "form-edit":
            case "form-delete":
            case "form-activate":
            case "form-deactivate":
                return static::runRecordForm($action, $id, $class);
            case "gip-create":
            case "gip-edit":
            case "gip-delete":
            case "gip-activate":
            case "gip-deactivate":
                if (!isset($_POST["gip-token"])) {
                    $response = HTML5\Category\StylesSemantics::Span();
                    $msj = "Falló validación de token.";
                    $modalContent = $this->cnstrctModal("Operación ilegal", $msj);
                    $modalContent->getHeader()->setBackground("danger");
                    $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
                    return $response;
                }
                $tokenValidation = \GIndie\Platform\Current::uniqueTokenValidate($_POST["gip-token"]);
                if (!$tokenValidation) {
                    $response = HTML5\Category\StylesSemantics::Span();
                    $msj = "Falló validación de token.";
                    $modalContent = $this->cnstrctModal("Operación ilegal", $msj);
                    $modalContent->getHeader()->setBackground("danger");
                    $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
                    return $response;
                }
                return static::runRecordAction($action, $id, $class);
            case "widget-reload":
                return $this->widgetReload($id, $class, $selected);
            default:
                if ($class != "undefined") {
                    if ($class != \NULL) {
                        if ($selected == \NULL) {
                            $selected = $id;
                        }
                        $obj = $class::findById($selected);
                        return $obj->run($action, $id, $selected);
                    }
                }
                return parent::run($action, $id, $class, $selected);
        }
    }

    /**
     * 
     * @param type $action
     * @param type $id
     * @param type $class
     * @return type
     * @throws \Exception
     * @edit 18-03-14
     * @edit 18-03-15
     * - Explode content into smaller methods
     */
    protected function runRecordAction($action, $id, $class)
    {
        $response = HTML5\Category\StylesSemantics::Span();
        try {
            switch ($action)
            {
                case "gip-create":
                    $modalContent = $this->runRecordActionGipCreate($action, $id, $class);
                    break;
                case "gip-edit":
                    $modalContent = $this->runRecordActionGipEdit($action, $id, $class);
                    break;
                case "gip-deactivate":
                    $modalContent = $this->runRecordActionGipDeactivate($action, $id, $class);
                    break;
                case "gip-activate":
                    $modalContent = $this->runRecordActionGipActivate($action, $id, $class);
                    break;
                case "gip-delete":
                    $modalContent = $this->runRecordActionGipDelete($action, $id, $class);
                    break;
                default:
                    $msj = "Contacte al administrador del sistema si el problema persiste.";
                    $modalContent = View\Modal\Content::danger("Algo salió mal en la ejecución", $msj);
//                    $modalContent = $this->cnstrctModal(, $msj);
//                    $modalContent->getHeader()->setBackground("danger");
                    \trigger_error("Unable to run recordAction: gip-action={$action} gip-action-id={$id} gip-action-class={$class}", \E_USER_ERROR);
                    break;
            }
        } catch (\GIndie\Platform\ExceptionMySQL $exc) {
            $msj = \GIndie\Platform\ExceptionMySQL::handleException($exc);
            $modalContent = $this->cnstrctModal("Algo salió mal. Error de usuario.", $msj);
            $modalContent->getHeader()->setBackground("warning");
        }
        $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
        return $response;
    }

    /**
     * @since 18-03-15
     * 
     * @param string $action
     * @param string $id
     * @param string $class
     * 
     * @return \GIndie\ScriptGenerator\Bootstrap3\Component\Modal\Content
     * 
     */
    protected function runRecordActionGipCreate($action, $id, $class)
    {
        $record = $class::findById($id);
        $record->run($action);
        $msj = "El registro ha sido creado exitosamente.";
        $modalContent = View\Modal\Content::succcess("Registro creado.", $msj);
//        $modalContent = $this->cnstrctModal("Registro creado.", $msj);
//        $modalContent->getHeader()->setBackground("success");
        return $modalContent;
    }

    /**
     * @since 18-03-15
     * 
     * @param string $action
     * @param string $id
     * @param string $class
     * 
     * @return \GIndie\ScriptGenerator\Bootstrap3\Component\Modal\Content
     * 
     */
    protected function runRecordActionGipDeactivate($action, $id, $class)
    {
        $record = $class::findById($id);
        $record->run($action);
        $msj = "El registro ha sido desactivado exitosamente.";
        $modalContent = View\Modal\Content::succcess("Registro desactivado.", $msj);
//        $modalContent = $this->cnstrctModal("Registro desactivado.", $msj);
//        $modalContent->getHeader()->setBackground("success");
        return $modalContent;
    }

    /**
     * @since 18-03-15
     * 
     * @param string $action
     * @param string $id
     * @param string $class
     * 
     * @return \GIndie\ScriptGenerator\Bootstrap3\Component\Modal\Content
     * 
     */
    protected function runRecordActionGipActivate($action, $id, $class)
    {
        $record = $class::findById($id);
        $record->run($action);
        $msj = "El registro ha sido activado exitosamente.";
        $modalContent = View\Modal\Content::succcess("Registro activado.", $msj);
//        $modalContent = $this->cnstrctModal("Registro activado.", $msj);
//        $modalContent->getHeader()->setBackground("success");
        return $modalContent;
    }

    /**
     * @since 18-03-15
     * 
     * @param string $action
     * @param string $id
     * @param string $class
     * 
     * @return \GIndie\ScriptGenerator\Bootstrap3\Component\Modal\Content
     * 
     */
    protected function runRecordActionGipDelete($action, $id, $class)
    {
        $record = $class::findById($id);
        $record->run($action);
        $msj = "El registro ha sido eliminado exitosamente.";
        $modalContent = View\Modal\Content::succcess("Registro eliminado.", $msj);
//        $modalContent = $this->cnstrctModal("Registro eliminado.", $msj);
//        $modalContent->getHeader()->setBackground("success");
        return $modalContent;
    }

    /**
     * @since 18-01-24
     * 
     * @param type $action
     * @param type $id
     * @param type $class
     * 
     * @return \GIndie\ScriptGenerator\Bootstrap3\Component\Modal\Content
     * 
     * @edit 18-03-14
     * @edit 18-03-15
     * - Refactor method to runRecordActionGipEdit
     * - Use cnstrctModal()
     */
    protected function runRecordActionGipEdit($action, $id, $class)
    {
        $record = $class::findById($id);
        try {
            $record->run($action);
            $msj = "El registro ha sido actualizado exitosamente.";
            $modalContent = View\Modal\Content::succcess("Registro actualizado.", $msj);
        } catch (\GIndie\Platform\ExceptionMySQL $exc) {
            $msj = \GIndie\Platform\ExceptionMySQL::handleException($exc);
            $modalContent = View\Modal\Content::warning("Error de usuario", $msj);
        }
        return $modalContent;
    }

}
