<?php

/**
 * GI-Platform-DVLP - UserFinalPassword
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2019 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\DataModel\Platform
 *
 * @version 0D.00
 * @since 19-04-05
 */

namespace GIndie\Platform\DataModel\Platform;

use GIndie\Platform\Model\Attribute;

/**
 * Description of UserFinalPassword
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class UserFinalPassword extends User
{

    /**
     * 
     * @since 19-04-05
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
     * @since 19-04-05
     */
    public function _update($postReading = \TRUE)
    {
        if (\GIndie\Platform\Security::validate($_POST["password_enct"],
                $this->getValueOf("password_su"))) {
            throw new \Exception("Necesita crear una contraseña distinta a la contraseña de uso único. No se pudo actualizar la contraseña.");
            //return "Necesita crear una contraseña distinta a la contraseña de uso único. No se pudo actualizar la contraseña.";
        } else {
            $_POST["password_su"] = "NULL";
            $_POST["password_enct"] = \GIndie\Platform\Security::enctript($_POST["password_enct"]);
            if (parent::_update($postReading)) {
                \GIndie\Platform\Current::setUser($this->getId());
                return true;
            }
        }
        throw new \Exception("No se pudo actualizar la contraseña. Intente de nuevo por favor.");
        return false;
    }

}
