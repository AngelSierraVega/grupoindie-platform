<?php

/**
 * GIplatform - Registro
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\DataModel
 *
 * @version DOING 0D.00
 * @since 17-06-11
 */

namespace GIndie\Platform\Model\Datos\mr_sesion\usuario_cuenta;

use GIndie\Platform\Model\Record;
use GIndie\Platform\Model;

/**
 * @edit 18-08-19
 * - Commented class
 */
class Registro extends Record
{

    /**
     * @since 17-??-??
     */
    const ICON = "glyphicon glyphicon-user";

    /**
     * @since 17-??-??
     */
    const NAME = "Cuenta de usuario";

    /**
     * The name of the table storing the the record.
     * @since 17-??-??
     */
    const TABLE = "usuario_cuenta";

    /**
     * The primary key of the record.
     * @since 17-??-??
     */
    const PRIMARY_KEY = "key";

    /**
     * @since 17-??-??
     */
    const AUTOINCREMENT = false;

    /**
     * @since 17-??-??
     */
    const DISPLAY_KEY = "user";

    /**
     * @edit 18-08-19
     * - Upgraded and commented code
     */
    public static function configAttributes()
    {
        /**
         * Attribute key
         */
        static::attribute("key")->setLabel("Llave");
        static::attribute("key")->excludeFromDisplay()->excludeFromForm();
        /**
         * Attribute user
         */
        static::attribute("user")->setType(Model\Attribute::TYPE_EMAIL);
        static::attribute("user")->setLabel("Clave de usuario (correo)");
        /**
         * Attribute password_su
         */
        static::attribute("password_su")->setType(Model\Attribute::TYPE_PASSWORD);
        static::attribute("password_su")->setLabel("Contraseña de uso único");
        /**
         * Attribute password_enct
         */
        static::attribute("password_enct")->setType(Model\Attribute::TYPE_PASSWORD);
        static::attribute("password_enct")->setLabel("Contraseña encriptada");
        static::attribute("password_enct")->excludeFromForm();
        /**
         * Attribute active
         */
        static::attribute("active")->setType(Model\Attribute::TYPE_BOOLEAN);
        static::attribute("active")->setLabel("Activo");
        /**
         * Attribute fk_unid_admin
         */
        static::attribute("fk_unid_admin");
    }

}
