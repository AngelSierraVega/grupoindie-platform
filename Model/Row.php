<?php

/**
 * GI-Platform-DVLP - RecordAutoincremented
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\Model
 *
 * @version 0C.00
 * @since 
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
