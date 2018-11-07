<?php

/**
 * AdministracionIngresos - caja_cobro
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\Model
 *
 * @version 0C.70
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
