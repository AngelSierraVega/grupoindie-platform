<?php

/**
 * GI-Platform-DVLP - LogUser
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\DataModel
 *
 * @version 0C.DA
 * @since 18-08-25
 */

namespace GIndie\Platform\DataModel\Platform;

//use GIndie\Platform\Model\Record;
use GIndie\Platform\Model;
use GIndie\DBHandler\MySQL57\Instance\DataType;

/**
 * Description of LogUser
 * @edit 18-10-27
 * - Added databaseClassname() from DataModel\AbstractTable
 * - Class extends Model\RecordAutoincremented 
 * - Removed PRIMARY_KEY and AUTOINCREMENT
 * @edit 18-11-11
 * - Upgraded column definition
 */
class LogUser extends AbstractTable
{

    /**
     * Nombre del modelo de datos.
     * @var string
     * @since 18-08-25
     */
    const NAME = "Bitácora de usuario";

    /**
     * Define la tabla de la Base de Datos
     * @since 18-08-25
     */
    const TABLE = "pltfrm_cta_log";

    /**
     * Llave primaria del modelo de datos.
     * @since 18-08-25
     */
    const DISPLAY_KEY = "id";

    /**
     * Define los atributos del modelo de datos.
     * @since 18-08-25
     */
    public static function configAttributes()
    {
        static::attribute("id")->excludeFromDisplay();
        static::attribute("pltfrm_cta_fk")->setLabel("Usuario");
        static::attribute("pltfrm_cta_fk")->setSize("col-sm-6");
//        static::attribute("pltfrm_cta_fk")->setTypeFK(\GIndie\Platform\DataModel\Resources\GIPList\Users::class);
        static::attribute("action")->setType(Model\Attribute::TYPE_STRING)->setLabel("action")->excludeFromDisplay();
        static::attribute("action-id")->setType(Model\Attribute::TYPE_STRING)->setLabel("action-id")->excludeFromDisplay();
        static::attribute("action-class")->setType(Model\Attribute::TYPE_STRING)->setLabel("action-class")->excludeFromDisplay();
        static::attribute("selected-id")->setType(Model\Attribute::TYPE_STRING)->setLabel("selected-id")->excludeFromDisplay();
        static::attribute("timestamp")->setType(Model\Attribute::TYPE_TIMESTAMP)->setLabel("Fecha");
        static::attribute("timestamp")->setSize("col-sm-6");
        static::attribute("notes")->setType(Model\Attribute::TYPE_STRING)->setLabel("Notas");
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
        static::columnDefinition("id", DataType::serial());
        static::referenceDefinition()->setPrimaryKey("id");

        /**
         * Column pltfrm_cta_fk
         * 
         */
        static::columnDefinition("pltfrm_cta_fk", static::getPKDataType(User::class));
        static::columnDefinition("pltfrm_cta_fk")->setNotNull();
        static::referenceDefinition()->addForeignKey("pltfrm_cta_fk", User::class, "pltfrm_cta_log_FK_pltfrm_cta");

        /**
         * Column action
         * 
         */
        static::columnDefinition("action", DataType::char(255));
        static::columnDefinition("action")->setNotNull();

        /**
         * Column action-id
         * 
         */
        static::columnDefinition("action-id", DataType::char(255));
        static::columnDefinition("action-id")->setDefaultValue(null);

        /**
         * Column action-class
         * 
         */
        static::columnDefinition("action-class", DataType::char(255));
        static::columnDefinition("action-class")->setDefaultValue(null);

        /**
         * Column selected-id
         */
        static::columnDefinition("selected-id", DataType::char(255));
        static::columnDefinition("selected-id")->setDefaultValue(null);

        /**
         * Column timestamp
         */
        static::columnDefinition("timestamp", DataType::integer(11));
//        static::columnDefinition("timestamp", DataType::timestamp());
        static::columnDefinition("timestamp")->setNotNull();

        /**
         * Column notes
         */
        static::columnDefinition("notes", DataType::varchar(2000));
        static::columnDefinition("notes")->setNotNull();

        /**
         * Reference Definition
         */
    }

    /**
     * Define las restricciones en función del ...
     * @since 18-08-25
     */
    public static function defineRecordRestrictions()
    {
        static::requireRoles("gip-create", ["NONE"]);
        static::requireRoles("gip-edit", ["NONE"]);
        static::requireRoles("gip-delete", ["NONE"]);
        static::requireRoles("gip-state", ["NONE"]);
    }

}
