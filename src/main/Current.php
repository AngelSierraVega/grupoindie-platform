<?php

/*
 * Copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * This software is protected under GNU: you can use, study and modify it
 * but not distribute it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 */

namespace GIndie\Platform;

use \GIndie\Platform\Model\Datos\mr_sesion\usuario_cuenta_rol\Lista as RolesUsuario;
use \GIndie\Platform\Model\Datos\mr_sesion\usuario_cuenta;

/**
 * Access to main vars.
 * 
 * @package     Platform
 * @subpackage  Main
 * @category    API
 * 
 * @since       2017-01-05
 * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @version     GIP.00.08
 */
class Current
{

    //public static $CONFIG_CLASS;

    /**
     * [description]
     * @return      null|\GIndie\Platform\Model\Datos\mr_sesion\usuario_cuenta\Registro
     * @version     GIP.00.03
     * @since       GIP.00.00
     */
    public static function User()
    {
        $_pointer = &$_SESSION["gip-user"];
        return $_pointer;
    }

    public static function uniqueTokenStore($token)
    {
        if (!isset($_SESSION["gip-unique-token"])) {
            $_SESSION["gip-unique-token"] = [];
        }
        $_SESSION["gip-unique-token"][$token] = \TRUE;
        return $token;
    }

    public static function uniqueTokenValidate($token)
    {
        switch (\TRUE)
        {
            case isset($_SESSION["gip-unique-token"][$token]):
                unset($_SESSION["gip-unique-token"][$token]);
                return \TRUE;
        }
        return \FALSE;
    }

    /**
     * 
     * @param type $instance
     * @since GIP.00.02
     * @version GIP.00.04
     */
    public static function setConfig(Config $config)
    {
        $_SESSION["gip-config"] = $config;
    }

    /**
     * 
     * @param type $instance
     * @since GIP.00.02
     * @version GIP.00.04
     */
    public static function setInstance(\GIndie\Instance $instance)
    {
        $_SESSION["gip-instance"] = $instance;
    }

    /**
     * 
     * @return \GIndie\Instance
     */
    public static function Instance()
    {
        $_pointer = &$_SESSION["gip-instance"];
        return $_pointer;
    }

    /**
     * @deprecated Use Instance() instead
     * @return \static
     */
    public static function Platform()
    {
        \trigger_error("Use Instance() instead", \E_USER_DEPRECATED);
        return static::Instance();
    }

    public static function setModule(\GIndie\Platform\Controller\Module $module)
    {
        //var_dump($instance);
        $_SESSION["gip-controller"] = $module;
    }

    /**
     * @deprecated since GIP.00.04
     * @return \static
     */
    public static function Controller()
    {
        \trigger_error("Use Module() instead", \E_USER_DEPRECATED);
        return static::Module();
    }

    /**
     * 
     * @return \GIndie\Platform\Controller\Module
     */
    public static function Module()
    {
        //static::IsAuthenticated();
//        if (!isset($_SESSION["gip-controller"])) {
//            static::setModule(new \GIndie\Platform\Controller\Module\Welcome());
//        }
        $_pointer = &$_SESSION["gip-controller"];
        return $_pointer;
    }

    public static function getAssetsPathDPR()
    {
        $configClass = static::$CONFIG_CLASS;
//        var_dump(static::$CONFIG_CLASS);
//        var_dump(get_called_class());
        $assetsFolder = $configClass::HOST . $configClass::PATH_TO_ASSETS;
        return $assetsFolder;
    }

    /**
     * [description]
     * @return      boolean|\GIndie\Platform\Model\User
     * @version     GIP.00.03
     * @since       GIP.00.00
     */
    public static function sessionInfo()
    {//
        return static::IsAuthenticated() ? $_SESSION["gip-session-info"] : FALSE;
    }

    /**
     * [description]
     * @deprecated since GIP.00.04
     * @return      boolean
     * @version     GIP.00.02
     */
    public static function IsAuthenticated()
    {
        return true;
        if (\session_status() == PHP_SESSION_ACTIVE) {
            
        } else {
//            if (isset($_COOKIE["GIPSESS"])) {
//                return static::sessionRestart();
//            } else {
//                return false;
//            }
        }
    }

    /**
     * Attempts to restart a previous session.
     * @deprecated since GIP.00.06
     * @todo        Token validation
     * @return      boolean
     * @since       GIP.00.03
     */
    public static function sessionRestart()
    {
        $tmpSess = \NULL;
        if (isset($_SESSION["gip-platform"])) {
            $tmpSess = $_SESSION["gip-platform"];
        }
        \session_name("GIPSESS");
        $rtnVal = \session_start();

//        \session_name("GIPSESS");
//        $rtnVal = \session_start();
        /**
         * $_SESSION["gip-session-info"]->getAttribute("timestamp_last_authentication")->setValue(\time());
         * $_SESSION["gip-session-info"]->getAttribute("authentication_method")->setValue("Token revalidation");
         * $_SESSION["gip-user"] = new Model\User(static::User()->getAttribute("id_user"));
         */
        return $rtnVal;
    }

    /**
     * @deprecated since GIP.00.06
     * @return      boolean
     * @version     GIP.00.04
     */
    private static function session_start_info()
    {
        $_SESSION["gip-session-info"] = new \GIndie\Platform\Model\Session\Information(\time(),
                                                                                       "User login");
        if (!isset($_SESSION["gip-log"])) {
            $_SESSION["gip-log"] = "";
        }
        $_SESSION["gip-log"] .= "<p>Inicio de sesión: " . \time() . "<\p>";
        return $_SESSION["gip-session-info"] != \NULL ? \TRUE : \FALSE;
    }

    /**
     * @deprecated since GIP.00.06
     * @return      boolean
     * @version     GIP.00.04
     */
    private static function session_start_connection()
    {
        if (array_key_exists("gip-connection", $GLOBALS)) {
            $_SESSION["gip-connection"] = $GLOBALS["gip-connection"];
            unset($GLOBALS["gip-connection"]);
        }
        return $_SESSION["gip-connection"] != \NULL ? \TRUE : \FALSE;
    }

    /**
     * @deprecated since GIP.00.05
     * @return      boolean
     * @version     GIP.00.04
     */
    private static function session_start_user($userId)
    {
        $_SESSION["gip-user"] = new Model\Session\User($userId);
        return $_SESSION["gip-user"] != \NULL ? \TRUE : \FALSE;
    }

    /**
     * @deprecated since GIP.00.04
     * @version     GIP.00.03
     * @since       GIP.00.02
     */
    public static function StartSession($userId)
    {
        $tmpSess = \NULL;
        if (isset($_SESSION["gip-platform"])) {
            $tmpSess = $_SESSION["gip-platform"];
        }
        \session_name("GIPSESS");
        $rtnVal = \session_start();
        if ($rtnVal) {
            if ($tmpSess != \NULL) {
                //var_dump("entro");
                static::setPlatform($tmpSess);
            }


            $rtnVal = $rtnVal ? static::session_start_info() : \FALSE;
            $rtnVal = $rtnVal ? static::session_start_connection() : \FALSE;
            $rtnVal = $rtnVal ? static::session_start_user($userId) : \FALSE;
            $rtnVal = $rtnVal ? static::session_start_roles($userId) : \FALSE;
            $rtnVal = $rtnVal ? static::session_swich_connection() : \FALSE;
        }

        if ($rtnVal === \FALSE) {
            \session_abort();
            \session_unset();
            \trigger_error("Unable to create session", \E_USER_ERROR);
            throw new \Exception("Unable to create session");
        }
    }

    /**
     * 
     * @param string $userId
     * @since GIP.00.05
     */
    public static function setUser($userId)
    {
        $_SESSION["gip-user"] = usuario_cuenta\Registro::findById($userId);
        return isset($_SESSION["gip-user"]) ? static::_setRoles($userId) : \FALSE;
    }

    /**
     * @todo carga dinámica de roles.
     * @return      boolean
     * @version     GIP.00.04
     */
    private static function _setRoles($userId)
    {
        $_SESSION["gip-roles"] = new RolesUsuario([["fk_usuario_cuenta" => $userId]]);
        return isset($_SESSION["gip-roles"]);
    }

    /**
     * [description]
     * @return      null|\GIndie\Platform\Model\Datos\mr_sesion\usuario_cuenta_rol\Lista
     * @version     GIP.00.03
     * @since       GIP.00.00
     */
    public static function Roles()
    {
        $_pointer = &$_SESSION["gip-roles"];
        return $_pointer;
    }

    /**
     * @todo basic funcionality
     * @param type $role
     * @return type
     */
    public static function hasRole($roles)
    {
        if (\session_status() === \PHP_SESSION_NONE) {
            return \FALSE;
        }
        if (!isset($_SESSION["gip-roles"])) {
            return \FALSE;
        }
        $roles = \is_string($roles) ? [$roles] : $roles;
        $roles = $roles == \NULL ? ["NONE"] : $roles;
        foreach ($roles as $tmpRol) {
            if ($_SESSION["gip-roles"]->getElementAt($tmpRol) !== \FALSE) {
                return \TRUE;
            }
        }
        return \FALSE;
    }

    /**
     *
     * @var Model\Database\Connection 
     */
    private static $_connection = \NULL;

    /**
     * 
     * @return \GIndie\Platform\Model\Database\Connection
     */
    public static function Connection()
    {
        if (\session_status() === \PHP_SESSION_NONE) {
            //if (!isset($_SESSION["gip-connection"])) {
            //    $_SESSION["gip-connection"] = new Model\Database\Connection\SessionHandler();
            //}
        } else {
            //var_dump(\session_status());
            /**
             * @todo gip-conection se instancia cada que se hace llamada a Connection. Verificar costo
             */
//            if (is_resource($connection) && get_resource_type($connection) === 'mysql link') {
//                
//            }
            //if (static::hasRole("AS")) {
            //$_SESSION["gip-connection"] = new Model\Database\Connection\SystemAdministrator();
//            } else {
//                $_SESSION["gip-connection"] = new Model\Database\Connection\UserDefault();
//            }
        }
        if (!isset(static::$_connection)) {
            static::$_connection = new Model\Database\Connection\SystemAdministrator();
        }
        $rtnRef = &static::$_connection;
        return $rtnRef;
    }

    /**
     * @deprecated since GIP.00.08
     * @todo VALIDAR SI SE DEPRECA COMPLETAMENTE
     * @todo create log entry before destroying session.
     * @return boolean
     */
    public static function sessionDestroy()
    {
        //if (Current::IsAuthenticated()) {
        $_SESSION = array();
        \session_name("GIPSESS");
        //var_dump();
        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        //if (ini_get("session.use_cookies")) {
        $params = \session_get_cookie_params();
        \setcookie(\session_name(), '', time() - 42000, $params["path"],
                   $params["domain"], $params["secure"], $params["httponly"]
        );
        //var_dump(\session_status());
        return \session_destroy();
        //}
    }

}
