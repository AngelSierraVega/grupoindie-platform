<?php
/*
 * Copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * This software is protected under GNU: you can use, study and modify it
 * but not distribute it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 */

namespace GIndie\Platform\View;

use GIndie\Platform\View\Widget\Buttons;

class WidgetMain extends Widget
{

    /**
     *
     * @var \GIndie\Platform\Model\Record 
     */
    protected $_record;

    public function __construct(\GIndie\Platform\Model\Record $record,
                                $title = \NULL)
    {
        $this->_record = $record;
//        $heading = \FALSE, $heading_body = \FALSE,
//            $body =\FALSE, $body_footer = \FALSE, $footer = \FALSE
        parent::__construct($title !== \NULL ? $title : $record::NAME, \FALSE,
                            $this->tmpContent()
                , FALSE);
        $this->setContext(static::$COLOR_SUCCESS);

        $this->addButtonHeading(Buttons::Reload(\urlencode(\get_class($record)),
                                                                      $record->getId()));

//        $this->_record = $record;
//
//        $relatedRecord = $record::RELATED_RECORD;
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
     * @todo Quitar HTML crudo, usar clases.
     * @return string
     */
    protected function tmpContent()
    {
        ob_start();
        ?>
        <div class="media">
            <div class="media-left"> 
                <span class="<?php
                $record = $this->_record;
                echo $record::ICON;
                ?>" aria-hidden="true" style="font-size: 64px;"></span>
            </div> 
            <div class="media-body"> 
                <dl>
                    <?php
                    foreach ($this->_record->getAttributesDisplay() as $attrName) {
                        $_display = $this->_record->getDisplayOf($attrName);
                        switch ($_display)
                        {
                            case "":
                                break;
                            default:
                                echo "<dt>" . $this->_record->getLabelOf($attrName) . "</dt>";
                                echo "<dd>" . $_display . "</dd>";
                                break;
                        }
                    }
                    ?>
                </dl>
            </div>

        </div>
        <?php
        $str = ob_get_contents();
        ob_end_clean();
        return $str;
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
