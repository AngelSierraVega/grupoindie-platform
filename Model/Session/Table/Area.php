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

namespace GIndie\Platform\Model\Session\Table;

use GIndie\Platform\Model\Database\Table;

/**
 * Description of Area
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Area extends Table {

    const NAME = "Unidades";

    /**
     * The name of the database
     */
    const DATABASE = "gip_session";

    /**
     * The name of the table
     */
    const TABLE = "area";
    const ROW_ID = "id";

    protected function defineColumns() {
        $this->defineColumn("id");
        $this->defineColumn("name");
        //$this->defineColumn("users")->setLabel("Usuarios");
        //$this->defineColumn("password_enct")->setLabel("Contraseña (Enc.)");;
    }

}
