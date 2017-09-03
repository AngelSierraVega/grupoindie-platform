<?php
/*
 * Copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * This software is protected under GNU: you can use, study and modify it
 * but not distribute it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 */

namespace GIndie\Platform\View\Document;

use GIndie\Generator\DML\HTML5;
use GIndie\Generator\DML\HTML5\Bootstrap3;


/**
 * Footbar
 * 
 * @since       2017-02-08
 * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @version     beta.00.01
 */
class Footbar extends HTML5\Category\StylesSemantics\Footer {

    private $_container;

    public function __construct($content) {
        parent::__construct([], "footer navbar-fixed-bottom");

        //$this->_container = $this->addContent(\GIgenerator\DML\HTML5\);
//        
//        $this->_container->addClass("container");
//        $this->_container->setId("gip-footer");
        $this->_container = parent::addContent(new Footbar\Content());
    }

    public function addContentDEPRECATED($content) {
        return $this->_container->addContent($content);
    }

}