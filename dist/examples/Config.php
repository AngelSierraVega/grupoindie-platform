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
 */
class Config extends \GIndie\Platform\Config
{

    /**
     * Nombre de la aplicación
     * @since GIP.00.01
     */
    public static function appNombre()
    {
        return "appNombre";
    }

    /**
     * Nombre de la aplicación
     * @since GIP.00.01
     */
    public static function urlInstitucion()
    {
        return "urlInstitucion";
    }

    /**
     * Host de la aplicación
     * @since GIP.00.01
     */
    public static function hostAplicacion()
    {
        return "http:\\\\local.dvlp\\Platform\\dist\\examples\\";
        //return "http:\\\\192.168.1.19\\";
    }

    /**
     * Ruta real de la aplicación
     * @since GIP.00.01
     */
    public static function rutaAplicacion()
    {
        return $_SERVER['DOCUMENT_ROOT'];
    }

    /**
     * Host de las facturas (ruta real)
     * @since GIP.00.01
     */
    public static function hostFacturas()
    {
        //return "/home/informatica/documentos/";
        return $_SERVER['DOCUMENT_ROOT'];
    }

    /**
     * Host de los respaldos (ruta real)
     * @since GIP.00.01
     */
    public static function hostRespaldos()
    {
        return $_SERVER['DOCUMENT_ROOT'];
    }

    /**
     * Ruta a la carpeta que almacena los assets de la aplicación
     * @since GIP.00.01
     */
    public static function urlAssets()
    {
        return "http:\\\\local.mr-sii\\assets\\";
    }

    /**
     * URL a la carpeta que almacena las facturas
     * @since GIP.00.01
     */
    public static function urlFacturas()
    {
        return static::hostAplicacion() . "generado\\factura\\";
    }

    /**
     * URL a la carpeta que almacena los recibos
     * @since GIP.00.01
     */
    public static function urlRecibos()
    {
        return static::hostAplicacion() . "generado\\recibo\\";
    }

    /**
     * Ruta real a las facturas
     * @since GIP.00.01
     */
    public static function rutaFacturas()
    {
        return static::hostFacturas();
        //return static::hostFacturas() . "generado/factura/";
    }

    /**
     * Ruta real a los recibos
     * @since GIP.00.01
     */
    public static function rutaRecibos()
    {
        return static::hostFacturas();
        //return static::hostFacturas() . "generado/recibo/";
    }

    /**
     * Ruta real a los recibos
     * @since GIP.00.01
     */
    public static function rutaRespaldos()
    {
        return static::hostRespaldos() . "private/respaldosBD/";
    }

    /**
     * URL al logotipo de la aplicación
     * @since GIP.00.01
     */
    public static function logoAplicacion()
    {
        return static::urlAssets() . "img\\icon-adminIngresos.png";
    }

    /**
     * URL al logotipo de la institución
     * @since GIP.00.01
     */
    public static function logoInstitucion()
    {
        return static::urlAssets() . "img\\logomunicipio1.png";
    }

    /**
     * URL al logotipo de las facturas
     * @since GIP.00.01
     */
    public static function logoFacturas()
    {
        return static::rutaAplicacion() . "/assets/img/logo_facturas.jpg";
    }

    /**
     * Slogan
     * @since GIP.00.01
     */
    public static function sloganAplicacion()
    {
        return "sloganAplicacion";
    }

}
