<?php

namespace GIndie\Platform\Controller\Module;

use GIndie\ScriptGenerator\HTML5;
use GIndie\ScriptGenerator\Bootstrap3;
use GIndie\Generator\DML\HTML5\Bootstrap3 AS Bootstrap3ToDeprecate;
use GIndie\Generator\DML\HTML5 AS HTML5ToDeprecate;
use GIndie\Platform\View;

/**
 * GI-Platform-DVLP - Upgrading
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.00 18-03-14 Empty [class/trait/interface/file] created.
 */
trait Upgrading
{

    /**
     * 
     * @param type $record
     * @param type $gipAction
     * @param type $uniqueToken
     * @param type $customTarget
     * @return \GIndie\Platform\View\Form
     * @since 18-06-14
     */
    protected function cnstrctForm($record, $gipAction = null, $uniqueToken = true, $customTarget = false)
    {
        $form = new View\Form($record, $uniqueToken, $customTarget);
        switch ($gipAction)
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
            case null:
                break;
            default:
                $form->setAttribute("gip-action", $gipAction);
                \trigger_error("To verify", \E_USER_WARNING);
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
     * @edit 18-03-13
     * - Handler for form on non editable record
     * @todo
     * - Return ModalContent
     */
    protected function runFormRequest($action, $id, $class)
    {
        if ($class::IS_VIEW) {
            $class = $class::getClassnameRecord();
        }
        $record = $class::findById($id);
        $form = $this->cnstrctForm($record, $action);
        $form->setAttribute("gip-action-class", $class);
        $form->setAttribute("gip-action-id", $id);
        $actionName = static::getActionName($action);
        $actionContext = static::getActionContext($action);
        $modalTitle = $actionName . " <b>" .
                $record->getName() . "</b> <i>" .
                $record->getDisplay() . "</i>";
        $modalContent = $this->cnstrctModal($modalTitle, $form);
        $modalContent->getHeader()->setBackground("primary");
        $btn = new Bootstrap3\Component\Button($actionName, Bootstrap3\Component\Button::TYPE_SUBMIT);
        $btn->setForm($form->getId())->setValue("Submit");
        $btn->setContext($actionContext);
        $modalContent->addFooterButton($btn);
        return $modalContent;
    }

    /**
     * 
     * @param type $action
     * @param type $id
     * @param type $class
     * @return type
     * @throws \Exception
     * @todo
     * - Explode content into smaller methods
     * - Refactor recordActionHandler ???? (no)
     */
    protected function actionHandlerRecord($action, $id, $class)
    {
        if (!isset($_POST["gip-token"])) {
            $response = HTML5\Category\StylesSemantics::Span();
            $response->addScript("$('#gip-modal .modal-content').html('Falló validación de token único en formulario.')");
            $response->setAttribute("gip-error");
            return $response;
        }
        $record = $class::findById($id);
        $response = HTML5\Category\StylesSemantics::Span();
        $tokenValidation = \GIndie\Platform\Current::uniqueTokenValidate($_POST["gip-token"]);
        if (!$tokenValidation) {
            $response->addScript("$('#gip-modal .modal-body').html('Falló validación de token')");
            $response->setAttribute("gip-error");
            return $response;
        }
        //$recordAction = $record->run($action);
        //if ($recordAction !== \FALSE) {
        $btnDismiss = new Bootstrap3ToDeprecate\Component\Button("Cerrar", Bootstrap3ToDeprecate\Component\Button::TYPE_BUTTON);
        $btnDismiss->setAttribute("data-dismiss", "modal");
        switch ($action)
        {
            case "gip-create":
                $recordAction = $record->run($action);
                //return "ENTRO";
                if (!\is_string($recordAction)) {

                    $modalContent = new Bootstrap3ToDeprecate\Component\Modal\Content("Registro creado con éxito");
                    $modalContent->addFooterButton($btnDismiss);
                    $script = "$('#gip-modal .modal-content').html('{$modalContent}');";
                    //$script .= "triggerInteraction('".$_POST["gip-id-placeholder"]."','".$record->getId()."');";
                    //$script .= "$('#" . $_POST["gip-id-placeholder"] . " .jstree #" . $record->getId() . " a').trigger('click');"; // 
                    $response->addScript($script);
                } else {
                    $modalContent = new Bootstrap3ToDeprecate\Component\Modal\Content("Error de usuario", $recordAction);
                    $modalContent->addFooterButton($btnDismiss);
                    $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
                }
                return $response;
            case "gip-edit":
                $modalContent = $this->recordActionGipEdit($action, $id, $class);
                $response = HTML5\Category\StylesSemantics::Span();
                $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
                return $response;
            case "gip-deactivate"://
                $recordAction = $record->run($action);
                if (!\is_string($recordAction)) {
                    $modalContent = new Bootstrap3ToDeprecate\Component\Modal\Content("Registro desactivado con éxito");
                    $modalContent->addFooterButton($btnDismiss);
                    $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
                    $response->setAttribute("gip-success");
                } else {
                    $modalContent = new Bootstrap3ToDeprecate\Component\Modal\Content("Algo salió mal al intentar desactivar el registro", $recordAction);
                    $modalContent->addFooterButton($btnDismiss);
                    $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
                }
                return $response;
            case "gip-activate"://
                $recordAction = $record->run($action);
                if (!\is_string($recordAction)) {
                    $modalContent = new Bootstrap3ToDeprecate\Component\Modal\Content("Registro activado con éxito");
                    $modalContent->addFooterButton($btnDismiss);
                    $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
                    $response->setAttribute("gip-success");
                } else {
                    $modalContent = new Bootstrap3ToDeprecate\Component\Modal\Content("Algo salió mal al intentar activar el registro", $recordAction);
                    $modalContent->addFooterButton($btnDismiss);
                    $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
                }
                return $response;

            case "gip-delete":
                $recordAction = $record->run($action);
                if (!\is_string($recordAction)) {
                    $modalContent = new Bootstrap3ToDeprecate\Component\Modal\Content("Registro eliminado con éxito");
                    $btnDismiss = new Bootstrap3ToDeprecate\Component\Button("Cerrar", Bootstrap3ToDeprecate\Component\Button::TYPE_BUTTON);
                    $btnDismiss->setAttribute("data-dismiss", "modal");
                    $modalContent->addFooterButton($btnDismiss);
                    $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
                    $response->setAttribute("gip-success");
                } else {
                    $response->addContent("Algo salió mal al eliminar, es posible que no se pueda eliminar debido a la integridad de la base de datos, inténtenlo de nuevo por favor.");
                    $modalContent = new Bootstrap3ToDeprecate\Component\Modal\Content("Algo salió mal.", $recordAction);
                    $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
                }
                return $response;
            default:
                \trigger_error("Unable to run recordAction: gip-action={$action} gip-action-id={$id} gip-action-class={$class}", E_USER_ERROR);
                throw new \Exception("Unable to run.");
                break;
        }
    }

    /**
     * @since 18-01-24
     * @param type $action
     * @param type $id
     * @param type $class
     */
    protected function recordActionGipEdit($action, $id, $class)
    {
        $record = $class::findById($id);
        //$response = HTML5\Category\StylesSemantics::Span();
        $btnDismiss = new Bootstrap3ToDeprecate\Component\Button("Cerrar", Bootstrap3ToDeprecate\Component\Button::TYPE_BUTTON);
        $btnDismiss->setAttribute("data-dismiss", "modal");
        try {
            $recordAction = $record->run($action);
            //$modalContent = new Bootstrap3ToDeprecate\Component\Modal\Content("Registro actualizado.");
            $modalContent = new Bootstrap3\Component\Modal\Content("Registro actualizado.");
            $modalContent->getHeader()->setBackground("success");
            $modalContent->addContent("El registro ha sido actualizado exitosamente.");
            $modalContent->addFooterButton($btnDismiss);
            //$script = "$('#gip-modal .modal-content').html('{$modalContent}');";
            //$script .= "triggerParents('".$_POST["gip-id-placeholder"]."','".$record->getId()."');";
            //$response->addScript($script);
        } catch (\GIndie\Platform\ExceptionMySQL $exc) {
            $msj = \GIndie\Platform\ExceptionMySQL::handleException($exc);
            $modalContent = new Bootstrap3\Component\Modal\Content("Error de usuario", $msj);
            $modalContent->getHeader()->setBackground("warning");
            $modalContent->addFooterButton($btnDismiss);
            //$response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
        }
        return $modalContent;
        //return $response;
    }

}
