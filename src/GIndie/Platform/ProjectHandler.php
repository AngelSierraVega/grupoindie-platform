<?php

namespace GIndie\Platform;

/**
 * DVLP-Platform - ProjectHandler
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.00 18-02-24 Empty class created.
 * @edit GIP.00.01
 * - Added code from GI-DBH
 */
class ProjectHandler extends \GIndie\ProjectHandler
{

    /**
     * 
     * @return string
     * @since GIP.00.01
     */
    public static function autoloaderFilename()
    {
        return "autoloader.php";
    }

    /**
     * 
     * @return string
     * @since GIP.00.01
     */
    public static function pathToSourceCode()
    {
        return \pathinfo(__FILE__, \PATHINFO_DIRNAME) . \DIRECTORY_SEPARATOR;
    }

    /**
     * 
     * @return string
     * @since GIP.00.01
     */
    public static function projectName()
    {
        return "Platform";
    }

    /**
     * 
     * @return null
     * @since GIP.00.01
     */
    public static function projectNamespace()
    {
        return null;
    }

    /**
     * 
     * @return string
     * @since GIP.00.01
     */
    public static function projectVendor()
    {
        return "GIndie";
    }

}
