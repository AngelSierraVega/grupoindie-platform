<?php

/**
 * Platform - autoloader
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 */

namespace GIndie\Platform;

/**
 * 
 * @version GIP.00.00 17-12-27
 * @version GI-CMMN.00.01
 * - Copia desde GICommon
 * Autoloader function
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