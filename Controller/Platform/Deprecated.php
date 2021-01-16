<?php

/**
 * GI-Platform-DVLP - Deprecated
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\Controller\Instance
 *
 * @version 0D.10
 * @since 18-06-24
 */

namespace GIndie\Platform\Controller\Platform;
use GIndie\Platform\View;

/**
 * @edit 18-06-24
 * - Fully deprecated cnstrctModal(), _modalWrap()
 */
trait Deprecated
{

    /**
     * Use constructor \GIndie\Platform\View\Modal\Content instead
     * 
     * @param mixed $modalTitle
     * @param mixed $modalContent
     * @param boolean $closeButton
     * 
     * @return \GIndie\Platform\View\Modal\Content
     * 
     * @since 18-03-14
     * @deprecated since 18-03-15
     * @edit 18-06-24
     * - Added trigger
     */
    protected function cnstrctModal($modalTitle, $modalContent,
                                    $closeButton = true)
    {
        \trigger_error("Use constructor \GIndie\Platform\View\Modal\Content instead",
                       \E_USER_DEPRECATED);
        return View\Modal\Content::defaultModalContent($modalTitle,
                                                       $modalContent,
                                                       $closeButton);
    }

    /**
     * Use constructor \GIndie\Platform\View\Modal\Content instead
     * 
     * @param string $modalTitle
     * @param mixed $modalContent
     * @param boolean $closeButton
     * 
     * @return \GIndie\Platform\View\Modal\Content
     * @deprecated since 18-06-24
     */
    protected function _modalWrap($modalTitle, $modalContent,
                                  $closeButton = true)
    {
        return $this->cnstrctModal($modalTitle, $modalContent, $closeButton);
    }

}
