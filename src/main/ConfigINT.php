<?php

/**
 * GIplatform - ConfigINT 2017-06-17
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.01
 */

namespace GIndie\Platform;

/**
 * Description of ConfigINT
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
interface ConfigINT {

    /**
     * Obtiene la <b>ruta al logotipo</b> del proyecto.
     * @since GIP.00.01
     * @todo Leer desde archivo externo de configuración
     */
    //public static function getPathToBrand();

    /**
     * Define el <b>slogan</b> del proyecto
     * @since GIP.00.01
     * @todo Leer desde archivo externo de configuración
     */
    //public static function getSlogan();
    
    //public static function pathToFacturas();
    
    //public static function pathToRecibos();
    
    public static function hostAplicacion();

    /**
     * Host de las facturas (ruta real)
     * @version MR-ADIN.00.03
     */
    public static function hostFacturas();

    /**
     * Host de los respaldos (ruta real)
     * @version MR-ADIN.00.03
     */
    public static function hostRespaldos();

    /**
     * Ruta a la carpeta que almacena los assets de la aplicación
     * @version MR-ADIN.00.03
     */
    public static function urlAssets();

    /**
     * URL a la carpeta que almacena las facturas
     * @version MR-ADIN.00.03
     */
    public static function urlFacturas();

    /**
     * URL a la carpeta que almacena los recibos
     * @version MR-ADIN.00.03
     */
    public static function urlRecibos();

    /**
     * Ruta real a las facturas
     * @version MR-ADIN.00.03
     */
    public static function rutaFacturas();

    /**
     * Ruta real a los recibos
     * @version MR-ADIN.00.03
     */
    public static function rutaRecibos();
    
    /**
     * Ruta real a los recibos
     * @version MR-ADIN.00.03
     */
    public static function rutaRespaldos();

    /**
     * URL al logotipo de la aplicación
     * @version MR-ADIN.00.03
     */
    public static function logoAplicacion();

    /**
     * URL al logotipo de la institución
     * @version MR-ADIN.00.03
     */
    public static function logoInstitucion();

    /**
     * URL al logotipo de las facturas
     * @version MR-ADIN.00.03
     */
    public static function logoFacturas();

    /**
     * Slogan
     * @version MR-ADIN.00.03
     */
    public static function sloganAplicacion();
}
