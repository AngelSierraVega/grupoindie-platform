<?php

/**
 * GI-PLTFRM - Estados
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
 * Description of Estados
 *
 * @author Angel
 */
class Estado extends Abstracto {

    /**
     * 
     * @since 21-06-17
     */
    const CLM_ID = "id";

    /**
     * 
     * @since 21-06-17
     */
    const CLM_NOMBRE = "nmbr";

    /**
     * 
     * @since 21-06-17
     */
    const CLM_PAIS = "pais";

    /**
     * 
     * @since 21-06-17
     */
    protected static function clmId() {
        static::clmnDfntn(static::CLM_ID, DataType::serial());
//        static::clmnDfntn(static::CLM_ID)->setComment("IdConsultorio");
    }

    /**
     * 
     * @since 21-06-17
     */
    protected static function clmNombre() {
        static::clmnDfntn(static::CLM_NOMBRE, DataType::varchar(50));
        static::clmnDfntn(static::CLM_NOMBRE)->setNotNull();
        static::clmnDfntn(static::CLM_NOMBRE)->setComment("Nombre NOTAS: El nombre con que se identifica el estado");
    }

    /**
     * 
     * @since 21-06-17
     */
    protected static function clmPais() {
        static::clmnDfntn(static::CLM_PAIS, DataType::varchar(11));
        static::clmnDfntn(static::CLM_PAIS)->setNotNull();
        static::clmnDfntn(static::CLM_PAIS)->setComment("Nombre NOTAS: El pais al que pertecene el estado");
    }

    /**
     * {@inheritdoc}
     * @since 21-06-17
     */
    protected static function tableDefinition() {
        static::clmId();
        static::clmNombre();
        static::clmPais();

        static::rfrncDfntn()->setPrimaryKey(static::CLM_ID);
    }

    /**
     * {@inheritdoc}
     * @since 21-05-23
     * @return string
     */
    public static function name() {
        return "std";
    }

    /**
     * {@inheritdoc}
     * @since 21-05-24
     */
    const NAME = "Estado";

    /**
     * {@inheritdoc}
     * @since 21-05-24
     */
    const TABLE = "std";

    /**
     * {@inheritdoc}
     * @since 21-05-24
     */
    const DISPLAY_KEY = "nmbr";

    /**
     * {@inheritdoc}
     * @since 21-05-24
     */
    const PRIMARY_KEY = "id";

    /**
     * {@inheritdoc}
     * @since 21-05-24
     */
    const AUTOINCREMENT = true;

    /**
     * {@inheritdoc}
     * @since 21-05-24
     */
    public static function configAttributes() {
        parent::configAttributes();
    }

    /**
     * {@inheritdoc}
     * @since 21-06-03
     */
    protected static function defineCommands() {
        parent::defineCommands();
//        static::commandDefinition("gip-create")->definePrerequisites(["BTC-A"]);
//        static::commandDefinition("gip-edit")->definePrerequisites(["BTC-A"]);
//        static::commandDefinition("gip-delete")->definePrerequisites(["BTC-A"]);
    }

}
