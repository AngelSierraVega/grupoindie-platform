<?php

/**
 * GI-Platform-DVLP - AbstractTable
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform
 *
 * @version 0C.70
 * @since 18-08-26
 */

namespace GIndie\Platform\DataModel;

/**
 * Description of AbstractTable
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
abstract class AbstractTable extends \GIndie\Platform\Model\Record
{

    /**
     * 
     * @return string
     * @since 18-08-26
     */
    public static function databaseClassname()
    {
        return \GIndie\Platform\DataModel\TmpDatabasePredial::class;
    }

}
