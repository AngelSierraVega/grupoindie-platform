<?php

/**
 * AdministracionIngresos - caja_cobro 2017-05-31
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package MineralDeLaReforma
 * @subpackage AdmininstracionIngresos
 *
 * @version MR-ADIN.00.01
 */

namespace GIndie\Platform\Model\MR;

use GIndie\Platform\Model\Database\Record;

/**
 * Description of caja_cobro
 * @since MR-ADIN.00.01
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