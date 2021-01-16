<?php

/**
 * GI-Platform-DVLP - Report
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform
 *
 * @version 0C.A0
 * @since 18-11-08
 * @todo Debug file
 */

namespace GIndie\Platform\View\Widgets;

use GIndie\Platform\View;

/**
 * Description of Report
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Report extends Table
{

    /**
     * @since 18-11-08
     */
    protected function cnstrctButtonsDPR()
    {
        return null;
    }

    /**
     * 
     * @param array $selectors
     * @param array $conditions
     * @param array $params
     * @return \GIndie\Platform\View\Tables\Report
     * @since 18-11-07
     */
    protected function cnstrctTable(array $selectors, array $conditions, array $params)
    {
        $tableView = new View\Tables\Report($this->modelClassname);
        $tableView->readFromDB($selectors, $conditions, $params);
        return $tableView;
    }

}
