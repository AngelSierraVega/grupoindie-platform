<?php

/**
 * GI-Platform-DVLP - 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\View
 * 
 * @version 0C.00
 * @since 
 */

namespace GIndie\Platform\View;

/**
 * Description of TableComplete
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @edit 18-02-27
 */
class TableComplete extends Table
{
    
    public function __construct(\GIndie\Platform\Model\Table $table,
                                $showFooter = \FALSE, $selectedId = \NULL)
    {
        parent::__construct($table, \TRUE, $selectedId);
    }
    
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
                    "title":title, 
                    "columns": columns, 
                    "search": true, 
                    "export": false, 
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
