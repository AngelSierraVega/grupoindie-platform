<?php

/**
 * GIplatform - Config 
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * 
 */

namespace GIndie\Platform;

/**
 * Description of Config
 * 
 * @deprecated since GIP.00.03
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @version GIP.00.00 17-05-22
 * @edit GIP.00.02
 * @edit GIP.00.03
 * - Deprecated class. Commented source code
 */
abstract class Config implements ConfigINT
{
    /**
     * 
     * @todo [Configuración global para definir error_reporting de PHP ]
     * @since GIP.00.01
     * public static $DEBUG = \FALSE;
     */
    /**
     * @deprecated since GIP.00.02
     * @since GIP.00.01
     * public static $TOKENIZE_IDS = \TRUE;
     */
    /**
     * @deprecated since GIP.00.02
     * @since GIP.00.01
     */
    //const HOST = \NULL;

    /**
     * Obtiene el HOST
     * @todo Convertir a función abstracta. 
     *      -Eliminar constante. 
     *      -Leer desde archivo externo de configuración
     * @return string
     * @since GIP.00.02
     * public function getHostDPR() {
      return static::HOST;
      }
     */
    /**
     * @deprecated since GIP.00.02
     * @since GIP.00.01
     */
    //const PATH_TO_PROJECT = \NULL;

    /**
     * Obtiene la ruta al proyecto actual
     * @todo Convertir a función abstracta. 
     *      -Eliminar constante. 
     *      -Leer desde archivo externo de configuración
     * @return string
     * @since GIP.00.02
     * public function getPathToProjectDPR() {
      return static::PATH_TO_PROJECT;
      }
     */
    /**
     * @deprecated since GIP.00.02
     * @since GIP.00.01
     */
    //const PATH_TO_ASSETS = \NULL;

    /**
     * @deprecated since GIP.00.02
     * Obtiene la ruta al folder de assets del proyecto
     * @return string
     * @since GIP.00.02
     * @todo Convertir a función abstracta. 
     *      -Eliminar constante. 
     *      -Leer desde archivo externo de configuración
     * public function getPathToAssetsDPR() {
      return static::PATH_TO_ASSETS;
      }
     */
    /**
     * @deprecated since GIP.00.02
     * @since GIP.00.01
     */
    //const SESSION_CONTROLLER = \FALSE;
}
