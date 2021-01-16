<?php

/**
 * AdministracionIngresos - caja_cobro
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\Model
 *
 * @version DEPRECATED
 * @since 17-05-31
 */

namespace GIndie\Platform\Model\MR;

use GIndie\Platform\Model\Database\Record;

/**
 * Description of caja_cobro
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class caja_cobro extends Record {

    /**
     * Nombre de la base de datos
     * @since MR-ADIN.00.01
     */
    const SCHEMA = "mr_ingresos";

    /**
     * Nombre de la tabla 
     * @since MR-ADIN.00.01
     */
    const TABLE = "caja_cobro";

    /**
     * Llave primaria
     * @since MR-ADIN.00.01
     */
    const PRIMARY_KEY = "id";

    /**
     * Define los atributos del modelo de datos
     * @since MR-ADIN.00.01
     */
    public function defineAttributes() {
        $this->defineAttribute("id")->excludeFromForm();
        $this->defineAttribute("area")->setType(static::TYPE_FOREIGN_KEY,
                [\GIndie\Platform\Model\Session\Area::class => []])->setLabel("Unidad administrativa");
        $this->defineAttribute("Nombre")->setType(static::TYPE_STRING);
    }

}
