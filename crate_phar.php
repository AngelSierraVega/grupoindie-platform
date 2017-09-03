<?php

/* 
 * Copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * This software is protected under GNU: you can use, study and modify it
 * but not distribute it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 */

$srcRoot = __DIR__ . "/src";
$buildRoot = __DIR__ . "/dist";
$phar = new Phar($buildRoot.'/Platform.phar', 0, 'Platform.phar');
$Directory = new RecursiveDirectoryIterator($srcRoot,FilesystemIterator::SKIP_DOTS);
$Iterator = new RecursiveIteratorIterator($Directory);
$phar->buildFromIterator($Iterator,$srcRoot);
$phar->setStub($phar->createDefaultStub('main.php'));