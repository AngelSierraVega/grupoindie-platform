<?php

/**
 * GI-Platform-DVLP - Plataforma
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform
 *
 * @version 0C.A0
 * @since 18-09-24
 */

namespace GIndie\Platform\DataModel;

use GIndie\DBHandler\MySQL56;

/**
 * Description of Plataforma
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Plataforma extends MySQL56\Instance\Database
{

    /**
     * The name of the database
     * @return string
     * @since 18-07-16
     */
    public static function name()
    {
        return "pltfrm";
    }

    /**
     * 
     * @return array
     * @since 18-08-15
     * @edit 18-09-18
     * - Todas las tablas de la base de datos definidas
     */
    public static function getTableClassnames()
    {
        return [Plataforma\UnidadAdministrativa::class
            , Plataforma\Rol::class
            , Plataforma\Usuario::class
            , Plataforma\UsuarioRol::class
            , Plataforma\BitacoraUsuario::class
            , Plataforma\Sesion::class
        ];
    }

}
