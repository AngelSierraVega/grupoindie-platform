<?php

/**
 * AdministracionIngresos - caja_cobro
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\Model
 *
 * @version 0C.80
 * @since 17-07-02
 */

namespace GIndie\Platform\Model;

/**
 * Description of RecordINT
 *
 * @edit 18-02-27
 */
interface RecordINT
{

    /**
     * Define los <b>atributos</b> del registro.
     */
    public static function configAttributes();

    /**
     * Define los <b>permisos</b> del registro.
     * 
     */
    public static function defineRecordRestrictions();
}
