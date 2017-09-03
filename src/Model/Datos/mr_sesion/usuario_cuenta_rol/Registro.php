<?php

/**
 * GIplatform - Registro 2017-06-11
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.01
 */

namespace GIndie\Platform\Model\Datos\mr_sesion\usuario_cuenta_rol;

use GIndie\Platform\Model\Database\Record;
use \GIndie\Platform\Model;

/**
 * Description of Registro
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Registro extends Record
{

    /**
     * Stores attribute definition
     * @var array 
     */
    //protected static $_attribute = [];
//    const ICON = "glyphicon glyphicon-user";

    const NAME = "Rol de usuario";

    /**
     * The name of the database storing the record.
     * @version     GIP.00.01
     */
    //const SCHEMA = "mrdemo_sesion";

    /**
     * The name of the table storing the the record.
     * @version     GIP.00.01
     */
    const TABLE = "usuario_cuenta_rol";

    /**
     * The primary key of the record.
     * @version     GIP.00.01
     */
    const PRIMARY_KEY = "fk_rol";
    const AUTOINCREMENT = \FALSE;
    const DISPLAY_KEY = "fk_usuario_cuenta";

    public static function configAttributes()
    {
        static::attribute("fk_rol")->setLabel("Rol")->excludeFromDisplay()->excludeFromForm();
        static::attribute("fk_usuario_cuenta");
//        static::attribute("password_su")->setType(Model\Attribute::TYPE_PASSWORD)->setLabel("Contraseña de uso único");
//        static::attribute("password_enct")->setType(Model\Attribute::TYPE_PASSWORD)->setLabel("Contraseña encriptada")->excludeFromForm();
//        static::attribute("active")->setType(Model\Attribute::TYPE_BOOLEAN)->setLabel("Activo");
//        static::attribute("fk_unid_admin");
    }

}
