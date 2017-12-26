<?php

/**
 * Platform - Module 2017-12-26
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 */

/**
 * Description of Module
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @version GIP.00.00 2017-12-26 Class created
 * @edit GIP.00.01
 * - Added code from external project DBHandler
 */
class Module extends \GIndie\Platform\Controller\Module
{

    /**
     * 
     * @since GIP.00.01
     * @return array
     */
    public static function RequiredRoles()
    {
        return ["AS"];
    }

    /**
     * @since GIP.00.01
     */
    const NAME = "NAME";

    /**
     * @since GIP.00.01
     */
    public function config()
    {
        $this->configPlaceholder("i-i-i")->typeHTMLString("THIS MUST APPEAR");
        $this->configPlaceholder("ii-i-i")->typeHTMLString("THIS MUST NOT APPEAR");
    }

    /**
     * @since GIP.00.01
     * @return \GIndie\Platform\View\Widget
     */
    protected function widgetReload($id, $class, $selected)
    {
        $widget = new \GIndie\Platform\View\Widget("Data", false, "MYSQL DATA");
        return $widget;
    }

}
