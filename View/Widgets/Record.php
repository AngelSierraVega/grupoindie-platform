<?php

/**
 * GI-Platform-DVLP - Record
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\View
 *
 * @version 0C.A0
 * @since 18-12-14
 */

namespace GIndie\Platform\View\Widgets;

use GIndie\Platform\View\Widget\Buttons;
use GIndie\ScriptGenerator\HTML5\Category\StylesSemantics;

/**
 * Description of Record
 *
 * 
 */
class Record extends \GIndie\Platform\View\Widget
{

    /**
     *
     * @var \GIndie\Platform\Model\Record 
     * @edit 18-12-14
     * - Copied code from GIndie\Platform\View\WidgetMain
     */
    protected $_record;

    /**
     * 
     * @param \GIndie\Platform\Model\Record $record
     * @param string $title
     * @edit 18-10-22
     * - Default color: $COLOR_PRIMARY
     * @edit 18-12-14
     * - Copied code from GIndie\Platform\View\WidgetMain
     */
    public function __construct(\GIndie\Platform\Model\Record $record, $title = \NULL)
    {
        $this->_record = $record;
        //$record::ICON
        parent::__construct($title !== \NULL ? $title : $record::NAME, \FALSE, $this->tmpContent(),
            true);
        $this->setContext(static::$COLOR_PRIMARY);
        $this->addButtonHeading(Buttons::Reload(\urlencode(\get_class($record)), $record->getId()));
        if (\GIndie\Platform\Current::hasRole($record->getValidRolesFor("gip-edit"))) {
            $this->addButtonEdit(\urlencode(\get_class($record)), $record->getId());
        }
        if (\GIndie\Platform\Current::hasRole($record->getValidRolesFor("gip-delete"))) {
            $this->addButtonDelete(\urlencode(\get_class($record)), $record->getId());
        }
        if (\GIndie\Platform\Current::hasRole($record->getValidRolesFor("gip-state"))) {
            $this->addButtonState($record->getState(), \urlencode(\get_class($record)),
                $record->getId());
        }
    }

    /**
     * 
     * @return mixed
     * @since 18-12-11
     * @edit 18-12-14
     * - Copied code from GIndie\Platform\View\WidgetMain
     */
    public function getRecord()
    {
        return $this->_record;
    }

    /**
     * @edit 18-03-23
     * - Updated div libs
     * @edit 18-12-14
     * - Copied code from GIndie\Platform\View\WidgetMain
     */
    protected function tmpContent()
    {
        $data = [];
        foreach ($this->_record->getAttributesDisplay() as $attrName) {
            $data[$this->_record->getLabelOf($attrName) . ""] = $this->_record->getDisplayOf($attrName) . "";
        }
        $table = \GIndie\Framework\View\Table::displayArray($data, null, 100)->setAttribute("style",
            "font-size:medium;");
        $table->addClass("table-condensed");
        return $table;
    }

    /**
     * 
     * @param type $gipClass
     * @param type $gipActionId
     * @edit 18-12-14
     * - Copied code from GIndie\Platform\View\WidgetMain
     */
    public function addButtonEdit($gipClass, $gipActionId = \NULL)
    {
        $this->addButtonHeading(Buttons::Edit($gipClass, $gipActionId));
    }

    /**
     * 
     * @param type $gipClass
     * @param type $gipActionId
     * @edit 18-12-14
     * - Copied code from GIndie\Platform\View\WidgetMain
     */
    protected function addButtonDelete($gipClass, $gipActionId = \NULL)
    {
        $this->addButtonHeading(Buttons::Delete($gipClass, $gipActionId));
    }

    /**
     * 
     * @param type $state
     * @param type $gipClass
     * @param type $gipActionId
     * @edit 18-12-14
     * - Copied code from GIndie\Platform\View\WidgetMain
     */
    protected function addButtonState($state, $gipClass, $gipActionId = \NULL)
    {
        if ($state) {
            $this->addButtonHeading(Buttons::Deactivate($gipClass, $gipActionId));
        } else {
            $this->addButtonHeading(Buttons::Activate($gipClass, $gipActionId));
        }
    }

}
