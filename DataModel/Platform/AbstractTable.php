<?php

/**
 * GI-Platform-DVLP - AbstractTable
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\DataModel
 *
 * @version 0D.10
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
    const SCHEMA = "grupoind_pltfrm";

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
