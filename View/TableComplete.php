<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GIndie\Platform\View;

/**
 * Description of TableComplete
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
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
