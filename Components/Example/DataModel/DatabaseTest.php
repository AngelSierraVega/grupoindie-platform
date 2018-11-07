<?php

/**
 * GI-Platform-DVLP - DatabaseTest
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\Components\Example
 *
 * @version 0C.00
 * @since 18-04-30
 */

namespace GIndie\Platform\Components\Example\DataModel;

/**
 * Description of DatabaseTest
 *
 * @edit 18-05-05
 * - Updated namespace
 * @edit 18-05-21
 * - Moved file from [sndbx_folder]\Platform\..
 * @edit 18-10-02
 * - Upgraded version
 * - Created getTableClassnames()
 * @edit 18-11-29
 * - Moved file from DBHandler\Components\DatabaseDefinitionTest\
 */
class DatabaseTest extends \GIndie\DBHandler\MySQL57\Instance\Database
{

    /**
     * 
     * @return string
     * @since 18-05-05
     * @edit 18-11-29
     */
    public static function name()
    {
        return "pltfrm_xmpl";
    }

    /**
     * 
     * @return array|string
     * @since 18-10-02
     * @edit 18-11-29
     */
    public static function getTableClassnames()
    {
        return [Tbl01Autoincremented::class, Tbl02ForeignKey::class,
            Tbl03DataTypesString::class, Tbl04DataTypesNumeric::class,
            Tbl05DataTypesDateTime::class, Tbl06VirtualColumns::class];
    }

}
