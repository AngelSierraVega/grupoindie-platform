<?php

/**
 * GI-Platform-DVLP - Tbl01Autoincremented
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\Components\Example
 *
 * @version 0C.F0
 * @since 18-11-29
 */

namespace GIndie\Platform\Components\Example\DataModel;

use \GIndie\DBHandler\MySQL57\Instance\DataType;

/**
 * Description of Tbl01Autoincremented
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Tbl01Autoincremented extends \GIndie\Platform\Model\Record
{
    
    /**
     * The name of the model
     * 
     * @since 18-12-14
     */
    const NAME = "Tbl01Autoincremented";
    
    /**
     * @since 18-11-29
     */
    const SCHEMA = "pltfrm_xmpl";

    /**
     * @since 18-11-29
     */
    const TABLE = "tbl01_atncrmtnd";

    /**
     * @since 18-11-29
     */
    const DISPLAY_KEY = "vle";

    /**
     * @since 18-11-29
     */
    const CLM_ID = "id";

    /**
     * @since 18-11-29
     */
    const CLM_VALUE = "vle";

    /**
     * @since 18-11-29
     */
    protected static function tableDefinition()
    {
        static::clmnDfntn(static::CLM_ID, DataType::serial());
        static::rfrncDfntn()->setPrimaryKey(static::CLM_ID);
        static::clmnDfntn(static::CLM_VALUE, DataType::char(20));
        static::clmnDfntn(static::CLM_VALUE)->setNotNull();
        static::clmnDfntn(static::CLM_VALUE)->setComment("Value");
        static::rfrncDfntn()->addUniqueKey(static::CLM_VALUE, "idxnq_tbl01_atncrmtnd_vle");
    }

    /**
     * @return string
     * @since 18-11-29
     */
    public static function databaseClassname()
    {
        return DatabaseTest::class;
    }

}
