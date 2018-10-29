<?php

/**
 * GI-Platform-DVLP - 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\View
 * 
 * @version 0D.00
 * @since 
 */

namespace GIndie\Platform\View;

use GIndie\Platform\Current;
//use GIndie\Generator\DML\HTML5\Bootstrap3;
use GIndie\ScriptGenerator\Bootstrap3;
//use GIndie\Generator\DML\HTML5\Category\StylesSemantics\Div;
use GIndie\ScriptGenerator\HTML5\Category\StylesSemantics\Div;
//use GIndie\Generator\DML\HTML5\Category\StylesSemantics;
use GIndie\ScriptGenerator\HTML5\Category\StylesSemantics;
//use GIndie\Generator\DML\HTML5\Category\Basic;
use GIndie\ScriptGenerator\HTML5\Category\Basic;

use GIndie\ScriptGenerator\HTML5\Category\Links;
use GIndie\Platform\Model\Datos\mr_sesion\usuario_cuenta;

/**
 * Pantalla de login
 * @edit 18-03-06
 * @edit 18-11-05
 * - Removed use of deprecated libs
 */
class Login extends Bootstrap3\Document
{

    function __construct($logoAplicacion, $slogan, $urlAssets, $logoInstitucion)
    {
        $assetsFolder = $urlAssets;
        $pathToCSS = $assetsFolder . "css/libs/bootstrap.min.css";
        $pathToTheme = $assetsFolder . "css/libs/bootstrap-flaty.css";

        $pathToJquery = $assetsFolder . "js/libs/jquery.min.js";
        $pathToJS = $assetsFolder . "js/libs/bootstrap.min.js";
        parent::__construct("Ingresar al sistema", "es", $pathToCSS, $pathToTheme, $pathToJquery, $pathToJS);

        $pathToStyle = $assetsFolder . "css/gip-stylesheet.css";
        $this->addLink($pathToStyle, "stylesheet");

        $this->addScript($assetsFolder . 'js/libs/jquery.form.js', true);
        $this->addScript($assetsFolder . 'js/libs/jquery.validate.js', true);

        $container = new Div("");
        $container->addClass("container");

        $divsm6 = new Div("");
        $divsm6->addClass("col-sm-6 col-sm-offset-3 divlogin col-xs-10 col-xs-offset-1");
        $container->addContent($divsm6);

        /* ------------- Inicia seccion para el logo ----------------- */

        // Creamos el div row de bootstrap
        $rowLogo = new Div("");
        $rowLogo->addClass("row");
        $divsm6->addContent($rowLogo);

        $divColLogo = new Div("");
        $divColLogo->addClass("col-sm-6 col-sm-offset-3 col-xs-5 col-xs-offset-3");
        $rowLogo->addContent($divColLogo);

        $img = StylesSemantics::Span();
        $img->setTag("img");
        $img->setAttribute("src", $logoInstitucion);
        $img->setAttribute("width", "120");
        $img->addClass("center-block");
        $divColLogo->addContent($img);


        /* ------------- Inicia seccion para el logo ----------------- */




        $divsm6->addContent(Basic::Hr());

        if (isset($GLOBALS["gip-error"])) {
            $rowNew = new Div($GLOBALS["gip-error"], ["class" => "row"]);
            //$rowNew->addContent();
            $divsm6->addContent($rowNew);
        }

        $rowForm = new Div("");
        $rowForm->addClass("row");
        $divsm6->addContent($rowForm);

        $record = usuario_cuenta\Ingreso::instance(["gip-action" => "gip-login"]);
        $form = new \GIndie\Platform\View\Form($record, \FALSE, "_self");
        $form->addClass("text-center");
        $form->setAttribute("gip-action-id", "login");
        $form->setMethod("post");
        $formId = $form->getId();
        //$form = "<p>El sistema se encuentra en mantenimiento de manera breve. Por favor aguarde.</p>";
        //$rowForm->addContent($form);
        $rowLogo->addContent($form);

        $rowbutton = new Div("");
        $rowbutton->addClass("row");
        $divsm6->addContent($rowbutton);

        $btn = new Bootstrap3\Component\Button("Ingresar al sistema", Bootstrap3\Component\Button::TYPE_SUBMIT);
        $btn->setForm($formId);
        $btn->setValue("Submit");
        $btn->setContext(Bootstrap3\Component\Button::$COLOR_PRIMARY);
        $btn->addClass("btn-block");
        $rowbutton->addContent($btn);


        /* ------------- Inicia seccion para el slogan ----------------- */

        // Creamos el div que sera el row para una nueva linea de bootstrap
        $rowslogan = new Div("");
        $rowslogan->addClass("row");
        $divsm6->addContent($rowslogan);

        // Agregamos el div que sera el que contendra la clase col-xx-xx
        $divColSlogan = new Div("");
        $divColSlogan->addClass("col-xs-12");
        $rowslogan->addContent($divColSlogan);

        // Agramos a nuestro div anterior el mensaje de nuestro slogan que estara a su vez dentro de un span
        $sloganMessage = Basic::Header(2, $slogan);
        $sloganMessage->addClass("text-center");
        $sloganMessage->addClass("slogan");
        $divColSlogan->addContent($sloganMessage);


        /* ------------- Termina seccion para el slogan ----------------- */

        $rowlogos = new Div("");
        $rowlogos->addClass("row");
        $divsm6->addContent($rowlogos);



        $divimg3 = new Div("");
        $divimg3->addClass("col-xs-6 col-xs-offset-3");
        $rowlogos->addContent($divimg3);
        $img = StylesSemantics::Span();
        $img->setTag("img");
        $img->setAttribute("width", "120");
        $img->addClass("center-block");
        $img->setAttribute("src", $logoAplicacion);
        $img->setAttribute("style", "background-color:#122b40; padding: 20px; margin-top: 15px;border-radius: 120px;");
        $img->addClass("img-responsive");
        $divimg3->addContent($img);

        //$this->addContent($container);

        $container = new Div("");
        $container->addClass("container");
        $divsm6 = new Div("");
        $divsm6->addClass("col-sm-12 col-md-8 col-md-offset-2");
        $container->addContent($divsm6);

        $row1 = new Div("");
        $row1->addClass("row");
        $row1->setAttribute("style", "background-color: gainsboro;");

        $col1 = new Div("");
        $col1->addClass("col-xs-12 col-sm-5");
//        $col1->setAttribute("style",
//                           "background-color:#122b40;");
        $img = StylesSemantics::Span();
        $img->setTag("img");
        $img->setAttribute("src", $logoInstitucion);
        $img->setAttribute("width", "150");
        $img->addClass("center-block");
        $img->setAttribute("style", "vertical-align: middle;");
        //$img->setAttribute($attributeName);
        $col1->addContent($img);
        $sloganMessage = Basic::Header(3, $slogan);
        $sloganMessage->addClass("text-center");
        $sloganMessage->addClass("slogan");
        $col1->addContent($sloganMessage);
        //$divColLogo->addContent($img);
        //$divsm6->addContent($col1);
        $row1->addContent($col1);

        $col2 = new Div("");
        $col2->addClass("col-xs-12 col-sm-7");
        $btn = new Bootstrap3\Component\Button("Ingresar al sistema", Bootstrap3\Component\Button::TYPE_SUBMIT);
        $btn->setForm($formId);
        $btn->setValue("Submit");
        $btn->setContext(Bootstrap3\Component\Button::$COLOR_PRIMARY);
        $btn->addClass("btn-block");
        $form->addContent($btn);
        $col2->addContent($form);
        //$col2->addContent(Basic::BreakLine());
        //$divsm6->addContent($col2);
        $row1->addContent($col2);
        $divsm6->addContent($row1);

        $msj = \GIndie\Platform\INIHandler::getCategoryValue("Vendor", "msj");
        if ($msj) {
            
        } else {
            $msj = "";
        }
        $subtext1 = Basic::Header(5, $msj);
        //$subtext1 = Basic::Paragraph("Dirección de informática. Mineral de la Reforma, Hidalgo. 2016-2020");
        $subtext1->addClass("text-center");
        $divsm6->addContent($subtext1);

        $subtext2 = Basic::Header(6, Links::hyperlink("http://www.mineraldelareforma.gob.mx", "www.mineraldelareforma.gob.mx", "_blank"));
        $subtext2->addClass("text-center");
        $divsm6->addContent($subtext2);

        $this->addContent($container);
    }

}
