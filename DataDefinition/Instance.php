<?php

/**
 * GI-PLTFRM - Instance
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2021 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\DataDefinition
 *
 * @version 0C.B0
 * @since 21-07-04
 */

namespace GIndie\Platform\DataDefinition;

/**
 *
 * @author Angel
 * @edit 23-05-13
 * - Added methods, updated names for consistency, updated visibility
 */
interface Instance {
    
    /**
     * The name of the instance/application
     * 
     * @since 23-05-13
     * @return string
     */
    public static function appName();
    
    /**
     * URL to the app's logo
     */
    public static function urlAppLogo();
    
    /**
     * URL to the vendor's logo
     * 
     * @since 23-05-12
     * @return string
     */
    public static function urlVendorLogo();
    
    /**
     * URL to the vendor's webpage
     * 
     * @since 23-05-12
     * @return string
     */
    public static function urlVendor();
    
    /**
     * Vendor's message
     * 
     * @since 23-05-12
     * @return string
     */
    public static function vendorMessage();
    
    /**
     * Url to the project assets
     * 
     * @since 23-05-14
     * @return string
     */
    public static function urlAssets();
}
