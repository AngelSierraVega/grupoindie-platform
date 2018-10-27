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
 * @version 0C.17
 * @since 17-05-23
 */

namespace GIndie\Platform\Controller;

use GIndie\ScriptGenerator\HTML5;
use GIndie\ScriptGenerator\Bootstrap3;
use GIndie\Platform\Model;
use GIndie\Platform\View;
use GIndie\Generator\DML\HTML5\Bootstrap3 AS Bootstrap3ToDeprecate;
use GIndie\Generator\DML\HTML5 AS HTML5ToDeprecate;

/**
 * @edit 18-03-05
 * - Created widgetTableFromModel()
 * @edit 18-05-21
 * - Use Module\Deprecated;
 * @edit 18-06-24
 * - runActionSelectRow(), run(): Moved from \GIndie\Platform\Controller\Module.
 * @uses GIndie\Platform\Controller\Module\RunRecordAction
 * @edit 18-10-19
 * - Added wdgtModuleInfo()
 */
abstract class Module extends Platform implements ModuleINT
{

    /**
     * @since 18-03-13
     * @edit 18-03-14
     * @edit 18-05-21
     * @edit 18-06-24
     * - Added Module\RunRecordAction
     */
    use Module\RunRecordAction;
    use Module\ToUpgrade;
    use Module\ToDeprecate;
    use Module\Upgrading;
    use Module\Deprecated;

    /**
     *
     * @var boolean Validates if wdgtModuleInfo() has been called
     */
    private $validateModuleInfo = false;

    /**
     * Placeholder o-o-o. Module info.
     * 
     * @return \GIndie\Platform\View\Widget
     * @since 18-10-19
     * @todo Functional validation
     */
    public function wdgtModuleInfo()
    {
        $this->validateModuleInfo = true;
        $rtnWidget = new View\Widget("<strong>" . static::NAME . ".</strong>", false, false);
        $rtnWidget->setContext("info");
        return $rtnWidget;
    }

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
     * 
     * @param string $action
     * @param string $id
     * @return mixed
     * @since 17-01-05
     * @edit 18-03-15
     * @edit 18-05-20
     * - Handle action @selectRow
     * @edit 18-06-24
     * - Moved token validation funcionality to runRecordAction()
     */
    public function run($action, $id, $class, $selected)
    {
        $this->_createLog($action, $id, $class, $selected);
        switch ($action)
        {
            case "@selectRow":
                return $this->runActionSelectRow($_POST["@placeholderId"], $_POST["@selectedId"]);
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
     * @param string $placeholderId
     * @param string $selectedId
     * @return \GIndie\ScriptGenerator\HTML5\Category\StylesSemantics\Span
     * @since 18-05-20
     */
    protected function runActionSelectRow($placeholderId, $selectedId)
    {
        return HTML5\Category\StylesSemantics::span()->addScriptOnDocumentReady('triggerInteraction("' . $placeholderId . '", "' . $selectedId . '");');
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
    protected function cnstrctForm($record, $gipAction = null, $uniqueToken = true, $customTarget = false)
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
     * @edit 18-07-13
     * - Use View\Modal\Content
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
        $modalContent = View\Modal\Content::defaultModalContent($modalTitle, $form, true);
        $modalContent->getHeader()->setBackground("primary");
        $btn = new Bootstrap3\Component\Button($actionName, Bootstrap3\Component\Button::TYPE_SUBMIT);
        $btn->setForm($form->getId())->setValue("Submit");
        $btn->setContext($actionContext);
        $modalContent->addFooterButton($btn);
        return $modalContent;
    }

}
