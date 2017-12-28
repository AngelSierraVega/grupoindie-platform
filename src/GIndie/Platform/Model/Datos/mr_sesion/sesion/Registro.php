<?php

/**
 * GIplatform - Registro 2017-06-11
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.01
 */

namespace GIndie\Platform\Model\Datos\mr_sesion\sesion;

use GIndie\Platform\Model\Database\Record;

/**
 * Description of Registro
 * @since GIP.00.01
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Registro extends Record {
    
//    /**
//     * Stores attribute definition
//     * @var array 
//     */
//    protected static $_attribute = [];
    
    

    const NAME = "Sesión de usuario";

    /**
     * @since GIP.00.01
     */
    //const SCHEMA = "mrdemo_sesion";

    /**
     * @since GIP.00.01
     */
    const TABLE = "sesion";

    /**
     * @since GIP.00.01
     */
    const PRIMARY_KEY = "fk_usuario_cuenta";

    /**
     * @since GIP.00.01
     */
    const AUTOINCREMENT = \FALSE;
    
    const DISPLAY_KEY = "php_sess_id";
    
    public static function configAttributes()
    {
        static::attribute("fk_usuario_cuenta");
        static::attribute("php_sess_id");
    }

}
