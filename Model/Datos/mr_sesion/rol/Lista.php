<?php

/**
 * AdministracionIngresos - Lista 2017-06-10
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package MineralDeLaReforma
 * @subpackage AdmininstracionIngresos
 *
 * @version MR-ADIN.00.00
 */


namespace AdminIngresos\Datos\mr_sesion\rol;

use GIndie\Platform\Model\Database\ListSimple;

/**
 * <b>Lista<\b> de los roles de usuario.
 *
 * @author Liliana Hernández Castañeda <liliana.hercast@gmail.com>
 * @since MR-ADIN.00.01
 */
class Lista extends ListSimple {

  /**
   * Rol de usuario
   * @var string
   * @since MR-ADIN.00.01
   */
    const NAME = "Rol de usuario";

    /**
     * mr_sesion
     * @since MR-ADIN.00.01
     */
    const DATABASE = "mrdemo_sesion";

    /**
     * rol
     * @since MR-ADIN.00.01
     */
    const TABLE = "rol";

    /**
     * id
     * @since MR-ADIN.00.01
     */
    const ELEMENT_ID = "id";

    /**
     * descripcion
     * @since MR-ADIN.00.01
     */
    const ELEMENT_NAME = "descripcion";

    /**
     * The name of the attribute to perform the autonest
     *  @since  GIP.00.02
     */
   // const ELEMENT_AUTONEST_ON = "parent";

   /**
    * Registro
    * @since MR-ADIN.00.01
    */
    //const RELATED_RECORD = '\AdminIngresos\Datos\mr_sesion\rol\Registro';
    public static function RelatedRecord()
    {
        return Registro::class;
    }

}
