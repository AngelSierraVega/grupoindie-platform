<?php

/**
 * GI-Platform-DVLP - 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\View
 * 
 * @version 0C.00
 * @since 18-03-14
 */

namespace GIndie\Platform\View;

/**
 * GI-Platform-DVLP - Javascript
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @todo
 * - Extend class from ScriptGenerator
 * @edit 18-05-20
 */
class Javascript
{

    /**
     * 
     * @param type $widgetId
     * @return string
     * @since 18-03-14
     * @edit 18-03-18
     * - Expanted waiter timeout
     * @edit 18-03-20
     * - Remove setTimeout for input type = "radio" [type="radio"]
     * @todo
     * - Verify-debug submit on the rest of input changes
     */
    public static function submitOnChange($formId)
    {
        \ob_start();
        ?>
        <script>
            var timerid;
            $("#<?= $formId; ?>").on('input', 'input[type="radio"]', function () {
                $("#<?= $formId; ?>").submit();
            });
            $("#<?= $formId; ?>").on('input', 'input[type="text"]', function () {
                clearTimeout(timerid);
                timerid = setTimeout(function () {
                    $("#<?= $formId; ?>").submit();
                }, 1200);
            });
            $("#<?= $formId; ?> select").change(function () {
                $("#<?= $formId; ?>").submit();
            });
        </script>
        <?php
        $out = \ob_get_contents();
        \ob_end_clean();
        return $out;
    }

    /**
     * 
     * @param type $widgetId
     * @return string
     * @since 18-03-14
     */
    public static function reloadWidget($widgetId)
    {
        \ob_start();
        ?>
        <script>
            $.ajax({
                type: "POST",
                data: {
                    "gip-action": "widget-reload",
                    "gip-action-id": "<?= $widgetId; ?>"
                },
                url: "?",
                success: function (data) {
                    $("#<?= $widgetId; ?>").html(data);
                },
                error: ajaxErrorHandler
            });
        </script>
        <?php
        $out = \ob_get_contents();
        \ob_end_clean();
        return $out;
    }

}
