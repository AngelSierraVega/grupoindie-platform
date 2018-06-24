<?php

/**
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @package GIndie\Platform\Controller\Instance\Module\Placeholder
 * 
 * @version 0C.30
 * @since 17-09-03
 */

namespace GIndie\Platform\Controller\Module;

use \GIndie\Platform\View\Widget;
use \GIndie\Generator\DML\HTML5\Bootstrap3\Component\Button;
use \GIndie\Platform\Model;

/**
 * 
 * @edit 18-05-21
 * - Created functional typeCallable(), $callable, callCallable()
 * - Updated call
 * @todo
 * - Explode methods into sepparated classes
 */
class Placeholder
{

    /**
     *
     * @var string|null
     * @since 18-05-21
     */
    private $callable;

    /**
     * 
     * @param type $callable
     * @since 18-05-21
     * @return GIndie\Platform\Controller\Module\Placeholder
     */
    public function typeCallable($callable)
    {
        $this->_type = "Callable";
        if (\is_callable($callable) === false) {
            switch (true)
            {
                case \is_string($callable):
                    \trigger_error($callable . " is not callable.",
                                   \E_USER_ERROR);
                    break;
                case \is_array($callable):
                    \trigger_error($callable[1] . " is not callable.",
                                   \E_USER_ERROR);
                    break;
                    \trigger_error("Var not callable.", \E_USER_ERROR);
                    break;
            }
        }
        switch (true)
        {
            case (\is_callable($callable) == false):
        }
        $this->callable = $callable;
        return $this;
    }

    /**
     * @since 18-05-21
     * @return mixed
     */
    private function callCallable()
    {
        return \call_user_func($this->callable);
    }

    /**
     * 
     * @return mixed
     * @edit 18-05-21
     * - Added funcionality for typeCallable
     */
    public function call($id)
    {
        switch ($this->_type)
        {
            case "Callable":
                return $this->callCallable();
            case "HTMLString":
                return $this->_customContent;
                break;
            case "ListDynamic":
                /**
                 * @todo set $this->_customTitle
                 */
                $recordId = $id;
//                if (isset($_POST["gip-selected-id"])) {
//                    $this->_selectedId = $_POST["gip-selected-id"];
//                    $_actionId;
//                }
                $_classname = $this->_dynamicClass;
                $_params = $this->_startParams;
                $_list = new $_classname($_params);
                $widget = new Widget\WidgetList($_list, $recordId);
                foreach ($this->_buttons as $tmpButton) {
                    $_actionId = $tmpButton["gipActionId"];
                    //var_dump($_actionId);
                    if (strcmp($_actionId, "gip-selected-id") == 0) {
                        //var_dump("ENTRO");
                        if (isset($_POST["gip-selected-id"])) {
                            $_actionId = $_POST["gip-selected-id"];
                            //$this->_selectedId = $_actionId;
                        } else {
                            //this->_selectedId = "NONE";
                            //$_actionId = $this->_selectedId;
                        }
                    }
                    $tmpButton = Widget\Buttons::Custom($tmpButton["context"],
                                                        $tmpButton["icon"],
                                                        $tmpButton["gipAction"],
                                                        $_actionId,
                                                        $tmpButton["gipModal"],
                                                        $tmpButton["gipClass"]);
                    $widget->addButtonHeading($tmpButton);
                }
                return $widget;
            case "RecordDynamic":
                //if($this->_record_reco)
                $recordId = $id;
                //$_recordId = $this->_record_recordId;
                if ($id == \NULL) {
                    //$recordId = $this->_record_recordId;
                    return new \GIndie\Platform\View\Widget("Ningún item seleccionado",
                                                            \FALSE, \FALSE);
                    $recordId = $id;
                }
                //var_dump($recordId);

                $_classname = $this->_record_recordClass;
                $_record = $_classname::findById($recordId);
                if (strcmp($_record->getId(), $recordId) == 0) {
                    if ($_record->getId() == "") {
                        return new \GIndie\Platform\View\Widget("Los datos <i><b>" . $_classname::NAME . "</b></i> no existen.",
                                                                \FALSE, \FALSE);
                    }
                    $widget = new \GIndie\Platform\View\WidgetMain($_record,
                                                                   $this->_customTitle);
                    foreach ($this->_buttons as $tmpButton) {
                        $_actionId = $tmpButton["gipActionId"];
                        if (strcmp($_actionId, "gip-selected-id") == 0) {
                            $_actionId = $recordId;
                        }
                        $tmpButton = Widget\Buttons::Custom($tmpButton["context"],
                                                            $tmpButton["icon"],
                                                            $tmpButton["gipAction"],
                                                            $_actionId,
                                                            $tmpButton["gipModal"],
                                                            $tmpButton["gipClass"]);
                        $widget->addButtonHeading($tmpButton);
                    }
                    return $widget;
                }
                $widget = new \GIndie\Platform\View\Widget("<i><b>" . $_classname::NAME . "</b></i> sin definir.",
                                                           \FALSE, \FALSE);
                $tmpButton = Widget\Buttons::Create($_classname);
                $tmpButton->setAttribute("gip-action-id", $recordId);
                $tmpButton->setAttribute("gip-selected-id", $recordId);
                $widget->addButtonHeading($tmpButton);
                $tmpButton = Widget\Buttons::Reload($_classname, $recordId);
                $widget->addButtonHeading($tmpButton);
                return $widget;
            case "ReportSearch":
                $_classname = $this->_dynamicClass;
                $_searchColumns = $this->_columnsSearch;
                $_params = $this->_startParams;
                $record = $_classname::RelatedRecord();
                $record::instance();
                //$record = $record::instance();
                $form = new \GIndie\Platform\View\Form(\NULL, \FALSE,
                                                       "#tempContent");
                $form->setAttribute("gip-action", "reportSearch");
                $form->setAttribute("gip-action-class", $_classname);
                foreach ($_searchColumns as $attribute) {
                    if (\is_array($attribute)) {
                        foreach ($attribute as $key => $value) {
                            $tmpAttr = \GIndie\Platform\View\Input::constructFromAttribute($record::getAttribute($key),
                                                                                                                 $value,
                                                                                                                 \NULL);
                        }
                    } else {
                        $tmpAttr = \GIndie\Platform\View\Input::constructFromAttribute($record::getAttribute($attribute),
                                                                                                             "",
                                                                                                             \NULL);
                    }
                    $form->addContent($tmpAttr);
                }
                //$script = "$(\"#". $form->getId() . "\").validate({debug: false});";
//                $script = "$(\"#". $form->getId() . "\").validate().destroy();";
//                $form->addScript($script);
                //$_table = new $_classname($_params);
                //$_table = new \GIndie\Platform\View\Table($_table);
                $widget = new Widget("Búsqueda", \FALSE, $form,
                                     "<div id='tempContent'></div>");
                $searchButton = Widget\Buttons::CustomPrimary("buscar", \NULL,
                                                              \NULL, \FALSE,
                                                              \NULL);
                $searchButton->setForm($form->getId());
//                $tmpButton = Widget\Buttons::Custom(Widget\Buttons::CustomDanger($icon, $gipAction) $tmpButton["context"],
//                                                        $tmpButton["icon"],
//                                                        $tmpButton["gipAction"],
//                                                        $_actionId,
//                                                        $tmpButton["gipModal"],
//                                                        $tmpButton["gipClass"]);
                $widget->addButtonHeading($searchButton);

                foreach ($this->_buttons as $tmpButton) {
                    $_actionId = $tmpButton["gipActionId"];
                    if (strcmp($_actionId, "gip-selected-id") == 0) {
                        if (isset($_POST["gip-selected-id"])) {
                            $_actionId = $_POST["gip-selected-id"];
                            $this->_selectedId = $_actionId;
                        } else {
                            //this->_selectedId = "NONE";
                            $_actionId = $this->_selectedId;
                        }
                    }
                    $tmpButton = Widget\Buttons::Custom($tmpButton["context"],
                                                        $tmpButton["icon"],
                                                        $tmpButton["gipAction"],
                                                        $_actionId,
                                                        $tmpButton["gipModal"],
                                                        $tmpButton["gipClass"]);
                    $widget->addButtonHeading($tmpButton);
                }
                return $widget;
            case "TableSearch":
                $_classname = $this->_dynamicClass;
                $_searchColumns = $this->_columnsSearch;
                $_params = $this->_startParams;
                $record = $_classname::RelatedRecord();
                $record::instance();
                $form = new \GIndie\Platform\View\Form(\NULL, \FALSE,
                                                       "#tempContent");
                $form->setAttribute("gip-action", "tableSearch");
                $form->setAttribute("gip-action-class", $_classname);
                foreach ($_searchColumns as $attribute) {
                    if (\is_array($attribute)) {
                        foreach ($attribute as $key => $value) {
                            $tmpAttr = \GIndie\Platform\View\Input::constructFromAttribute($record::getAttribute($key),
                                                                                                                 $value,
                                                                                                                 \NULL);
                        }
                    } else {
                        $tmpAttr = \GIndie\Platform\View\Input::constructFromAttribute($record::getAttribute($attribute),
                                                                                                             "",
                                                                                                             \NULL);
                    }
                    $form->addContent($tmpAttr);
                }
                $widget = new Widget("Búsqueda de " . $_classname::Name(),
                                     \FALSE, $form,
                                     "<div id='tempContent'></div>");
//                $searchButton = Widget\Buttons::CustomDefault("<span class=\"glyphicon glyphicon-refresh\"></span>", "widget-reload", \NULL, \FALSE, \NULL);
//                $searchButton->setForm($form->getId());
//                $searchButton = Widget\Buttons::Reload();
//                $widget->addButtonHeading($searchButton);

                $searchButton = Widget\Buttons::CustomPrimary("<span class=\"glyphicon glyphicon-search\"></span>",
                                                              \NULL, \NULL,
                                                              \FALSE, \NULL);
                $searchButton->setForm($form->getId());
                $widget->addButtonHeading($searchButton);

                foreach ($this->_buttons as $tmpButton) {
                    $_actionId = $tmpButton["gipActionId"];
                    if (strcmp($_actionId, "gip-selected-id") == 0) {
                        if (isset($_POST["gip-selected-id"])) {
                            $_actionId = $_POST["gip-selected-id"];
                            $this->_selectedId = $_actionId;
                        } else {
                            //this->_selectedId = "NONE";
                            $_actionId = $this->_selectedId;
                        }
                    }
                    $tmpButton = Widget\Buttons::Custom($tmpButton["context"],
                                                        $tmpButton["icon"],
                                                        $tmpButton["gipAction"],
                                                        $_actionId,
                                                        $tmpButton["gipModal"],
                                                        $tmpButton["gipClass"]);
                    $widget->addButtonHeading($tmpButton);
                }
                return $widget;

                return $widget;
            case "TableReport":
                $_classname = $this->_dynamicClass;
                $_params = $this->_startParams;
                $_table = new $_classname($_params);
                $widget = new Widget\WidgetReport($_table);
                foreach ($this->_buttons as $tmpButton) {
                    $_actionId = $tmpButton["gipActionId"];
                    if (strcmp($_actionId, "gip-selected-id") == 0) {
                        if (isset($_POST["gip-selected-id"])) {
                            $_actionId = $_POST["gip-selected-id"];
                            $this->_selectedId = $_actionId;
                        } else {
                            //this->_selectedId = "NONE";
                            $_actionId = $this->_selectedId;
                        }
                    }
                    $tmpButton = Widget\Buttons::Custom($tmpButton["context"],
                                                        $tmpButton["icon"],
                                                        $tmpButton["gipAction"],
                                                        $_actionId,
                                                        $tmpButton["gipModal"],
                                                        $tmpButton["gipClass"]);
                    $widget->addButtonHeading($tmpButton);
                }
                return $widget;
            case "TableDynamic":
                $_classname = $this->_dynamicClass;
                $_params = $this->_startParams;
                $_table = new $_classname($_params);
                $recordId = $id;
                //$widget = new Widget\WidgetTable($_table, $recordId);
                $widget = new Widget\WidgetTable($_table);
                foreach ($this->_buttons as $tmpButton) {
                    $_actionId = $tmpButton["gipActionId"];
                    if (strcmp($_actionId, "gip-selected-id") == 0) {
                        if (isset($_POST["gip-selected-id"])) {
                            $_actionId = $_POST["gip-selected-id"];
                            $this->_selectedId = $_actionId;
                        } else {
                            //this->_selectedId = "NONE";
                            $_actionId = $this->_selectedId;
                        }
                    }
                    $tmpButton = Widget\Buttons::Custom($tmpButton["context"],
                                                        $tmpButton["icon"],
                                                        $tmpButton["gipAction"],
                                                        $_actionId,
                                                        $tmpButton["gipModal"],
                                                        $tmpButton["gipClass"]);
                    $widget->addButtonHeading($tmpButton);
                }
                return $widget;
            case "TableInstance":
//                return new \GIndie\Platform\View\Widget($this->_customContent,
//                        $this->_customTitle);
                return new Widget\WidgetTable($this->_table_instance,
                                              $this->_customTitle
                );
            case "CustomContent":
                return new \GIndie\Platform\View\Widget($this->_customTitle,
                                                        \FALSE,
                                                        $this->_customContent
                );
            case "Custom":
                $widget = new Widget($this->_instanceOfHeading,
                                     $this->_instanceOfHeadingBody,
                                     $this->_instanceOfBody,
                                     $this->_instanceOfBodyFooter,
                                     $this->_instanceOfFooter);
                foreach ($this->_buttons as $tmpButton) {
                    $_actionId = $tmpButton["gipActionId"];
                    //var_dump($_actionId);
                    if (strcmp($_actionId, "gip-selected-id") == 0) {
                        //var_dump("ENTRO");
                        if (isset($_POST["gip-selected-id"])) {
                            $_actionId = $_POST["gip-selected-id"];
                            $this->_selectedId = $_actionId;
                        } else {
                            //this->_selectedId = "NONE";
                            $_actionId = $this->_selectedId;
                        }
                    }
                    $tmpButton = Widget\Buttons::Custom($tmpButton["context"],
                                                        $tmpButton["icon"],
                                                        $tmpButton["gipAction"],
                                                        $_actionId,
                                                        $tmpButton["gipModal"],
                                                        $tmpButton["gipClass"]);
                    $widget->addButtonHeading($tmpButton);
                }
                return $widget;
                return new Widget($this->_instanceOfHeading,
                                  $this->_instanceOfHeadingBody,
                                  $this->_instanceOfBody,
                                  $this->_instanceOfBodyFooter,
                                  $this->_instanceOfFooter);

            case "RecordInstance":
                return new \GIndie\Platform\View\WidgetMain($this->_record_instance,
                                                            $this->_customTitle);
            case "UNDEFINED":
                \trigger_error("El placeholder no está definido", \E_USER_ERROR);
            default:
                //var_dump( $this->_type);
                trigger_error("Unrecognized type " . $this->_type, E_USER_ERROR);
                throw new Exception("Unrecognized type ");
        }
    }

    /**
     *
     * @var string 
     */
    private $_type = "UNDEFINED";

    /**
     *
     * @var string 
     */
    private $_customContent;

    /**
     * @var string 
     */
    private $_customTitle;

    /**
     * @var string 
     */
    private $_buttons = [];

    /**
     * 
     * 
     */
    public function addButton($context, $icon, $gipAction, $gipActionId = \NULL,
                              $gipModal = \FALSE, $gipClass = \NULL)
    {
        $this->_buttons[] = ["context" => $context,
            "icon" => $icon,
            "gipAction" => $gipAction,
            "gipActionId" => $gipActionId,
            "gipModal" => $gipModal,
            "gipClass" => $gipClass];
    }

    /**
     * 
     * @param mixed $content
     * @return \GIndie\Platform\Controller\Module\WidgetInterface
     */
    public function typeHTMLString($content)
    {
        $this->_customContent = $content;
        $this->_type = "HTMLString";
        return $this;
    }

    private $_instanceOfHeading;
    private $_instanceOfHeadingBody;
    private $_instanceOfBody;
    //private $_instanceOfHeading;
    private $_instanceOfBodyFooter;
    private $_instanceOfFooter;

    /**
     * 
     * @param mixed $content
     * @return \GIndie\Platform\Controller\Module\WidgetInterface
     */
    public function typeCustom($heading = \FALSE, $heading_body = \FALSE,
                               $body = \FALSE, $body_footeer = \FALSE,
                               $footer = \FALSE)
    {
        //$this->_customContent = $content;
        $this->_type = "Custom";
        $this->_instanceOfHeading = $heading;
        $this->_instanceOfHeadingBody = $heading_body;
        $this->_instanceOfBody = $body;
        $this->_instanceOfBodyFooter = $body_footeer;
        $this->_instanceOfFooter = $footer;
        return $this;
    }

    /**
     * 
     * @param mixed $content
     * @return \GIndie\Platform\Controller\Module\WidgetInterface
     */
    public function setTypeCustomContent($content, $title = \FALSE)
    {
        $this->_customContent = $content;
        $this->_type = "CustomContent";
        $this->_customTitle = $title;
        return $this;
    }

    /**
     * @var \GIndie\Platform\Model\Table 
     */
    private $_table_instance;

    /**
     * 
     * @param \GIndie\Platform\Model\Record $record
     * @return \GIndie\Platform\Controller\Module\WidgetInterface
     */
    public function setTypeTableInstance(\GIndie\Platform\Model\Table $table,
                                         $title = \FALSE)
    {
        $this->_table_instance = $table;
        $this->_type = "TableInstance";
        $this->_customTitle = $title;
        return $this;
    }

    /**
     * @var         \GIndie\Platform\Model\Record 
     */
    private $_record_instance;

    /**
     * 
     * @param \GIndie\Platform\Model\Record $record
     * @return \GIndie\Platform\Controller\Module\WidgetInterface
     */
    public function setTypeRecordInstance(\GIndie\Platform\Model\Record $record,
                                          $title = NULL)
    {
        $this->_record_instance = $record;
        $this->_type = "RecordInstance";
        $this->_customTitle = $title;
        return $this;
    }

    /**
     *
     * @var string 
     */
    private $_dynamicClass;

    /**
     *
     * @var array 
     */
    private $_startParams;
    private $_selectedId;

    /**
     * 
     * @param string $class
     * @param array $params
     * @param string $selectedId
     * @return \GIndie\Platform\Controller\Module\WidgetInterface
     */
    public function listSimple($class, $params = [], $selectedId = "NONE")
    {
        if (!\is_subclass_of($class, Model\ListSimple::class, \TRUE)) {
            \trigger_error($class . " no es subtipo de " .
                    Model\ListSimple::class . " en " . get_called_class(),
                           \E_USER_ERROR);
        }
        $this->_dynamicClass = $class;
        $this->_startParams = $params;
        $this->_type = "ListDynamic";
        $this->_selectedId = $selectedId;
        return $this;
    }

    /**
     * @deprecated since
     * @param string $recordClass
     * @param string $recordId
     * @return \GIndie\Platform\Controller\Module\WidgetInterface
     */
    public function typeListDynamic($dynamicClass, $startParams = [],
                                    $title = \NULL, $selectedId = \NULL)
    {
        $this->_dynamicClass = $dynamicClass;
        $this->_startParams = $startParams;
        $this->_type = "ListDynamic";
        $this->_customTitle = $title;
        $this->_selectedId = $selectedId;
        return $this;
    }

    /**
     * 
     * @param string $recordClass
     * @param string $recordId
     * @return \GIndie\Platform\Controller\Module\WidgetInterface
     */
    public function typeTableDynamic($tableClass, $parameters = [],
                                     $title = NULL, $selectedId = \NULL)
    {
        $this->_dynamicClass = $tableClass;
        $this->_startParams = $parameters;
        $this->_type = "TableDynamic";
        $this->_customTitle = $title;
        $this->_selectedId = $selectedId;
        return $this;
    }

    /**
     * 
     * @param       string $recordClass
     * @param       string $recordId
     * @return \GIndie\Platform\Controller\Module\WidgetInterface
     */
    public function typeReport($tableClass, $parameters = [], $title = NULL)
    {
        $this->_dynamicClass = $tableClass;
        $this->_startParams = $parameters;
        $this->_type = "TableReport";
        $this->_customTitle = $title;
        return $this;
    }

    public $_columnsSearch;

    /**
     * 
     * @param       string $recordClass
     * @param       string $recordId
     * @return \GIndie\Platform\Controller\Module\WidgetInterface
     */
    public function typeReportSearch($tableClass, $searchColumns = [],
                                     $parameters = [])
    {
        $this->_dynamicClass = $tableClass;
        $this->_columnsSearch = $searchColumns;
        $this->_startParams = $parameters;
        $this->_type = "ReportSearch";
        return $this;
    }

    /**
     * 
     * @param       string $recordClass
     * @param       string $recordId
     * @return \GIndie\Platform\Controller\Module\WidgetInterface
     */
    public function typeTableSearch($tableClass, $searchColumns = [],
                                    $parameters = [])
    {
        $this->_dynamicClass = $tableClass;
        $this->_columnsSearch = $searchColumns;
        $this->_startParams = $parameters;
        $this->_type = "TableSearch";
        return $this;
    }

    /**
     * 
     * @param       string $recordClass
     * @param       string $recordId
     * @return \GIndie\Platform\Controller\Module\WidgetInterface
     */
    public function typeRecordDynamic($recordClass,
                                      $recordId = "gip-selected-id",
                                      $title = NULL)
    {
        $this->_record_recordClass = $recordClass;
        $this->_record_recordId = $recordId;
        $this->_type = "RecordDynamic";
        $this->_customTitle = $title;
        return $this;
    }

    /**
     *
     * @var array 
     */
    private $_slaves = [];

    /**
     * 
     * @param       string $placeholder
     * @return \GIndie\Platform\Controller\Module\WidgetInterface
     */
    public function addSlave($placeholder)
    {
        $this->_slaves[] = $placeholder;
        return $this;
    }

    /**
     * 
     * @param string $placeholder
     * @return array
     */
    public function getSlaves()
    {
        return $this->_slaves;
    }

}
