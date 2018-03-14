<?php

/**
 * GIplatform - Platform 
 */

namespace GIndie\Platform\Controller;

use \GIndie\ScriptGenerator\Bootstrap3;

/**
 * Description of Platform
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @since GIP.00.00 2017-05-22
 * @version GIP.00.03
 * @edit GIP.00.04 18-01-14
 * - Bitácora restaurada
 * @edit 18-03-14
 * - Moved methods to trait Platform/ToUpgrade or Platform/ToDeprecate
 */
abstract class Platform
{

    /**
     * @since 18-03-14
     */
    use Platform\ToDeprecate;
    use Platform\ToUpgrade;

    /**
     * 
     * @param mixed $modalTitle
     * @param mixed $modalContent
     * @param boolean $closeButton
     * @return \GIndie\ScriptGenerator\Bootstrap3\Component\Modal\Content
     * @since 18-03-14
     */
    protected function cnstrctModal($modalTitle, $modalContent, $closeButton = true)
    {
        $modalContent = new Bootstrap3\Component\Modal\Content($modalTitle, $modalContent);
        if ($closeButton) {
            $btnDismiss = new Bootstrap3\Component\Button("Cerrar ventana", Bootstrap3\Component\Button::TYPE_BUTTON);
            $btnDismiss->setAttribute("data-dismiss", "modal");
            $modalContent->addFooterButton($btnDismiss);
        }
        return $modalContent;
    }

}
