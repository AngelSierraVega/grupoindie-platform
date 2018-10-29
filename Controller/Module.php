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
 * @version 0C.A0
 * @since 17-05-23
 */

namespace GIndie\Platform\Controller;

use GIndie\ScriptGenerator\HTML5;
use GIndie\ScriptGenerator\Bootstrap3;
//use GIndie\Platform\Model;
use GIndie\Platform\View;
//use GIndie\Generator\DML\HTML5\Bootstrap3 AS Bootstrap3ToDeprecate;
//use GIndie\Generator\DML\HTML5 AS HTML5ToDeprecate;
use GIndie\Platform\View\Widget;

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
 * @edit 18-11-05
 * - Use of Record instead of Table for some cases
 * - Moved back methods from Module\ToUpgrade
 * - Removed use of deprecated libs
 * - Removed dependency to Straffsa\SII
 * @todo debug use of Record instead of Table
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
    
    /**
     * 
     * @param type $_classname
     * @param array $_searchColumns
     * @param array $_params
     * @param array $buttons
     * @return \GIndie\Platform\View\Widget
     * @edit 18-03-12
     * - Se agregó código para separar los inputs y sus errores en filas
     * @edit 18-04-03
     * - Removed autosubmit
     * @edit 18-11-05
     * - Use of Record instead of Table
     */
    protected function widgetTableSearch($_classname, array $_searchColumns, array $_params = [], array $buttons = [])
    {
//        $record = $_classname::RelatedRecord();
//        $record::instance();
        $record = $_classname::instance();
        $form = new \GIndie\Platform\View\Form(null, false, "#tempContent");
        $form->setAttribute("gip-action", "tableSearch");
        $form->setAttribute("gip-action-class", $_classname);
        //$form->addContent($_classname);
        $size = 0;
        foreach ($_searchColumns as $attribute) {
            if (\is_array($attribute)) {
                foreach ($attribute as $key => $value) {
                    $recordAttr = $record::getAttribute($key);
                    $tmpAttr = \GIndie\Platform\View\Input::constructFromAttribute($recordAttr, $value, \NULL);
                }
            } else {
                if ($record::getAttribute($attribute)) {
                    $recordAttr = $record::getAttribute($attribute);
                    $value = static::getSearchValue($_classname, $attribute);
                    //$value = $_classname;
                    //$value = isset($_POST[$attribute]) ? $_POST[$attribute] : "";
                    $tmpAttr = \GIndie\Platform\View\Input::constructFromAttribute($recordAttr, $value, \NULL);
                } else {
                    \trigger_error($attribute . " not defined in " . $record::SCHEMA . "." . $record::TABLE . " " . $record, \E_USER_ERROR);
                }
            }
            if ($recordAttr->getSize()) {
                $tmpSize = $recordAttr->getSize();
                $tmpSize = \explode("-", $tmpSize);
                $tmpSize = \array_pop($tmpSize);
                $size += (integer) $tmpSize;
                if ($size > 12) {
                    $form->addContent("<div class='row col-xs-12'></div>");
                    $size = (integer) $tmpSize;
                }
            }
            $form->addContent($tmpAttr);
        }
        $widget = new \GIndie\Platform\View\Widget("" . $_classname::Name(), \FALSE, $form, "<div id='tempContent'></div>");
//        $reloadButton = Widget\Buttons::Reload($_classname);
//        $widget->addButtonHeading($reloadButton);

        $searchButton = \GIndie\Platform\View\Widget\Buttons::CustomSuccess("<span class=\"glyphicon glyphicon-search\"></span>", \NULL, \NULL, \FALSE, \NULL);
        $searchButton->setForm($form->getId());
        $widget->addButtonHeading($searchButton);
        //$widget->addContent(\GIndie\Platform\View\Javascript::submitOnChange($form->getId()));
        $widget->addScriptOnDocumentReady("$('#" . $form->getId() . "').submit();");
//        foreach ($buttons as $tmpButton) {
//            $_actionId = $tmpButton["gipActionId"];
//            if (strcmp($_actionId, "gip-selected-id") == 0) {
//                if (isset($_POST["gip-selected-id"])) {
//                    $_actionId = $_POST["gip-selected-id"];
//                    $this->_selectedId = $_actionId;
//                } else {
//                    //this->_selectedId = "NONE";
//                    $_actionId = $this->_selectedId;
//                }
//            }
//            $tmpButton = \GIndie\Platform\View\Widget\Buttons::Custom($tmpButton["context"], $tmpButton["icon"], $tmpButton["gipAction"], $_actionId, $tmpButton["gipModal"], $tmpButton["gipClass"]);
//            $widget->addButtonHeading($tmpButton);
//        }
        $widget->setContext("primary");
        return $widget;
    }

    /**
     * 
     * @param string $classname
     * @param string $params
     * @return \GIndie\Platform\View\Widget\WidgetReport
     * @since 18-03-30
     */
    protected function widgetReportFromModel($classname, $params = [])
    {
        if (\is_subclass_of($classname, \GIndie\Platform\Model\Table::class, true)) {
            $rtnWidget = new Widget\WidgetReport(new $classname($params));
            return $rtnWidget;
        }
        \trigger_error($classname . " is not subclass of \GIndie\Platform\Model\Table", \E_USER_ERROR);
    }

    /**
     * @param string $classname
     * @param array $params
     * @return \GIndie\Platform\View\Widget\WidgetTable
     */
    protected function widgetTableFromModel($classname, $params = [])
    {
        if (\is_subclass_of($classname, \GIndie\Platform\Model\Table::class, true)) {
            $rtnWidget = new Widget\WidgetTable(new $classname($params));
            return $rtnWidget;
        }
        \trigger_error($classname . " is not subclass of \GIndie\Platform\Model\Table", \E_USER_ERROR);
    }

    /**
     * 
     * @param type $class
     * @return type
     * @since 18-03-30
     * @edit 18-11-05
     * - Use of Record instead of Table
     */
    protected function cnstrctSearchParamsFromPost($class)
    {
//        $record = $class::RelatedRecord();
        $record = $class::instance();
        $searchArray = [];
        foreach ($record::getAttributeNames() as $attrName) {
            if (\array_key_exists($attrName, $_POST)) {
                $this->searchValues[$class][$attrName] = $_POST[$attrName];
                switch ($record::getAttribute($attrName)->getType())
                {
                    case \GIndie\Platform\Model\Attribute::TYPE_DATE:
                        $tmp = \explode(" a ", $_POST[$attrName]);
                        if (\sizeof($tmp) > 1) {
                            $searchArray[] = $attrName . ">='$tmp[0]'";
                            $searchArray[] = $attrName . "<='" . $tmp[1] . ' 23:59:59' . "'";
                        } else {
                            $searchArray[] = $attrName . " LIKE '%" . $_POST[$attrName] . "%'";
                        }
                        break;
                    case \GIndie\Platform\Model\Attribute::TYPE_TIMESTAMP:
                        $tmp = \explode(" a ", $_POST[$attrName]);
                        if (\sizeof($tmp) > 1) {
                            $searchArray[] = $attrName . ">='" . \strtotime($tmp[0]) . "'";
                            $searchArray[] = $attrName . "<='" . \strtotime($tmp[1] . " 23:59:59") . "'";
                        } else {
                            $searchArray[] = $attrName . ">='" . \strtotime($_POST[$attrName]) . "'";
                            $searchArray[] = $attrName . "<='" . \strtotime($_POST[$attrName] . " 23:59:59") . "'";
                        }
                        break;
                    default:
                        switch ($_POST[$attrName])
                        {
                            case "":
                            case "NULL":
                                break;
                            case "NOT NULL":
                                $searchArray[] = $attrName . " IS NOT NULL ";
                                break;
                            default:
                                $searchArray[] = $attrName . " LIKE '%" . $_POST[$attrName] . "%'";
                                break;
                        }
                        break;
                }
            }
        }
        if (\sizeof($searchArray) > 0) {
            $searchArray = [\join(" AND ", $searchArray)];
        } else {
            
        }
        return $searchArray;
    }

    /**
     * @since 17-??-??
     * @param string $class
     * @return \GIndie\Platform\View\Table
     * @edit 18-03-20
     * - Renamed from _searchTable to  cnstrctTableFromSearch
     */
    protected function cnstrctTableFromSearch($class)
    {
        $_table = new $class($this->cnstrctSearchParamsFromPost($class));
        return $_table;
    }

    /**
     * @todo error handling
     * 
     * @since 17-04-21
     *          
     * @param string $widgetPlaceholder
     * @return null|\GIndie\Platform\Controller\Main\WidgetInterface
     */
    public function getWidget($placeholderid)
    {
        if (\array_key_exists($placeholderid, $this->_placeholder)) {
            return $this->_placeholder[$placeholderid];
        } else {
            return NULL;
        }
    }

    /**
     * @param string $id
     * @param string $class
     * @param string $selected
     * 
     * 
     * @return null|\GIndie\Platform\Controller\Main\WidgetInterface
     * 
     */
    protected function widgetReload($id, $class, $selected)
    {

        $placeholder = \GIndie\Platform\Current::Module()->getWidget($id);
//        @edit 18-10-19
//        * - Added validation for ModuleInfo
//        if ($this->validateModuleInfo == false) {
//            \trigger_error("wdgtModuleInfo() must be called", \E_USER_ERROR);
//        }
        $placeholder = $placeholder->call($selected);
        return $placeholder;
    }

    /**
     * 
     * @param type $class
     * @return \GIndie\Platform\View\Tables\TablePagination
     * @edit 18-11-05
     * - Use of Record instead of Table
     */
    protected function tableSearch($class)
    {
        $table = new \GIndie\Platform\View\Tables\TablePagination($class);
        $table->readFromDB($class::getSelectorsDisplay(), $this->cnstrctSearchParamsFromPost($class));
        return $table;
    }

    /**
     * @since 2017-04-28
     * @var array 
     */
    private $_placeholder = [];

    /**
     * 
     * @return type
     */
    public function getWidgets()
    {
        return $this->_placeholder;
    }

    /**
     * 
     * @return string Un string de un array asociativo para javascript
     */
    public function fetchMasterSlaves()
    {
        $rtnArray = [];
        foreach ($this->_placeholder as $placeholder => $interface) {
            $tmpSlaves = [];
            foreach ($interface->getSlaves() as $_tmp) {
                $tmpSlaves[] = "" . $_tmp;
            }
            $rtnArray[] = ["" . $placeholder => $tmpSlaves];
        }
        $string = json_encode($rtnArray);
        $string = str_replace("},{", ",", $string);
        $string = substr($string, 0, -1);
        $string = substr($string, 1);
        $string = $string . ";";
        return $string;
    }

}
