<?php

/**
 * AdministracionIngresos - Registro 2017-06-12
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package MineralDeLaReforma
 * @subpackage AdmininstracionIngresos
 *
 * @version MR-ADIN.00.01
 */

namespace GIndie\Platform\Model\Datos\mr_sesion\bitacora;

use GIndie\Platform\Model\Record;
use \GIndie\Platform\Model;

/**
 * Registro de la <b>bitácora de usuario</b>
 *
 * @since MR-ADIN.00.01
 */
class Registro extends Record
{

    /**
     * Nombre del modelo de datos.
     * @var string
     * @since MR-ADIN.00.01
     */
    const NAME = "Bitácora de usuario";

    /**
     * Define la tabla de la Base de Datos
     * @since MR-ADIN.00.01
     */
    const TABLE = "bitacora_usuario";

    /**
     * Llave primaria del modelo de datos.
     * @since MR-ADIN.00.01
     */
    const PRIMARY_KEY = "id";

    /**
     * Llave primaria del modelo de datos.
     * @since MR-ADIN.00.01
     */
    const DISPLAY_KEY = "id";

    /**
     * Define los atributos del modelo de datos.
     * @since MR-ADIN.00.01
     */
    public static function configAttributes()
    {
        static::attribute("id")->excludeFromDisplay();
        static::attribute("fk_usuario_cuenta")->setLabel("Usuario");
        static::attribute("fk_usuario_cuenta")->setSize("col-sm-6");
        static::attribute("fk_usuario_cuenta")->setTypeFK(\AdminIngresos\Datos\mr_sesion\usuario_cuenta\Lista::class);
        static::attribute("action")->setType(Model\Attribute::TYPE_STRING)->setLabel("action")->excludeFromDisplay();
        static::attribute("action-id")->setType(Model\Attribute::TYPE_STRING)->setLabel("action-id")->excludeFromDisplay();
        static::attribute("action-class")->setType(Model\Attribute::TYPE_STRING)->setLabel("action-class")->excludeFromDisplay();
        static::attribute("selected-id")->setType(Model\Attribute::TYPE_STRING)->setLabel("selected-id")->excludeFromDisplay();
        static::attribute("timestamp")->setType(Model\Attribute::TYPE_TIMESTAMP)->setLabel("Fecha");
        static::attribute("timestamp")->setSize("col-sm-6");
        static::attribute("notas")->setType(Model\Attribute::TYPE_STRING)->setLabel("Notas");
    }

    /**
     * Define las restricciones en función del ...
     * @since MR-ADIN.00.01
     */
    public static function defineRecordRestrictions()
    {
        static::requireRoles("gip-create", ["NONE"]);
        static::requireRoles("gip-edit", ["NONE"]);
        static::requireRoles("gip-delete", ["NONE"]);
        static::requireRoles("gip-state", ["NONE"]);
    }

}
