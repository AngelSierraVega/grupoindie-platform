<?php

/**
 * GI-Platform-DVLP - RecordAutoincremented
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\Model
 *
 * @version DEPRECATED
 * @since 
 */

namespace GIndie\Platform\Model;

/**
 * @edit 18-10-29
 * - Created setValueOf(), getAssoc()
 * @todo check deprecate
 */
class Row
{

    private $_data;

    public function __construct(array $assoc)
    {
        $this->_data = $assoc;
    }

    /**
     * 
     * @param type $columnId
     * @param type $value
     * @since 18-10-29
     */
    public function setValueOf($columnId, $value)
    {
        $this->_data[$columnId] = $value;
    }

    /**
     * 
     * @return array
     * @since 18-10-29
     */
    public function getAssoc()
    {
        return $this->_data;
    }

    public function getValue($columnId)
    {
        return isset($this->_data[$columnId]) ? $this->_data[$columnId] :
                \NULL;
    }

}
