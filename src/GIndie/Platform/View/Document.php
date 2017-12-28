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

use GIndie\Generator\DML\HTML5;
use GIndie\Generator\DML\HTML5\Bootstrap3;

/**
 * Document
 * 
 * @since       2017-01-05
 * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @version MR-ADIN.00.02
 */
class Document extends Bootstrap3\Component\Document
{

    /**
     * @since       2017-01-05
     * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
     * @var         type $_topbar
     */
    private $_topbar;

    /**
     * @since       2017-02-08
     * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
     * @var         type $_footbar
     */
    private $_footbar;

    /**
     * @since       2017-02-08
     * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
     * @var         type $_modal
     */
    private $_modal;

    /**
     * @since       2017-04-17
     * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
     * @var         type
     */
    private $_container;

    /**
     * 
     * @since       2017-01-05
     * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
     * @var         type $title
     * @var         type $lang
     */
    public function __construct()
    {
        $assetsFolder = \GIndie\Platform\Current::Instance()->urlAssets();
        $cnt = \GIndie\Platform\Current::Module();
        $pathToCSS = $assetsFolder . "css/libs/bootstrap.min.css";
        $pathToTheme = $assetsFolder . "css/libs/bootstrap-pan.css";
        $pathToJquery = $assetsFolder . "js/libs/jquery.min.js";
        $pathToJS = $assetsFolder . "js/libs/bootstrap.min.js";
        parent::__construct(\GIndie\Platform\Current::Instance()->appNombre(), "es", $pathToCSS, $pathToTheme,
                            $pathToJquery, $pathToJS);

        $this->addLink($assetsFolder . 'css/gip-stylesheet.css?version=3',
                       "stylesheet");
//        $this->addLink($assetsFolder . '/js/libs/font-awesome/css/font-awesome.min.css',
//                "stylesheet");
        $this->addLink($assetsFolder . 'css/libs/bootstrap-select.min.css',
                       "stylesheet");
        $this->addLink($assetsFolder . 'css/libs/dataTables.bootstrap.min.css',
                       "stylesheet");
        $this->addLink($assetsFolder . 'css/libs/select.dataTables.min.css',
                       "stylesheet");
        $this->addLink($assetsFolder . 'css/libs/datatables.net-buttons/buttons.bootstrap.min.css',
                       "stylesheet");

        $this->addLink($assetsFolder . 'css/libs/bootstrap-datetimepicker.min.css',
                       "stylesheet");
        $this->addLink($assetsFolder . 'css/libs/bootstrap-treeview.css',
                       "stylesheet");
        $this->addLink($assetsFolder . 'css/libs/bootstrap-switch.min.css',
                       "stylesheet");
        $this->addLink($assetsFolder . 'js/libs/jstree-themes/proton/style.min.css',
                       "stylesheet");

        $this->addScript($assetsFolder . 'js/libs/jquery.form.js', true);
        $this->addScript($assetsFolder . 'js/libs/jquery.validate.js', true);
        $this->addScript($assetsFolder . 'js/libs/additional-methods.js', true);
        $this->addScript($assetsFolder . 'js/libs/jquery.blockUI.js', true);
        $this->addScript($assetsFolder . 'js/libs/jquery.form.js', true); //otra vez?
        $this->addScript($assetsFolder . 'js/libs/bootstrap-select.min.js', true);

        $this->addScript($assetsFolder . 'js/libs/jquery-ui.min.js', true);

        $this->addScript($assetsFolder . 'js/libs/moment.min.js', true);
        $this->addScript($assetsFolder . 'js/libs/moment_locale/es.js', true);

        $this->addScript($assetsFolder . 'js/libs/bootstrap-datetimepicker.js',
                         true);
        $this->addScript($assetsFolder . 'js/libs/jstree.min.js', true);

        $treeview = $this->addScript($assetsFolder . 'js/libs/bootstrap-treeview.js',
                                     true);
        $treeview->setAttribute('async');

        $treeview = $this->addScript($assetsFolder . 'js/libs/bootstrap-switch.min.js',
                                     true);
        $treeview->setAttribute('async');

        // Librerias de datatables
        $this->addScript($assetsFolder . 'js/libs/jquery.dataTables.min.js',
                         true);
        $this->addScript($assetsFolder . 'js/libs/dataTables.select.min.js',
                         true);
        $this->addScript($assetsFolder . 'js/libs/dataTables.bootstrap.min.js',
                         true);

        $this->addScript($assetsFolder . 'js/libs/datatables.net-buttons/dataTables.buttons.min.js',
                         true);

        $this->addScript($assetsFolder . 'js/libs/datatables.net-buttons/buttons.html5.min.js',
                         true);
        $this->addScript($assetsFolder . 'js/libs/datatables.net-buttons/buttons.flash.min.js',
                         true);
        $this->addScript($assetsFolder . 'js/libs/jszip/jszip.min.js', true);
        $this->addScript($assetsFolder . 'js/libs/pdfmake/pdfmake.min.js', true);
        $this->addScript($assetsFolder . 'js/libs/pdfmake/vfs_fonts.js', true);
        $this->addScript($assetsFolder . 'js/gip-scripts.js?version=5', true);

        $this->_topbar = $this->addContentGetPointer(new Document\Topbar());
        $mainLinks = \GIndie\Platform\Current::Instance()->getPlatformLinks();
        foreach ($mainLinks as $className => $href) {
            if (\class_exists($className, \TRUE)) {
                $this->addSystemReference($href, $className::BRAND_NAME);
            } else {
                trigger_error("Error: Classname '{$className}' doesn't exists.",
                              \E_USER_ERROR);
                throw new \Exception("Error: Classname '{$className}' doesn't exists.");
            }
        }
        $this->_modal = $this->addContentGetPointer(new Bootstrap3\Component\Modal());
        $this->_modal->setId("gip-modal");
        $this->_container = $this->addContentGetPointer(new Document\Container());
        $widgets = \GIndie\Platform\Current::Module()->getWidgets();
        $widgets = array_keys($widgets);
        foreach ($widgets as $id) {
            $this->_container->addWidget($id,
                                         \GIndie\Platform\Current::Module()->getWidget($id)
                    != NULL ? \GIndie\Platform\Current::Module()->getWidget($id)->call(\NULL) : NULL);
        }
        $this->addContent(HTML5\Category\StylesSemantics::Div("")->setId("gip-loader"));
        $this->_footbar = $this->addContentGetPointer(new Document\Footbar("[gip-footbar]"));
    }

    /**
     * 
     * @return \GIndie\Generator\DML\HTML5\Bootstrap3\Component\Modal
     */
    public function getGIPModal()
    {
        return $this->_modal;
    }

    /**
     * 
     * @since       2017-01-05
     * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
     * @var         type $href
     * @var         type $text
     * @var         type $target
     */
    public function addSystemReference($href, $text, $target = null)
    {
        $this->_topbar->addSystemReference($href, $text, $target);
    }

    public function addWidget($id, Widget $widget = NULL)
    {
        $this->_container->addWidget($id, $widget);
    }

}