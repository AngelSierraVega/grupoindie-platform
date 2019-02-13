<?php
/**
 * GI-Platform-DVLP - Complete
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\View
 *
 * @version 0C.00
 * @since 18-12-24
 */

namespace GIndie\Platform\View\Tables;

/**
 * Description of Complete
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Complete extends Table
{

    /**
     * 
     * @return string
     * @since 18-12-24
     */
    public function defineScript()
    {
        $title = $this->recordInstance->getName();
        ob_start();
        ?>
        <script>
            var columns = [<?= $this->getColumns(); ?>];
            var title = "<?= $title; ?>";
            $(document).ready(function () {
                create_datatable("<?= $this->getId(); ?>", {
                    "title": title,
                    "columns": columns,
                    "search": true,
                    "export": true,
                    "pagination": true,
                    "selectable": true
                });
            });
        </script>
        <?php
        $str = ob_get_contents();
        ob_end_clean();
        return $str;
    }

}
