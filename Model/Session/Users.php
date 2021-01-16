<?php

/*
 * Copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @license file://LICENSE
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
