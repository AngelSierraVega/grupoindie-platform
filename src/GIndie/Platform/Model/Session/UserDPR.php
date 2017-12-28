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

use GIndie\Platform\Model\Database\Record;

/**
 * Description of User
 * @deprecated since version number
 *
 * @since       2017-02-03
 * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @version     beta.00.01
 */
class User extends Record {

    const NAME = "User";

    /**
     * The name of the database storing the record.
     * @version     GIP.00.01
     */
    const SCHEMA = "mr_sesion";

    /**
     * The name of the table storing the the record.
     * @version     GIP.00.01
     */
    const TABLE = "usuario_cuenta";

    /**
     * The primary key of the record.
     * @version     GIP.00.01
     */
    const PRIMARY_KEY = "key";

    /**
     * @since       beta.00.01
     * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
     * 
     * @version     GIP.00.01
     */
    public function defineAttributes() {
        $this->defineAttribute("key");
        $this->defineAttribute("user")->setType(static::TYPE_EMAIL)->setLabel("Clave de usuario (correo)");
        $this->defineAttribute("password_su")->setType(static::TYPE_PASSWORD)->setLabel("Contraseña de uso único");
        $this->defineAttribute("password_enct")->setType(static::TYPE_PASSWORD)->setLabel("Contraseña de usuario");
    }

}
