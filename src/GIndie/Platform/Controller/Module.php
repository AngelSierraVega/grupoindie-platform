<?php

/**
 * GIplatform - Module
 */

namespace GIndie\Platform\Controller;

use GIndie\Generator\DML\HTML5;
use GIndie\Generator\DML\HTML5\Bootstrap3ToDeprecate;
use GIndie\Platform\Model\Datos\mr_sesion;
use GIndie\Platform\View\Widget;
use \GIndie\ScriptGenerator\Bootstrap3;

/**
 * Description of Module
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 * @version GIP.00.00 17-05-23
 * @version GIP.00.0?
 * @edit GIP.00.07
 * @edit GIP.00.08 18-03-05
 * - Created widgetTableFromModel()
 */
abstract class Module extends Platform implements ModuleINT
{

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
     * @param type $_classname
     * @param array $_searchColumns
     * @param array $_params
     * @param array $buttons
     * @return \GIndie\Platform\View\Widget
     * @edit 18-03-12
     * - Se agregó código para separar los inputs y sus errores en filas
     */
    protected function widgetTableSearch($_classname, array $_searchColumns, array $_params = [],
                                         array $buttons = [])
    {
        $record = $_classname::RelatedRecord();
        $record::instance();
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

        $searchButton = \GIndie\Platform\View\Widget\Buttons::CustomPrimary("<span class=\"glyphicon glyphicon-search\"></span>", \NULL, \NULL, \FALSE, \NULL);
        $searchButton->setForm($form->getId());
        $widget->addButtonHeading($searchButton);
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
     * @since GIP.00.08
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

    //use \GIndie\Platform\WidgetsDefinition;

    /**
     * @version     GIP.00.02
     * @since       2017-04-23
     * @var         string 
     */
    const NAME = "UnnamedModule";

    /**
     * Define los <b>roles</b> requeridos para accesar al módulo.
     * @since GIP.00.03
     * @var array 
     */
    //const REQUIRED_ROLES = [];
//    public static function RequiredRoles()
//    {
//        return ["AS"];
//    }

    /**
     * @version     GIP.00.03
     * @since       2017-04-21
     */
    public function __construct()
    {
        $this->config();
        //$this->_placeholder = $this->WidgetsDefinition;
    }

    /**
     * [description]
     * @abstract
     * @version     GIP.00.03
     * @since       2017-04-28
     */
    abstract public function config();

    /**
     * @since GIP.00.06
     * @param string $placeholderId
     * @return \GIndie\Platform\Controller\Module\Placeholder
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
     * @deprecated since GIP.00.06
     * @version GIP.00.05
     * @var string $widgetPlaceholder
     * @return \GIndie\Platform\Controller\Module\Placeholder
     */
    public function configPlaceholder($placeholderId)
    {
        return static::placeholder($placeholderId);
    }

    /**
     * @version     GIP.00.04
     * @since       2017-04-28
     * @var array 
     */
    private $_placeholder = [];

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

    /**
     * @final
     * 
     * @todo        error handling
     * 
     * @version     GIP.00.04
     * @since       2017-04-21
     *          
     * @param       string $widgetPlaceholder
     * @return      null|\GIndie\Platform\Controller\Main\WidgetInterface
     */
    public function getWidget($placeholderid)
    {
        //var_dump($widgetPlaceholder);
        if (\array_key_exists($placeholderid, $this->_placeholder)) {
            return $this->_placeholder[$placeholderid];
        } else {
            return NULL;
        }
    }

    /**
     * @param type $id
     * @param type $class
     * @param type $selected
     * 
     * @since GIP.00.07
     * 
     * @return null|\GIndie\Platform\Controller\Main\WidgetInterface
     */
    protected function widgetReload($id, $class, $selected)
    {
        $placeholder = \GIndie\Platform\Current::Module()->getWidget($id);
        $placeholder = $placeholder->call($selected);
        return $placeholder;
    }

    /**
     * 
     * @param type $class
     * @return \GIndie\Platform\View\TablePagination
     */
    protected function tableSearch($class)
    {
        $table = new \GIndie\Platform\View\TablePagination($this->_searchTable($class));
        return $table;
    }
    
    /**
     * @since 17-??-??
     * @param string $class
     * @return \GIndie\Platform\View\Table
     */
    protected function _searchTable($class)
    {
        $record = $class::RelatedRecord();
        $searchArray = [];
        foreach ($record::getAttributeNames() as $attrName) {
            if (\array_key_exists($attrName, $_POST)) {
                $this->searchValues[$class][$attrName] = $_POST[$attrName];
                switch ($record::getAttribute($attrName)->getType())
                {
                    case \GIndie\Platform\Model\Attribute::TYPE_DATE:
                        $tmp = \explode(" a ", $_POST[$attrName]);
                        if (sizeof($tmp) > 1) {
                            $searchArray[] = $attrName . ">='$tmp[0]'";
                            $searchArray[] = $attrName . "<='" . $tmp[1] . ' 23:59:59' . "'";
                            //
                        } else {
                            $searchArray[] = $attrName . " LIKE '%" . $_POST[$attrName] . "%'";
                        }
                        break;
                    case \GIndie\Platform\Model\Attribute::TYPE_TIMESTAMP:
                        $tmp = \explode(" a ", $_POST[$attrName]);
                        if (sizeof($tmp) > 1) {
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
            $searchArray = \join(" AND ", $searchArray);
            $_table = new $class([$searchArray]);
        } else {
            $_table = new $class([]);
        }
        //$_table->addContent($class);
        return $_table;
    }

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
            //$_table = $this->_searchTable($class);
            //return new \GIndie\Platform\View\TablePagination($_table);
            //return new \GIndie\Platform\View\Table($_table);
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
                return static::_recordModalForm($action, $id, $class);
            case "gip-create":
            case "gip-edit":
            case "gip-delete":
            case "gip-activate":
            case "gip-deactivate":
                return static::actionHandlerRecord($action, $id, $class);
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
     * @edit 18-03-16
     * - Handler for form on non editable record
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
            
            $modalContent = new Bootstrap3ToDeprecate\Component\Modal\Content("Registro actualizado.");
            $modalContent->addContent("El registro ha sido actualizado exitosamente.");
            $modalContent->addFooterButton($btnDismiss);
            //$script = "$('#gip-modal .modal-content').html('{$modalContent}');";
            //$script .= "triggerParents('".$_POST["gip-id-placeholder"]."','".$record->getId()."');";
            //$response->addScript($script);
        } catch (\GIndie\Platform\ExceptionMySQL $exc) {
            $msj = \GIndie\Platform\ExceptionMySQL::handleException($exc);
            $modalContent = new Bootstrap3ToDeprecate\Component\Modal\Content("Error de usuario", $msj);
            $modalContent->addFooterButton($btnDismiss);
            //$response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
        }
        return $modalContent;
        //return $response;
    }

/**
     * @since 18-03-13
     */
    use Module\ToUpgrade;

/**
     * @since 18-03-13
     */
    use Module\ToDeprecate;

    

}
