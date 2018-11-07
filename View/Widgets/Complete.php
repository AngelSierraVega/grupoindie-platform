<?php

/**
 * GI-Platform-DVLP - Complete
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\View
 *
 * @version 0C.C0
 * @since 18-12-24
 */

namespace GIndie\Platform\View\Widgets;

use GIndie\Platform\View;

/**
 * Description of Complete
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Complete extends Table
{

    /**
     * 
     * @param array $selectors
     * @param array $conditions
     * @param array $params
     * @return \GIndie\Platform\View\Tables\Complete
     * @since 18-12-24
     * @edit 19-01-11
     * - Show footer
     */
    protected function cnstrctTable(array $selectors, array $conditions, array $params)
    {
        $tableView = new View\Tables\Complete($this->modelClassname, true);
        $tableView->readFromDB($selectors, $conditions, $params);
        return $tableView;
    }

}
