<?php

/**
 * GI-Platform-DVLP - Tbl02ForeignKey
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
 * Description of Test02ForeignKey
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Tbl02ForeignKey extends \GIndie\Platform\Model\Record
{
    
    /**
     * The name of the model
     * 
     * @since 18-12-16
     */
    const NAME = "Tbl02ForeignKey";

    /**
     * @since 18-11-29
     */
    const SCHEMA = "pltfrm_xmpl";

    /**
     * @since 18-11-29
     */
    const TABLE = "tbl02_frgn_ky";

    /**
     * @since 18-12-16
     */
    const DISPLAY_KEY = ["display" => ["tbl01_atncrmtnd" => "gip-model", "vle" => "gip-model"]];

    /**
     * @since 18-11-29
     */
    const CLM_ID = "id";

    /**
     * @since 18-11-29
     */
    const CLM_TABLE01 = "tbl01_atncrmtnd";

    /**
     * @since 18-11-29
     */
    const CLM_VALUE = "vle";
    
    /**
     * @since 18-12-16
     */
    public static function configAttributes()
    {
        parent::configAttributes();
        static::attribute(static::CLM_TABLE01)->setTypeFK(Tbl01AutoincrementedList::class);
    }

    /**
     * @since 18-11-29
     */
    protected static function tableDefinition()
    {
        static::clmnDfntn(static::CLM_ID, DataType::serial());
        static::rfrncDfntn()->setPrimaryKey(static::CLM_ID);
        static::clmnDfntn(static::CLM_TABLE01, Tbl01Autoincremented::getPKDataType());
        static::clmnDfntn(static::CLM_TABLE01)->setNotNull();
        static::rfrncDfntn()->addForeignKey($colName = static::CLM_TABLE01,
            $tableClass = Tbl01Autoincremented::class, $symbol = "tbl02_fk_tbl01",
            $onDelete = "RESTRICT", $onUpdate = "CASCADE");
        static::clmnDfntn(static::CLM_TABLE01)->setComment("Foreing key to Table01");
        static::clmnDfntn(static::CLM_VALUE, DataType::integer(2, true));
        static::clmnDfntn(static::CLM_VALUE)->setNotNull();
        static::rfrncDfntn()->addUniqueKey([static::CLM_TABLE01, static::CLM_VALUE], "idxnq_tbl02");
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
