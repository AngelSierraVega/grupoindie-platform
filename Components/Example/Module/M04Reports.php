<?php

/**
 * GI-Platform-DVLP - M04Reports
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\Components\Example
 *
 * @version DOING 00.F0
 * @since 18-11-29
 */

namespace GIndie\Platform\Components\Example\Module;

use GIndie\Platform\View;
use GIndie\Platform\Components\Example\DataModel;

/**
 * Description of Reports
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class M04Reports extends \GIndie\Platform\Controller\Module
{

    /**
     * {@inheritdoc}
     * @since 18-12-21
     */
    public static function name()
    {
        return "M04Reports";
    }

    /**
     * {@inheritdoc}
     * @since 18-12-21
     */
    public static function description()
    {
        return "Example 0?: @todo";
    }

    /**
     * {@inheritdoc}
     * @since 18-12-07
     */
    public static function requiredRoles()
    {
        return ["AS"];
    }

    /**
     * @since 18-12-07
     */
    public function configPlaceholders()
    {
        $this->placeholder("wdgtTable")->setColumnSize(6);
        $this->placeholder("wdgtReport")->setColumnSize(6);
    }
    
    /**
     * {@inheritdoc}
     * @since 19-01-29
     */
    public static function configActions()
    {
//        static::setActionModel("@createTbl01", Tbl01Autoincremented::class, "gip-create");
    }

    public function wdgtTable()
    {
        $rtnWidget = new View\Widgets\Table(DataModel\Tbl02ForeignKey::class);
        return $rtnWidget;
    }

    public function wdgtReport()
    {
//        $rtnWidget= new View\Widget(true, true, true, true, true);
        $classname = DataModel\Tbl02ForeignKey::class;
//        $table = new View\Tables\Table($classname);
//        $table->readFromDB($selectors, $conditions, $params);
//        $rtnWidget->getHeadingBody()->addContent($table);
        $rtnWidget = new View\Widgets\Report($classname);
//        $rtnWidget = new View\Widgets\Table($classname);
        return $rtnWidget;
    }

}
