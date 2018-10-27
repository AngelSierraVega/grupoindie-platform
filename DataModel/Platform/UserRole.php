<?php

/**
 * GI-Platform-DVLP - UserRole
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

use GIndie\Platform\Model\Record;
use GIndie\Platform\Model;
//use Straffsa\SistemaIntegralIngresos\Datos\mr_sesion\rol;
//use Straffsa\SistemaIntegralIngresos\Datos\mr_sesion\usuario_cuenta;
use GIndie\Generator\DML\HTML5\Bootstrap3\Component\Modal;
use GIndie\Generator\DML\HTML5\Bootstrap3;
use GIndie\DBHandler\MySQL56\Instance\DataType;

/**
 * Description of UserRole
 *
 */
class UserRole extends Record
{

    /**
     * Nombre del modelo de datos.
     * @var string
     * @since 18-08-26
     */
    const NAME = "Rol de usuario";

    /**
     * Define la tabla de la Base de Datos
     * @since 18-08-26
     */
    const TABLE = "pltfrm_cta_rol";

    /**
     * Llave primaria del modelo de datos.
     * @since 18-08-26
     */
    const PRIMARY_KEY = "id";

    /**
     * @since 18-08-26
     */
    const AUTOINCREMENT = true;

    /**
     * @since 18-08-26
     */
    const DISPLAY_KEY = "pltfrm_rol_fk";

    /**
     * Define los atributos del modelo de datos.
     * @since MR-ADIN.00.01
     */
    public static function configAttributes()
    {
        static::attribute("pltfrm_rol_fk")->setTypeFK(\GIndie\Platform\DataModel\Resources\GIPList\Roles::class)->setLabel("Rol");
        static::attribute("pltfrm_rol_fk")->setLabel("Roles de usuario");
        static::attribute("pltfrm_rol_fk")->setNotNull();

        static::attribute("pltfrm_cta_fk")->setType(Model\Attribute::TYPE_HIDDEN);
        static::attribute("pltfrm_cta_fk")->excludeFromDisplay();
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
         * Column pltfrm_rol_fk
         * 
         */
        static::columnDefinition("pltfrm_rol_fk", DataType::char(12));
        static::columnDefinition("pltfrm_rol_fk")->setNotNull();

        /**
         * Column pltfrm_cta_fk
         * 
         */
        static::columnDefinition("pltfrm_cta_fk", DataType::varchar(8));
        static::columnDefinition("pltfrm_cta_fk")->setNotNull();


        /**
         * Reference Definition
         */
        static::referenceDefinition()->setPrimaryKey("id");
        static::referenceDefinition()->addUniqueKey(["pltfrm_rol_fk", "pltfrm_cta_fk"], "idxunique_pltfrm_cta_rol");
        $instance = Role::instance();
        $instance->columns();
        static::referenceDefinition()->addForeignKey("pltfrm_rol_fk", $instance, "pltfrm_cta_rol_FK_pltfrm_rol");
        $instance = User::instance();
        $instance->columns();
        static::referenceDefinition()->addForeignKey("pltfrm_cta_fk", $instance, "pltfrm_cta_rol_FK_pltfrm_cta");
    }

    /**
     * 
     * @return array
     * @since 18-08-26
     * @edit 18-10-24
     */
    public static function defaultRecord()
    {
        return [
            ["id" => null, "pltfrm_rol_fk" => "AS", "pltfrm_cta_fk" => "1a0108f3"]
            , ["id" => null, "pltfrm_rol_fk" => "AS", "pltfrm_cta_fk" => "1a0108f4"]
        ];
    }

    /**
     * 
     * @param type $command
     * @return type
     */
    public static function getValidRolesForDPR($command)
    {
        switch ($command)
        {
            case "gip-create":
                return [];
                break;
            case "gip-delete":
                return ["AS"];
                break;
        }
    }

    /**
     * 
     * @param type $postReading
     * @return type
     * @since 18-08-26
     */
    protected function _create($postReading = \TRUE)
    {
        $_POST["pltfrm_cta_fk"] = $_POST["gip-action-id"];
        return parent::_create($postReading);
    }

    /**
     * 
     * @param type $action
     * @param type $actionId
     * @param type $selectedId
     * @return \GIndie\Generator\DML\HTML5\Bootstrap3\Component\Modal\Content
     * @since 18-08-26
     */
    public function run($action, $actionId = \NULL, $selectedId = \NULL)
    {
        switch ($action)
        {
            case "mr-asignar-rol":
                $record = self::instance();
                $form = new \GIndie\Platform\View\Form($record);
                $form->setAttribute("gip-action-id", $actionId);
                $form->setAttribute("gip-action", "gip-create");
                $form->setAttribute("gip-action-class", \urlencode(static::class));
                $modalContent = new Modal\Content("Asignar un rol", $form);
                $btn = new Bootstrap3\Component\Button("Crear", Bootstrap3\Component\Button::TYPE_SUBMIT);
                $btn->setForm($form->getId())->setValue("Submit");
                $btn->setContext(Bootstrap3\Component\Button::$COLOR_SUCCESS);
                $modalContent->addFooterButton($btn);
                return $modalContent;
                break;
            default:
                break;
        }
        parent::run($action, $actionId, $selectedId);
    }

    /**
     * Define las restricciones en función del rol
     * @since 18-08-25
     */
    public static function defineRecordRestrictions()
    {
        static::requireRoles("gip-create", ["NONE"]);
        static::requireRoles("gip-edit", ["NONE"]);
        static::requireRoles("gip-delete", ["AS"]);
        static::requireRoles("gip-state", ["NONE"]);
    }

}
