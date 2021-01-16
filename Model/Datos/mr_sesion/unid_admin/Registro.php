<?php

/**
 * AdministracionIngresos - Registro 2017-06-10
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\Model\Datos
 * @version DEPRECATED
 */

namespace Straffsa\SistemaIntegralIngresos\Datos\mr_sesion\unid_admin;

use GIndie\Platform\Model\Database\Record;

/**
 * <b>Registro<\b> de las unidades administrativas.
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @since MR-ADIN.00.01
 * @todo
 * - Move \Straffsa\SistemaIntegralIngresos funcionality 
 */
class Registro extends Record {

  /**
   * glyphicon glyphicon-home
   * @var string
   * @since MR-ADIN.00.01
   */
    const ICON = "glyphicon glyphicon-home";

    /**
     * Unidad administrativa
     * @var string
     * @since MR-ADIN.00.01
     */
    const NAME = "Unidad administrativa";

    /**
     * mr_sesion
     * @since MR-ADIN.00.01
     */
    const SCHEMA = "mrdemo_sesion";

    /**
     * unid_admin
     * @since MR-ADIN.00.01
     */
    const TABLE = "unid_admin";

    /**
     * id
     * @since MR-ADIN.00.01
     */
    const PRIMARY_KEY = "id";

    /**
     * Define los atributos del modelo de datos.
     * @since MR-ADIN.00.01
     */
    public function defineAttributes() {
        $this->defineAttribute("id")->excludeFromDisplay();
        $this->defineAttribute("nombre")->setType(static::TYPE_STRING)->setLabel("Nombre de la unidad");
        $this->defineAttribute("tipo")->setType(static::TYPE_ENUM,
                                                ["admin" => "Administrativa", "func" => "Funcional", "staff" => "Staff"])->setLabel("Tipo");
        $this->defineAttribute("parent")->setType(static::TYPE_FOREIGN_KEY,
                                                  [Lista::class => []])->setLabel("Depende de...");
        $this->defineAttribute("generadora_ingresos")->setType(static::TYPE_BOOLEAN)->setLabel("¿Es generadora de ingresos?");
    }

    public static function defineRecordRestrictions() {
//        static::requireRoles("gip-create", ["AS"]);
//        static::excludeRoles("gip-update", ["AS"]);
    }

}
