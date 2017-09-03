<?php

/**
 * GrupoIndie - Widget 2017-04-21
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.00
 */

namespace GIndie\Platform\View;

use GIndie\Generator\DML\HTML5\Category\StylesSemantics;
use GIndie\Generator\DML\HTML5\Bootstrap3\Component\Panel;
use \GIndie\Generator\DML\HTML5\Bootstrap3\Component\Button;
use GIndie\Platform\View\Widget\Buttons;

/**
 * Description of Widget
 * 
 * @since   
 * @author  Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @version GIP.00.00
 */
class Widget extends Panel {

    private $_btnGroup;

    public function __construct($heading = \FALSE, $heading_body = \FALSE,
            $body = \FALSE, $body_footer = \FALSE, $footer = \FALSE,
            $buttons = \NULL) {
        if(is_subclass_of($heading, Panel\Heading::class,\FALSE)){
            $heading_new = $heading;
        }else{
            $heading_new = new Panel\Heading();
        }
        
        $this->_btnGroup = $heading_new->addContentGetPointer(StylesSemantics::Div("",
                        ["class" => "btn-group pull-right"]));
        $heading_new->setTitle($heading);
        //$this->addButtonReload();
        parent::__construct($heading_new, $heading_body, $body, $body_footer,
                $footer);
    }

    public function addButtonHeading(Button $button) {
        $this->_btnGroup->addContent($button);
    }

//    public function addButtonReload() {
//        
//    }

}
