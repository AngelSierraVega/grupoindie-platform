<?php

/**
 * GIplatform - ConfigINT 2017-06-17
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.04
 */

namespace GIndie\Platform;

/**
 * Description of ConfigINT
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
interface ConfigINT
{

    /**
     * Nombre de la aplicación
     * @version GIP.00.04
     */
    public static function appNombre();
    
    /**
     * URL a la página oficial de la institución/organismo
     * @version GIP.00.04
     */
    public static function urlInstitucion();

    /**
     * Host de la aplicación (url)
     * @version GIP.00.03
     */
    public static function hostAplicacion();
    
    /**
     * Ruta real de la aplicación
     * @version GIP.00.03
     */
    public static function rutaAplicacion();

    /**
     * Host de las facturas (ruta real)
     * @version GIP.00.03
     */
    public static function hostFacturas();

    /**
     * Host de los respaldos (ruta real)
     * @version GIP.00.03
     */
    public static function hostRespaldos();

    /**
     * URL al logotipo de la aplicación
     * @version GIP.00.03
     */
    public static function logoAplicacion();

    /**
     * URL al logotipo de la institución
     * @version GIP.00.03
     */
    public static function logoInstitucion();

    /**
     * URL al logotipo de las facturas
     * @version GIP.00.03
     */
    public static function logoFacturas();

    /**
     * Ruta real a las facturas
     * @version GIP.00.03
     */
    public static function rutaFacturas();

    /**
     * Ruta real a los recibos
     * @version GIP.00.03
     */
    public static function rutaRecibos();

    /**
     * Ruta real a los recibos
     * @version GIP.00.03
     */
    public static function rutaRespaldos();

    /**
     * Slogan
     * @version GIP.00.03
     */
    public static function sloganAplicacion();

    /**
     * Ruta a la carpeta que almacena los assets de la aplicación
     * @version GIP.00.03
     */
    public static function urlAssets();

    /**
     * URL a la carpeta que almacena las facturas
     * @version GIP.00.03
     */
    public static function urlFacturas();

    /**
     * URL a la carpeta que almacena los recibos
     * @version GIP.00.03
     */
    public static function urlRecibos();
}
