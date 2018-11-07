<?php

/**
 * GI-Platform-DVLP - AbstractTable
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\DataModel
 *
 * @version 0D.00
 * @since 18-11-02
 */

namespace GIndie\Platform\DataModel\Platform;

use GIndie\Platform\Model;

/**
 * 
 * @edit 18-11-03
 * - Added SCHEMA
 */
abstract class AbstractTable extends Model\Record
{

    /**
     * @since 18-11-03
     */
    const SCHEMA = "u278724529_t1";

    /**
     * 
     * @return string
     * @since 18-11-02
     */
    public static function databaseClassname()
    {
        return \GIndie\Platform\DataModel\Platform::class;
    }

}
