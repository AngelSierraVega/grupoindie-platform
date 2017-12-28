<?php

/**
 * Platform - Config 2017-12-26
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 */

/**
 * Description of Config
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @version GIP.00.00 2017-12-26 Class created
 * @edit GIP.00.01
 * - Added code from external project AdminIngresos
 * @edit GIP.00.02 17-12-27
 * - Deprecated methods
 * - Deleted methods
 */
class Config extends \GIndie\Platform\Config
{


    /**
     * Ruta real de la aplicación
     * @since GIP.00.01
     * @deprecated since GIP.00.02
     */
    public static function rutaAplicacion()
    {
        \trigger_error("Use Current::instance() instead", \E_USER_DEPRECATED);
        return $_SERVER['DOCUMENT_ROOT'];
    }

    /**
     * Host de las facturas (ruta real)
     * @since GIP.00.01
     * @deprecated since GIP.00.02
     */
    public static function hostFacturas()
    {
        \trigger_error("Use Current::instance() instead", \E_USER_DEPRECATED);
        //return "/home/informatica/documentos/";
        return $_SERVER['DOCUMENT_ROOT'];
    }

    /**
     * Host de los respaldos (ruta real)
     * @since GIP.00.01
     * @deprecated since GIP.00.02
     */
    public static function hostRespaldos()
    {
        \trigger_error("Use Current::instance() instead", \E_USER_DEPRECATED);
        return $_SERVER['DOCUMENT_ROOT'];
    }

    /**
     * URL a la carpeta que almacena las facturas
     * @since GIP.00.01
     * @deprecated since GIP.00.02
     */
    public static function urlFacturas()
    {
        \trigger_error("Use Current::instance() instead", \E_USER_DEPRECATED);
        return static::hostAplicacion() . "generado\\factura\\";
    }

    /**
     * URL a la carpeta que almacena los recibos
     * @since GIP.00.01
     * @deprecated since GIP.00.02
     */
    public static function urlRecibos()
    {
        \trigger_error("Use Current::instance() instead", \E_USER_DEPRECATED);
        return static::hostAplicacion() . "generado\\recibo\\";
    }

    /**
     * Ruta real a las facturas
     * @since GIP.00.01
     * @deprecated since GIP.00.02
     */
    public static function rutaFacturas()
    {
        \trigger_error("Use Current::instance() instead", \E_USER_DEPRECATED);
        return static::hostFacturas();
        //return static::hostFacturas() . "generado/factura/";
    }

    /**
     * Ruta real a los recibos
     * @since GIP.00.01
     * @deprecated since GIP.00.02
     */
    public static function rutaRecibos()
    {
        \trigger_error("Use Current::instance() instead", \E_USER_DEPRECATED);
        return static::hostFacturas();
        //return static::hostFacturas() . "generado/recibo/";
    }

    /**
     * Ruta real a los recibos
     * @since GIP.00.01
     * @deprecated since GIP.00.02
     */
    public static function rutaRespaldos()
    {
        \trigger_error("Use Current::instance() instead", \E_USER_DEPRECATED);
        return static::hostRespaldos() . "private/respaldosBD/";
    }

    /**
     * URL al logotipo de las facturas
     * @since GIP.00.01
     * @deprecated since GIP.00.02
     */
    public static function logoFacturas()
    {
        \trigger_error("Use Current::instance() instead", \E_USER_DEPRECATED);
        return static::rutaAplicacion() . "/assets/img/logo_facturas.jpg";
    }

}
