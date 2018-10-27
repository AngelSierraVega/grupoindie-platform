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
 * @since 18-03-30
 */

namespace GIndie\Platform\View\Table;

use GIndie\Platform\View;
use GIndie\Platform\Model;

/**
 * @edit 18-05-20
 */
class ReportSelectable extends View\Table
{

    /**
     * 
     * @param \GIndie\Platform\Model\Table $table
     * @param boolean $showFooter
     * @param type $selectedId
     * @since 18-03-30
     */
    public function __construct(Model\Table $table, $showFooter = false, $selectedId = null)
    {
        parent::__construct($table, true, $selectedId);
    }

    /**
     * 
     * @return string
     * @since 18-03-30
     */
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
                create_datatable("<?= $this->getId(); ?>", {
                    "title": title,
                    "columns": columns,
                    "search": false,
                    "export": true,
                    "pagination": false,
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
