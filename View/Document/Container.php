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

use \GIndie\Platform\Current;

//require_once __DIR__ . '/../Widget.php';

/**
 * Description of Container
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Container
{

    use \GIndie\Platform\WidgetsDefinition;

    /**
     * @version     GIP.00.03
     * @since       2017-04-21
     */
    public function __construct()
    {
        $this->_widgets = $this->WidgetsDefinition;
    }

    private $_widgets = [];

    public function addWidget($id, /* \GIndie\Platform\View\Widget */ $widget = NULL)
    {
        $this->_widgets[$id] = $widget == NULL ? "" : $widget;
    }

    public function __toString()
    {
        ob_start();
        ?>
        <script>

        <?= "var relaciones = " . Current::Module()->fetchMasterSlaves(); ?>

            /**
             * triggerInteraction   Permit avisar a todos los hijos de un padre el ID de este ultimo, con ello
             *                      se pueden cargar los datos usando el id padre.
             * @param widget_id     Es el id logico de la base de datos (Id padre en base de datos),
             */
            function triggerInteraction(widget_id, selected = "NONE") {
                if (relaciones[widget_id]) {
                    if (relaciones[widget_id].length > 0) {
                        gipInteraction(relaciones[widget_id], selected);
                    }
            }
            }
            //console.log(relaciones);

            /**
             * triggerParents       Permit avisar a todos los hijos de un padre el ID de este ultimo, con ello
             *                      se pueden cargar los datos usando el id padre.
             * @param widget_id     Es el id logico de la base de datos (Id padre en base de datos),
             */
            function triggerParents(widget_id, selected) {
                var refresh_parents = [];
                $.each(relaciones, function (index, val) {
                    if (val.includes(widget_id) > 0) {
                        refresh_parents.push(index);
                    }
                });
                gipInteraction(refresh_parents, selected);

            }



            /**
             * SendchildrensId      Permite avisar a todos los hijos de un padre el ID de este ultimo, con ello
             *                      se pueden cargar los datos usando el id padre.
             * @param id_element    Es el id logico de la base de datos (Id padre en base de datos), "
             * @param id_parent     Es el id del placeholder (Id del widget padre).
             */
            function sendChildrensId(id_element, id_parent) {
                // Si nodo padre tiene hijos declarados
                if (relaciones[id_parent].length > 0) {
                    // Procedemos por cada uno de sus hijos a enviar la informacion necesaria para que pueda cargar sus datos
                    $.each(relaciones[id_parent], function (index, el) {

                        data = {
                            "gip-action": "widget-reload",
                            "gip-action-id": el,
                            "gip-selected-id": id_element
                        };

                        $.ajax({
                            type: "POST",
                            data: data,
                            url: "?",
                            success: function (datos) {
                                //console.log(data);
                                $("#" + el).html(datos);
                            },
                            error: ajaxErrorHandler
                        });
                    });
                }
            }


            function gipInteraction(slaves, selected) {
                $.each(slaves, function (index, el) {
                    $("#" + el).find('button[gip-action="widget-reload"]').trigger('click');

        //                            console.log(selected);
        //                            var data = {
        //                                "gip-action": "widget-reload",
        //                                "gip-action-id": el,
        //                                "gip-selected-id": selected
        //                            };
        //        
        //                            $.ajax({
        //                                type: "POST",
        //                                data: data,
        //                                url: "?",
        //                                success: function (data) {
        //                                    $("#" + el).html(data);
        //                                },
        //                                error: ajaxErrorHandler
        //                            });
                });
            }

        </script>

        <div id="gip-container" class="container-fluid">

            <div class="row ">
                <div gip-placeholder="i-i-i" class="col-xs-12">
                    <?php echo $this->_widgets["i-i-i"]; ?>
                </div>
            </div>
            
            <div class="row ">
                <div class="col-sm-6">
                    <div id="i-ii-i">
                        <?php echo $this->_widgets["i-ii-i"]; ?>
                    </div>
                    <div id="i-ii-ia">
                        <?php echo $this->_widgets["i-ii-ia"]; ?>
                    </div>
                    <div id="i-ii-ib">
                        <?php echo $this->_widgets["i-ii-ib"]; ?>
                    </div>
                </div>
                <div id="i-ii-ii" class="col-sm-6">
                    <?php echo $this->_widgets["i-ii-ii"]; ?>
                </div>
            </div>

            <div class="row">
                <div id="i-iii-i" class="col-sm-4">
                    <?php echo $this->_widgets["i-iii-i"]; ?>
                </div>
                <div id="i-iii-ii" class="col-sm-4">
                    <?php echo $this->_widgets["i-iii-ii"]; ?>
                </div>
                <div id="i-iii-iii" class="col-sm-4">
                    <?php echo $this->_widgets["i-iii-iii"]; ?>
                </div>
            </div>


            <div class="row ">
                <div id="ii-i-i" class="col-xs-12">
                    <?php echo $this->_widgets["ii-i-i"]; ?>
                </div>
            </div>

            <div class="row ">
                <div id="ii-ii-i" class="col-sm-6">
                    <?php echo $this->_widgets["ii-ii-i"]; ?>
                </div>
                <div id="ii-ii-ii" class="col-sm-6">
                    <?php echo $this->_widgets["ii-ii-ii"]; ?>
                </div>
            </div>

            <div class="row ">
                <div id="ii-iii-i" class="col-sm-4">
                    <?php echo $this->_widgets["ii-iii-i"]; ?>
                </div>
                <div id="ii-iii-ii" class="col-sm-4">
                    <?php echo $this->_widgets["ii-iii-ii"]; ?>
                </div>
                <div id="ii-iii-iii" class="col-sm-4">
                    <?php echo $this->_widgets["ii-iii-iii"]; ?>
                </div>
            </div>


            <div class="row ">
                <div id="iii-i-i" class="col-xs-12">
                    <?php echo $this->_widgets["iii-i-i"]; ?>
                </div>
            </div>
            <div class="row">
                <div id="iii-ii-i" class="col-sm-6">
                    <?php echo $this->_widgets["iii-ii-i"]; ?>
                </div>
                <div id="iii-ii-ii" class="col-sm-6">
                    <?php echo $this->_widgets["iii-ii-ii"]; ?>
                </div>
            </div>

            <div class="row ">
                <div id="iii-iii-i" class="col-sm-4">
                    <?php echo $this->_widgets["iii-iii-i"]; ?>
                </div>
                <div id="iii-iii-ii" class="col-sm-4">
                    <?php echo $this->_widgets["iii-iii-ii"]; ?>
                </div>
                <div id="iii-iii-iii" class="col-sm-4">
                    <?php echo $this->_widgets["iii-iii-iii"]; ?>
                </div>
            </div>
        </div>


        <?php
        $str = ob_get_contents();
        ob_end_clean();
        return $str;
    }

}
