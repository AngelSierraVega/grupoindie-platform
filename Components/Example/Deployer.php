<?php

/**
 * GI-Platform-DVLP - Deployer
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\Components\Example
 *
 * @version 0C.FF
 * @since 18-11-29
 */

namespace GIndie\Platform\Components\Example;

/**
 * Description of Deployer
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Deployer extends \GIndie\DBHandler\Components\Framework\Deployer
{

    /**
     * 
     * @return string|array
     * @since 18-11-29
     */
    protected static function databases()
    {
        return [DataModel\DatabaseTest::getInstance()];
    }

}
