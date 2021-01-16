<?php

/**
 * GI-Platform-DVLP - Module
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\DataDefinition
 *
 * @version 0D.10
 * @since 17-05-23
 */

namespace GIndie\Platform\DataDefinition;

/**
 * @todo
 * - Upgrade class
 * @edit 18-12-21
 * - Added description()
 * - Moved from Controller\ModuleINT
 * - Renamed from ModuleINT to Module
 */
interface Module
{

    /**
     * Name of the module.
     * 
     * @return string
     * 
     * @since 18-12-21
     */
    public static function name();

    /**
     * Short description of the module.
     * 
     * @return string
     * 
     * @since 18-12-21
     */
    public static function description();

    /**
     * Category of the module.
     * 
     * @return string|null
     * 
     * @since 18-12-21
     */
    public static function category();

    /**
     * Required roles for accessing the module.
     * 
     * @return array
     * 
     * @since 17-05-23
     * @edit 18-12-07
     */
    public static function requiredRoles();

    /**
     * Placeholder configuration.
     * 
     * @since 18-12-07
     */
    public function configPlaceholders();

    /**
     * Defines module actions and help topics
     * 
     * @since 19-01-29
     */
    public static function configActions();
}
