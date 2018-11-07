<?php

/**
 * GI-Platform-DVLP - 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\View
 *
 * @version 0D.70
 * @since 
 */

namespace GIndie\Platform\View;

use GIndie\ScriptGenerator\HTML5\Category\StylesSemantics\Span;

/**
 * Description of Icons
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @edit 18-02-27
 * @edit 18-11-05
 * - Removed use of deprecated libs
 * @edit 19-01-30
 * - Added eyeClose(), eyeOpen()
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

    /**
     * 
     * @return \GIndie\ScriptGenerator\HTML5\Category\StylesSemantics\Span
     * @since 19-01-30
     */
    public static function eyeClose()
    {
        return new Span("", ["class" => "glyphicon glyphicon-eye-close"]);
    }

    /**
     * 
     * @return \GIndie\ScriptGenerator\HTML5\Category\StylesSemantics\Span
     * @since 19-01-30
     */
    public static function eyeOpen()
    {
        return new Span("", ["class" => "glyphicon glyphicon-eye-open"]);
    }

}
