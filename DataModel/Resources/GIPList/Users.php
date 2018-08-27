<?php

/**
 * GI-Platform-DVLP - Users
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

use GIndie\Platform\Model\ListSimple;

/**
 * Description of Users
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Users extends ListSimple
{

    /**
     * Modelo de datos relacionado con la lista.
     * @since 18-08-25
     */
    public static function relatedRecord()
    {
        return \MunicipioMineralReforma\Predial\ModeloDatos\Plataforma\Usuario::class;
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
