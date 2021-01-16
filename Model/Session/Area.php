<?php

/**
 * GIplatform - Area 2017-05-31
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\Model
 *
 * @version DEPRECATED
 */

namespace GIndie\Platform\Model\Session;

use GIndie\Platform\Model\Database\Record;

/**
 * Description of Area
 * @since GIP.00.00
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Area extends Record {

    /**
     * Nombre de la base de datos
     * @since MR-ADIN.00.01
     */
    const SCHEMA = "gip_session";

    /**
     * Nombre de la tabla 
     * @since MR-ADIN.00.01
     */
    const TABLE = "area";

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
        $this->defineAttribute("name")->setType(static::TYPE_STRING)->setLabel("Nombre");
        $this->defineAttribute("type")->setType(static::TYPE_ENUM,
                [
            "admin" => "Administrativa", "func" => "Funcional",
            "staff" => "Staff"])->setLabel("Tipo");
        $this->defineAttribute("parent")->setType(static::TYPE_FOREIGN_KEY,
                [static::class => []])->setLabel("Depende de");
    }

}
