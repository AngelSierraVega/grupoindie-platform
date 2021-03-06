<?php

/**
 * GI-Platform-DVLP - 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\View
 *
 * @version 0C.00
 * @since 17-05-21
 */

namespace GIndie\Platform\View\Widget;

use GIndie\Platform\View;

/**
 * Description of WidgetTableComplete
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @edit 18-02-27
 */
class WidgetTableComplete extends View\Widget
{

    /**
     * @todo new consctruct from View\Widget
     * @param \GIndie\Platform\Model\Table $table
     * @param type $title
     * @since GIP.00.00
     * @edit Angel Sierra Vega <angel.sierra@grupoindie.com>
     *      - Se usa \GIndie\Platform\View\Table para construir el marcado HTML de la tabla.
     */
    public function __construct(\GIndie\Platform\Model\Table $tableModel, $selectedId = \NULL)
    {
        $this->_table = $tableModel;
        $title = $tableModel::Name();
        $tableView = new \GIndie\Platform\View\TableComplete($tableModel, \TRUE, $selectedId);
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

}
