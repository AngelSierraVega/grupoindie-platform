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
 * @version 0C.20
 * @since 18-03-30
 */

namespace GIndie\Platform\View\Widget;

use GIndie\Platform\View;
use GIndie\Platform\Model;
use GIndie\Platform\Current;

/**
 * @edit 18-05-20
 */
class WidgetReportSelectable extends View\Widget
{

    /**
     *
     * @var \GIndie\Platform\Model\Table 
     * @since 18-03-30
     */
    protected $_table;

    /**
     * @param \GIndie\Platform\Model\Table $table
     * @since 18-03-30
     */
    public function __construct(Model\Table $tableModel, $selectedId = null)
    {
        $this->_table = $tableModel;
        $title = $tableModel::Name();
        $tableView = new View\Table\ReportSelectable($tableModel);
        parent::__construct($title, $tableView);
        $this->addButtonHeading(Buttons::Reload(null, $selectedId));
        $this->setContext(static::$COLOR_INFO, true);
        if (Current::hasRole($tableModel::getValidRolesFor("gip-create"))) {
            $this->addButtonCreate(urlencode($tableModel::relatedRecord()));
        }
    }

    /**
     * 
     * @param type $gipClass
     * @param type $gipActionId
     * @since 18-03-30
     */
    public function addButtonCreate($gipClass, $gipActionId = null)
    {
        $this->addButtonHeading(Buttons::Create($gipClass, $gipActionId));
    }

}
