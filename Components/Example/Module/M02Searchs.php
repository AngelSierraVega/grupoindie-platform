<?php

/**
 * GI-Platform-DVLP - M02Searchs
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\Components\Example
 *
 * @version DOING 0A.F3
 * @since 18-11-29
 */

namespace GIndie\Platform\Components\Example\Module;

/**
 * Description of SearchTable
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class M02Searchs extends \GIndie\Platform\Controller\Module
{

    /**
     * {@inheritdoc}
     * @since 18-12-21
     */
    public static function name()
    {
        return "M02Searchs";
    }

    /**
     * {@inheritdoc}
     * @since 18-12-21
     */
    public static function description()
    {
        return "Example 02: @todo";
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
        $this->placeholder("i-i-i")->typeHTMLString("@todo");
    }

    /**
     * {@inheritdoc}
     * @since 19-01-29
     */
    public static function configActions()
    {
//        static::setActionModel("@createTbl01", Tbl01Autoincremented::class, "gip-create");
    }

}
