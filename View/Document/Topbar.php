<?php

/*
 * Copyright (C) 2016 Angel Sierra Vega. Grupo INDIE.
 *
 * This software is protected under GNU: you can use, study and modify it
 * but not distribute it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 */

namespace GIndie\Platform\View\Document;

use GIndie\Platform\Current;
use GIndie\Generator\DML\HTML5\Category\StylesSemantics;
use GIndie\Generator\DML\HTML5\Category\Links\Anchor;
use GIndie\Generator\DML\HTML5\Category\Lists;
use GIndie\Generator\DML\HTML5\Category\StylesSemantics\Div;
use GIndie\Generator\DML\HTML5\Bootstrap3\Component\Button;
use GIndie\Generator\DML\HTML5\Bootstrap3 as Bootstrap3;

/**
 * Topbar
 * 
 * @since       2017-01-05
 * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @version     GIP.00.02
 */
class Topbar extends Div
{

    /**
     * @since       2017-01-05
     * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
     * 
     * @version     GIP.00.02
     * 
     * @var         \GIndie\DML\HTML5\Node
     */
    private $_brand;

    /**
     * @since       2017-01-05
     * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
     * 
     * @version     GIP.00.02
     * 
     * @var         \GIndie\DML\HTML5\Node
     */
    private $_userMenu;

    /**
     * @since       2017-04-21
     * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
     * 
     * @version     GIP.00.01
     * 
     */
    private $_moduleMenu;

    /**
     * 
     * @final
     * @since       2017-01-05
     * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
     * 
     * @version     GIP.00.02
     */
    final public function __construct()
    {
        parent::__construct("");

        $this->_userMenu = new Topbar\UserMenu();
        $this->_moduleMenu = new Topbar\ModuleMenu();

        $this->setTag("nav");
        $this->addClass("navbar navbar-default");
        $this->addClass("navbar-fixed-top");
        $container_fluid = new Div("", ["class" => "container-fluid"]);
        $this->addContent($container_fluid);

        $navbar_header = new Div("", ["class" => "navbar-header"]);
        $container_fluid->addContent($navbar_header);

        $button_toggle = new Button("", "button");
        $button_toggle->addClass("navbar-toggle collapsed");
        $button_toggle->setAttribute("data-toggle", "collapse");
        $button_toggle->setAttribute("data-target", "#gip-topbar-content");
        $button_toggle->setAttribute("aria-expanded", "false");
        $navbar_header->addContent($button_toggle);

        $span = StylesSemantics::Span();
        $span->addClass("sr-only");
        $span->addContent("Toggle navigation");
        $button_toggle->addContent($span);

        $span = StylesSemantics::Span();
        $span->addClass("icon-bar");
        $button_toggle->addContent($span);
        $button_toggle->addContent($span);
        $button_toggle->addContent($span);

        $navbar_brand = new Div("", ["class" => "navbar-brand"]);
        $navbar_header->addContent($navbar_brand);

        $anchor = \GIndie\Generator\DML\HTML5\Category\Links::Anchor();
        $anchor->setAttribute("gip-action","setController");
        $anchor->setAttribute("gip-action-id",urlencode(\GIndie\Platform\Controller\Module\Welcome::class));
        
        
        $img = StylesSemantics::Span();
        $img->setTag("img");
        $img->setAttribute("src",
                           Current::Instance()->logoAplicacion());
        $img->setAttribute("width", "30");
//        $img->addContent('<a gip-action="setController" gip-action-id="' .
//                urlencode(\GIndie\Platform\Controller\Module\Welcome::class) .
//                '" href="#">' . "" . '</a>');
        $anchor->addContent($img);
        $navbar_brand->addContent($anchor);

        $brand = \GIndie\Platform\Current::Instance();
        if ($brand == \NULL) {
            $brand = "ERROR";
        } else {
            $brand = $brand::BRAND_NAME;
        }
        $this->_brand = new Bootstrap3\Component\Dropdown($brand, []);
        $this->_brand->addClass("navbar-brand");
        $navbar_header->addContent($this->_brand);

        $navbar_collapse = new Div("", ["class" => "collapse navbar-collapse"]);
        $navbar_collapse->setAttribute("id", "gip-topbar-content");
        $container_fluid->addContent($navbar_collapse);

        $navbar_collapse->addContent($this->_moduleMenu);

        $ul = Lists::Unordered([$this->_userMenu]);
        $ul->addClass("nav navbar-nav navbar-right");
        $navbar_collapse->addContent($ul);
    }

    /**
     * 
     * @since       2017-01-05
     * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
     * 
     * @version     beta.00.01
     * 
     * @var         type $brand
     */
    public function setBrandDEPRECATED($brand)
    {
        $this->_brand = new Bootstrap3\Dropdown($brand, []);
        $this->_brand->addClass("navbar-brand dropdown");
        return $this;
    }

    /**
     * 
     * @since       2017-01-05
     * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
     * 
     * @version     beta.00.01
     * 
     * @var         type $href
     * @var         type $text
     * @var         type $target
     */
    public function addSystemReference($href, $text, $target = null)
    {
        if (!defined($this->_brand)) {
            //throw new \Exception("Brand must be defined with setBrand() in document");
        }
        //$content = new \GIndie\DML\HTML5\Anchor\Anchor($href, $text, $target);
        $content = new \GIndie\Generator\DML\HTML5\Category\Links\Hyperlink($href,
                                                                            $text,
                                                                            $target);
        $this->_brand->addListElement(new \GIndie\Generator\DML\HTML5\Category\Lists\ListItem([],
                                                                                              [$content]));
    }

}
