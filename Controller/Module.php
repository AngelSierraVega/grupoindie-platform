<?php

/**
 * Description of Module
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\Controller\Instance\Module
 * 
 * @version 0C.13
 * @since 17-05-23
 */

namespace GIndie\Platform\Controller;

use GIndie\ScriptGenerator\HTML5;
use GIndie\ScriptGenerator\Bootstrap3;
use GIndie\Platform\Model;
use GIndie\Platform\View;

/**
 * @edit 18-03-05
 * - Created widgetTableFromModel()
 * @edit 18-05-21
 * - Use Module\Deprecated;
 */
abstract class Module extends Platform implements ModuleINT
{

    /**
     * @since 18-03-13
     * @edit 18-03-14
     * @edit 18-05-21
     */
    use Module\ToUpgrade;
    use Module\ToDeprecate;
    use Module\Upgrading;
    use Module\Deprecated;

    /**
     * @param string $placeholderId
     * @return \GIndie\Platform\Controller\Module\Placeholder
     * @since 18-03-30
     */
    public function placeholder($placeholderId)
    {
        if (!isset($this->_placeholder[$placeholderId]))
            $this->_placeholder[$placeholderId] = new \GIndie\Platform\Controller\Module\Placeholder();
        $rnt = &$this->_placeholder[$placeholderId];
        return $rnt;
    }

    /**
     * @since 18-04-01
     * @return \GIndie\ScriptGenerator\Bootstrap3\Component\Alert
     */
    public static function cnstrctLoadingMsj()
    {
        return Bootstrap3\Component\Alert::info("Cargando contenido por favor espere...");
    }

    /**
     * @since 17-04-23
     * @var string 
     */
    const NAME = "UnnamedModule";

    /**
     * @since 17-04-21
     */
    public function __construct()
    {
        $this->config();
    }

    /**
     * 
     * @param type $record
     * @param type $gipAction
     * @param type $uniqueToken
     * @param type $customTarget
     * @return \GIndie\Platform\View\Form
     * @since 18-06-14
     */
    protected function cnstrctForm($record, $gipAction = null,
                                   $uniqueToken = true, $customTarget = false)
    {
        switch ($gipAction)
        {
            case "form-edit":
            case "form-create":
                $form = new View\Form($record, $uniqueToken, $customTarget);
                break;
            case "form-delete":
            case "form-deactivate":
            case "form-activate":
                $form = new View\Form(null, $uniqueToken, $customTarget);
                break;
        }
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
     * [description]
     * @abstract
     * @since 17-04-28
     */
    abstract public function config();

    /**
     * 
     * @param string $action
     * @return strin|null
     * @since 18-03-14
     */
    public static function getActionName($action)
    {
        $rntValue = null;
        switch ($action)
        {
            case "form-edit":
                $rntValue = "Guardar datos";
                break;
            case "form-create":
                $rntValue = "Crear";
                break;
            case "form-activate":
                $rntValue = "Activar";
                break;
            case "form-delete":
                $rntValue = "Eliminar";
                break;
            case "form-deactivate":
                $rntValue = "Desactivar";
                break;
        }
        return $rntValue;
    }

    /**
     * 
     * @param string $action
     * @return string|null
     * @since 18-03-14
     */
    public static function getActionContext($action)
    {
        $rntValue = null;
        switch ($action)
        {
            case "form-edit":
            case "form-create":
            case "form-activate":
                $rntValue = Bootstrap3\Component\Button::$COLOR_SUCCESS;
                break;
            case "form-delete":
                $rntValue = Bootstrap3\Component\Button::$COLOR_DANGER;
                break;
            case "form-deactivate":
                $rntValue = Bootstrap3\Component\Button::$COLOR_WARNING;
                break;
        }
        return $rntValue;
    }

    /**
     *
     * @var array 
     * @since 18-03-13
     */
    protected $searchValues = [];

    /**
     * 
     * @param type $classname
     * @param type $attribute
     * @return string|null
     * @since 18-03-13
     */
    protected function getSearchValue($classname, $attribute)
    {
        $rntValue = null;
        if (isset($this->searchValues[$classname][$attribute])) {
            $rntValue = $this->searchValues[$classname][$attribute];
        }
        return $rntValue;
    }

    /**
     * 
     * @param string $action
     * @param string $id
     * @param string $class
     * @return \GIndie\ScriptGenerator\Bootstrap3\Component\Modal\Content
     * @edit 18-03-13
     * - Handler for form on non editable record
     * @edit 18-03-14
     * - Return ModalContent
     */
    protected function runRecordForm($action, $id, $class)
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
        //$modalContent = View\Modal\Content::primary($modalTitle, $form);
        $modalContent = $this->cnstrctModal($modalTitle, $form);
        $modalContent->getHeader()->setBackground("primary");
        $btn = new Bootstrap3\Component\Button($actionName,
                                               Bootstrap3\Component\Button::TYPE_SUBMIT);
        $btn->setForm($form->getId())->setValue("Submit");
        $btn->setContext($actionContext);
        $modalContent->addFooterButton($btn);
        return $modalContent;
    }

}
