<?php

namespace GIndie\Platform;

/**
 * DVLP-Platform - ProjectHandler
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform
 *
 * @version 0C.A7
 * 
 * @edit 18-02-24
 * - Added code from GI-DBH
 * - Class extends \GIndie\ProjectHandler\AbstractProjectHandler
 * - Added versions()
 */
class ProjectHandler extends \GIndie\ProjectHandler\AbstractProjectHandler
{

    /**
     * 
     * @return string
     * @since 18-05-20
     */
    public static function versions()
    {
        $rtnArray = parent::versions();
        //One
        $rtnArray[\hexdec("0C.00")]["description"] = "Functional project on SII.";
        $rtnArray[\hexdec("0C.00")]["code"] = "One";
        $rtnArray[\hexdec("0C.00")]["threshold"] = "0C.00";
        //One
        $rtnArray[\hexdec("0C.20")]["description"] = "Data model upgrade";
        $rtnArray[\hexdec("0C.20")]["code"] = "One";
        $rtnArray[\hexdec("0C.20")]["threshold"] = "0C.20";

        $rtnArray[\hexdec("0C.60")]["description"] = "Removed deprecated dependency";
        $rtnArray[\hexdec("0C.60")]["code"] = "PGRD-1";
        $rtnArray[\hexdec("0C.60")]["threshold"] = "0C.60";

        $rtnArray[\hexdec("0C.8C")]["description"] = "GOODBAY 2018";
        $rtnArray[\hexdec("0C.8C")]["code"] = "PGRD-2018";
        $rtnArray[\hexdec("0C.8C")]["threshold"] = "0C.8C";
        
        /**
         * 0C.96: DYNMC-HLP
         */
        $rtnArray[\hexdec("0C.96")]["description"] = "Dynamic help";
        $rtnArray[\hexdec("0C.96")]["code"] = "DYNMC-HLP";
        $rtnArray[\hexdec("0C.96")]["threshold"] = "0C.96";
        
         /**
         * 0C.A6: AREACLIE
         */
        $rtnArray[\hexdec("0C.A6")]["description"] = "Platform for GI-MPRSRL-AREACLIE";
        $rtnArray[\hexdec("0C.A6")]["code"] = "AREACLIE";
        $rtnArray[\hexdec("0C.A6")]["threshold"] = "0C.A6";
        
        /**
         * 0C.A7: 191104_AREACLIE
         */
        $rtnArray[\hexdec("0C.A7")]["description"] = "2019-11-04 Platform for GI-MPRSRL-AREACLIE";
        $rtnArray[\hexdec("0C.A7")]["code"] = "191104_AREACLIE";
        $rtnArray[\hexdec("0C.A7")]["threshold"] = "0C.A7";
        
        
        //Two
        $rtnArray[\hexdec("0D.00")]["description"] = "Platform for MMR-PRDL";
        $rtnArray[\hexdec("0D.00")]["code"] = "Two";
        $rtnArray[\hexdec("0D.00")]["threshold"] = "0D.00";
        
        

        $rtnArray[\hexdec("10.00")]["description"] = "";
        $rtnArray[\hexdec("10.00")]["code"] = "FINAL";
        $rtnArray[\hexdec("10.00")]["threshold"] = "10.00";
        \ksort($rtnArray);
        return $rtnArray;
    }

    /**
     * 
     * @return string
     * @since 18-02-24
     * @deprecated since 18-03-18
     */
    public static function autoloaderFilenameDPR()
    {
        return "autoloader.php";
    }

    /**
     * 
     * @return string
     * @since 18-02-24
     */
    public static function pathToSourceCode()
    {
        return \pathinfo(__FILE__, \PATHINFO_DIRNAME) . \DIRECTORY_SEPARATOR;
    }

    /**
     * 
     * @return string
     * @since 18-02-24
     */
    public static function projectName()
    {
        return "Platform";
    }

    /**
     * 
     * @return null
     * @since 18-02-24
     */
    public static function projectNamespace()
    {
        return null;
    }

    /**
     * 
     * @return string
     * @since 18-02-24
     */
    public static function projectVendor()
    {
        return "GIndie";
    }

}
