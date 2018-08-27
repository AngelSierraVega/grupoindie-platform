<?php

/**
 * GI-Platform-DVLP - User
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\DataModel
 *
 * @version 0C.70
 * @since 18-08-25
 */

namespace GIndie\Platform\DataModel\Platform;

use GIndie\Platform\Model\Record;
use GIndie\Platform\Model;
use GIndie\DBHandler\MySQL56\Instance\DataType;
use GIndie\DBHandler\MySQL56\Instance\ColumnDefinition;

/**
 * @edit 18-08-19
 * - Commented class
 */
class User extends Record
{

    /**
     * @since 18-08-26
     */
    const STATE_ATTRIBUTE = "active";

    /**
     * @since 17-??-??
     */
    const ICON = "glyphicon glyphicon-user";

    /**
     * @since 17-??-??
     */
    const NAME = "Cuenta de usuario";

    /**
     * The name of the table storing the the record.
     * @since 17-??-??
     */
    const TABLE = "pltfrm_cta";

    /**
     * The primary key of the record.
     * @since 17-??-??
     */
    const PRIMARY_KEY = "key";

    /**
     * @since 17-??-??
     */
    const AUTOINCREMENT = false;

    /**
     * @since 17-??-??
     */
    const DISPLAY_KEY = "user";

    /**
     * @edit 18-08-19
     * - Upgraded and commented code
     */
    public static function configAttributes()
    {
        /**
         * Attribute key
         */
        static::attribute("key")->setLabel("Llave");
        static::attribute("key")->excludeFromDisplay()->excludeFromForm();
        /**
         * Attribute user
         */
        static::attribute("user")->setType(Model\Attribute::TYPE_EMAIL);
        static::attribute("user")->setLabel("Clave de usuario (correo)");
        /**
         * Attribute password_su
         */
        static::attribute("password_su")->setType(Model\Attribute::TYPE_PASSWORD);
        static::attribute("password_su")->setLabel("Contraseña de uso único");
        /**
         * Attribute password_enct
         */
        static::attribute("password_enct")->setType(Model\Attribute::TYPE_PASSWORD);
        static::attribute("password_enct")->setLabel("Contraseña encriptada");
        static::attribute("password_enct")->excludeFromForm();
        /**
         * Attribute active
         */
        static::attribute("active")->setType(Model\Attribute::TYPE_BOOLEAN);
        static::attribute("active")->setLabel("Activo");
        /**
         * Attribute pltfrm_ndd_dmnstrtv_fk
         */
        static::attribute("pltfrm_ndd_dmnstrtv_fk");
    }

    /**
     * @since 18-08-19
     * @edit 18-08-26
     * - Removed id
     * - Added referenceDefinition()
     */
    protected static function tableDefinition()
    {
        /**
         * Column id
         */
        //static::columnDefinition("id", DataType::serial());

        /**
         * Column key
         */
        static::columnDefinition("key", DataType::varchar(8));
        static::columnDefinition("key")->setNotNull();

        /**
         * Column user
         */
        static::columnDefinition("user", DataType::varchar(255));
        static::columnDefinition("user")->setNotNull();

        /**
         * Column password_su 
         */
        static::columnDefinition("password_su", DataType::varchar(60));
        static::columnDefinition("password_su")->setDefaultValue(null);

        /**
         * Column password_enct
         */
        static::columnDefinition("password_enct", DataType::varchar(60));
        static::columnDefinition("password_enct")->setDefaultValue(null);

        /**
         * Column active
         */
        static::columnDefinition("active", DataType::tinyint(1));
        static::columnDefinition("active")->setDefaultValue(1);

        /**
         * Column pltfrm_ndd_dmnstrtv_fk
         */
        static::columnDefinition("pltfrm_ndd_dmnstrtv_fk", DataType::serializedBigint());
        static::columnDefinition("pltfrm_ndd_dmnstrtv_fk")->setNotNull();
        
        /**
         * Column trtmnt
         */
        static::columnDefinition("trtmnt", DataType::varchar(8));
        /**
         * Column nmbrs
         */
        static::columnDefinition("nmbrs", DataType::varchar(255));
        /**
         * Column ap_pat
         */
        static::columnDefinition("ap_pat", DataType::varchar(255));
        /**
         * Column apo_mat
         */
        static::columnDefinition("ap_mat", DataType::varchar(255));

        /**
         * Reference Definition
         */
        static::referenceDefinition()->setPrimaryKey("key");
        static::referenceDefinition()->addUniqueKey("key", "idxunique_key_pltfrm_cta");
        static::referenceDefinition()->addUniqueKey("user", "idxdsply_pltfrm_cta");
        $instance = AdministrativeUnit::instance();
        $instance->columns();
        static::referenceDefinition()->addForeignKey("pltfrm_ndd_dmnstrtv_fk", $instance, "pltfrm_cta_FK_pltfrm_ndd_dmnstrtv");
    }

    /**
     * 
     * @return array
     * @since 18-08-26
     */
    public static function defaultRecord()
    {
        return [
            "key" => "1a0108f3",
            "user" => "admin@localhost",
            "password_su" => "$2y$10\$CO8ruMmANUfiyF/vupP//um45QCHqaxc9Z2dT8OCkt/uaZyuI3jQO",
            "pltfrm_ndd_dmnstrtv_fk" => 1
        ];
    }

    /**
     * 
     * @param type $postReading
     * @return string
     */
    protected function _create($postReading = \TRUE)
    {
        switch ($_POST["pltfrm_ndd_dmnstrtv_fk"])
        {
            case "NULL":
                return "Todo usuario requiere una Unidad Administrativa definida.";
        }
        $_POST["key"] = \GIndie\Platform\Security::tokenizeSecure("token");
        $_POST["password_su"] = \GIndie\Platform\Security::enctript($_POST["password_su"]);
        $_POST["password_enct"] = "NULL";
        return parent::_create($postReading);
    }

}
