<?php

/**
 * GI-Platform-DVLP - M01TableAndRecord
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\Components\Example
 *
 * @version 0D.00
 * @since 18-11-29
 */

namespace GIndie\Platform\Components\Example\Module;

use GIndie\Platform\View;
use GIndie\Platform\Components\Example\DataModel;
use GIndie\Platform\Components\Example\DataModel\Tbl01Autoincremented;
use GIndie\Platform\Components\Example\DataModel\Tbl02ForeignKey;

/**
 * Description of TableAndRecord
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class M01TableAndRecord extends \GIndie\Platform\Controller\Module
{

    /**
     * {@inheritdoc}
     * @since 18-12-21
     */
    public static function name()
    {
        return "M01TableAndRecord";
    }

    /**
     * {@inheritdoc}
     * @since 18-12-21
     */
    public static function description()
    {
        return "Example 01 for wdgtTable related to wdgtRecord with foreign key";
    }

    /**
     * {@inheritdoc}
     * @since 18-12-21
     */
    public static function category()
    {
        return "Main interfaces";
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
     * @edit 18-12-16
     * - Added wdgtForeignKey
     */
    public function configPlaceholders()
    {
        $this->placeholder("wdgtTable");
        $this->placeholder("wdgtTable")->setColumnSize(6);
        $this->placeholder("wdgtRecord")->setColumnSize(6);
        $this->placeholder("wdgtForeignKey")->setColumnSize(12);
        $this->placeholder("wdgtTable")->addSlave("wdgtRecord");
        $this->placeholder("wdgtRecord")->addSlave("wdgtForeignKey");
    }

    /**
     * {@inheritdoc}
     * @since 19-01-29
     */
    public static function configActions()
    {
        static::setActionModel("@createTbl01", Tbl01Autoincremented::class, "gip-create");
        static::setActionHelp("@createTbl01", 1, "From: Main interfaces – M01TableAndRecord",
            "M01TableAndRecordAccess");
        static::setActionHelp("@createTbl01", 2,
            "Click on [+] button on widget Tbl01Autoincremented",
            "M01TableAndRecordwdgtTableTbl01Autoincremented");
        static::setActionHelp("@createTbl01", 3, "Fill requested data and click on [Crear]",
            "M01TableAndRecordMdlCreateTbl01Autoincremented");
        static::setActionHelp("@createTbl01", 4, "Close confirmation window",
            "MdlClsCreateRecord");
        static::setActionHelp("@createTbl01", 5, "Validate created data on widget",
            "M01TableAndRecordwdgtTableTbl01Autoincremented");
        static::setActionModel("@editTbl01", Tbl01Autoincremented::class, "gip-edit");
        static::setActionModel("@deleteTbl01", Tbl01Autoincremented::class, "gip-delete");
    }

    /**
     * @since 18-12-08
     * @edit 18-12-14
     * @return \GIndie\Platform\View\Widgets\Table
     */
    public function wdgtTable()
    {
        return new View\Widgets\Table(Tbl01Autoincremented::class);
    }

    /**
     * @since 18-12-08
     * @return \GIndie\Platform\View\Widget
     */
    public function wdgtRecord()
    {
        if (isset($_POST["gip-selected-id"])) {
            $record = Tbl01Autoincremented::findById($_POST["gip-selected-id"]);
        } else {
            $record = Tbl01Autoincremented::instance([]);
        }
        return new View\Widgets\Record($record);
        return new View\Widget("wdgtRecord", false);
    }

    /**
     * @since 18-12-16
     * @return \GIndie\Platform\View\Widgets\Table
     */
    public function wdgtForeignKey()
    {
//        return new View\Widget("wdgtForeignKey", false); 
        return new View\Widgets\Table(Tbl02ForeignKey::class);
    }

}
