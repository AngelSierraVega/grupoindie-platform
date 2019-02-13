<?php

/**
 * GI-Platform-DVLP - Users
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\DataModel
 *
 * @version DOING 00.80
 * @since 18-08-25
 */

namespace GIndie\Platform\DataModel\Resources\GIPList;

use GIndie\Platform\Model\ListSimple;
use GIndie\Platform\DataModel\Platform\User;

/**
 * @todo Deprecate class. Cannot surpass version 00.80
 */
class Users extends ListSimple
{

    /**
     * Modelo de datos relacionado con la lista.
     * @since 18-08-25
     * @edit 19-02-15
     * - Use \GIndie\Platform\DataModel\Platform\User
     */
    public static function relatedRecord()
    {
        return User::class;
    }

    /**
     * 
     * @param string $action
     * @return array
     * @since 18-08-25
     */
    public static function getValidRolesFor($action)
    {
        switch ($action)
        {
            case "gip-edit":
            case "gip-delete":
                return ["NONE"];
            default:
                return parent::getValidRolesFor($action);
        }
    }

}
