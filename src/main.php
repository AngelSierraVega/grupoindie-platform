<?php

/*
 * Copyright (C) 2016 Angel Sierra Vega. Grupo INDIE.
 *
 * This software is protected under GNU: you can use, study and modify it
 * but not distribute it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 */

namespace GIndie\Platform;

\spl_autoload_register(function($className) {
    $edited = substr($className,
            strlen(__NAMESPACE__) + strrpos($className, __NAMESPACE__));
    $edited = str_replace("\\", "/", __DIR__ . $edited) . ".php";
    if (is_readable($edited)) {
        require_once($edited);
    }
});
require_once __DIR__ . '/main/ExceptionLogin.php';
require_once __DIR__ . '/main/ExceptionMySQL.php';
require_once __DIR__ . '/main/Security.php';
require_once __DIR__ . '/main/ConfigINT.php';
require_once __DIR__ . '/main/Config.php';
require_once __DIR__ . '/main/Current.php';
require_once __DIR__ . '/main/Instance.php';
require_once __DIR__ . '/main/WidgetsDefinition.php';
