<?php

/**
 * GI-Platform-DVLP - UserRole
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2019 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\DataModel
 *
 * @version DOING 00.80
 * @since 19-04-04
 */

namespace GIndie\Platform\DataModel\Resources\GIPTable;

/**
 * Description of UserRole
 *
 * @todo Deprecate class. Cannot surpass version 00.80
 */
class UserRole extends \GIndie\Platform\Model\Table
{

    /**
     * 
     * @return string
     */
    public static function relatedRecord()
    {
        return \GIndie\Platform\DataModel\Platform\UserRole::class;
    }

}
