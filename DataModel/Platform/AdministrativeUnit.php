<?php

/**
 * GI-Platform-DVLP - AdministrativeUnit
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\DataModel
 *
 * @version 0C.A0
 * @since 18-08-25
 */

namespace GIndie\Platform\DataModel\Platform;

//use GIndie\Platform\Model\Record;
use GIndie\DBHandler\MySQL56\Instance\DataType;
use GIndie\Platform\Model;
use GIndie\Platform\DataModel\Resources\GIPList;

/**
 * Description of AdministrativeUnit
 *
 * @edit 18-10-27
 * - Class extends Model\RecordAutoincremented 
 * - Removed PRIMARY_KEY and AUTOINCREMENT
 */
class AdministrativeUnit extends Model\RecordAutoincremented
{

    /**
     * gráfico del modelo de datos
     * @var string
     * @since 18-08-26
     */
    const ICON = "glyphicon glyphicon-home";

    /**
     * Nombre del modelo de datos.
     * @var string
     * @since 18-08-26
     */
    const NAME = "Unidad administrativa";

    /**
     * Define la tabla de la Base de Datos
     * @since 18-08-26
     */
    const TABLE = "pltfrm_ndd_dmnstrtv";

    /**
     * @since 18-08-26
     */
    const DISPLAY_KEY = "dscrpcn";

    /**
     * Define los atributos del modelo de datos.
     * @since 18-08-26
     */
    public static function configAttributes()
    {
        static::attribute("dscrpcn")->setType(Model\Attribute::TYPE_STRING);
        static::attribute("dscrpcn")->setRestrictionRequired();
        static::attribute("dscrpcn")->setLabel("Nombre de la unidad administrativa");
        static::attribute("dscrpcn")->setSize("col-sm-6");
        static::attribute("parent")->setLabel("Depende de");
        static::attribute("parent")->setTypeFK(GIPList\Units::class);
        static::attribute("parent")->setSize("col-sm-6");
    }

    /**
     * Define las restricciones en función del rol
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
     * @since 18-08-19
     */
    protected static function tableDefinition()
    {
        /**
         * Column id
         */
        static::columnDefinition("id", DataType::serial());

        /**
         * Column parent
         */
        static::columnDefinition("parent", DataType::serializedBigint());

        /**
         * Column dscrpcn
         */
        static::columnDefinition("dscrpcn", DataType::varchar(255));
        static::columnDefinition("dscrpcn")->setNotNull();

        /**
         * Reference Definition
         */
        static::referenceDefinition()->setPrimaryKey("id");
        static::referenceDefinition()->addUniqueKey(["parent", "dscrpcn"], "idx_dsply_pltfrm_ndd_dmnstrtv");
        static::referenceDefinition()->addForeignKey("parent", static::instance(), "idx_parent_pltfrm_ndd_dmnstrtv");
    }

    /**
     * 
     * @return array
     * @since 18-08-26
     */
    public static function defaultRecord()
    {
        return ["id" => null, "parent" => null, "dscrpcn" => "DEFAULT"];
    }

}
