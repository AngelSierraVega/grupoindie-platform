<?php
/*
 * GIplatform - test 2017-05-21
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.00
 */

namespace GIndie\Platform\View\Widget;

//use GIndie\Platform;

/**
 * Description of WidgetTableSelectable
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class WidgetTableSelectable extends WidgetTable {

    public function __construct(\GIndie\Platform\Model\Table $table,
            $title = "WidgetTableSelectable") {
        parent::__construct($table, $title);
    }

    protected function tmpContent() {
        ob_start();
        ?>
        <table class="table table-hover"> 
            <thead> 
        <!--    <tr> 
                    <th>#</th> 
                    <th>First Name</th> <th>Last Name</th> <th>Username</th> 
                </tr>-->
                <tr> 
                    <th>#</th> 
                    <?php
                    foreach ($this->_table->getColumns() as $colName) {
                        ?>
                        <th><?php echo $this->_table->getLabel($colName); ?></th> 
                        <?php
                    }
                    ?> 
                </tr> 
            </thead> 
            <tbody> 
                <?php
                $inc = 0;
                foreach ($this->_table->getRows() as $row) {
                    $inc++;
                    ?>
                    <tr> 
                        <th scope="row"><?php echo $inc; ?></th> 
                        <?php
                        foreach ($row as $data) {
                            ?>
                            <td><?php echo $data; ?></td>
                            <?php
                        }
                        ?> 
                    </tr> 
                    <?php
                }
                ?>
        <!--  <tr> <th scope="row">2</th> <td>Jacob</td> <td>Thornton</td> <td>@fat</td> </tr> -->
            </tbody> 
        </table> 
        <?php
        $str = ob_get_contents();
        ob_end_clean();
        return $str;
    }

}
