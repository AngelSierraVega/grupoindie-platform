<?php

/**
 * GI-Platform-DVLP - Roles
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2019 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\Module
 *
 * @version 0B.00
 * @since 19-02-15
 */

namespace GIndie\Platform\Module;

/**
 * Description of Roles
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Roles extends \GIndie\Platform\Controller\Module
{

    /**
     * {@inheritdoc}
     * @since 19-02-15
     */
    public static function name()
    {
        return "Roles";
    }

    /**
     * {@inheritdoc}
     * @since 19-02-15
     */
    public static function description()
    {
        return "@todo";
    }

    /**
     * {@inheritdoc}
     * @since 19-02-15
     */
    public function configPlaceholders()
    {
        $this->placeholder("wdgtRoles");
    }

    /**
     * 
     * @return \GIndie\Platform\View\Widgets\Table
     * @since 19-02-15
     */
    public function wdgtRoles()
    {
        $rtnWidget = new \GIndie\Platform\View\Widgets\Table(\GIndie\Platform\DataModel\Platform\Role::class);
        return $rtnWidget;
    }

    /**
     * {@inheritdoc}
     * @since 19-02-15
     */
    public static function configActions()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     * @since 19-02-15
     */
    public static function requiredRoles()
    {
        return ["AS"];
    }

}
