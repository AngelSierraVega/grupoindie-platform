<?php

/**
 * Platform - INIHandler
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 */

namespace GIndie\Platform;

/**
 * Description of INIHandler
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @version GIP.00.00 17-12-26 Created class
 * @edit GIP.00.01
 * - Extended class from \GIndie\INIHandler
 * - Added required methods: fileName(), pathToFile(), requiredVars()
 */
class INIHandler extends \GIndie\INIHandler
{
    /**
     * 
     * @since GIP.00.01
     * @return string
     */
    public static function fileName()
    {
        return "Config";
    }

    /**
     * 
     * @since GIP.00.01
     * @return string
     */
    public static function pathToFile()
    {
        return __DIR__ . "/" . static::fileName() . ".ini";
    }

    /**
     * 
     * @since GIP.00.01
     * @return array
     */
    public static function requiredVars()
    {
        return ["app"=>["logo","slogan","assets_fullpath"],"vendor"=>["logo"]];
    }

}
