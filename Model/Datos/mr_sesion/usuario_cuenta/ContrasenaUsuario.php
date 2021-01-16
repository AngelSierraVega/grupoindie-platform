<?php

/**
 * GIplatform - ContrasenaUsuario 2017-06-16
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\Model\Datos
 * @version DEPRECATED
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
     * @edit 
     * - Se agregó validación de contraseñas SU/ENCT
     */
    public function _update($postReading = \TRUE)
    {

        if (\GIndie\Platform\Security::validate($_POST["password_enct"], $this->getValueOf("password_su"))) {
            throw new \Exception("Necesita crear una contraseña distinta a la contraseña de uso único. No se pudo actualizar la contraseña.");
            //return "Necesita crear una contraseña distinta a la contraseña de uso único. No se pudo actualizar la contraseña.";
        } else {
            //var_dump("entro");
            //throw new \Exception("entro");
            $_POST["password_su"] = "NULL";
            $_POST["password_enct"] = \GIndie\Platform\Security::enctript($_POST["password_enct"]);
            if (parent::_update($postReading)) {
                \GIndie\Platform\Current::setUser($this->getId());
                return \TRUE;
            }
        }
        throw new \Exception("No se pudo actualizar la contraseña. Intente de nuevo por favor.");
        return \FALSE;
    }

}
