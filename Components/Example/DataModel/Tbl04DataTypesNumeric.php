<?php

/**
 * GI-Platform-DVLP - Tbl04DataTypesNumeric
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\Components\Example
 *
 * @version DOING 00.70
 * @since 18-11-29
 */

namespace GIndie\Platform\Components\Example\DataModel;

use \GIndie\DBHandler\MySQL57\Instance\DataType;

/**
 * Description of Test04DataTypesNumeric
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Tbl04DataTypesNumeric extends \GIndie\Platform\Model\Record
{
    
    /**
     * @since 18-11-29
     */
    const SCHEMA = "pltfrm_xmpl";

    /**
     * @since 18-11-29
     */
    const TABLE = "tbl04_dt_nmrc";

    /**
     * @since 18-11-29
     */
    const DISPLAY_KEY = "id";

    /**
     * @since 18-11-29
     */
    const CLM_ID = "id";

    /**
     * @since 18-11-29
     */
    protected static function tableDefinition()
    {
        static::clmnDfntn(static::CLM_ID, DataType::serial());
        static::rfrncDfntn()->setPrimaryKey(static::CLM_ID);
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
