<?php

/**
 * GI-Platform-DVLP - JqueryValidator
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\View
 *
 * @version 0C.A0
 * @since 18-10-29
 */

namespace GIndie\Platform\View;

/**
 * Description of JqueryValidator
 */
class JqueryValidator
{

    /**
     * Solo letras mayúsculas y espacios
     * @return string
     * @since 18-10-29
     */
    public static function mayusEsp()
    {
        return "mayusculas_espacios";
    }

    /**
     * Solo letras mayúsculas y números
     * @return string
     * @since 18-10-29
     */
    public static function mayusNum()
    {
        return "mayusculas_numeros";
    }

    /**
     * Solo letras mayúsculas, números y espacios
     * @return string
     * @since 18-10-29
     */
    public static function mayusNumEsp()
    {
        return "mayusculas_numeros_espacios";
    }

    /**
     * Solo letras mayúsculas, números, espacios y los símbolos ( ) . ,
     * @return string
     * @since 18-10-29
     */
    public static function txtSimplSnComillas()
    {
        return "texto_simple_mayusculas_sin_comillas";
    }

    /**
     * Solo letras mayúsculas, números, espacios y los símbolos & \" . ,
     * @return string
     * @since 18-10-29
     */
    public static function rznScl()
    {
        return "razon_social";
    }

}
