<?php

/**
 * GIplatform - Area 2017-05-31
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.00
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
     * @version     GIP.00.01
     */
    const DATABASE = "gip_session";

    /**
     * The name of the table
     * @version     GIP.00.01
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
