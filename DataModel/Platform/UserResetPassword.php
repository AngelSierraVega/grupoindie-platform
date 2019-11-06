<?php

/**
 * GI-Platform-DVLP - UserFinalPassword
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2019 Angel Sierra Vega. Grupo INDIE.
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
class UserResetPassword extends User
{

    /**
     * 
     * @since 19-04-05
     */
    public static function configAttributes()
    {
        static::attribute("key")->excludeFromForm();
        static::attribute("user")->excludeFromForm();
        //static::attribute("password_su")->excludeFromForm();
        static::attribute("password_enct")->excludeFromForm();
        //static::attribute("password_su")->setType(Attribute::TYPE_PASSWORD);
        static::attribute("password_su")->setLabel("Contraseña de uso único")->setRestrictionRequired();
        static::attribute("password_su")->setRestrictions(["minlength" => "5"]);
    }

    /**
     * 
     * @since 19-04-05
     */
    public function _update($postReading = \TRUE)
    {
        $_POST["password_enct"] = "NULL";
        $_POST["password_su"] = \GIndie\Platform\Security::enctript($_POST["password_enct"]);
        return parent::_update($postReading);
    }

}
