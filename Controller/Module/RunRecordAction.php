<?php

/**
 * GI-Platform-DVLP - RunRecordAction
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\Controller\Instance\Module
 *
 * @version 0C.1F
 * @since 18-06-24
 */

namespace GIndie\Platform\Controller\Module;

use GIndie\ScriptGenerator\HTML5;
use GIndie\ScriptGenerator\Bootstrap3;
//use GIndie\Platform\Model;
use GIndie\Platform\View;

/**
 *
 * @edit 18-06-24
 * - Added from Upgrading: runRecordAction(), runRecordActionGipCreate(), 
 *   runRecordActionGipDeactivate(), runRecordActionGipActivate(),
 *   runRecordActionGipDelete(), runRecordActionGipEdit()
 * @todo
 * - Upgrade Exception Handling and Modal creation
 */
trait RunRecordAction
{

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
     * @edit 18-06-24
     * - Added token validation funcionality
     */
    protected function runRecordAction($action, $id, $class)
    {
        $response = HTML5\Category\StylesSemantics::Span();
        if (!isset($_POST["gip-token"])) {
            $msj = "Falló validación de token.";
            $modalContent = $this->cnstrctModal("Operación ilegal", $msj);
            $modalContent->getHeader()->setBackground("danger");
            $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
            return $response;
        }
        $tokenValidation = \GIndie\Platform\Current::uniqueTokenValidate($_POST["gip-token"]);
        if (!$tokenValidation) {
            $msj = "Falló validación de token.";
            $modalContent = $this->cnstrctModal("Operación ilegal", $msj);
            $modalContent->getHeader()->setBackground("danger");
            $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
            return $response;
        }
        try {
            switch ($action)
            {
                case "gip-create":
                    $modalContent = $this->runRecordActionGipCreate($action,
                                                                    $id, $class);
                    break;
                case "gip-edit":
                    $modalContent = $this->runRecordActionGipEdit($action, $id,
                                                                  $class);
                    break;
                case "gip-deactivate":
                    $modalContent = $this->runRecordActionGipDeactivate($action,
                                                                        $id,
                                                                        $class);
                    break;
                case "gip-activate":
                    $modalContent = $this->runRecordActionGipActivate($action,
                                                                      $id,
                                                                      $class);
                    break;
                case "gip-delete":
                    $modalContent = $this->runRecordActionGipDelete($action,
                                                                    $id, $class);
                    break;
                default:
                    $msj = "Contacte al administrador del sistema si el problema persiste.";
                    $modalContent = View\Modal\Content::danger("Algo salió mal en la ejecución",
                                                               $msj);
//                    $modalContent = $this->cnstrctModal(, $msj);
//                    $modalContent->getHeader()->setBackground("danger");
                    \trigger_error("Unable to run recordAction: gip-action={$action} gip-action-id={$id} gip-action-class={$class}",
                                   \E_USER_ERROR);
                    break;
            }
        } catch (\GIndie\Platform\ExceptionMySQL $exc) {
            $msj = \GIndie\Platform\ExceptionMySQL::handleException($exc);
            $modalContent = $this->cnstrctModal("Algo salió mal. Error de usuario.",
                                                $msj);
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
        $modalContent = View\Modal\Content::succcess("Registro desactivado.",
                                                     $msj);
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
            $modalContent = View\Modal\Content::succcess("Registro actualizado.",
                                                         $msj);
        } catch (\GIndie\Platform\ExceptionMySQL $exc) {
            $msj = \GIndie\Platform\ExceptionMySQL::handleException($exc);
            $modalContent = View\Modal\Content::warning("Error de usuario", $msj);
        }
        return $modalContent;
    }

}
