<?php

/**
 * GI-Platform-DVLP - ExceptionMySQL
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform
 *
 * @version 0D.50
 * @since 17-12-26
 */

namespace GIndie\Platform;

/**
 * Description of INIHandler
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @edit 17-12-26
 * - Extended class from \GIndie\INIHandler
 * - Added required methods: fileName(), pathToFile(), requiredVars()
 * @edit 17-12-26
 * - Updated method requiredVars()
 * @edit 18-01-16
 * @edit 18-01-23
 * - Updated requiredVars()
 * @edit 23-05-14
 * - Removed unnecesary requierements for vars
 */
class INIHandler extends \GIndie\INIHandler
{

    /**
     * 
     * @since 17-12-26
     * @return string
     */
    public static function fileName()
    {
        return "Config";
    }

    /**
     * 
     * @since 17-12-26
     * @return string
     * @deprecated since 18-01-16
     *     public static function pathToFile()
      {
      return __DIR__ . "/" . static::fileName() . ".ini";
      }
     */

    /**
     * 
     * @since 17-12-26
     * @return array
     * @edit 18-01-23
     * @edit 23-05-14
     */
    public static function requiredVars()
    {
        return [
            "Config" => ["host", "assets_url"],
//            "Instance" => ["logo"],
            //"Vendor" => ["logo", "url"],
//            "PHPMailer" => ["SMTPDebug", "Host","Port","Username","Password","FromName"]
        ];
    }

}
