<?php

/**
 * GI-Platform-DVLP - SystemLogs
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform
 *
 * @version 0C.80
 * @since 18-11-28
 */

namespace GIndie\Platform\Module;

/**
 * Description of SystemLogs
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class SystemLogs extends \GIndie\Platform\Controller\Module
{

    /**
     * Module name
     * 
     * @since 18-11-28
     */
    const NAME = "System logs";

    /**
     * @since 18-11-28
     */
    public function configPlaceholders()
    {
        $this->placeholder("o-o-o")->typeCallable([$this, "wdgtModuleInfo"]);
        $this->placeholder("i-i-i")->typeCallable([$this, "wdgtLogSearch"]);
    }

    /**
     * 
     * @return \GIndie\Platform\View\Widget
     * @since 18-11-28
     */
    public function wdgtLogSearch()
    {
        $widget = $this->widgetTableSearch(
            \GIndie\Platform\DataModel\Platform\LogUser::class,
            ["pltfrm_cta_fk", "timestamp", "notes"]);
        return $widget;
    }

    /**
     * @return array
     * @since 18-11-28
     */
    public static function requiredRoles()
    {
        return ["AS"];
    }

    /**
     * 
     * @return string
     * @since 18-12-31
     */
    public static function description()
    {
        return "SystemLogs";
    }

    /**
     * 
     * @return string
     * @since 18-12-31
     */
    public static function name()
    {
        return static::NAME;
    }

}
