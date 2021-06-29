<?php

/**
 * GI-Platform-DVLP - Plataforma
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\DataModel
 *
 * @version 0C.D1
 * @since 18-09-24
 */

namespace GIndie\Platform\DataModel;

use GIndie\DBHandler\MySQL57;

/**
 * Database Platform
 *
 * @edit 18-11-02
 * - Renamed class from Plataforma to Platform
 */
class Platform extends MySQL57\Instance\Database
{

    /**
     * The name of the database
     * @return string
     * @since 18-07-16
     */
    public static function name()
    {
        return "grupoind_pltfrm";
    }

    /**
     * 
     * @return array
     * @since 18-08-15
     * @edit 18-09-18
     * @edit 18-11-02
     * - Upgraded tables
     */
    public static function getTableClassnames()
    {
        return [Platform\AdministrativeUnit::class
            , Platform\Role::class
            , Platform\User::class
            , Platform\UserRole::class
            , Platform\LogUser::class
            , Platform\Session::class
        ];
    }

}
