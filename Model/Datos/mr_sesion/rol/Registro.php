<?php

/**
 * AdministracionIngresos - Registro 2017-06-10
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\Model\Datos
 * @version DEPRECATED
 */

namespace Straffsa\SistemaIntegralIngresos\Datos\mr_sesion\rol;

use GIndie\Platform\Model\Database\Record;

/**
 * <b>Registro<\b> de roles de usuario.
 *
 * @author Liliana Hernández Castañeda <liliana.hercast@gmail.com>
 * @since MR-ADIN.00.01
 * @todo
 * - Move \Straffsa\SistemaIntegralIngresos funcionality 
 */
class Registro extends Record {

  /**
   * Rol de usuario
   * @var string
   * @since MR-ADIN.00.01
   */
    const NAME = "Rol de usuario";

    /**
     * mr_sesion
     * @since MR-ADIN.00.01
     */
    const SCHEMA = "mrdemo_sesion";

    /**
     * rol
     * @since MR-ADIN.00.01
     */
    const TABLE = "rol";

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
        $this->defineAttribute("id");
        $this->defineAttribute("descripcion")->setType(static::TYPE_STRING)->setLabel("Rol");

    }

    public static function defineRecordRestrictions() {
//        static::requireRoles("gip-create", ["AS"]);
//        static::excludeRoles("gip-update", ["AS"]);
    }

}
