<?php

/**
 * GI-PLTFRM - Municipios
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2021 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\DataModel\Comun
 *
 * @version 0C.B0
 * @since 21-06-20
 */

namespace GIndie\Platform\DataModel\Comun;

use GIndie\DBHandler\MySQL57\Instance\DataType;

/**
 * Description of Municipios
 *
 * @author Angel
 */
class Municipio extends Abstracto {

    /**
     * 
     * @since 21-06-21
     */
    const CLM_ID = "id";

    /**
     * 
     * @since 21-06-21
     */
    const CLM_NOMBRE = "nmbr";

    /**
     * 
     * @since 21-06-21
     */
    const CLM_ESTADO = "std";

    /**
     * 
     * @since 21-06-21
     */
    protected static function clmId() {
        static::clmnDfntn(static::CLM_ID, DataType::serial());
//        static::clmnDfntn(static::CLM_ID)->setComment("IdConsultorio");
    }

    /**
     * 
     * @since 21-06-21
     */
    protected static function clmNombre() {
        static::clmnDfntn(static::CLM_NOMBRE, DataType::varchar(200));
        static::clmnDfntn(static::CLM_NOMBRE)->setNotNull();
        static::clmnDfntn(static::CLM_NOMBRE)->setComment("Nombre NOTAS: El nombre con que se identifica el municipio");
    }

    /**
     * 
     * @since 21-06-21
     */
    protected static function clmEstado() {
        static::clmnDfntn(static::CLM_ESTADO, Estado::getPKDataType());
        static::clmnDfntn(static::CLM_ESTADO)->setNotNull();
        static::clmnDfntn(static::CLM_ESTADO)->setComment("Nombre NOTAS: El estado al que pertenece el municipio.");
    }

    /**
     * {@inheritdoc}
     * @since 21-06-21
     */
    protected static function tableDefinition() {
        static::clmId();
        static::clmNombre();
        static::clmEstado();

        static::rfrncDfntn()->setPrimaryKey(static::CLM_ID);
        static::rfrncDfntn()->addForeignKey(static::CLM_ESTADO, Estado::class, static::name() . "_FK_" . Estado::name());
    }

    /**
     * {@inheritdoc}
     * @since 21-06-21
     * @return string
     */
    public static function name() {
        return "mncp";
    }

    /**
     * {@inheritdoc}
     * @since 21-06-21
     */
    const NAME = "Municipio";

    /**
     * {@inheritdoc}
     * @since 21-06-21
     */
    const TABLE = "mncp";

    /**
     * {@inheritdoc}
     * @since 21-06-21
     */
    const DISPLAY_KEY = "nmbr";

    /**
     * {@inheritdoc}
     * @since 21-06-21
     */
    const PRIMARY_KEY = "id";

    /**
     * {@inheritdoc}
     * @since 21-06-21
     */
    const AUTOINCREMENT = true;

    /**
     * {@inheritdoc}
     * @since 21-06-21
     */
    public static function configAttributes() {
        parent::configAttributes();
    }

    /**
     * {@inheritdoc}
     * @since 21-06-21
     */
    protected static function defineCommands() {
        parent::defineCommands();
//        static::commandDefinition("gip-create")->definePrerequisites(["BTC-A"]);
//        static::commandDefinition("gip-edit")->definePrerequisites(["BTC-A"]);
//        static::commandDefinition("gip-delete")->definePrerequisites(["BTC-A"]);
    }

}
