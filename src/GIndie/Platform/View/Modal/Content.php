<?php

namespace GIndie\Platform\View\Modal;

use GIndie\ScriptGenerator\Bootstrap3;

/**
 * GI-Platform-DVLP - Content
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version ??
 * @since 18-03-15
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
    public static function defaultModal($title, $content, $closeButton = true)
    {
        $modalContent = new Content($title, $content);
        if ($closeButton) {
            $btnDismiss = new Bootstrap3\Component\Button("Cerrar ventana", Bootstrap3\Component\Button::TYPE_BUTTON);
            $btnDismiss->setAttribute("data-dismiss", "modal");
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
    public static function modalSucccess($title, $content, $closeButton = true)
    {
        $modalContent = static::defaultModal($title, $content, $closeButton);
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
    public static function modalDanger($title, $content, $closeButton = true)
    {
        $modalContent = static::defaultModal($title, $content, $closeButton);
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
    public static function modalWarning($title, $content, $closeButton = true)
    {
        $modalContent = static::defaultModal($title, $content, $closeButton);
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
    public static function modalPrimary($title, $content, $closeButton = true)
    {
        $modalContent = static::defaultModal($title, $content, $closeButton);
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
    public static function modalInfo($title, $content, $closeButton = true)
    {
        $modalContent = static::defaultModal($title, $content, $closeButton);
        $modalContent->addClass("gip-modal-info");
        $modalContent->getHeader()->setBackground("info");
        return $modalContent;
    }

}
