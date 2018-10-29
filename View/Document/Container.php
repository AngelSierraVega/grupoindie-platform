<?php
/**
 * GI-Platform-DVLP - Container
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\View
 *
 * @version 0C.90 
 * 
 * @todo
 * - Funcional class with node
 */

namespace GIndie\Platform\View\Document;

use \GIndie\Platform\Current;
use \GIndie\ScriptGenerator\Bootstrap3;

/**
 * 
 * @since 17-04-21
 * @edit 18-06-23
 */
class Container extends Bootstrap3\Grid
{

    use \GIndie\Platform\WidgetsDefinition;

    /**
     * 
     * @since 17-04-21
     * @edit 18-06-24
     * - Implemented constructor for Grid
     */
    public function __construct()
    {
        parent::__construct(Bootstrap3\Grid::TYPE_CONTAINER_FLUID);
        $this->_widgets = $this->WidgetsDefinition;
        $this->setId("gip-container");
    }

    /**
     * 
     * @since 17-04-21
     */
    private $_widgets = [];

    /**
     * 
     * @since 17-04-21
     */
    public function addWidget($id, /* \GIndie\Platform\View\Widget */ $widget = NULL)
    {
        $this->_widgets[$id] = $widget == NULL ? "" : $widget;
    }

    /**
     * @since 18-06-24
     * @return string
     */
    public function defineScript()
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
        //                console.log("triggerInteraction");
                // console.log("'triggerInteraction' called widget_id(" + widget_id + ") selected(" + selected + ")");
                // console.log(relaciones);
                if (relaciones[widget_id]) {
                    if (relaciones[widget_id].length > 0) {
                        //     console.log("Calling 'gipInteraction'");
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
        //                console.log("triggerParents");
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
        //                console.log("gipInteraction");
                $.each(slaves, function (index, el) {
                    //console.log("'Clicking' widget-reload");
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
        <?php
        $str = ob_get_contents();
        ob_end_clean();
        return $str;
    }

    /**
     * 
     * @return type
     * @since 17-04-21
     * @edit 18-06-24
     * - Moved script to defineScript()
     * - Moved divs to tmpContent()
     */
    public function __toString()
    {
        $this->removeContent();
        $this->addContent($this->tmpContent());
        return parent::__toString();
    }

    /**
     * 
     * @since 18-06-24
     * @edit 18-07-29
     * - Added ID to placeholders: o-o-o, i-i-i
     * @edit 18-10-18
     * - Added placeholders: i-ii-i-large, i-ii-ii-small
     * @edit 18-10-29
     * - Added ii-ii-i-large, ii-ii-ii-small
     */
    private function tmpContent()
    {
        ob_start();
        ?>
        <!--        <div id="gip-container" class="container-fluid">-->
        <div class="row ">
            <div id="o-o-o" gip-placeholder="o-o-o" class="col-xs-12">
                <?php echo $this->_widgets["o-o-o"]; ?>
            </div>
        </div>
        <div class="row ">
            <div id="i-i-i" gip-placeholder="i-i-i" class="col-xs-12">
                <?php echo $this->_widgets["i-i-i"]; ?>
            </div>
        </div>

        <div class="row ">
            <div id="i-ii-i-large" class="col-sm-8">
                <?php echo $this->_widgets["i-ii-i-large"]; ?>
            </div>
            <div id="i-ii-ii-small" class="col-sm-4">
                <?php echo $this->_widgets["i-ii-ii-small"]; ?>
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
            <div id="ii-ii-i-large" class="col-sm-8">
                <?php echo $this->_widgets["ii-ii-i-large"]; ?>
            </div>
            <div id="ii-ii-ii-small" class="col-sm-4">
                <?php echo $this->_widgets["ii-ii-ii-small"]; ?>
            </div>
        </div>

        <div class="row ">
            <div id="ii-ii-i-small" class="col-sm-4">
                <?php echo $this->_widgets["ii-ii-i-small"]; ?>
            </div>
            <div id="ii-ii-ii-large" class="col-sm-8">
                <?php echo $this->_widgets["ii-ii-ii-large"]; ?>
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
        <!--        </div>-->


        <?php
        $str = ob_get_contents();
        ob_end_clean();
        return $str;
    }

}
