<?php

/**
 * GI-Platform-DVLP - ToDeprecate
 *
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 *
 * @package GIndie\Platform\Controller\Instance
 * 
 * @version 0C.10
 * @since 18-03-14
 */

namespace GIndie\Platform\Controller\Platform;

use \GIndie\Generator\DML\HTML5;
use \GIndie\Generator\DML\HTML5\Bootstrap3;
use \GIndie\Platform\Model\Datos\mr_sesion;
use \GIndie\Platform\Current;
use \GIndie\Platform\View;

/**
 * 
 * 
 */
trait ToDeprecate
{

    /**
     * 
     * @param mixed $modalTitle
     * @param mixed $modalContent
     * @param boolean $closeButton
     * 
     * @return \GIndie\Platform\View\Modal\Content
     * 
     * @since 18-03-14
     * @deprecated since 18-03-15
     */
    protected function cnstrctModal($modalTitle, $modalContent,
                                    $closeButton = true)
    {
        return View\Modal\Content::defaultModalContent($modalTitle,
                                                       $modalContent,
                                                       $closeButton);
    }

    /**
     * 
     * @param string $modalTitle
     * @param mixed $modalContent
     * @param boolean $closeButton
     * @return \GIndie\Generator\DML\HTML5\Bootstrap3\Component\Modal\Content
     */
    protected function _modalWrap($modalTitle, $modalContent,
                                  $closeButton = \TRUE)
    {
        $modalContent = new Bootstrap3\Component\Modal\Content($modalTitle,
                                                               $modalContent);
        if ($closeButton === \TRUE) {
            $btnDismiss = new Bootstrap3\Component\Button("Cerrar",
                                                          Bootstrap3\Component\Button::TYPE_BUTTON);
            $btnDismiss->setAttribute("data-dismiss", "modal");
            $modalContent->addFooterButton($btnDismiss);
        }
        return $modalContent;
    }

}
