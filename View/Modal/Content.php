<?php

/**
 * GI-Platform-DVLP - 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\View
 *
 * @version 0C.80
 * @since 18-03-15
 */

namespace GIndie\Platform\View\Modal;

use GIndie\ScriptGenerator\Bootstrap3;

/**
 * @edit 18-06-25
 */
class Content extends Bootstrap3\Component\Modal\Content
{

    /**
     * 
     * @since 18-03-15
     * 
     * @param mixed|string $title
     * @param mixed $content
     * @param boolean $closeButton
     * 
     * @return \GIndie\Platform\View\Modal\Content
     */
    public static function defaultModalContent($title, $content, $closeButton = true)
    {
        $modalContent = new Content($title, $content);
        if ($closeButton) {
            $btnDismiss = new Bootstrap3\Component\Button("Cerrar ventana", Bootstrap3\Component\Button::TYPE_BUTTON);
            $btnDismiss->setAttribute("data-dismiss", "modal");
            //$btnDismiss->setAttribute("data-dismiss", "modal");
            $modalContent->addFooterButton($btnDismiss);
        }
        return $modalContent;
    }

    /**
     * 
     * @since 18-03-15
     * 
     * @param mixed|string $title
     * @param mixed $content
     * @param boolean $closeButton
     * 
     * @return \GIndie\Platform\View\Modal\Content
     */
    public static function success($title, $content, $closeButton = true)
    {
        $modalContent = static::defaultModalContent($title, $content, $closeButton);
        $modalContent->addClass("gip-modal-success");
        $modalContent->getHeader()->setBackground("success");
        return $modalContent;
    }

    /**
     * 
     * @since 18-03-15
     * 
     * @param mixed|string $title
     * @param mixed $content
     * @param boolean $closeButton
     * 
     * @return \GIndie\Platform\View\Modal\Content
     */
    public static function succcess($title, $content, $closeButton = true)
    {
        return static::success($title, $content, $closeButton);
    }

    /**
     * 
     * @since 18-03-15
     * 
     * @param mixed|string $title
     * @param mixed $content
     * @param boolean $closeButton
     * 
     * @return \GIndie\Platform\View\Modal\Content
     */
    public static function danger($title, $content, $closeButton = true)
    {
        $modalContent = static::defaultModalContent($title, $content, $closeButton);
        $modalContent->addClass("gip-modal-danger");
        $modalContent->getHeader()->setBackground("danger");
        return $modalContent;
    }

    /**
     * 
     * @since 18-03-15
     * 
     * @param mixed|string $title
     * @param mixed $content
     * @param boolean $closeButton
     * 
     * @return \GIndie\Platform\View\Modal\Content
     */
    public static function warning($title, $content, $closeButton = true)
    {
        $modalContent = static::defaultModalContent($title, $content, $closeButton);
        $modalContent->addClass("gip-modal-warning");
        $modalContent->getHeader()->setBackground("warning");
        return $modalContent;
    }

    /**
     * 
     * @since 18-03-15
     * 
     * @param mixed|string $title
     * @param mixed $content
     * @param boolean $closeButton
     * 
     * @return \GIndie\Platform\View\Modal\Content
     */
    public static function primary($title, $content, $closeButton = true)
    {
        $modalContent = static::defaultModalContent($title, $content, $closeButton);
        $modalContent->addClass("gip-modal-primary");
        $modalContent->getHeader()->setBackground("primary");
        return $modalContent;
    }

    /**
     * 
     * @since 18-03-15
     * 
     * @param mixed|string $title
     * @param mixed $content
     * @param boolean $closeButton
     * 
     * @return \GIndie\Platform\View\Modal\Content
     */
    public static function info($title, $content, $closeButton = true)
    {
        $modalContent = static::defaultModalContent($title, $content, $closeButton);
        $modalContent->addClass("gip-modal-info");
        $modalContent->getHeader()->setBackground("info");
        return $modalContent;
    }

}
