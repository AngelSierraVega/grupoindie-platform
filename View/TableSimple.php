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
 * Description of TableSimple
 *
 * @edit 18-02-27
 */
class TableSimple extends Table
{
    public function __construct(\GIndie\Platform\Model\Table $table,
                                $selectable = \FALSE, $selectedId = \NULL)
    {
        parent::__construct($table, $selectable, $selectedId);
    }
}
