<?php

/*
 * Copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @license file://LICENSE
 */

namespace GIndie\Platform\Model\Session;

use GIndie\Platform\Model\Database\Table;

/**
 * Description of Roles
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @since 2017-05-08
 * @package GIndie\Platform\Model
 *
 * @version DEPRECATED
 */
class Roles extends Table {
    
    const ROW_ID = "role";

    public function hasRole($role) {
        return $this->getValue($role,"role");
    }

    protected function defineColumns() {
        $this->defineColumn("role");
        $this->defineColumn("user");
    }

    /**
     * The name of the database
     */
    const DATABASE = "gip_session";

    /**
     * The name of the table
     */
    const TABLE = "user_role";

}
