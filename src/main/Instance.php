<?php

/**
 * GIplatform - Instance 2017-05-23
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.0?
 */

namespace GIndie;

use GIndie\Platform\Current;
use GIndie\Platform\Model\Datos\mr_sesion;
use \GIndie\Generator\DML\HTML5;

/**
 * Description of Platform
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @since GIP.00.00
 * @version GIP.00.05
 */
abstract class Instance
{

    /**
     * @since GIP.00.01
     */
    const CONFIG_CLASS = \NULL;

    public function hostAplicacion()
    {
        $configClass = static::CONFIG_CLASS;
        return $configClass::hostAplicacion();
    }

    /**
     * Host de las facturas (ruta real)
     * @version MR-ADIN.00.03
     */
    public function hostFacturas()
    {
        $configClass = static::CONFIG_CLASS;
        return $configClass::hostFacturas();
    }

    /**
     * Host de los respaldos (ruta real)
     * @version MR-ADIN.00.03
     */
    public function hostRespaldos()
    {
        $configClass = static::CONFIG_CLASS;
        return $configClass::hostRespaldos();
    }

    /**
     * Ruta a la carpeta que almacena los assets de la aplicación
     * @version MR-ADIN.00.03
     */
    public function urlAssets()
    {
        $configClass = static::CONFIG_CLASS;
        return $configClass::urlAssets();
    }

    /**
     * URL a la carpeta que almacena las facturas
     * @version MR-ADIN.00.03
     */
    public function urlFacturas()
    {
        $configClass = static::CONFIG_CLASS;
        return $configClass::urlFacturas();
    }

    /**
     * URL a la carpeta que almacena los recibos
     * @version MR-ADIN.00.03
     */
    public function urlRecibos()
    {
        $configClass = static::CONFIG_CLASS;
        return $configClass::urlRecibos();
    }

    /**
     * Ruta real a las facturas
     * @version MR-ADIN.00.03
     */
    public function rutaFacturas()
    {
        $configClass = static::CONFIG_CLASS;
        return $configClass::rutaFacturas();
    }

    /**
     * Ruta real a los respaldos
     * @version MR-ADIN.00.03
     */
    public function rutaRespaldos()
    {
        $configClass = static::CONFIG_CLASS;
        return $configClass::rutaRespaldos();
    }

    /**
     * Ruta real a los recibos
     * @version MR-ADIN.00.03
     */
    public function rutaRecibos()
    {
        $configClass = static::CONFIG_CLASS;
        return $configClass::rutaRecibos();
    }

    /**
     * URL al logotipo de la aplicación
     * @version MR-ADIN.00.03
     */
    public function logoAplicacion()
    {
        $configClass = static::CONFIG_CLASS;
        return $configClass::logoAplicacion();
    }

    /**
     * URL al logotipo de la institución
     * @version MR-ADIN.00.03
     */
    public function logoInstitucion()
    {
        $configClass = static::CONFIG_CLASS;
        return $configClass::logoInstitucion();
    }

    /**
     * URL al logotipo de las facturas
     * @version MR-ADIN.00.03
     */
    public function logoFacturas()
    {
        $configClass = static::CONFIG_CLASS;
        return $configClass::logoFacturas();
    }

    /**
     * Slogan
     * @version MR-ADIN.00.03
     */
    public function sloganAplicacion()
    {
        $configClass = static::CONFIG_CLASS;
        return $configClass::sloganAplicacion();
    }

    /**
     * Define el nombre de la instancia actual
     * @since GIP.00.01
     */
    const NAME = \NULL;

    /**
     * Obtiene el <b>slogan</b> declarado para la <b>Instancia</b> actual.
     * @author Izmir Sanchez Juarez <izmirreffi@gmail.com>
     * @since GIndie\Platform::GIP.00.07
     * @edit 2017-06-17 <angel.sierra@grupoindie.com>
     *      - Se redeclaró la función desde GIndie\Platform.
     *      - Se redeclaró el método de estático a dinámico.
     *      - La constante es accesada desde el archivo de configuración instanciado
     * @version GIP.00.03
     */
    public function getSloganDPR()
    {
        $configClass = static::CONFIG_CLASS;
        return $configClass::getSlogan();
    }

    /**
     * Obtiene la <b>ruta del logo</b> declarada para la <b>Instancia</b> actual.
     * @author Izmir Sanchez Juarez <izmirreffi@gmail.com>
     * @since GIndie\Platform::GIP.00.07
     * @edit 2017-06-17 <angel.sierra@grupoindie.com>
     *      - Se redeclaró la función desde GIndie\Platform.
     *      - Se redeclaró el método de estático a dinámico.
     *      - La constante es accesada desde el archivo de configuración instanciado
     * @version GIP.00.03
     */
    public function getImageBrandDPR()
    {
        $configClass = static::CONFIG_CLASS;
        return $configClass::getPathToBrand();
    }

    /**
     * Obtiene la <b>ruta del proyecto</b>.
     * @version GIP.00.0?
     */
    public static function getProjectPathDPR()
    {
        $configClass = static::CONFIG_CLASS;
        $assetsFolder = $configClass::HOST . $configClass::PATH_TO_PROJECT;
        return $assetsFolder;
    }

    /**
     * Ruta a la carpeta que almacena las facturas
     * @version MR-ADIN.00.03
     */
    public static function hostDPR()
    {
        $configClass = static::CONFIG_CLASS;
        return $configClass::HOST;
    }

    /**
     * Ruta a la carpeta que almacena las facturas
     * @version MR-ADIN.00.03
     */
    public static function pathToFacturasDPR()
    {
        $configClass = static::CONFIG_CLASS;
        return $configClass::pathToFacturas();
    }

    /**
     * Ruta a la carpeta que almacena los recibos
     * @version MR-ADIN.00.03
     */
    public static function pathToRecibosDPR()
    {
        $configClass = static::CONFIG_CLASS;
        return $configClass::pathToRecibos();
    }

    /**
     * @version GIP.00.0?
     */
    public static function getAssetsPathDPR()
    {
        $configClass = static::CONFIG_CLASS;
        return $configClass::PATH_TO_ASSETS;
        //return $assetsFolder;
    }

    /**
     * @todo Definir links desde el archivo global de configuración
     * @var null|array 
     * @since GIP.00.01
     */
    private static $_LINKS = [];

    /**
     * @deprecated since GIP.00.02
     * @var array 
     * @since GIP.00.01
     * @version GIP.00.02
     */
    private static $_MODULES = [];

    /**
     * Crea una nueva instancia de la plataforma
     * @final
     * @since GIP.00.01
     * @version GIP.00.02
     */
    final private function __construct()
    {
        static::BRAND_NAME !== \NULL ?: trigger_error("Constant BRAND_NAME must be defined inside class definition of: " . get_called_class(),
                                                      \E_USER_ERROR);
        static::CONFIG_CLASS !== \NULL ?: trigger_error("Constant CONFIG_CLASS must be defined inside class definition of: " . get_called_class(),
                                                        \E_USER_ERROR);
        if (Current::Instance() !== \NULL) {
            static::config();
        }
    }

    /**
     * []
     * @abstract
     * @since GIP.00.01
     */
    abstract public function config();

    /**
     * @deprecated  since GIP.00.02
     * @since GIP.00.01
     * @version GIP.00.02
     * 
     * @param string $classname
     * @param boolean|string $config true for show, false for hide, string for group
     * 
     * @return \GIndie\Platform\Controller\Platform\ModuleInterface
     * @throws \Exception
     */
    public function setModule($classname, $groupName = \NULL)
    {
        if (!\is_subclass_of($classname, Platform\Controller\Module::class,
                             \TRUE)) {
            $sub = Platform\Controller\Module::class;
            trigger_error("Class {$classname} is not subclass of {$sub}",
                          E_USER_ERROR);
            throw new \Exception("Unable to run.");
        }
        self::$_MODULES[$classname] = $groupName;
        return isset(self::$_MODULES[$classname]);
    }

    /**
     * 
     * @since GIP.00.02
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
     * @since GIP.00.01
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
            trigger_error("Classname {$classname} is not subclass of {$class} ",
                          E_USER_ERROR);
            throw new \Exception("Unable to run.");
        }
        self::$_LINKS[$classname] = $href;
        return isset(self::$_LINKS[$classname]);
    }

    /**
     * 
     * @since GIP.00.01
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
     * @since GIP.00.01
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
     * @since GIP.00.04
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
     * @since GIP.00.04
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
     * @since GIP.00.01
     * @version GIP.00.05
     */
    final public static function run()
    {
        /**
         * Retrasa la ejecución del código por 0.1 seg. Distribuye la carga de peticiones.
         * \time_nanosleep(0,100000000);
         */
        \usleep(100000);
        //\usleep(100000);
        if (\session_status() === \PHP_SESSION_NONE) {
            try {
                if (static::_isLoginAttempt()) {
                    Platform\Security::startSession();
                    Platform\Current::setInstance(new static());
                    Platform\Current::setInstance(new static());
                    Platform\Current::setModule(new Platform\Controller\Module\Welcome());
                    $data = [];
                    $data['fk_usuario_cuenta'] = \GIndie\Platform\Current::User()->getId();
                    $data['action'] = "gip-login";
                    $data['timestamp'] = \time();
                    $nota = "Ingresó al sistema con correo y contraseña";
                    $data['notas'] = \filter_var($nota,
                                                 \FILTER_SANITIZE_SPECIAL_CHARS);
                    $bitacora = \AdminIngresos\Datos\mr_sesion\bitacora\Registro::instance($data);
                    $bitacora->run("gip-inner-create");
                }
                if (static::_isRestartAttempt()) {
                    Platform\Security::restartSession();
                }
            } catch (\GIndie\Platform\ExceptionLogin $e) {
                $params = \session_get_cookie_params();
                \setcookie(\session_name(), '', \time() - 42000,
                           $params["path"], $params["domain"],
                           $params["secure"], $params["httponly"]
                );
                if ($_SERVER["REQUEST_METHOD"] === "POST") {//
                    $response = \GIndie\Generator\DML\HTML5\Category\Basic::Paragraph($e->getMessage());
                    $response->addScript("setTimeout(function(){location.replace(location.pathname);}, 1000);");
                    return $response;
                } else {
                    \header("Refresh: 1; url=" . $_SERVER['PHP_SELF']);
                    return $e->getMessage();
                }
            } catch (\Exception $e) {
                \header("Refresh: 1; url=" . $_SERVER['PHP_SELF']);
                return $e->getMessage();
            }
        }
        if (\session_status() == \PHP_SESSION_NONE) {
            $instance = new static();

            return new Platform\View\Login($instance->logoAplicacion(),
                                           $instance->sloganAplicacion(),
                                           $instance->urlAssets(),
                                           $instance->logoInstitucion());
        }
        try {
            switch ($_SERVER["REQUEST_METHOD"])
            {
                case "GET":
                    $instance = new static();
                    Platform\Current::setInstance($instance);
                    Platform\Current::setInstance($instance);
                    Platform\Current::setModule(new Platform\Controller\Module\Welcome());
                    $_class = \NULL;
                    $_action = "load";
                    $_action_id = "document";
                    $_selected_id = \NULL;
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
            return Platform\Current::Module()->run($_action, $_action_id,
                                                   $_class, $_selected_id);
        } catch (\Exception $e) {
            //return "TEST";
            $GLOBALS["gip-error"] = static::displayException($e);
            return static::displayException($e);
        }
    }

}
