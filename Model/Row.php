<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GIndie\Platform\Model;

/**
 * Description of Row
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Row
{
    private $_data;

    public function __construct(array $assoc)
    {
        $this->_data = $assoc;
    }

    public function getValue($columnId)
    {
        return isset($this->_data[$columnId]) ? $this->_data[$columnId] :
                \NULL;
    }
}
