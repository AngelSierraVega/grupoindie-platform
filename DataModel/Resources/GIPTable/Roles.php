<?php

/**
 * GI-Platform-DVLP - Roles
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\DataModel
 *
 * @version DOING 00.80
 * @since 18-10-24
 */

namespace GIndie\Platform\DataModel\Resources\GIPTable;

/**
 * Description of Roles
 *
 * @todo Deprecate class. Cannot surpass version 00.80
 */
class Roles extends \GIndie\Platform\Model\Table
{

    /**
     * @since 18-10-24
     */
    public static function relatedRecord()
    {
        return \GIndie\Platform\DataModel\Platform\Role::class;
    }

}
