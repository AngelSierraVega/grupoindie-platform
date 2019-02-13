<?php

/**
 * GI-Platform-DVLP - 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\View
 * 
 * @version 0C.A0
 * @since 
 */

namespace GIndie\Platform\View;

use GIndie\Platform\View\Widget\Buttons;
use GIndie\ScriptGenerator\HTML5\Category\StylesSemantics;

/**
 * @edit 18-10-22
 */
class WidgetMain extends Widget
{

    /**
     *
     * @var \GIndie\Platform\Model\Record 
     */
    protected $_record;

    /**
     * 
     * @param \GIndie\Platform\Model\Record $record
     * @param string $title
     * @edit 18-10-22
     * - Default color: $COLOR_PRIMARY
     * @edit 19-02-01
     * - Create heading-body in widget
     */
    public function __construct(\GIndie\Platform\Model\Record $record, $title = \NULL)
    {
        $this->_record = $record;
        //$record::ICON
        parent::__construct($title !== \NULL ? $title : $record::NAME, true, $this->tmpContent(), true);
        $this->setContext(static::$COLOR_PRIMARY);
        $this->addButtonHeading(Buttons::Reload(\urlencode(\get_class($record)), $record->getId()));
        if (\GIndie\Platform\Current::hasRole($record->getValidRolesFor("gip-edit"))) {
            $this->addButtonEdit(\urlencode(\get_class($record)), $record->getId());
        }
        if (\GIndie\Platform\Current::hasRole($record->getValidRolesFor("gip-delete"))) {
            $this->addButtonDelete(\urlencode(\get_class($record)), $record->getId());
        }
        if (\GIndie\Platform\Current::hasRole($record->getValidRolesFor("gip-state"))) {
            $this->addButtonState($record->getState(), \urlencode(\get_class($record)), $record->getId());
        }
    }
    
    /**
     * 
     * @return mixed
     * @since 18-12-11
     */
    public function getRecord(){
        return $this->_record;
    }

    /**
     * @edit 18-03-23
     * - Updated div libs
     */
    protected function tmpContent()
    {
        $data = [];
        foreach ($this->_record->getAttributesDisplay() as $attrName) {
            $data[$this->_record->getLabelOf($attrName).""] = $this->_record->getDisplayOf($attrName)."";
        }
        $table = \GIndie\Framework\View\Table::displayArray($data,null,100)->setAttribute("style","font-size:medium;");
        $table->addClass("table-condensed");
        return $table;
        $mainRow = StylesSemantics::div(null, ["class" => "row"]);
//        $mainRow = new \GIndie\Generator\DML\HTML5\Node("div", \FALSE,
//                                                        ["class" => "row"]);
        if (\sizeof($this->_record->getAttributesDisplay()) > 4) {
            $_counter = 0;
            $_size = \intval(\sizeof($this->_record->getAttributesDisplay()));
            $_limit = \intval($_size / 2);
            $_firstCol = StylesSemantics::div(null, ["class" => "col-sm-6"]);
//            $_firstCol = new \GIndie\Generator\DML\HTML5\Node("div", \FALSE,
//                                                              ["class" => "col-sm-6"]);
            $_secondCol = StylesSemantics::div(null, ["class" => "col-sm-6"]);
//            $_secondCol = new \GIndie\Generator\DML\HTML5\Node("div", \FALSE,
//                                                               ["class" => "col-sm-6"]);
            foreach ($this->_record->getAttributesDisplay() as $attrName) {
                $_display = $this->_record->getDisplayOf($attrName);
                switch ($_display)
                {
                    case "":
                        break;
                    default:
                        if ($_counter < $_limit) {
                            $_firstCol->addContent("<dt>" . $this->_record->getLabelOf($attrName) . "</dt>");
                            $_firstCol->addContent("<dd>" . $_display . "</dd>");
                        } else {
                            $_secondCol->addContent("<dt>" . $this->_record->getLabelOf($attrName) . "</dt>");
                            $_secondCol->addContent("<dd>" . $_display . "</dd>");
                        }
                        break;
                }
                $_counter++;
            }
            $mainRow->addContent($_firstCol);
            $mainRow->addContent($_secondCol);
        } else {
            $singleCol = StylesSemantics::div(null, ["class" => "col-xs-12"]);
//            $singleCol = new \GIndie\Generator\DML\HTML5\Node("div", \FALSE,
//                                                              ["class" => "col-xs-12"]);
            foreach ($this->_record->getAttributesDisplay() as $attrName) {
                $_display = $this->_record->getDisplayOf($attrName);
                switch ($_display)
                {
                    case "":
                        break;
                    default:
                        $singleCol->addContent("<dt>" . $this->_record->getLabelOf($attrName) . "</dt>");
                        $singleCol->addContent("<dd>" . $_display . "</dd>");
                        break;
                }
            }
            $mainRow->addContent($singleCol);
        }
        return $mainRow;
    }

    public function addButtonEdit($gipClass, $gipActionId = \NULL)
    {
        $this->addButtonHeading(Buttons::Edit($gipClass, $gipActionId));
    }

    protected function addButtonDelete($gipClass, $gipActionId = \NULL)
    {
        $this->addButtonHeading(Buttons::Delete($gipClass, $gipActionId));
    }

    protected function addButtonState($state, $gipClass, $gipActionId = \NULL)
    {
        if ($state) {
            $this->addButtonHeading(Buttons::Deactivate($gipClass, $gipActionId));
        } else {
            $this->addButtonHeading(Buttons::Activate($gipClass, $gipActionId));
        }
    }

}
