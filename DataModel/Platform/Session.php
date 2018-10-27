<?php

/**
 * GI-Platform-DVLP - Session
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\DataModel
 *
 * @version 0C.70
 * @since 18-08-27
 */

namespace GIndie\Platform\DataModel\Platform;

use GIndie\Platform\Model\Record;
use GIndie\DBHandler\MySQL56\Instance\DataType;

/**
 * Description of Session
 *
 */
class Session extends Record
{

    /**
     * @since 18-08-26
     */
    const NAME = "Sesión de usuario";

    /**
     * @since 18-08-26
     */
    const TABLE = "pltfrm_ssn";

    /**
     * @since 18-08-26
     */
    const PRIMARY_KEY = "pltfrm_cta_fk";

    /**
     * @since 18-08-26
     */
    const AUTOINCREMENT = false;

    /**
     * @since 18-08-26
     */
    const DISPLAY_KEY = "php_sess_id";

    /**
     * @since 18-08-26
     */
    public static function configAttributes()
    {
        static::attribute("pltfrm_cta_fk");
        static::attribute("php_sess_id");
    }

    /**
     * @since 18-08-26
     */
    protected static function tableDefinition()
    {
        /**
         * Column id
         */
        static::columnDefinition("id", DataType::serial());
        /**
         * Column pltfrm_cta_fk
         */
        static::columnDefinition("pltfrm_cta_fk", DataType::char(8));
        /**
         * Column php_sess_id
         */
        static::columnDefinition("php_sess_id", DataType::varchar(255));

        /**
         * Reference Definition
         */
        static::referenceDefinition()->setPrimaryKey("id");
        static::referenceDefinition()->addUniqueKey("pltfrm_cta_fk", "idxunique_pltfrm_cta_pltfrm_ssn");
        $instance = User::instance();
        $instance->columns();
        static::referenceDefinition()->addForeignKey("pltfrm_cta_fk", $instance, "pltfrm_ssn_FK_pltfrm_cta");
    }

}
