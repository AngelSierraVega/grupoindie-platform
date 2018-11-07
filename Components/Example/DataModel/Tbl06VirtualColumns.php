<?php

/**
 * GI-Platform-DVLP - Tbl06VirtualColumns
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\Components\Example
 *
 * @version DOING 00.70
 * @since 18-11-29
 */

namespace GIndie\Platform\Components\Example\DataModel;

use \GIndie\DBHandler\MySQL57\Instance\DataType;

/**
 * Description of Test06VirtualColumns
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Tbl06VirtualColumns extends \GIndie\Platform\Model\Record
{
    
    /**
     * @since 18-11-29
     */
    const SCHEMA = "pltfrm_xmpl";

    /**
     * @since 18-11-29
     */
    const TABLE = "tbl06_vrtl_clmns";

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
