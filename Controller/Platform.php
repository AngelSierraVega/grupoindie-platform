<?php

/**
 * GIplatform - Platform 
 *
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 *
 * @package GIndie\Platform\Controller\Instance
 * 
 * @version 0C.13
 * @since 17-05-22
 */

namespace GIndie\Platform\Controller;

use \GIndie\Platform\View;
use GIndie\Platform\Current;

/**
 *
 * @edit 18-01-14
 * - Bitácora restaurada
 * @edit 18-03-14
 * - Moved methods to trait Platform/ToUpgrade or Platform/ToDeprecate
 * @uses \GIndie\Platform\Controller\Platform\Deprecated
 */
abstract class Platform
{

    /**
     * @since 18-03-14
     * @edit 18-06-24
     * - Added Platform\Deprecated
     */
    use Platform\ToDeprecate;
    use Platform\ToUpgrade;
    use Platform\Deprecated;

    /**
     * @since 18-06-24
     * @return \GIndie\Platform\View\Document
     */
    protected function cnstrctDocument()
    {
        $document = new View\Document();
        //$document->setContainer($this->load("container"));
        return $document;
    }

    /**
     * @since 18-06-24
     * @return \GIndie\Platform\View\Document\Container
     */
    protected function cnstrctContainer()
    {
        $container = new View\Document\Container();
        $widgets = Current::Module()->getWidgets();
        $widgets = \array_keys($widgets);
        foreach ($widgets as $id) {
            $container->addWidget($id,
                                  Current::Module()->getWidget($id) != NULL ?
                            Current::Module()->run("widget-reload", $id, \NULL,
                                                   \NULL) : \NULL);
        }
        return $container;
    }

}
