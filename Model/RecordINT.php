<?php

/**
 * GIplatform - Record 2017-07-02
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.0?
 */

namespace GIndie\Platform\Model;

/**
 * Description of RecordINT
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
interface RecordINT
{

    /**
     * Define los <b>atributos</b> del registro.
     * @since GIP.00.01
     */
    public static function configAttributes();

    /**
     * @todo 
     * Define los <b>permisos</b> del registro.
     * @version GIP.00.02
     * 
     */
    public static function defineRecordRestrictions();
}
