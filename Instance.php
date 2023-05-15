<?php

/**
 * GI-Platform-DVLP - Instance
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform
 *
 * @version 0D.90
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
 * @edit 23-05-13
 * - Removed some Config.ini dependencies
 * - Removed deprecated methods and variables
 */
abstract class Instance implements DataDefinition\Instance
{

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
     * {@inheritdoc}
     * 
     * @edit 17-12-27
     */
    public static function urlAssets()
    {
        return \GIndie\Platform\INIHandler::getCategoryValue("Config", "assets_url");
    }


    /**
     * Ruta real a los respaldos
     * @since 17-12-26
     * @edit 18-03-23
     * - Not deprecated 
     * @edit 18-03-23
     * @deprecated since 23-05-14
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
     * URL al logotipo de la aplicación
     * @edit 17-12-27
     */
//    public function logoAplicacion()
//    {
//        return \GIndie\Platform\INIHandler::getCategoryValue("Instance", "logo");
//    }
    
    /**
     * {@inheritdoc}
     * @since 23-05-12
     */
    public static function vendorMessage(){
        return "Éste sistema ha sido desarrollado utilizando la Plataforma de Grupo INDIE.";
    }
    
    /**
     * {@inheritdoc}
     * @since 23-05-12
     */
    public static function urlVendor(){
        return "https://grupoindie.com";
    }
    
    /**
     * {@inheritdoc}
     * @since 23-05-12
     */
    public static function urlVendorLogo(){
        return static::urlAssets(). "img\\LogoIndie.png";
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
            return new View\Login(static::urlAppLogo(), static::appName() ,
                static::urlAssets(), static::urlVendor());
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
