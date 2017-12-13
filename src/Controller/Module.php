<?php

/**
 * GIplatform - Module 2017-05-23
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.0?
 * @lastChange GIP.00.07
 */

namespace GIndie\Platform\Controller;

use \GIndie\Generator\DML\HTML5;
use \GIndie\Generator\DML\HTML5\Bootstrap3;
use \GIndie\Platform\Model\Datos\mr_sesion;

/**
 * Description of Module
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
abstract class Module extends Platform implements ModuleINT
{
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
                $_table = $this->_searchTable($class);
                return new \GIndie\Platform\View\TablePagination($_table);
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
                return static::_recordAction($action, $id, $class);
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

    protected function _recordModalForm($action, $id, $class)
    {
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
                $actionContext = Bootstrap3\Component\Button::$COLOR_SUCCESS;
                break;
            case "form-delete":
                $actionContext = Bootstrap3\Component\Button::$COLOR_DANGER;
                break;
            case "form-deactivate":
                $actionContext = Bootstrap3\Component\Button::$COLOR_WARNING;
                break;
        }
        $modalTitle = $actionName . " <b>" .
                $record->getName() . "</b> <i>" .
                $record->getDisplay() . "</i>";
        $modalContent = $this->_modalWrap($modalTitle, $form);
        $btn = new Bootstrap3\Component\Button($actionName, Bootstrap3\Component\Button::TYPE_SUBMIT);
        $btn->setForm($form->getId())->setValue("Submit");
        $btn->setContext($actionContext);
        $modalContent->addFooterButton($btn);
        return $modalContent;
    }

    protected function _recordAction($action, $id, $class)
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
        if ($tokenValidation === \FALSE) {
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
                    $modalContent = new Bootstrap3\Component\Modal\Content("Hubo un error al intentar crear el registro", $recordAction);
                    $modalContent->addFooterButton($btnDismiss);
                    $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
                }
                return $response;
            case "gip-edit"://gip-deactivate
                $recordAction = $record->run($action);
//                if ($record->run($action)) {
//                    $response->addScript("$('#gip-modal .modal-body').html('Registro actualizado.')");
//                    $response->setAttribute("gip-success");
//                } else {
//                    $response->addContent("Hubo un error al actualizar, intentenlo de nuevo.");
//                }

                if (!\is_string($recordAction)) {
                    $modalContent = new Bootstrap3\Component\Modal\Content("Registro actualizado con éxito");
                    $modalContent->addFooterButton($btnDismiss);
                    $script = "$('#gip-modal .modal-content').html('{$modalContent}');";
                    //$script .= "triggerParents('".$_POST["gip-id-placeholder"]."','".$record->getId()."');";
                    $response->addScript($script);
                    //$response->setAttribute("gip-success");
                } else {
                    $modalContent = new Bootstrap3\Component\Modal\Content("Hubo un error al intentar actualizar el registro", $recordAction);
                    $modalContent->addFooterButton($btnDismiss);
                    //$modalContent = \htmlentities($modalContent);
//                    $modalContent = \addslashes($modalContent);
                    $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
                }

                return $response;
            case "gip-deactivate"://
                $recordAction = $record->run($action);
                if (!\is_string($recordAction)) {
                    $modalContent = new Bootstrap3\Component\Modal\Content("Registro desactivado con éxito");
                    $modalContent->addFooterButton($btnDismiss);
                    $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
                    $response->setAttribute("gip-success");
                } else {
                    $modalContent = new Bootstrap3\Component\Modal\Content("Hubo un error al intentar desactivar el registro", $recordAction);
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
                    $modalContent = new Bootstrap3\Component\Modal\Content("Hubo un error al intentar activar el registro", $recordAction);
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
                    $response->addContent("Hubo un error al eliminar, intentenlo de nuevo.");
                    $modalContent = new Bootstrap3\Component\Modal\Content("Error al eliminar", $recordAction);
                    $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
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
     * @param string $class
     * @return \GIndie\Platform\View\Table
     */
    protected function _searchTable($class)
    {
        $record = $class::RelatedRecord();
        $searchArray = [];
        foreach ($record::getAttributeNames() as $attrName) {
            if (\array_key_exists($attrName, $_POST)) {
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
        return $_table;
    }

}
