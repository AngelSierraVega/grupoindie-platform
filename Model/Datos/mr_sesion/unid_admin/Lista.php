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

//namespace AdminIngresos\Datos\mr_sesion\unid_admin;

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
    const NAME = "Unidades administrativas";

    /**
     * mr_sesion
     * @since MR-ADIN.00.01
     */
    const DATABASE = "mrdemo_sesion";

    /**
     * unid_admin
     * @since MR-ADIN.00.01
     */
    const TABLE = "unid_admin";

    /**
     * id
     * @since MR-ADIN.00.01
     */
    const ELEMENT_ID = "id";

    /**
     * nombre
     * @since MR-ADIN.00.01
     */
    const ELEMENT_NAME = "nombre";

    /**
     * parent
     * @since MR-ADIN.00.01
     */
    const ELEMENT_AUTONEST_ON = "parent";

    /**
     * Registro
     * @since MR-ADIN.00.01
     */
    const RELATED_RECORD = "\AdminIngresos\Datos\mr_sesion\unid_admin\Registro";

}
