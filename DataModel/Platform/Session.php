<?php

/**
 * GI-Platform-DVLP - Session
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\DataModel
 *
 * @version 0C.DA
 * @since 18-08-27
 */

namespace GIndie\Platform\DataModel\Platform;

use GIndie\Platform\Model\Record;
use GIndie\DBHandler\MySQL57\Instance\DataType;

/**
 * Description of Session
 * @edit 18-11-11
 * - Upgraded column definition
 */
class Session extends AbstractTable
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
     * @edit 18-11-11
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
        static::columnDefinition("pltfrm_cta_fk", static::getPKDataType(User::class));
        /**
         * Column php_sess_id
         */
        static::columnDefinition("php_sess_id", DataType::char(255));

        /**
         * Reference Definition
         */
        static::referenceDefinition()->setPrimaryKey("id");
        static::referenceDefinition()->addUniqueKey("pltfrm_cta_fk", "idxunique_pltfrm_cta_pltfrm_ssn");
//        $instance = User::instance();
//        $instance->columns();
        static::referenceDefinition()->addForeignKey("pltfrm_cta_fk", User::class, "pltfrm_ssn_FK_pltfrm_cta");
    }

    /**
     * Define las restricciones en función del rol
     * @since 18-10-28
     */
    public static function defineRecordRestrictions()
    {
        
    }

}
