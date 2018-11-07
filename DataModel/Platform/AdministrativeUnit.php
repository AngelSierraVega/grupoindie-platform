<?php

/**
 * GI-Platform-DVLP - AdministrativeUnit
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
use GIndie\DBHandler\MySQL57\Instance\DataType;
//use GIndie\Platform\Model;
use GIndie\Platform\DataModel\Resources\GIPList;

/**
 * Description of AdministrativeUnit
 *
 * @edit 18-10-27
 * - Class extends Model\RecordAutoincremented 
 * - Removed PRIMARY_KEY and AUTOINCREMENT
 * @edit 18-11-02
 * - Upgraded Model
 * @edit 18-11-04
 * - Handle user error
 * @edit 18-11-11
 * - Upgraded column definition
 */
class AdministrativeUnit extends AbstractTable
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
     * @edit 18-11-02
     */
    const TABLE = "ndd_dmnstrtv";

    /**
     * @since 18-08-26
     * @edit 18-11-02
     */
    const DISPLAY_KEY = "nmbr";

    /**
     * Define los atributos del modelo de datos.
     * @since 18-08-26
     * @edit 18-11-02
     */
    public static function configAttributes()
    {
        parent::configAttributesFromColumnDefinition();
        static::attribute(static::ATTR_NOMBRE)->setSize("col-sm-6");
        static::attribute(static::ATTR_DEPENDE)->setTypeFK(GIPList\Units::class);
        static::attribute(static::ATTR_DEPENDE)->setNotNull();
        static::attribute(static::ATTR_DEPENDE)->setSize("col-sm-6");
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
     * @since 18-11-02
     */
    const ATTR_ID = "id";

    /**
     * @since 18-11-02
     */
    const ATTR_DEPENDE = "dpnd";

    /**
     * @since 18-11-02
     */
    const ATTR_NOMBRE = "nmbr";

    /**
     * @since 18-08-19
     * @edit 18-11-11
     */
    protected static function tableDefinition()
    {
        /**
         * Column id
         */
        static::columnDefinition(static::ATTR_ID, DataType::serial());
        static::columnDefinition(static::ATTR_ID)->setComment("índice autoincremental");
        static::referenceDefinition()->setPrimaryKey(static::ATTR_ID);

        /**
         * Column parent
         */
        static::columnDefinition(static::ATTR_DEPENDE, DataType::serializedBigint());
        static::columnDefinition(static::ATTR_DEPENDE)->setComment("Depende de");
        static::referenceDefinition()->addForeignKey(static::ATTR_DEPENDE, static::class, "idx_parent_pltfrm_ndd_dmnstrtv");

        /**
         * Column dscrpcn
         */
        static::columnDefinition(static::ATTR_NOMBRE, DataType::char(255));
        static::columnDefinition(static::ATTR_NOMBRE)->setNotNull();
        static::columnDefinition(static::ATTR_NOMBRE)->setComment("Nombre de la unidad administrativa");

        /**
         * Reference Definition
         */
        static::referenceDefinition()->addUniqueKey([static::ATTR_DEPENDE, static::ATTR_NOMBRE], "idx_dsply_pltfrm_ndd_dmnstrtv");
    }

    /**
     * 
     * @param boolean $postReading
     * @since 18-11-04
     * - Handle update
     */
    protected function _update($postReading = \TRUE)
    {
        switch (true)
        {
            case $_POST["gip-action-id"] == $_POST[static::ATTR_DEPENDE]:
                $error = \GIndie\ScriptGenerator\Dashboard\Alert::danger("Error de usuario: Seleccione una unidad dependiente distinta");
                throw new \Exception($error);
                break;
            default:
                break;
        }
        return parent::_update($postReading);
    }

    /**
     * 
     * @return array
     * @since 18-08-26
     */
    public static function defaultRecord()
    {
        return [static::ATTR_ID => null, static::ATTR_DEPENDE => null, static::ATTR_NOMBRE => "DEFAULT"];
    }

}
