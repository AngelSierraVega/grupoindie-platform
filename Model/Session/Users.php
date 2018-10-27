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
 * Description of Users
 *
 * @package GIndie\Platform\Model
 *
 * @version DEPRECATED
 */
class Users extends Table
{

    const NAME = "Usuarios";

    /**
     * The name of the database
     */
    const DATABASE = "gip_session";

    /**
     * The name of the table
     */
    const TABLE = "user";
    const ROW_ID = "key";

    protected function defineColumns()
    {
        $this->defineColumn("key")->setLabel("Llave única");
        $this->defineColumn("user")->setLabel("Usuario");
        //$this->defineColumn("users")->setLabel("Usuarios");
        //$this->defineColumn("password_enct")->setLabel("Contraseña (Enc.)");;
    }

//    public function __construct() {
//        
//        $this->addRow(["name" => "[tratamiento] Nombre(s) Apellido1 Apellido 2", "email" => "email@domain"]);
//        $this->addRow(["name" => "[tratamiento] Nombre(s) Apellido1 Apellido 2", "email" => "email@domain"]);
//        $this->addRow(["name" => "[tratamiento] Nombre(s) Apellido1 Apellido 2", "email" => "email@domain"]);
//        $this->addRow(["name" => "[tratamiento] Nombre(s) Apellido1 Apellido 2", "email" => "email@domain"]);
//        $this->addRow(["name" => "[tratamiento] Nombre(s) Apellido1 Apellido 2", "email" => "email@domain"]);
//    }
}
