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
 * @since 
 */

namespace GIndie\Platform\View;

/**
 * Description of TablePagination
 *
 * @edit 18-02-27
 */
class TablePagination extends TableSimple
{
    public function defineScript()
    {
        $tableModel = $this->_model;
        $title = $tableModel::Name();
        ob_start();
        ?>
        <script>
            var columns = [<?= $this->_getColumns(); ?>];
            var title = "<?= $title; ?>";
            $(document).ready(function () {
                create_datatable("<?= $this->getId(); ?>", {"title":title, "columns": columns, "search": false, "export": false, "pagination": true, "selectable": true});
            });
        </script>
        <?php
        $str = ob_get_contents();
        ob_end_clean();
        return $str;
    }
}
