<?php

/**
 * GI-Platform-DVLP - 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\View
 *
 * @version 0C.00
 * @since 17-06-08
 */

namespace GIndie\Platform\View\Widget;

use \GIndie\Generator\DML\HTML5\Bootstrap3\Component\Button;

/**
 * Description of Buttons
 *
 * @edit 18-03-23
 */
class Buttons
{

    use \GIndie\Generator\DML\HTML5\Bootstrap3\ContextualColors;

    /**
     * 
     * @param int $context
     * @param Span $icon
     * @param string $gipAction
     * @param string|null $gipActionId
     * @param boolean $gipModal
     * @param string|null $gipClass
     * @return \GIndie\Generator\DML\HTML5\Bootstrap3\Component\Button
     */
    public static function Custom($context, $icon, $gipAction, $gipActionId = \NULL, $gipModal = \FALSE, $gipClass = \NULL, $gipSelectedId = \NULL)
    {
        $btn = new Button("");
        $btn->addClass('btn-sm');
        $btn->setContext($context, \FALSE);
        $btn->addContent($icon);
        if ($gipAction !== \NULL) {
            $btn->setAttribute("gip-action", $gipAction);
        }
        if ($gipActionId !== \NULL) {
            $btn->setAttribute("gip-action-id", $gipActionId);
        }
        if ($gipModal !== \FALSE) {
            $btn->setAttribute("gip-modal", $gipModal);
        }
        if ($gipClass !== \NULL) {
            $btn->setAttribute("gip-action-class", $gipClass);
        }
        if ($gipSelectedId !== \NULL) {
            $btn->setAttribute("gip-selected-id", $gipSelectedId);
        }
        return $btn;
    }

    /**
     * 
     * @return \GIndie\Generator\DML\HTML5\Bootstrap3\Component\Button
     */
    public static function CustomDanger($icon, $gipAction, $gipActionId = \NULL, $gipModal = \FALSE, $gipClass = \NULL)
    {
        return static::Custom(static::$COLOR_DANGER, $icon, $gipAction, $gipActionId, $gipModal, $gipClass);
    }

    /**
     * 
     * @return \GIndie\Generator\DML\HTML5\Bootstrap3\Component\Button
     * @since 18-03-23
     */
    public static function customWarning($icon, $gipAction, $gipActionId = \NULL, $gipModal = \FALSE, $gipClass = \NULL)
    {
        return static::Custom(static::$COLOR_WARNING, $icon, $gipAction, $gipActionId, $gipModal, $gipClass);
    }

    /**
     * 
     * @return \GIndie\Generator\DML\HTML5\Bootstrap3\Component\Button
     */
    public static function CustomPrimary($icon, $gipAction, $gipActionId = \NULL, $gipModal = \FALSE, $gipClass = \NULL)
    {
        return static::Custom(Button::$COLOR_PRIMARY, $icon, $gipAction, $gipActionId, $gipModal, $gipClass);
    }

    /**
     * 
     * @return \GIndie\Generator\DML\HTML5\Bootstrap3\Component\Button
     */
    public static function CustomSuccess($icon, $gipAction, $gipActionId = \NULL, $gipModal = \FALSE, $gipClass = \NULL)
    {
        return static::Custom(Button::$COLOR_SUCCESS, $icon, $gipAction, $gipActionId, $gipModal, $gipClass);
    }

    /**
     * 
     * @return \GIndie\Generator\DML\HTML5\Bootstrap3\Component\Button
     */
    public static function CustomDefault($icon, $gipAction, $gipActionId = \NULL, $gipModal = \FALSE, $gipClass = \NULL, $gipSelectedId = \NULL)
    {
        return static::Custom(Button::$COLOR_DEFAULT, $icon, $gipAction, $gipActionId, $gipModal, $gipClass, $gipSelectedId);
    }

    /**
     * 
     * @return \GIndie\Generator\DML\HTML5\Bootstrap3\Component\Button
     */
    public static function Create($gipClass, $gipActionId = \NULL)
    {
        return static::CustomSuccess("<span class=\"glyphicon glyphicon-plus\"></span>", "form-create", $gipActionId, "lg", $gipClass);
    }

    /**
     * 
     * @return \GIndie\Generator\DML\HTML5\Bootstrap3\Component\Button
     */
    public static function Edit($gipClass, $gipActionId = \NULL)
    {
        return static::CustomPrimary("<span class=\"glyphicon glyphicon-edit\"></span>", "form-edit", $gipActionId, "lg", $gipClass);
    }

    /**
     * 
     * @return \GIndie\Generator\DML\HTML5\Bootstrap3\Component\Button
     */
    public static function Delete($gipClass, $gipActionId = \NULL)
    {
        return static::CustomDanger("<span class=\"glyphicon glyphicon-trash\"></span>", "form-delete", $gipActionId, \TRUE, $gipClass);
    }

    /**
     * 
     * @return \GIndie\Generator\DML\HTML5\Bootstrap3\Component\Button
     */
    public static function Activate($gipClass, $gipActionId = \NULL)
    {
        return static::CustomSuccess("<span class=\"glyphicon glyphicon-eye-open\"></span>", "form-activate", $gipActionId, \TRUE, $gipClass);
    }

    /**
     * 
     * @return \GIndie\Generator\DML\HTML5\Bootstrap3\Component\Button
     */
    public static function Deactivate($gipClass, $gipActionId = \NULL)
    {
        return static::CustomDefault("<span class=\"glyphicon glyphicon-eye-close\"></span>", "form-deactivate", $gipActionId, \TRUE, $gipClass);
    }

    /**
     * 
     * @return \GIndie\Generator\DML\HTML5\Bootstrap3\Component\Button
     */
    public static function Reload($gipClass = \NULL, $gipSelectedId = \NULL)
    {

        return static::CustomDefault("<span class=\"glyphicon glyphicon-refresh\"></span>", "widget-reload", \NULL, \FALSE, $gipClass, $gipSelectedId);
    }

}
