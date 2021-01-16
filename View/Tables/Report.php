<?php
/**
 * GI-Platform-DVLP - Report
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\View
 *
 * @version 0C.A0
 * @since 18-11-08
 */

namespace GIndie\Platform\View\Tables;

/**
 * Description of Report
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Report extends Table
{

    /**
     * 
     * @param string $classname
     * @param boolean $showFooter
     * @since 18-11-08
     */
    public function __construct($classname, $showFooter = true)
    {
        parent::__construct($classname, $showFooter);
    }

    /**
     * 
     * @return string
     * @since 18-11-08
     * - Copied from GIndie\Platform\View\TableReport
     * @edit 18-12-24
     * - Debuged method
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
                    "search": false,
                    "export": true,
                    "pagination": false,
                    "selectable": false
                });
            });
        </script>
        <?php
        $str = ob_get_contents();
        ob_end_clean();
        return $str;
    }

}
