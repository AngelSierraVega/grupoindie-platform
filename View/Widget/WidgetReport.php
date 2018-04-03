<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GIndie\Platform\View\Widget;
use GIndie\Platform\View;
/**
 * Description of WidgetReport
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class WidgetReport extends View\Widget
{

    /**
     *
     * @var \GIndie\Platform\Model\Table 
     * @since GIP.00.00
     */
    protected $_table;

    /**
     * @todo new consctruct from View\Widget
     * @param \GIndie\Platform\Model\Table $table
     * @param type $title
     * @since GIP.00.00
     * @edit Angel Sierra Vega <angel.sierra@grupoindie.com>
     *      - Se usa \GIndie\Platform\View\Table para construir el marcado HTML de la tabla.
     */
    public function __construct(\GIndie\Platform\Model\Table $tableModel,
                                $selectedId = \NULL)
    {
        $this->_table = $tableModel;
        $title = $tableModel::Name();
        $tableView = new \GIndie\Platform\View\TableReport($tableModel);
        parent::__construct($title, $tableView);
        $this->addButtonHeading(Buttons::Reload(\NULL, $selectedId));
        $this->setContext(static::$COLOR_INFO, true);
        if (\GIndie\Platform\Current::hasRole($tableModel::getValidRolesFor("gip-create"))) {
            $this->addButtonCreate(urlencode($tableModel::RelatedRecord()));
        }
    }

    public function addButtonCreate($gipClass, $gipActionId = \NULL)
    {
        $this->addButtonHeading(Buttons::Create($gipClass, $gipActionId));
    }

}
