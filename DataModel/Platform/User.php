<?php

/**
 * GI-Platform-DVLP - User
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * 
 * @package GIndie\Platform\DataModel
 *
 * @version 0D.00
 * @since 18-08-25
 */

namespace GIndie\Platform\DataModel\Platform;

use GIndie\Platform\Model\Record;
use GIndie\Platform\Model;
use GIndie\DBHandler\MySQL57\Instance\DataType;
use GIndie\DBHandler\MySQL57\Instance\ColumnDefinition;

/**
 * @edit 18-08-19
 * - Commented class
 * @edit 18-08-30
 * - Added defineRecordRestrictions()
 * @edit 18-11-11
 * - Upgraded column definition
 */
class User extends AbstractTable
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
        static::attribute("key")->excludeFromForm();
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
        static::attribute("pltfrm_ndd_dmnstrtv_fk")->setTypeFK(\GIndie\Platform\DataModel\Resources\GIPList\Units::class);
        static::attribute("pltfrm_ndd_dmnstrtv_fk")->setLabel("Unidad Administrativa");
    }

    /**
     * @since 18-08-19
     * @edit 18-08-26
     * - Removed id
     * - Added referenceDefinition()
     * @edit 18-10-11
     * - Added virtual column nbr_cmplt
     * @edit 18-11-05
     * - Upgraded column definition
     * @edit 18-11-11
     */
    protected static function tableDefinition()
    {
        /**
         * Column key
         */
        static::clmnDfntn("key", DataType::char(8));
        static::clmnDfntn("key")->setNotNull();
        static::clmnDfntn("key")->setComment("key");
        static::rfrncDfntn()->setPrimaryKey("key");
//        static::rfrncDfntn()->addUniqueKey("key", "idxunique_key_pltfrm_cta");

        /**
         * Column user
         */
        static::clmnDfntn("user", DataType::char(255));
        static::clmnDfntn("user")->setNotNull();
        static::clmnDfntn("user")->setComment("user");
        static::rfrncDfntn()->addUniqueKey("user", "idxdsply_pltfrm_cta");

        /**
         * Column password_su 
         */
        static::clmnDfntn("password_su", DataType::char(60));
        static::clmnDfntn("password_su")->setComment("password_su");
        static::clmnDfntn("password_su")->setDefaultValue(null);

        /**
         * Column password_enct
         */
        static::clmnDfntn("password_enct", DataType::char(60));
        static::clmnDfntn("password_enct")->setComment("password_enct");
        static::clmnDfntn("password_enct")->setDefaultValue(null);

        /**
         * Column active
         */
        static::clmnDfntn("active", DataType::tinyint(1, true));
        static::clmnDfntn("active")->setComment("active");
        static::clmnDfntn("active")->setDefaultValue(1);

        /**
         * Column pltfrm_ndd_dmnstrtv_fk
         */
        static::clmnDfntn("pltfrm_ndd_dmnstrtv_fk", static::getPKDataType(AdministrativeUnit::class));
        static::clmnDfntn("pltfrm_ndd_dmnstrtv_fk")->setNotNull();
        static::clmnDfntn("pltfrm_ndd_dmnstrtv_fk")->setComment("pltfrm_ndd_dmnstrtv_fk");
//        $instance = AdministrativeUnit::instance();
//        $instance->columns();
        static::rfrncDfntn()->addForeignKey("pltfrm_ndd_dmnstrtv_fk", AdministrativeUnit::class, "pltfrm_cta_FK_pltfrm_ndd_dmnstrtv");

        /**
         * Column trtmnt
         */
        static::clmnDfntn("trtmnt", DataType::varchar(8));
        static::clmnDfntn("trtmnt")->setComment("trtmnt");
        /**
         * Column nmbrs
         */
        static::clmnDfntn("nmbrs", DataType::char(100));
        static::clmnDfntn("nmbrs")->setComment("nmbrs");
        /**
         * Column ap_pat
         */
        static::clmnDfntn("ap_pat", DataType::char(50));
        static::clmnDfntn("ap_pat")->setComment("ap_pat");
        /**
         * Column apo_mat
         */
        static::clmnDfntn("ap_mat", DataType::char(50));
        static::clmnDfntn("ap_mat")->setComment("ap_mat");

        /**
         * Virtual column nbr_cmplt
         */
        static::clmnDfntn("nbr_cmplt", DataType::char(208));
        static::clmnDfntn("nbr_cmplt")->setComment("nbr_cmplt");
        static::clmnDfntn("nbr_cmplt")->setGenerated("(CONCAT_WS(' ',trtmnt,nmbrs,ap_pat,ap_mat))", "STORED");
    }

    /**
     * 
     * @return array
     * @since 18-08-26
     * @edit 18-10-11
     * - Added projectHandler
     */
    public static function defaultRecord()
    {
        return [[
        "key" => "1a0108f3",
        "user" => "admin@localhost",
        "password_su" => "$2y$10\$CO8ruMmANUfiyF/vupP//um45QCHqaxc9Z2dT8OCkt/uaZyuI3jQO",
        "pltfrm_ndd_dmnstrtv_fk" => 1
            ], [
                "key" => "1a0108f4",
                "user" => "projectHandler@localhost",
                "password_su" => "$2y$10\$CO8ruMmANUfiyF/vupP//um45QCHqaxc9Z2dT8OCkt/uaZyuI3jQO",
                "pltfrm_ndd_dmnstrtv_fk" => 1
        ]];
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

    /**
     * Define los permisos de usuario
     * @since 18-08-30
     */
    public static function defineRecordRestrictions()
    {
        static::requireRoles("gip-create", ["AS"]);
        static::requireRoles("gip-edit", ["AS"]);
        static::requireRoles("gip-delete", ["AS"]);
        static::requireRoles("gip-state", ["AS"]);
    }

}
