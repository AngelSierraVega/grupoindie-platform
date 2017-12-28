<?php
/**
 * WidgetMain
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.01
 */

namespace GIndie\Platform\View;

use GIndie\Platform\View\Widget\Buttons;

/**
 * 
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
     */
    public function __construct(\GIndie\Platform\Model\Record $record,
                                $title = \NULL)
    {
        $this->_record = $record;
        //$record::ICON
        parent::__construct($title !== \NULL ? $title : $record::NAME, \FALSE,
                            $this->tmpContent(), \FALSE);
        $this->setContext(static::$COLOR_SUCCESS);
        $this->addButtonHeading(Buttons::Reload(\urlencode(\get_class($record)),
                                                                      $record->getId()));
        if (\GIndie\Platform\Current::hasRole($record->getValidRolesFor("gip-edit"))) {
            $this->addButtonEdit(\urlencode(\get_class($record)),
                                                       $record->getId());
        }
        if (\GIndie\Platform\Current::hasRole($record->getValidRolesFor("gip-delete"))) {
            $this->addButtonDelete(\urlencode(\get_class($record)),
                                                         $record->getId());
        }
        if (\GIndie\Platform\Current::hasRole($record->getValidRolesFor("gip-state"))) {
            $this->addButtonState($record->getState(),
                                  \urlencode(\get_class($record)),
                                                        $record->getId());
        }
    }

    /**
     * 
     */
    protected function tmpContent()
    {
        $mainRow = new \GIndie\Generator\DML\HTML5\Node("div", \FALSE,
                                                        ["class" => "row"]);
        if (\sizeof($this->_record->getAttributesDisplay()) > 4) {
            $_counter = 0;
            $_size = \intval(\sizeof($this->_record->getAttributesDisplay()));
            $_limit = \intval($_size / 2);
            $_firstCol = new \GIndie\Generator\DML\HTML5\Node("div", \FALSE,
                                                              ["class" => "col-sm-6"]);
            $_secondCol = new \GIndie\Generator\DML\HTML5\Node("div", \FALSE,
                                                               ["class" => "col-sm-6"]);
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
            $singleCol = new \GIndie\Generator\DML\HTML5\Node("div", \FALSE,
                                                              ["class" => "col-xs-12"]);
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

    protected function addButtonEdit($gipClass, $gipActionId = \NULL)
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
