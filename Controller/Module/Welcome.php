<?php

/**
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @license file://LICENSE
 * 
 * @package GIndie\Platform\Module
 * 
 * @version 0D.70
 * @since 17-06-13
 */

namespace GIndie\Platform\Controller\Module;

use GIndie\ScriptGenerator\HTML5\Category\StylesSemantics;
use GIndie\ScriptGenerator\HTML5\Category\StylesSemantics\Div;
use GIndie\Platform\Current;
use GIndie\ScriptGenerator\HTML5\Category\Links\Anchor;

//use GIndie\Generator\DML\HTML5\Category\Basic\Paragraph;

/**
 * @edit 17-04-23
 * @edit 17-04-28
 * @edit 18-01-07
 * - Displays the name of the app + the name of the instance.
 * @edit 18-11-05
 * - Removed use of deprecated libs
 */
class Welcome extends \GIndie\Platform\Controller\Module
{

    /**
     * {@inheritdoc}
     * @since 18-12-21
     */
    public static function name()
    {
        return "Bienvenido";
    }

    /**
     * {@inheritdoc}
     * @since 18-12-21
     */
    public static function description()
    {
        return null;
    }
    
    /**
     * {@inheritdoc}
     * @since 19-01-29
     */
    public static function configActions()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     * @edit 18-12-21
     */
    public function wdgtModuleInfo()
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
        $h1->addContent("<b>" . \GIndie\Platform\INIHandler::getCategoryValue("Instance", "name") . "</b>");
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


        $rtnWidget = new \GIndie\Platform\View\Widget($heading, false, $row, false, $footer);
        $rtnWidget->setContext("primary");
        return $rtnWidget;
    }

    /**
     * 
     * @return array
     */
    public static function requiredRoles()
    {
        return ["AS"];
    }

    /**
     * 
     * @edit 18-12-07
     * - Upgraded from config() to configPlaceholders()
     */
    public function configPlaceholders()
    {
        $this->placeholder("i-i-i")->typeHTMLString("");
        return;
    }

}
