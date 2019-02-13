<?php

/**
 * GI-Platform-DVLP - Table
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\View
 *
 * @version 0C.A7
 * @since 18-11-07
 */

namespace GIndie\Platform\View\Widgets;

use GIndie\Platform\View;
use GIndie\Platform\View\Widget\Buttons;

/**
 * Description of Table
 *
 * @edit 18-11-08
 * - Created $modelClassname, getModelClassname(), cnstrctButtons()
 * - Created cnstrctTable()
 */
class Table extends View\Widget
{

    /**
     *
     * @var \GIndie\Platform\View\Tables\Table
     * @since 17-05-21
     * @edit 18-02-05
     * @edit 18-11-07
     * - Copied from Platform\View\Widget\WidgetTable
     */
    protected $table;

    /**
     * @edit 18-11-07
     * - Copied from Platform\View\Widget\WidgetTable
     * - Upgraded for record class
     * @edit 18-11-08
     * - Exploded content for abstraction
     */
    public function __construct($modelClassname, $selectors = null, array $conditions = [], array $params = [])
    {
        if (!\is_subclass_of($modelClassname, \GIndie\Platform\Model\Record::class)) {
            \trigger_error("recordClass is not subclass of " .
                \GIndie\Platform\Model\Record::class
                . " called in " . \get_called_class(), \E_USER_ERROR);
        }
        $this->modelClassname = $modelClassname;
//        if ($selectors === null) {
//            $selectors = $modelClassname::getSelectorsDisplay();
//        }
        switch (true)
        {

            case ($selectors === null):
                $selectors = $modelClassname::getSelectorsDisplay();
                break;
            case (!\is_array($selectors)):
                \trigger_error("selectors should be array or null "
                    . "called in " . \get_called_class(), \E_USER_ERROR);
                break;
            case (empty($selectors)):
                $selectors = $modelClassname::getSelectorsDisplay();
                break;
            default:
                break;
        }
        $this->table = $this->cnstrctTable($selectors, $conditions, $params);
        parent::__construct($modelClassname::getName(), $this->table);
        $this->cnstrctButtons();
    }

    /**
     *
     * @var string Stores the class name of the current model.
     * @since 18-11-07
     */
    protected $modelClassname;

    /**
     * @since 18-11-07
     * @return string
     */
    public function getModelClassname()
    {
        return $this->modelClassname;
    }

    /**
     * @since 18-11-08
     * @edit 19-03-27
     */
    protected function cnstrctButtons()
    {
        $modelClassname = $this->modelClassname;
        $this->addButtonHeading(Buttons::Reload(null));
//        var_dump();
        switch (true)
        {
            case \is_null($modelClassname::getValidRolesFor("gip-create")):
            case \GIndie\Platform\Current::hasRole($modelClassname::getValidRolesFor("gip-create")):
                $this->addButtonCreate(\urlencode($modelClassname));
                break;
//            default:
//                $this->setContext(static::$COLOR_PRIMARY, true);
//                break;
        }
        $this->setContext(static::$COLOR_PRIMARY, true);
    }

    /**
     * 
     * @param array $selectors
     * @param array $conditions
     * @param array $params
     * @return \GIndie\Platform\View\Tables\Table
     * @since 18-11-07
     */
    protected function cnstrctTable(array $selectors, array $conditions, array $params)
    {
        $tableView = new View\Tables\Table($this->modelClassname);
        $tableView->readFromDB($selectors, $conditions, $params);
        return $tableView;
    }

    /**
     * 
     * @param type $gipClass
     * @param type $gipActionId
     * @edit 18-11-07
     * - Copied from Platform\View\Widget\WidgetTable
     */
    public function addButtonCreate($gipClass, $gipActionId = null)
    {
        $this->addButtonHeading(Buttons::Create($gipClass, $gipActionId));
    }

    /**
     * @since 18-02-05
     * @return \GIndie\Platform\View\Tables\Table
     * @edit 18-11-07
     * - Copied from Platform\View\Widget\WidgetTable
     */
    public function getTable()
    {
        return $this->table;
    }

}
