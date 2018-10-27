<?php

/**
 * AdministracionIngresos - Lista 2017-06-10
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\Model\Datos
 * @version DEPRECATED
 */

namespace GIndie\Platform\Model\Datos\mr_sesion\sesion;

use GIndie\Platform\Model\Database\ListSimple;

/**
 * <b>Lista<\b> de las unidades administrativas registradas
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @since MR-ADIN.00.01
 */
class Lista extends ListSimple {

    /**
     * El nombre de la Lista
     * @var string
     * @since MR-ADIN.00.01
     */
    //const NAME = "Sesión de usuario";

    /**
     * []
     * @since MR-ADIN.00.01
     */
    //const DATABASE = "mrdemo_sesion";

    /**
     * []
     * @since MR-ADIN.00.01
     */
    //const TABLE = "sesion";

    /**
     * []
     * @since MR-ADIN.00.01
     */
    //const ELEMENT_ID = "fk_usuario_cuenta";

    /**
     * []
     * @since MR-ADIN.00.01
     */
    //const ELEMENT_NAME = "php_sess_id";

    /**
     * []
     * @since MR-ADIN.00.01
     */
    //const ELEMENT_AUTONEST_ON = \NULL;

    /**
     * Registro relacionado
     * @since MR-ADIN.00.01
     */
    //const RELATED_RECORD = \NULL;
    
    public static function RelatedRecord()
    {
        return Registro::class;
    }

}
