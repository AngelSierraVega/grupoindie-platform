<?php

/**
 * GI-Platform-DVLP - Tbl01AutoincrementedList
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\Components\Example
 *
 * @version 0C.FF
 * @since 18-12-16
 */

namespace GIndie\Platform\Components\Example\DataModel;

/**
 * Description of Tbl01AutoincrementedList
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Tbl01AutoincrementedList extends \GIndie\Platform\Model\ListSimple
{

    /**
     * 
     * @return string
     * @since 18-12-16
     */
    public static function relatedRecord()
    {
        return Tbl01Autoincremented::class;
    }

}
