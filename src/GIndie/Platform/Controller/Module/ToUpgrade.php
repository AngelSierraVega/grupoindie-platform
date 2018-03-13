<?php

/**
 * GI-Platform-DVLP - ToUpgrade
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.00 18-03-13 Empty [class/trait/interface/file] created.
 */

namespace GIndie\Platform\Controller\Module;

use GIndie\Generator\DML\HTML5;
use GIndie\Generator\DML\HTML5\Bootstrap3;

//use GIndie\Platform\Model\Datos\mr_sesion;
//use GIndie\Platform\View\Widget;

/**
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
trait ToUpgrade
{

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
     * - Refactor method and create ToDeprecate alias
     */
    protected function _recordModalForm($action, $id, $class)
    {
        if ($class::IS_VIEW) {
            $class = $class::getClassnameRecord();
        }
        $record = $class::findById($id);
        switch (0)
        {
            case strcmp("form-delete", $action):
            case strcmp("form-deactivate", $action):
            case strcmp("form-activate", $action):
                $form = static::_recordForm(\NULL, $action);
                break;
            default:
                $form = static::_recordForm($record, $action);
                break;
        }
        $form->setAttribute("gip-action-class", $class);
        $form->setAttribute("gip-action-id", $id);
        switch ($action)
        {
            case "form-edit":
                $actionName = "Guardar datos";
                break;
            case "form-create":
                $actionName = "Crear";
                break;
            case "form-activate":
                $actionName = "Activar";
                break;
            case "form-delete":
                $actionName = "Eliminar";
                break;
            case "form-deactivate":
                $actionName = "Desactivar";
                break;
        }
        switch ($action)
        {
            case "form-edit":
            case "form-create":
            case "form-activate":
                $actionContext = Bootstrap3ToDeprecate\Component\Button::$COLOR_SUCCESS;
                break;
            case "form-delete":
                $actionContext = Bootstrap3ToDeprecate\Component\Button::$COLOR_DANGER;
                break;
            case "form-deactivate":
                $actionContext = Bootstrap3ToDeprecate\Component\Button::$COLOR_WARNING;
                break;
        }
        $modalTitle = $actionName . " <b>" .
                $record->getName() . "</b> <i>" .
                $record->getDisplay() . "</i>";
        $modalContent = $this->_modalWrap($modalTitle, $form);
        $btn = new Bootstrap3ToDeprecate\Component\Button($actionName, Bootstrap3ToDeprecate\Component\Button::TYPE_SUBMIT);
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
        $btnDismiss = new Bootstrap3\Component\Button("Cerrar", Bootstrap3\Component\Button::TYPE_BUTTON);
        $btnDismiss->setAttribute("data-dismiss", "modal");
        switch ($action)
        {
            case "gip-create":
                $recordAction = $record->run($action);
                //return "ENTRO";
                if (!\is_string($recordAction)) {

                    $modalContent = new Bootstrap3\Component\Modal\Content("Registro creado con éxito");
                    $modalContent->addFooterButton($btnDismiss);
                    $script = "$('#gip-modal .modal-content').html('{$modalContent}');";
                    //$script .= "triggerInteraction('".$_POST["gip-id-placeholder"]."','".$record->getId()."');";
                    //$script .= "$('#" . $_POST["gip-id-placeholder"] . " .jstree #" . $record->getId() . " a').trigger('click');"; // 
                    $response->addScript($script);
                } else {
                    $modalContent = new Bootstrap3\Component\Modal\Content("Error de usuario", $recordAction);
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
                    $modalContent = new Bootstrap3\Component\Modal\Content("Registro desactivado con éxito");
                    $modalContent->addFooterButton($btnDismiss);
                    $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
                    $response->setAttribute("gip-success");
                } else {
                    $modalContent = new Bootstrap3\Component\Modal\Content("Algo salió mal al intentar desactivar el registro", $recordAction);
                    $modalContent->addFooterButton($btnDismiss);
                    $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
                }
                return $response;
            case "gip-activate"://
                $recordAction = $record->run($action);
                if (!\is_string($recordAction)) {
                    $modalContent = new Bootstrap3\Component\Modal\Content("Registro activado con éxito");
                    $modalContent->addFooterButton($btnDismiss);
                    $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
                    $response->setAttribute("gip-success");
                } else {
                    $modalContent = new Bootstrap3\Component\Modal\Content("Algo salió mal al intentar activar el registro", $recordAction);
                    $modalContent->addFooterButton($btnDismiss);
                    $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
                }
                return $response;

            case "gip-delete":
                $recordAction = $record->run($action);
                if (!\is_string($recordAction)) {
                    $modalContent = new Bootstrap3\Component\Modal\Content("Registro eliminado con éxito");
                    $btnDismiss = new Bootstrap3\Component\Button("Cerrar", Bootstrap3\Component\Button::TYPE_BUTTON);
                    $btnDismiss->setAttribute("data-dismiss", "modal");
                    $modalContent->addFooterButton($btnDismiss);
                    $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
                    $response->setAttribute("gip-success");
                } else {
                    $response->addContent("Algo salió mal al eliminar, es posible que no se pueda eliminar debido a la integridad de la base de datos, inténtenlo de nuevo por favor.");
                    $modalContent = new Bootstrap3\Component\Modal\Content("Algo salió mal.", $recordAction);
                    $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
                }
                return $response;
            default:
                \trigger_error("Unable to run recordAction: gip-action={$action} gip-action-id={$id} gip-action-class={$class}", E_USER_ERROR);
                throw new \Exception("Unable to run.");
                break;
        }
    }

}
