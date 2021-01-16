<?php

/**
 * AdministracionIngresos - Tabla 2017-06-10
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\Model\Datos
 * @version DEPRECATED
 */

namespace GIndie\Platform\Model\Datos\mr_sesion\bitacora;

use GIndie\Platform\Model\Database\Table;

/**
 * <b>Tabla</b> de la bitacora de registros del sistema.
 * @author Izmir Sanchez Juarez <izmirrreffi@gmail.com>
 * @since MR-ADIN.00.01
 * @todo
 * - Move \Straffsa\SistemaIntegralIngresos funcionality 
 */
class Tabla extends Table {

    /**
     * Nombre del modelo de datos.
     * @var string
     * @since MR-ADIN.00.01
     */
    const NAME = "Bitacora";

    /**
     * Define la base de datos en que se almacena la tabla
     * @since MR-ADIN.00.01
     */
    const DATABASE = "mrdemo_sesion";

    /**
     * Define la tabla de la Base de Datos
     * @since MR-ADIN.00.01
     */
    const TABLE = "bitacora";

    /**
     * Fila id del modelo de datos.
     * @since MR-ADIN.00.01
     */
    const ROW_ID = "id";

    /**
     * Modelo de datos relacionado con la lista.
     * @since MR-ADIN.00.01
     */
    //const RELATED_RECORD = "Straffsa\SistemaIntegralIngresos\Datos\mr_sesion\usuario_cuenta\Registro";


    /**
     * Define los atributos del modelo de datos.
     * @since MR-ADIN.00.01
     */
    protected function defineColumns() {
        $this->defineColumn("id");
        $this->defineColumn("fk_usuario_cuenta")->setLabel("fk_usuario_cuenta");
        $this->defineColumn("action")->setLabel("action");
        $this->defineColumn("action-id")->setLabel("action-id");
        $this->defineColumn("action-class")->setLabel("action-class");
        $this->defineColumn("selected-id")->setLabel("selected-id");
        $this->defineColumn("timestamp")->setLabel("timestamp");
        $this->defineColumn("notas")->setLabel("notas");
    }

}
