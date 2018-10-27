<?php

/**
 * GI-Platform-DVLP - RecordAutoincremented
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\View
 *
 * @version 0C.00
 * @since 
 */

namespace GIndie\Platform\View\Document\Footbar;

use GIndie\Platform\Current;
use GIndie\Generator\DML\HTML5\Category\StylesSemantics;
use GIndie\Generator\DML\HTML5\Category\Links\Anchor;
use GIndie\Generator\DML\HTML5\Category\StylesSemantics\Div;

/**
 * @edit 18-02-27
 */
class Content extends Div
{

    public function __construct()
    {
        parent::__construct("", ["class" => "container", "id" => "gip-footer"]);
        $row = new Div("", ["class" => "row"]);
        $this->addContent($row);

        $div1 = new Div("", ["class" => "col-xs-4"]);
        $row->addContent($div1);

        $bitacora = new Anchor("Bitácora");
        $bitacora->setAttribute("gip-action", "tabla-bitacora");
        $bitacora->setAttribute("gip-modal", "lg");
        $bitacora->setAttribute("href", "current_log");
        $div1->addContent($bitacora);

        $div2 = new Div("", ["class" => "col-xs-4"]);
        $row->addContent($div2);

        $media = new Div("", ["class" => "media-body"]);
        $div2->addContent($media);
        $img = StylesSemantics::Span();
        $media->addContent($img);

        $media = new Div("", ["class" => "media-body"]);
        $div2->addContent($media);
        $img = StylesSemantics::Span();
        $img->setTag("img");
        $img->setAttribute("src", Current::Instance()->logoInstitucion());
        $img->setAttribute("width", "45");
        $media->addContent($img);

        $div3 = new Div("", ["class" => "col-xs-4"]);
        $row->addContent($div3);

        $acercade = new Anchor("Acerca de");
        $div3->addContent($acercade);
    }

}
