<?php

/**
 * GIplatform - ContrasenaUsuario 2017-06-16
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.00
 */

namespace GIndie\Platform\Model\Datos\mr_sesion\usuario_cuenta;
use GIndie\Platform\Model\Attribute;

/**
 * Description of ContrasenaUsuario
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class ContrasenaUsuario extends Registro
{

    public static function configAttributes()
    {
        static::attribute("key")->excludeFromForm();
        static::attribute("user")->excludeFromForm();
        static::attribute("password_su")->excludeFromForm();
        static::attribute("password_enct")->setType(Attribute::TYPE_PASSWORD);
        static::attribute("password_enct")->setLabel("Contraseña final de usuario")->setRestrictionRequired();
        static::attribute("password_enct")->setRestrictions(["minlength" => "8"]);
    }

    public function _update($postReading = \TRUE)
    {
        $_POST["password_su"] = "NULL";
        $_POST["password_enct"] = \GIndie\Platform\Security::enctript($_POST["password_enct"]);
        //\trigger_error("Error: Unable to find record ''", E_USER_ERROR);
        //return "TEST";
        if (parent::_update($postReading)) {
            \GIndie\Platform\Current::setUser($this->getId());
            return \TRUE;
        }
        return \FALSE;
    }

}
