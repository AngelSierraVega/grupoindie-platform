<?php

/**
 * GIplatform
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.05
 */

namespace GIndie\Platform\View;

use GIndie\Generator\DML\HTML5\Category\StylesSemantics\Span;

/**
 * Description of Icons
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Icons
{

    public static function Delete()
    {
        return new Span("", ["class" => "glyphicon glyphicon-trash"]);
    }

    public static function Create()
    {
        return new Span("", ["class" => "glyphicon glyphicon-plus"]);
    }

    public static function Edit()
    {
        return new Span("", ["class" => "glyphicon glyphicon-edit"]);
    }

    public static function Active()
    {
        return new Span("", ["class" => "glyphicon glyphicon-view"]);
    }

    public static function Help()
    {
        return new Span("", ["class" => "glyphicon glyphicon-question-sign"]);
    }

}
