<?php

/**
 * GIplatform - Registro 2017-06-11
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.01
 */

namespace GIndie\Platform\Model\Datos\mr_sesion\usuario_cuenta;

use GIndie\Platform\Model\Record;
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

    const ICON = "glyphicon glyphicon-user";
    const NAME = "Cuenta de usuario";

    /**
     * The name of the database storing the record.
     * @version     GIP.00.01
     */
    //const SCHEMA = "mrdemo_sesion";

    /**
     * The name of the table storing the the record.
     * @version     GIP.00.01
     */
    const TABLE = "usuario_cuenta";

    /**
     * The primary key of the record.
     * @version     GIP.00.01
     */
    const PRIMARY_KEY = "key";
    const AUTOINCREMENT = \FALSE;
    
    const DISPLAY_KEY = "user";

    public static function configAttributes()
    {
        static::attribute("key")->setLabel("Llave")->excludeFromDisplay()->excludeFromForm();
        static::attribute("user")->setType(Model\Attribute::TYPE_EMAIL)->setLabel("Clave de usuario (correo)");
        static::attribute("password_su")->setType(Model\Attribute::TYPE_PASSWORD)->setLabel("Contraseña de uso único");
        static::attribute("password_enct")->setType(Model\Attribute::TYPE_PASSWORD)->setLabel("Contraseña encriptada")->excludeFromForm();
        static::attribute("active")->setType(Model\Attribute::TYPE_BOOLEAN)->setLabel("Activo");
        static::attribute("fk_unid_admin");
        //static::attribute("gip_holder");
    }

}
