<?php

/**
 * GI-Platform-DVLP - UserProfile
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\DataModel
 *
 * @version 0C.A0
 * @since 18-08-27
 */

namespace GIndie\Platform\DataModel\Platform;

use GIndie\DBHandler\MySQL56\Instance\DataType;
use GIndie\Platform\Model;

/**
 * Description of UserProfile
 * 
 */
class UserProfile extends User
{

    /**
     * Nombre del modelo de datos.
     * @var string
     * @since 18-08-27
     */
    const NAME = "Perfil de usuario";

    /**
     * @since 18-08-27
     * @edit 18-10-27
     * const AUTOINCREMENT = true;
     */

    /**
     * @since 18-08-27
     * @edit 18-10-27
     * - Atributo virtual en lugar de compuesto
     */
    const DISPLAY_KEY = "nbr_cmplt";

    /**
     * Define los atributos del modelo de datos
     * @since 18-08-27
     */
    public static function configAttributes()
    {
        //static::attribute("fk_usuario_cuenta")->setLabel("Clave de usuario")->excludeFromDisplay();
        static::attribute("trtmnt")->setType(Model\Attribute::TYPE_STRING)->setLabel("Tratamiento");
        static::attribute("nmbrs")->setType(Model\Attribute::TYPE_STRING)->setLabel("Nombre(s)")->setRestrictionRequired();
        static::attribute("ap_pat")->setType(Model\Attribute::TYPE_STRING)->setLabel("Apellido Paterno")->setRestrictionRequired();
        static::attribute("ap_mat")->setType(Model\Attribute::TYPE_STRING)->setLabel("Apellido Materno")->setRestrictionRequired();
    }

    /**
     * Define las restricciones en función del rol
     * @since 18-08-27
     * @todo
     * - Add other roles
     */
    public static function defineRecordRestrictions()
    {
        static::requireRoles("gip-create", ["AS"]);
        static::requireRoles("gip-edit", ["AS"]);
        static::requireRoles("gip-delete", ["NONE"]);
        static::requireRoles("gip-state", ["NONE"]);
    }

}
