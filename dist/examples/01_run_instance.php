<?php

/**
 * Platform - 01_run_instance 2017-12-26
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 * 
 * @version GIP.00.00
 * @edit GIP.00.00
 * - Semi functional Platform
 */
$private_folder = realpath("../../../../srvr/mr-sii/private");

require_once realpath("../../../GICommon/src/GIndie/autoloader.php");


require_once "phar://" . $private_folder . '/libsGI/DML.phar/main.php';
require_once "phar://" . $private_folder . '/libsGI/HTML5.phar/main.php';
require_once "phar://" . $private_folder . '/libsGI/HTML5extended.phar/main.php';
require_once "phar://" . $private_folder . '/libsGI/HTML5form.phar/main.php';
require_once "phar://" . $private_folder . '/libsGI/Bootstrap3.phar/main.php';


require_once realpath("../../src/main.php");
require_once 'Config.php';
require_once 'Module.php';
require_once 'Instance.php';



//require_once "phar://" . __DIR__ . '/libsGI/AdminIngresos.phar/main.php';
//require_once "phar://" . __DIR__ . '/libsGI/WebServiceTimbrado.phar/main.php';

echo Instance::run();