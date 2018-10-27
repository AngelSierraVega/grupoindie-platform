<?php

/**
 * GIplatform - UserNew 2017-05-31
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\Model
 *
 * @version DEPRECATED
 */

namespace GIndie\Platform\Model\Session;

use GIndie\Platform\Model\Database\Record;

/**
 * Description of UserNew
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class UserNew extends Record {

    const NAME = "User";

    /**
     * The name of the database storing the record.
     */
    const SCHEMA = "mr_sesion";

    /**
     * The name of the table storing the the record.
     */
    const TABLE = "usuario_cuenta";

    /**
     * The primary key of the record.
     */
    const PRIMARY_KEY = "key";

    /**
     * @since       beta.00.01
     * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
     * 
     */
    public function defineAttributes() {
        $this->defineAttribute("key")->excludeFromForm();
        $this->defineAttribute("user")->setType(static::TYPE_EMAIL)->setLabel("Clave de usuario (correo)")->setRestrictionRequired();
        $this->defineAttribute("password_su")->setType(static::TYPE_PASSWORD)->setLabel("Contraseña de uso único");
        $this->defineAttribute("password_enct")->setType(static::TYPE_PASSWORD)->setLabel("Contraseña de usuario")->setRestrictionRequired();
        
        
        
        $this->defineAttribute("area")->setType(static::TYPE_FOREIGN_KEY,
                [\GIndie\Platform\Model\Session\Area::class => []])->setLabel("Unidad administrativa");
        
    }

    public function create() {
        $tmp = $this->getAttribute("user")->getValue();
        $this->defineAttribute("key")->setValue(\GIndie\Platform\Security::tokenizeSecure($tmp));
        $pwd_su = $this->getAttribute("password_su")->getValue();
        $this->defineAttribute("password_su")->setValue(\GIndie\Platform\Security::enctript($pwd_su));
        $pwd = $this->getAttribute("password_enct")->getValue();
        $this->defineAttribute("password_enct")->setValue(\GIndie\Platform\Security::enctript($pwd));
        return parent::create();
    }

}
