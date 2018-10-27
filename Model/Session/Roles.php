<?php

/*
 * Copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * This software is protected under GNU: you can use, study and modify it
 * but not distribute it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
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
