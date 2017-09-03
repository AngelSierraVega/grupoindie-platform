<?php

/*
 * Copyright (C) 2016 Angel Sierra Vega. Grupo INDIE.
 *
 * This software is protected under GNU: you can use, study and modify it
 * but not distribute it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 */

namespace GIndie\Platform\View;

use GIndie\Platform\Current;
use GIndie\Generator\DML\HTML5\Bootstrap3;
use GIndie\Generator\DML\HTML5\Category\StylesSemantics\Div;
use GIndie\Generator\DML\HTML5\Category\StylesSemantics;
use GIndie\Generator\DML\HTML5\Category\Basic;
use GIndie\Platform\Model\Datos\mr_sesion\usuario_cuenta;

/**
 * Pantalla de login
 * @version MR-ADIN.00.02
 */
class Login extends Bootstrap3\Component\Document
{

    function __construct($imageLogo, $slogan, $urlAssets, $logoInstitucion)
    {
        $assetsFolder = $urlAssets;
        $pathToCSS = $assetsFolder . "css/libs/bootstrap.min.css";
        $pathToTheme = $assetsFolder . "css/libs/bootstrap-flaty.css";

        $pathToJquery = $assetsFolder . "js/libs/jquery.min.js";
        $pathToJS = $assetsFolder . "js/libs/bootstrap.min.js";
        parent::__construct("Ingreso a A.I.I.", "es", $pathToCSS, $pathToTheme,
                            $pathToJquery, $pathToJS);

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
        $img->setAttribute("src", $imageLogo);
        $img->setAttribute("style",
                           "background-color:#122b40; padding: 20px; margin-top: 15px;border-radius: 180px;");
        $img->addClass("img-responsive");
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
        $rowForm->addContent($form);

        $rowbutton = new Div("");
        $rowbutton->addClass("row");
        $divsm6->addContent($rowbutton);

        $btn = new Bootstrap3\Component\Button("Ingresar a A.I.I.",
                                               Bootstrap3\Component\Button::TYPE_SUBMIT);
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
        $img->setAttribute("src", $logoInstitucion);
        $img->setAttribute("width", "120");
        $img->addClass("center-block");
        $divimg3->addContent($img);

        $this->addContent($container);

    }

}
