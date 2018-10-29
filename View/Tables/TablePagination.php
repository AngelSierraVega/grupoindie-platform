<?php
/**
 * GI-Platform-DVLP - TablePagination
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\View
 *
 * @version 0C.50
 * @since 18-11-04
 */

namespace GIndie\Platform\View\Tables;

/**
 * Description of TablePagination
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class TablePagination extends Table
{

    /**
     * 
     * @return string
     * @since 18-11-04
     */
    public function defineScript()
    {
        $title = $this->recordInstance->name();
        ob_start();
        ?>
        <script>
            var columns = [<?= $this->getColumns(); ?>];
            var title = "<?= $title; ?>";
            $(document).ready(function () {
                create_datatable("<?= $this->getId(); ?>", {"title": title, "columns": columns, "search": false, "export": false, "pagination": true, "selectable": true});
            });
        </script>
        <?php
        $str = ob_get_contents();
        ob_end_clean();
        return $str;
    }

}
