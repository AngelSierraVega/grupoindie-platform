<?php

/**
 * GI-Platform-DVLP - Instance
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform
 *
 * @version 0D.78
 * @since 17-05-23
 * @todo Upgrade class
 */

namespace GIndie\Platform;

use GIndie\Platform\Current;
use GIndie\ScriptGenerator\HTML5;

/**
 * Description of Platform
 * 
 * @edit 17-12-26 
 * - Deprecated methods appNombre(), urlInstitucion(), hostAplicacion(), hostAplicacion()
 *   hostFacturas(), hostRespaldos(), urlAssets(), urlFacturas(), urlRecibos(), rutaFacturas(),
 *   rutaRespaldos(), logoAplicacion(), logoInstitucion(), logoFacturas(), sloganAplicacion()
 * @edit 17-12-27 
 * - Used \GIndie\Platform\INIHandler::getCategoryValue in previously deprecated methods.
 * @edit 18-01-14 
 * - Bitácora restaurada
 * @edit 18-11-05
 * - Removed use of deprecated libs
 * - Removed \Straffsa\SistemaIntegralIngresos dependency
 */
abstract class Instance
{

    /**
     * 
     */
    const CONFIG_CLASS = \NULL;

    /**
     * Nombre de la aplicación mas el nombre de la instancia.
     * @edit 18-01-14
     */
    public function appNombre()
    {
        return static::BRAND_NAME;
    }

    /**
     * Ruta real a las facturas
     * @edit 17-12-27
     */
    public function urlInstitucion()
    {
        return \GIndie\Platform\INIHandler::getCategoryValue("Vendor", "url");
    }

    /**
     * 
     * @return type
     * @edit 17-12-27
     */
    public function hostAplicacion()
    {
        return \GIndie\Platform\INIHandler::getCategoryValue("Config", "host");
    }

    /**
     * Host de las facturas (ruta real)
     * @deprecated since 17-12-26
     */
    public function hostFacturas()
    {
        \trigger_error("hostFacturas is to be removed", \E_USER_DEPRECATED);
        $configClass = static::CONFIG_CLASS;
        return $configClass::hostFacturas();
    }

    /**
     * Host de los respaldos (ruta real)
     * @deprecated since 17-12-26
     */
    public function hostRespaldos()
    {
        \trigger_error("hostRespaldos is to be removed", \E_USER_DEPRECATED);
        $configClass = static::CONFIG_CLASS;
        return $configClass::hostRespaldos();
    }

    /**
     * Ruta a la carpeta que almacena los assets de la aplicación
     * @edit 17-12-27
     */
    public function urlAssets()
    {
        return \GIndie\Platform\INIHandler::getCategoryValue("Config", "assets_url");
    }

    /**
     * URL a la carpeta que almacena las facturas
     * @deprecated since 17-12-26
     */
    public function urlFacturas()
    {
        \trigger_error("urlFacturas is to be removed", \E_USER_DEPRECATED);
        $configClass = static::CONFIG_CLASS;
        return $configClass::urlFacturas();
    }

    /**
     * URL a la carpeta que almacena los recibos
     * @edit 18-01-14
     * - Not deprecated 
     */
    public function urlRecibos()
    {
        return $this->rutaRecibos();
//        \trigger_error("Use INIHandler insted", \E_USER_DEPRECATED);
//        $configClass = static::CONFIG_CLASS;
//        return $configClass::urlRecibos();
    }

    /**
     * Ruta real a las facturas
     * @edit 18-01-14
     * - Not deprecated 
     */
    public function rutaFacturas()
    {
        return $this->rutaRecibos();
//        \trigger_error("Use INIHandler insted", \E_USER_DEPRECATED);
//        $configClass = static::CONFIG_CLASS;
//        return $configClass::rutaFacturas();
    }

    /**
     * Ruta real a los respaldos
     * @since 17-12-26
     * @edit 18-03-23
     * - Not deprecated 
     * @edit 18-03-23
     */
    public function rutaRespaldos()
    {
        $ini = \GIndie\Platform\INIHandler::getCategoryValue("Path", "generatedFiles");
        if ($ini) {
            return $ini;
        } else {
            \GIndie\Common\PHP\Directories::createFolderStructure(\dirname($_SERVER['SCRIPT_FILENAME']),
                "\\private\\respaldos\\");
            return \dirname($_SERVER['SCRIPT_FILENAME']) . "\\private\\respaldos\\";
        }
    }

    /**
     * Ruta real a los recibos
     * @NOTdeprecated since 18-01-14
     * @todo 
     * - Verificar ruta automática
     */
    public function rutaRecibos()
    {
        $ini = \GIndie\Platform\INIHandler::getCategoryValue("Path", "generatedFiles");
        if ($ini) {
            return $ini;
        } else {
            return \dirname($_SERVER['SCRIPT_FILENAME']) . "/private/generado/";
        }
    }

    /**
     * URL al logotipo de la aplicación
     * @edit 17-12-27
     */
    public function logoAplicacion()
    {
        return \GIndie\Platform\INIHandler::getCategoryValue("Instance", "logo");
    }

    /**
     * URL al logotipo de la institución
     * @edit 17-12-27
     */
    public function logoInstitucion()
    {
        return \GIndie\Platform\INIHandler::getCategoryValue("Vendor", "logo");
    }

    /**
     * URL al logotipo de las facturas
     * @deprecated since 17-12-26
     */
    public function logoFacturas()
    {
        throw new \Exception("Deprecated. Use INIHandler instead");
        \trigger_error("Use INIHandler insted", \E_USER_DEPRECATED);
        $configClass = static::CONFIG_CLASS;
        return $configClass::logoFacturas();
    }

    /**
     * Slogan
     * @edit 17-12-27
     */
    public function sloganAplicacion()
    {
        return \GIndie\Platform\INIHandler::getCategoryValue("Config", "slogan");
    }

    /**
     * Define el nombre de la instancia actual
     * @since GIP.00.01
     */
    const NAME = \NULL;

    /**
     * Obtiene el <b>slogan</b> declarado para la <b>Instancia</b> actual.
     * @author Izmir Sanchez Juarez <izmirreffi@gmail.com>
     * @since 17-12-26
     * @edit 17-06-17 <angel.sierra@grupoindie.com>
     *      - Se redeclaró la función desde GIndie\Platform.
     *      - Se redeclaró el método de estático a dinámico.
     *      - La constante es accesada desde el archivo de configuración instanciado
     */
    public function getSloganDPR()
    {
        \trigger_error("Use INIHandler insted", \E_USER_DEPRECATED);
        $configClass = static::CONFIG_CLASS;
        return $configClass::getSlogan();
    }

    /**
     * Obtiene la <b>ruta del logo</b> declarada para la <b>Instancia</b> actual.
     * @author Izmir Sanchez Juarez <izmirreffi@gmail.com>
     * @since GIndie\Platform::17-12-26
     * @edit 2017-06-17 <angel.sierra@grupoindie.com>
     *      - Se redeclaró la función desde GIndie\Platform.
     *      - Se redeclaró el método de estático a dinámico.
     *      - La constante es accesada desde el archivo de configuración instanciado
     */
    public function getImageBrandDPR()
    {
        \trigger_error("Use INIHandler insted", \E_USER_DEPRECATED);
        $configClass = static::CONFIG_CLASS;
        return $configClass::getPathToBrand();
    }

    /**
     * Obtiene la <b>ruta del proyecto</b>.
     */
    public static function getProjectPathDPR()
    {
        \trigger_error("Use INIHandler insted", \E_USER_DEPRECATED);
        $configClass = static::CONFIG_CLASS;
        $assetsFolder = $configClass::HOST . $configClass::PATH_TO_PROJECT;
        return $assetsFolder;
    }

    /**
     * Ruta a la carpeta que almacena las facturas
     */
    public static function hostDPR()
    {
        \trigger_error("Use INIHandler insted", \E_USER_DEPRECATED);
        $configClass = static::CONFIG_CLASS;
        return $configClass::HOST;
    }

    /**
     * Ruta a la carpeta que almacena las facturas
     */
    public static function pathToFacturasDPR()
    {
        \trigger_error("Use INIHandler insted", \E_USER_DEPRECATED);
        $configClass = static::CONFIG_CLASS;
        return $configClass::pathToFacturas();
    }

    /**
     * Ruta a la carpeta que almacena los recibos
     */
    public static function pathToRecibosDPR()
    {
        \trigger_error("Use INIHandler insted", \E_USER_DEPRECATED);
        $configClass = static::CONFIG_CLASS;
        return $configClass::pathToRecibos();
    }

    /**
     */
    public static function getAssetsPathDPR()
    {
        \trigger_error("Use INIHandler insted", \E_USER_DEPRECATED);
        $configClass = static::CONFIG_CLASS;
        return $configClass::PATH_TO_ASSETS;
        //return $assetsFolder;
    }

    /**
     * @todo Definir links desde el archivo global de configuración
     * @var null|array 
     */
    private static $_LINKS = [];

    /**
     * @deprecated since GIP.00.02
     * @var array 
     */
    private static $_MODULES = [];

    /**
     * Crea una nueva instancia de la plataforma
     * @final
     */
    final private function __construct()
    {
        static::BRAND_NAME !== \NULL ?: trigger_error("Constant BRAND_NAME must be defined inside class definition of: " . get_called_class(),
                    \E_USER_ERROR);
        //static::CONFIG_CLASS !== \NULL ?: trigger_error("Constant CONFIG_CLASS must be defined inside class definition of: " . get_called_class(), \E_USER_ERROR);
        if (Current::Instance() !== \NULL) {
            static::config();
        }
    }

    /**
     * []
     * @abstract
     */
    abstract public function config();

    /**
     * 
     * @param string $classname
     * @param boolean|string $config true for show, false for hide, string for group
     * @param string|null $groupName overrides Module::category() use only if necesary for module
     * dulplication
     * 
     * @return \GIndie\Platform\Controller\Module
     * @throws \Exception
     * @edit 18-06-13
     * - Optimized funcionality
     * @edit 18-12-21
     * - Graciously handle $groupName
     */
    public function setModule($classname, $groupName = null)
    {
        switch (false)
        {
            case \is_subclass_of($classname, Controller\Module::class, true):
                \trigger_error("Class {$classname} is not subclass of " .
                    Controller\Module::class, \E_USER_ERROR);
        }
        self::$_MODULES[$classname] = \is_null($groupName) ? $classname::category() : $groupName;
        return isset(self::$_MODULES[$classname]);
    }

    /**
     * 
     * 
     * @param string $classname
     * @param string|null $href Null for hiding
     * 
     * @throws \Exception
     * @return boolean 
     */
    public function getModules()
    {
        return self::$_MODULES;
    }

    /**
     * 
     * 
     * @param string $classname
     * @param string|null $href Null for hiding
     * 
     * @throws \Exception
     * @return boolean 
     */
    public function setPlatformLink($classname, $href)
    {
        if (!\is_subclass_of($classname, self::class, \TRUE)) {
            $class = self::class;
            trigger_error("Classname {$classname} is not subclass of {$class} ", E_USER_ERROR);
            throw new \Exception("Unable to run.");
        }
        self::$_LINKS[$classname] = $href;
        return isset(self::$_LINKS[$classname]);
    }

    /**
     * 
     * 
     * @param string $classname
     * @param string|null $href Null for hiding
     * 
     * @throws \Exception
     * @return boolean 
     */
    public function getPlatformLinks()
    {
        return self::$_LINKS;
    }

    /**
     * [Despliegue de una excepción al usuario final]
     * 
     * @param \Exception $e
     * @todo Funcionalidad y pruebas
     */
    public static function displayException(\Exception $e)
    {
        return $e->getMessage();
    }

    /**
     * Verifica si se está intentando autenticar una sesión
     */
    private static function _isLoginAttempt()
    {
        switch (\FALSE)
        {
            case ($_SERVER["REQUEST_METHOD"] === "POST"):
                return \FALSE;
            case (\array_key_exists("gip-action", $_POST)):
                return \FALSE;
            case (\strcmp($_POST["gip-action"], "gip-login") === 0 ):
                return \FALSE;
        }
        return \TRUE;
    }

    /**
     * Verifica si es posible reiniciar una sesión
     */
    private static function _isRestartAttempt()
    {
        switch (\FALSE)
        {
            case (\array_key_exists(\session_name(), $_COOKIE)):
                return \FALSE;
            case (\strcmp($_COOKIE[\session_name()], "") !== 0 ):
                return \FALSE;
        }
        return \TRUE;
    }

    /**
     * [description]
     * 
     * @edit 18-01-14
     * @edit 18-04-01
     * @edit 18-10-27
     * - Se eliminó referencia a SII
     * @edit 18-12-26
     * - Max execution time updated to 1200
     * @edit 19-01-07
     * - Sleep set to 001000
     */
    final public static function run()
    {
        \date_default_timezone_set("America/Mexico_City");
        \set_time_limit(1200);
        /**
         * Retrasa la ejecución del código por 0.1 seg. Distribuye la carga de peticiones.
         * \time_nanosleep(0,100000000);
         */
        \usleep(001000);
        //\usleep(100000);
        if (\session_status() === \PHP_SESSION_NONE) {
            try {
                if (static::_isLoginAttempt()) {
                    Security::startSession();
                    Current::setInstance(new static());
                    Current::setInstance(new static());
                    Current::setModule(new Controller\Module\Welcome());
                    $data = [];
                    $data['pltfrm_cta_fk'] = \GIndie\Platform\Current::User()->getId();
                    $data['action'] = "gip-login";
                    $data['timestamp'] = \time();
                    $nota = "Ingresó al sistema con correo y contraseña";
                    $data['notes'] = \filter_var($nota, \FILTER_SANITIZE_SPECIAL_CHARS);
                    $bitacora = DataModel\Platform\LogUser::instance($data);
                    $bitacora->run("gip-inner-create");
                }
                if (static::_isRestartAttempt()) {
                    Security::restartSession();
                }
            } catch (\GIndie\Platform\ExceptionLogin $e) {
                $params = \session_get_cookie_params();
                \setcookie(\session_name(), '', \time() - 42000, $params["path"],
                    $params["domain"], $params["secure"], $params["httponly"]
                );
                if ($_SERVER["REQUEST_METHOD"] === "POST") {//
                    $response = HTML5\Category\Basic::Paragraph($e->getMessage());
                    $response->addScript("setTimeout(function(){location.replace(location.pathname);}, 1000);");
                    return $response;
                } else {
                    \header("Refresh: 1; url=" . $_SERVER['PHP_SELF']);
                    return "ExceptionLogin: " . $e->getMessage();
                }
            } catch (\Exception $e) {
                \header("Refresh: 1; url=" . $_SERVER['PHP_SELF']);
                return "Exception: " . $e->getMessage();
            }
        }
        if (\session_status() == \PHP_SESSION_NONE) {
            $instance = new static();
            return new View\Login($instance->logoAplicacion(), $instance->sloganAplicacion(),
                $instance->urlAssets(), $instance->logoInstitucion());
        }
        try {
            switch ($_SERVER["REQUEST_METHOD"])
            {
                case "GET":
                    if (isset($_GET["gip-action"])) {
                        switch ($_GET["gip-action"])
                        {
                            case "descargar-pdf":
                                $_class = \NULL;
                                $_action = "descargar-pdf";
                                $_action_id = \NULL;
                                $_selected_id = \NULL;
                                break;
                            case "descargar-xml":
                                $_class = \NULL;
                                $_action = "descargar-xml";
                                $_action_id = \NULL;
                                $_selected_id = \NULL;
                                break;
                            default:
                                $instance = new static();
                                Current::setInstance($instance);
                                Current::setInstance($instance);
                                Current::setModule(new Controller\Module\Welcome());
                                $_class = \NULL;
                                $_action = "load";
                                $_action_id = "document";
                                $_selected_id = \NULL;
                                break;
                        }
                    } else {
                        $instance = new static();
                        Current::setInstance($instance);
                        Current::setInstance($instance);
                        Current::setModule(new Controller\Module\Welcome());
                        $_class = \NULL;
                        $_action = "load";
                        $_action_id = "document";
                        $_selected_id = \NULL;
                    }
                    break;
                case "POST":
                    $_action = isset($_POST["gip-action"]) ? $_POST["gip-action"] : \NULL;
                    $_action_id = isset($_POST["gip-action-id"]) ? $_POST["gip-action-id"] : \NULL;
                    $_class = isset($_POST["gip-action-class"]) ? urldecode($_POST["gip-action-class"]) : \NULL;
                    $_selected_id = isset($_POST["gip-selected-id"]) ? $_POST["gip-selected-id"] : \NULL;
                    break;
                default:
                    throw new \Exception("Forbiden request method");
                    break;
            }
            return Current::Module()->run($_action, $_action_id, $_class, $_selected_id);
        } catch (\Exception $e) {
            $GLOBALS["gip-error"] = static::displayException($e);
            return static::displayException($e);
        }
    }

}
