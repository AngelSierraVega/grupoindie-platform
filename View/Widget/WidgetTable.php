<?php

/**
 * GI-Platform-DVLP - 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\View
 *
 * @version 0C.00
 * @since 17-05-21
 */

namespace GIndie\Platform\View\Widget;

use GIndie\Platform\View;

/**
 * @edit 18-02-05 
 * - Created getTable()
 * - Renamed vars due to PSR-1 violation.
 * @edit 18-10-01
 */
class WidgetTable extends View\Widget
{

    /**
     *
     * @var \GIndie\Platform\Model\Table 
     * @since 17-05-21
     * @edit 18-02-05
     */
    protected $table;

    /**
     * @todo new consctruct from View\Widget
     * @param \GIndie\Platform\Model\Table $table
     * @param type $title
     * @since 17-05-21
     * @edit 
     *      - Se usa \GIndie\Platform\View\Table para construir el marcado HTML de la tabla.
     * @edit 18-02-05
     * @edit 18-10-10
     * - Default context success.
     */
    public function __construct(\GIndie\Platform\Model\Table $tableModel, $selectedId = \NULL)
    {
        $this->table = $tableModel;
        $title = $tableModel::Name();
        $tableView = new \GIndie\Platform\View\Table($tableModel, \TRUE, $selectedId);
        parent::__construct($title, $tableView);
        $this->addButtonHeading(Buttons::Reload(null, $selectedId));
        if (\GIndie\Platform\Current::hasRole($tableModel::getValidRolesFor("gip-create"))) {
            $this->setContext(static::$COLOR_PRIMARY, true);
            $this->addButtonCreate(urlencode($tableModel::RelatedRecord()));
        } else {
            $this->setContext(static::$COLOR_SUCCESS, true);
        }
    }

    public function addButtonCreate($gipClass, $gipActionId = \NULL)
    {
        $this->addButtonHeading(Buttons::Create($gipClass, $gipActionId));
    }

    /**
     * @since 18-02-05
     * @return \GIndie\Platform\Model\Table
     */
    public function getTable()
    {
        return $this->table;
    }

}
