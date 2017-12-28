<?php

/**
 * Created by PhpStorm.
 * User: robertogs.soft@hotmail.com	
 * Date: 13/06/2017
 * Time: 11:05
 */

namespace GIndie\Platform\Controller\Module;

//require_once __DIR__ . '/../model/Login.php';
/* use GIndie\Generator\DML\HTML5;
  use GIndie\Generator\DML\HTML5\Bootstrap3;
  use GIndie\Generator\DML\HTML5\Category\Meta\Head;
  use GIndie\Platform\Current; */
use GIndie\Generator\DML\HTML5\Category\StylesSemantics;
use GIndie\Generator\DML\HTML5\Category\StylesSemantics\Div;
use GIndie\Platform\Current;
use GIndie\Generator\DML\HTML5\Category\Links\Anchor;
use GIndie\Generator\DML\HTML5\Category\Basic\Paragraph;

class Welcome extends \GIndie\Platform\Controller\Module
{

    /**
     * @version     GIP.00.02
     * @since       2017-04-23
     * @var         string 
     */
    const NAME = "Bienvenido";

    public static function RequiredRoles()
    {
        return ["AS", "AO"];
    }

    /**
     * [description]
     * @version     GIP.00.03
     * @since       2017-04-28
     */
    public function config()
    {
        $imageBRAND = Current::Instance()->logoAplicacion();
        $heading = date("d-m-Y");
        $row = new Div("", ["class" => "row text-center"]);

        $col = new Div("", ["class" => "col-sm-2"]);

        $media = new Div("", ["class" => "media-body"]);
        $col->addContent($media);

        $img = StylesSemantics::Span();
        $img->setTag("img");
        $img->setAttribute("src", $imageBRAND);
        $img->setAttribute("width", "120");
        $img->addClass("center-block logoAI");
        $col->addContent($img);
        $row->addContent($col);
        $col = new Div("", ["class" => "col-sm-8"]);

        $h1 = StylesSemantics::Span();
        $h1->setTag("h1");
        $h1->addContent(Current::Instance()->appNombre());
        $col->addContent($h1);

        $h2 = StylesSemantics::Span();
        $h2->setTag("h2");
        //$h2->addContent($record->getAttribute("user")->getDisplay());
        $h2->addContent("¡Bienvenido!");
        $col->addContent($h2);

        //$p = new Paragraph("Administrar electr&oacutenicamente los procesos y los datos relacionados con los ingresos del ayuntamiento de Mineral de la Reforma.");
        //$col->addContent($p);

        $row->addContent($col);


        $col = new Div("", ["class" => "col-sm-2"]);
        $rowimg = new Div("");
        $rowimg->addClass("row");
        //$row->addContent($col);

        //$div2 = new Div("", ["class" => "col-xs-12"]);
        $div2 = new Div("");

        $media = new Div("", ["class" => "media-body"]);
        $div2->addContent($media);
        $img = StylesSemantics::Span();
        $img->setTag("img");
        $media->addContent($img);

        $media = new Div("", ["class" => "media-body"]);
        $div2->addContent($media);
        $img = StylesSemantics::Span();
        $img->setTag("img");
        $img->setAttribute("src", Current::Instance()->logoInstitucion());
        $img->setAttribute("width", "150");
        $media->addContent($img);

        $row->addContent($media);


        $footer = new Div("", ["class" => "row"]);

        $footer1 = new Div("", ["class" => "col-xs-12 text-center"]);
        $url1 = new Anchor(Current::Instance()->urlInstitucion());
        $url1->setAttribute("target", "_blank");
        $url1->setAttribute("href", Current::Instance()->urlInstitucion());
        $footer1->addContent($url1);
        $footer->addContent($footer1);

//        $footer2 = new Div("", ["class" => "col-xs-6 text-center"]);
//        $url2 = new Anchor("www.hidalgo.gob.mx");
//        $url2->setAttribute("target", "_blank");
//        $url2->setAttribute("href", "http://www.hidalgo.gob.mx/");
//        $footer2->addContent($url2);
//        $footer->addContent($footer2);

        $this->configPlaceholder("ii-i-i")->typeCustom($heading, false, $row,
                                                       false, $footer);
    }

}
