<?php

/**
 * GI-Platform-DVLP - Roles
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
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
