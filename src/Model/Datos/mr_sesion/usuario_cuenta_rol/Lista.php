<?php

/**
 * AdministracionIngresos - Lista 2017-06-10
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package MineralDeLaReforma
 * @subpackage AdmininstracionIngresos
 *
 * @version MR-ADIN.00.01
 */

namespace GIndie\Platform\Model\Datos\mr_sesion\usuario_cuenta_rol;

use GIndie\Platform\Model\Database\ListSimple;

/**
 * <b>Lista<\b> de las unidades administrativas registradas
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @since MR-ADIN.00.01
 */
class Lista extends ListSimple {

    /**
     * Unidades administrativas
     * @var string
     * @since MR-ADIN.00.01
     */
    //const NAME = "Roles de usuario";

    /**
     * mr_sesion
     * @since MR-ADIN.00.01
     */
    //const DATABASE = "mrdemo_sesion";

    /**
     * unid_admin
     * @since MR-ADIN.00.01
     */
    //const TABLE = "usuario_cuenta_rol";

    /**
     * id
     * @since MR-ADIN.00.01
     */
    //const ELEMENT_ID = "fk_rol";

    /**
     * nombre
     * @since MR-ADIN.00.01
     */
    //const ELEMENT_NAME = "fk_usuario_cuenta";

    /**
     * parent
     * @since MR-ADIN.00.01
     */
    //const ELEMENT_AUTONEST_ON = \NULL;

//    /**
//     * Registro
//     * @since MR-ADIN.00.01
//     */
//    const RELATED_RECORD = \NULL;
    public static function RelatedRecord()
    {
        return Registro::class;
    }

}
