<?php

/**
 * GI-Platform-DVLP - Role
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\DataModel
 *
 * @version 0D.00
 * @since 18-08-25
 */

namespace GIndie\Platform\DataModel\Platform;

use GIndie\Platform\Model\Database\Record;
use GIndie\Platform\Model;
use GIndie\DBHandler\MySQL57\Instance\DataType;

/**
 * 
 * @edit 18-11-11
 * - Upgraded column definition
 */
class Role extends AbstractTable
{

    /**
     * Nombre del modelo de datos.
     * @var string
     * @since 18-08-26
     */
    const NAME = "Registro de roles";

    /**
     * Define la tabla de la Base de Datos
     * @since 18-08-26
     */
    const TABLE = "pltfrm_rol";

    /**
     * Llave primaria del modelo de datos.
     * @since 18-08-26
     */
    const PRIMARY_KEY = "id";

    /**
     * @since 18-08-26
     */
    const AUTOINCREMENT = false;

    /**
     * @since 18-08-26
     */
    const DISPLAY_KEY = ["compuesto" => [
            "(" => "string",
            "id" => "gip-model",
            ") " => "string",
            "dscrptn" => "gip-model"]
    ];

    /**
     * Define los atributos del modelo de datos.
     * @since 18-08-26
     */
    public static function configAttributes()
    {
        static::attribute("id")->setType(Model\Attribute::TYPE_STRING)->setLabel("Clave del rol")->setRestrictionRequired();
        static::attribute("dscrptn")->setType(Model\Attribute::TYPE_STRING)->setLabel("Rol")->setRestrictionRequired();
    }

    /**
     * Define los permisos de usuario
     * @since 18-08-26
     */
    public static function defineRecordRestrictions()
    {
        static::requireRoles("gip-create", ["AS"]);
        static::requireRoles("gip-edit", ["AS"]);
        static::requireRoles("gip-delete", ["AS"]);
        static::requireRoles("gip-state", ["NONE"]);
    }

    /**
     * @since 18-08-26
     * @edit 18-11-11
     */
    protected static function tableDefinition()
    {
        /**
         * Column id
         */
        static::columnDefinition("id", DataType::char(12));

        /**
         * Column pltfrm_cta_fk
         */
        static::columnDefinition("dscrptn", DataType::char(255));
        static::columnDefinition("dscrptn")->setNotNull();

        /**
         * Reference Definition
         */
        static::referenceDefinition()->setPrimaryKey("id");
        static::referenceDefinition()->addUniqueKey("dscrptn", "idxunique_dscrptn_pltfrm_rol");
    }

    /**
     * 
     * @return array
     * @since 18-11-02
     */
    public static function defaultRecord()
    {
        return [
            ["id" => "AS",
                "dscrptn" => "Administrador del sistema."]
        ];
    }

}
