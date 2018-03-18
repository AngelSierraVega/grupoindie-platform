<?php

/*
 * GIplatform - test
 */

namespace GIndie\Platform\View\Widget;

use GIndie\Platform\View;

/**
 * Description of WidgetTable
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 *  
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.00 17-05-21
 * @version GIP.00.02
 * @edit GIP.00.03 18-02-05
 * - Created getTable()
 * - Renamed vars due to PSR-1 violation.
 */
class WidgetTable extends View\Widget
{

    /**
     *
     * @var \GIndie\Platform\Model\Table 
     * @since GIP.00.00
     * @edit GIP.00.03
     */
    protected $table;

    /**
     * @todo new consctruct from View\Widget
     * @param \GIndie\Platform\Model\Table $table
     * @param type $title
     * @since GIP.00.00
     * @edit 
     *      - Se usa \GIndie\Platform\View\Table para construir el marcado HTML de la tabla.
     * @edit GIP.00.03
     */
    public function __construct(\GIndie\Platform\Model\Table $tableModel, $selectedId = \NULL)
    {
        $this->table = $tableModel;
        $title = $tableModel::Name();
        $tableView = new \GIndie\Platform\View\Table($tableModel, \TRUE, $selectedId);
        parent::__construct($title, $tableView);
        $this->addButtonHeading(Buttons::Reload(\NULL, $selectedId));
        if (\GIndie\Platform\Current::hasRole($tableModel::getValidRolesFor("gip-create"))) {
            $this->setContext(static::$COLOR_PRIMARY, \TRUE);
            $this->addButtonCreate(urlencode($tableModel::RelatedRecord()));
        }
    }

    public function addButtonCreate($gipClass, $gipActionId = \NULL)
    {
        $this->addButtonHeading(Buttons::Create($gipClass, $gipActionId));
    }

    /**
     * @since GIP.00.03
     * @return \GIndie\Platform\Model\Table
     */
    public function getTable()
    {
        return $this->table;
    }

}
