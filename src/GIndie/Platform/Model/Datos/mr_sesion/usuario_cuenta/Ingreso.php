<?php

/**
 * GIplatform - Ingreso 2017-06-11
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.03
 */

namespace GIndie\Platform\Model\Datos\mr_sesion\usuario_cuenta;

use \GIndie\Platform\Model;

/**
 * Description of Login
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @version GIP.00.03
 */
class Ingreso extends Registro
{

    public static function configAttributes()
    {
        static::attribute("gip-action")->setType(Model\Attribute::TYPE_HIDDEN);
        static::attribute("log_user")->setLabel("Clave de usuario")->setType(Model\Attribute::TYPE_EMAIL);
        static::attribute("log_pass")->setLabel("Contraseña")->setType(Model\Attribute::TYPE_PASSWORD);
//        parent::configAttributes();
//        static::attribute("password_login")->setLabel("Contraseña")->setType(Model\Attribute::TYPE_PASSWORD);
//        static::attribute("gip-action")->setType(Model\Attribute::TYPE_HIDDEN);
//        static::attribute("password_su")->excludeFromForm();
//        static::attribute("password_enct")->excludeFromForm();
//        static::attribute("active")->excludeFromForm();
//        static::attribute("fk_unid_admin")->excludeFromForm();
    }

}
