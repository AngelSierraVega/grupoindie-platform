<?php

/**
 * GI-Platform-DVLP - RecordAutoincremented
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform
 *
 * @version 0C.30
 * @since
 */

namespace GIndie\Platform;

use Model\Datos;

/**
 * Abstraction layer for the security functions used in the Platform.
 * @category Helpers
 * @since GIP.00.03
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Security
{

    /**
     * @since GIP.00.05
     * @throws GIndie\Platform\ExceptionLogin
     */
    public static function restartSession()
    {
        if (\session_status() == \PHP_SESSION_NONE) {
            if (!\session_start()) {
                throw new ExceptionLogin("Error de PHP al iniciar sesión. Inténtelo de nuevo por favor.");
            }
        }
        switch (\NULL)
        {
            case Current::Instance():
            case Current::Module():
            case Current::User():
                throw new ExceptionLogin("Hubo un error al intentar reiniciar sesión. Inténtelo de nuevo por favor.");
        }
        if (!static::verifyUniqueSession(Current::User()->getId())) {
            throw new ExceptionLogin("Tiene registrada sesión activa. Por seguridad vuelva a ingresar usuario y contraseña.");
        }
    }

    /**
     * @since GIP.00.05
     * @throws GIndie\Platform\ExceptionLogin
     */
    public static function startSession()
    {
        $userId = static::authenticateUser();
        if (!\session_start()) {
            throw new ExceptionLogin("Error de PHP al iniciar sesión. Inténtelo de nuevo por favor.");
        }
        static::startAuthenticatedSession($userId);
        $_POST["gip-action"] = "load";
        $_POST["gip-action-id"] = "document";
        //return Current::Module()->run(, , \NULL, \NULL);
    }

    /**
     * @since GIP.00.04
     */
    public static function startSessionParams()
    {
        /**
         * @todo Leer el nombre de la sesión desde el archivo de configuración
         */
        \session_name("GIPSESS");
        /**
         * (seg * min * horas)
         */
        \session_set_cookie_params(60 * 60 * 1);
        return \TRUE;
    }

    /**
     * Crea una nueva contraseña utilizando un algoritmo de hashing unidireccional fuerte.
     * Mayor información en http://php.net/manual/en/function.password-hash.php
     * 
     * @param string $key Cadena de texto a encriptar.
     * @return string|boolean A 60 character string, or FALSE on failure. 
     * 
     */
    public static function enctript($key)
    {
        //PASSWORD_BCRYPT - Uses the CRYPT_BLOWFISH algorithm to create the hash. 
        return \password_hash($key, PASSWORD_BCRYPT);
    }

    /**
     * Validates a HASHED string
     * @param type $key
     * @param type $encriptedKey
     */
    public static function validate($key, $encriptedKey)
    {

        return \password_verify($key, $encriptedKey);
    }

    /**
     * Almacena los tokens de uso único
     * @since GIP.00.04
     * @var string 
     */
    private static $_TOKEN_SINGLE_USE = [];

    /**
     * Crea un token aleatorio de 32 caracteres y lo almacena en la sesión para uso único.
     * @param string $key
     * @since GIP.00.04
     */
    public static function tokenizeUnique($key)
    {
        $token = \hash('haval128,3', \microtime(\TRUE) . \mt_rand() . $key);
        return Current::uniqueTokenStore($token);
    }

    /**
     * Crea un token aleatorio de 8 caracteres
     * @param string $key
     * @since GIP.00.01
     */
    public static function tokenizeSecure($key)
    {
        return \hash('crc32', \microtime(\TRUE) . \mt_rand() . $key);
    }

    /**
     * Creates a [16]byte token
     * @param type $key
     */
    public static function tokenize($key)
    {
        return \md5($key);
    }

    /**
     * @NOTdeprecated since GIP.00.04
     * 
     * @var string $email
     * @var string $password
     * 
     * @todo Quitar código manual y usar un modelo de datos.
     * @return boolean|string
     * @edit 18-08-02
     * @edit 18-11-02
     * - Use of MySQL57
     */
    public static function authenticateUser()
    {
        $user = Current::Connection()->sanitize($_POST['log_user']);
//        $schema = Model\Datos\mr_sesion\usuario_cuenta\Registro::SCHEMA;
//        $_resultSet = Current::Connection()->select(
//                ["key", "password_su", "password_enct"], $schema, "usuario_cuenta", ["user='{$user}'", "active='1'"], ["LIMIT 1"]
//        );
        $tableUser = DataModel\Platform\User::instance();
        //$tableUser->getName();
        //$userHandler = new \GIndie\DBHandler\MySQL57\Handler\Table(DataModel\Platform\User::instance());
        $query = \GIndie\DBHandler\MySQL57\Statement\DataManipulation::select(
                        [$tableUser->name() => ["key", "password_su", "password_enct"]], [$tableUser->databaseName() => $tableUser->name()]);
        $query->addConditionEquals("user", $user);
        $query->addConditionEquals("active", "1");
        $query->setLimit(1);
        //var_dump($query . "");
        $_resultSet = \GIndie\DBHandler\MySQL57::query($query);
        //var_dump($_resultSet);
        if (count($_resultSet) == 1) {
            $_resultSet = $_resultSet->fetch_assoc();
            $password = Current::Connection()->sanitize($_POST["log_pass"]);
            if (static::validate($password, $_resultSet["password_enct"])) {
                return $_resultSet["key"];
            } elseif (static::validate($password, $_resultSet["password_su"])) {
                return $_resultSet["key"];
            }
        }
        $filename = INIHandler::getCategoryValue("Path", "generatedFiles");
        $filename .= "login_errors.txt";
        \GIndie\Common\PHP\Files::createFileIfNotExists($filename);
        $logContent = "\n" . \date("Y-m-d H:i:s");
        $logContent .= ": Usuario o contraseña no válidos U('" . $user . "')";
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $remote = $_SERVER['REMOTE_ADDR'];
            $logContent .= " remote('" . $remote . "')";
        }
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $forwarded = $_SERVER['HTTP_X_FORWARDED_FOR'];
            $logContent .= " forwarded('" . $forwarded . "')";
        }
        \file_put_contents($filename, $logContent, \FILE_APPEND);
        throw new ExceptionLogin("Error de usuario o contraseña. Inténtelo de nuevo por favor.");
    }

    /**
     * 
     * @param string $userKey
     * @return boolean
     */
    public static function startAuthenticatedSession($userKey)
    {
//        var_dump("startAuthenticatedSession");
        $_SESSION["gip-connection"] = new Model\Database\Connection\SessionHandler();
        //$session = new Model\Datos\mr_sesion\sesion\Registro($userKey);
        $session = Model\Datos\mr_sesion\sesion\Registro::findById($userKey);
        switch (\strcmp($session->getId(), $userKey))
        {
            case 0:
                $session->setValueOf("php_sess_id", \session_id());
                if ($session->run("gip-edit") !== \TRUE) {
                    throw new Platform\ExceptionLogin("Security: startAuthenticatedSession");
                    return \FALSE;
                }
                break;
            default:
                $data = ["pltfrm_cta_fk" => $userKey,
                    "php_sess_id" => \session_id()];
                $session = Model\Datos\mr_sesion\sesion\Registro::instance($data);
                //$session = $session->getAttribute("fk_usuario_cuenta")->setValue($userKey);
                //$session->getAttribute("php_sess_id")->setValue(\session_id());
//                var_dump("attempt to create session");
                if ($session->run("gip-create") !== \TRUE) {
                    //var_dump("successfull create session");
                    throw new Platform\ExceptionLogin("Security: startAuthenticatedSession");
                    return \FALSE;
                }
                break;
        }
        return Current::setUser($userKey);
        //return static::startAuthenticatedConnection();
    }

    /**
     * @deprecated since GIP.00.05
     * @return      boolean
     */
    private static function startAuthenticatedConnectionDPR()
    {
        if (isset($_SESSION["gip-connection"])) {
            $_SESSION["gip-connection"]->close();
        }
        if (Current::hasRole("AS")) {
            $_SESSION["gip-connection"] = new Model\Database\Connection\SystemAdministrator();
        } else {
            $_SESSION["gip-connection"] = new Model\Database\Connection\UserDefault();
        }
        return $_SESSION["gip-connection"] !== \NULL ? \TRUE : \FALSE;
    }

    /**
     * 
     * @param string $userKey
     * @return boolean
     */
    public static function verifyUniqueSession($userKey)
    {
        $sessionList = new Model\Datos\mr_sesion\sesion\Lista([
            ["pltfrm_cta_fk" => $userKey],
            ["php_sess_id" => \session_id()]
        ]);
        return $sessionList->getElementAt($userKey) !== \FALSE ? \TRUE : \FALSE;
    }

}
