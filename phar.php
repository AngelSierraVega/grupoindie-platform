<?php

/**
 * Platform - phar
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 */

/**
 * Crea un archivo phar
 * @version GIP.00.00 17-12-27
 * @version GI-CMMN.00.01
 * - Copia desde GICommon
 */
$srcRoot = __DIR__ . "/src/GIndie/Platform";
$buildRoot = __DIR__ . "/dist";
$phar = new Phar($buildRoot . '/Platform.phar', 0, 'Platform.phar');
$Directory = new RecursiveDirectoryIterator($srcRoot, FilesystemIterator::SKIP_DOTS);
$Iterator = new RecursiveIteratorIterator($Directory);
$phar->buildFromIterator($Iterator, $srcRoot);
$phar->setStub($phar->createDefaultStub('autoloader.php'));
echo "Archivo phar (/dist/Platform.phar) creado con éxito";