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
use GIndie\Platform\View\Widget;
use GIndie\Platform\Model\Datos\mr_sesion;

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

        $searchButton = \GIndie\Platform\View\Widget\Buttons::CustomSuccess("<span class=\"glyphicon glyphicon-search\"></span>", \NULL, \NULL, \FALSE, \NULL);
        $searchButton->setForm($form->getId());
        $widget->addButtonHeading($searchButton);
        $widget->addContent(\GIndie\Platform\View\Javascript::submitOnChange($form->getId()));
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
    protected function widgetReportFromModel($classname, $params = []){
        if (\is_subclass_of($classname, \GIndie\Platform\Model\Table::class, true)) {
            $rtnWidget = new Widget\WidgetReport(new $classname($params));
            return $rtnWidget;
        }
        \trigger_error($classname . " is not subclass of \GIndie\Platform\Model\Table", \E_USER_ERROR);
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

    /**
     * 
     * @param type $class
     * @return type
     * @since 18-03-30
     */
    protected function cnstrctSearchParamsFromPost($class)
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
        $table = new \GIndie\Platform\View\TablePagination($this->cnstrctTableFromSearch($class));
        return $table;
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
     * Use placeholder() instead
     * @deprecated since GIP.00.06
     * @version GIP.00.05
     * @var string $widgetPlaceholder
     * @return \GIndie\Platform\Controller\Module\Placeholder
     */
    public function configPlaceholder($placeholderId)
    {
        return static::placeholder($placeholderId);
    }

}
