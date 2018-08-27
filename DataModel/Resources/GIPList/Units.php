<?php

/**
 * GI-Platform-DVLP - Units
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\DataModel
 *
 * @version 0C.70
 * @since 18-08-25
 */

namespace GIndie\Platform\DataModel\Resources\GIPList;

/**
 * Description of Units
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Units extends \GIndie\Platform\Model\ListSimple
{

    /**
     * 
     * @return string
     * @since 18-08-26
     */
    public static function relatedRecord()
    {
        return \GIndie\Platform\DataModel\Platform\AdministrativeUnit::class;
    }

}