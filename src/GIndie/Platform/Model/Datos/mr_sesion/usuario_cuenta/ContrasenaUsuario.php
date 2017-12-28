<?php

/**
 * GIplatform - ContrasenaUsuario 2017-06-16
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.02
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

    /**
     * 
     */
    public static function configAttributes()
    {
        static::attribute("key")->excludeFromForm();
        static::attribute("user")->excludeFromForm();
        static::attribute("password_su")->excludeFromForm();
        static::attribute("password_enct")->setType(Attribute::TYPE_PASSWORD);
        static::attribute("password_enct")->setLabel("Contraseña final de usuario")->setRestrictionRequired();
        static::attribute("password_enct")->setRestrictions(["minlength" => "8"]);
    }

    /**
     * 
     * @param boolean $postReading
     * @return string|boolean
     * @version GIP.00.02 - Se agregó validación de contraseñas SU/ENCT
     */
    public function _update($postReading = \TRUE)
    {
        if (\GIndie\Platform\Security::validate($_POST["password_enct"],
                                                $this->getValueOf("password_su"))) {
            return "Necesita crear una contraseña distinta a la contraseña de uso único. No se pudo actualizar la contraseña.";
        } else {
            $_POST["password_su"] = "NULL";
            $_POST["password_enct"] = \GIndie\Platform\Security::enctript($_POST["password_enct"]);
            if (parent::_update($postReading)) {
                \GIndie\Platform\Current::setUser($this->getId());
                return \TRUE;
            }
        }
        return \FALSE;
    }

}
