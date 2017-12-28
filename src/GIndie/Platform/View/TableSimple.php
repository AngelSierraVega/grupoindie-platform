<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GIndie\Platform\View;

/**
 * Description of TableSimple
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class TableSimple extends Table
{
    public function __construct(\GIndie\Platform\Model\Table $table,
                                $selectable = \FALSE, $selectedId = \NULL)
    {
        parent::__construct($table, $selectable, $selectedId);
    }
}
