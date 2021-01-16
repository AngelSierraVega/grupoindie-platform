<?php

/**
 * AdministracionIngresos - Lista 2017-06-10
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\Model\Datos
 * @version DEPRECATED
 */

//namespace Straffsa\SistemaIntegralIngresos\Datos\mr_sesion\unid_admin;

use GIndie\Platform\Model\Database\ListSimple;

/**
 * <b>Lista<\b> de las unidades administrativas registradas
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @since MR-ADIN.00.01
 * @todo
 * - Move \Straffsa\SistemaIntegralIngresos funcionality 
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
    const RELATED_RECORD = "\Straffsa\SistemaIntegralIngresos\Datos\mr_sesion\unid_admin\Registro";

}
