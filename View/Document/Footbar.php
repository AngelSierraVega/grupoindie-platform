<?php

/**
 * GI-Platform-DVLP - 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\View
 *
 * @version 0D.10
 * @since 17-02-08
 */

namespace GIndie\Platform\View\Document;

//use GIndie\Generator\DML\HTML5;
use GIndie\ScriptGenerator\HTML5;
//use GIndie\Generator\DML\HTML5\Bootstrap3;
use GIndie\ScriptGenerator\Bootstrap3;

/**
 * Footbar
 * @edit 18-05-20
 * @edit 18-11-05
 * - Removed use of deprecated libs
 */
class Footbar extends HTML5\Category\StylesSemantics\Footer
{

    private $_container;

    public function __construct($content)
    {
        parent::__construct([], "footer navbar-fixed-bottom");
        $this->_container = parent::addContent(new Footbar\Content());
    }

    public function addContentDEPRECATED($content)
    {
        return $this->_container->addContent($content);
    }

}
