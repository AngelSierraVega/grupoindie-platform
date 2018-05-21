<?php

/**
 * Platform - autoloader
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform
 * 
 * @version 0C.00
 * @since 17-12-27
 * @edit 18-03-18
 * - Renamed file from autoloader.php to AutoloaderPlatform.php
 */

namespace GIndie\Platform;

/**
 * Autoloader function
 * @edit 18-03-18
 * - Copia desde GICommon
 */
\spl_autoload_register(function($className) {
    switch (\substr($className, 0, (\strlen(__NAMESPACE__) * 1)))
    {
        case __NAMESPACE__:
            $edited = \substr($className, \strlen(__NAMESPACE__) + \strrpos($className, __NAMESPACE__));
            $edited = \str_replace("\\", \DIRECTORY_SEPARATOR, __DIR__ . $edited) . ".php";
            if (\is_readable($edited)) {
                require_once($edited);
            }
    }
});
