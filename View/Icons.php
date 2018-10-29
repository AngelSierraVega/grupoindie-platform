<?php

/**
 * GI-Platform-DVLP - 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\View
 *
 * @version 0D.00
 * @since 
 */

namespace GIndie\Platform\View;

//use GIndie\Generator\DML\HTML5\Category\StylesSemantics\Span;
use GIndie\ScriptGenerator\HTML5\Category\StylesSemantics\Span;

/**
 * Description of Icons
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @edit 18-02-27
 * @edit 18-11-05
 * - Removed use of deprecated libs
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
