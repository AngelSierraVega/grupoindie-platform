<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GIndie\Platform\Model;


/**
 * Description of List
 *
 * @version     GIP.00.02
 * @since       2017-06-26
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Element
{

    private $_id;
    private $_value;
    private $_category = \FALSE;
    
    /**
     * @param $value
     * @return mixed
     * @since GIP.00.01
     */
    public function setCategory()
    {
        $this->_category = \TRUE;
        return $this;
    }

    /**
     * @return mixed
     * @since GIP.00.01
     */
    public function getCategory()
    {
        return $this->_category;
    }

    /**
     *
     * @var type 
     * @since GIP.00.02
     * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
     */
    private $_nested = \NULL;

    /**
     * @param $value
     * @return mixed
     * @since GIP.00.01
     */
    public function setNested($value)
    {
        $this->_nested = $value;
        return $this;
    }

    /**
     * @return mixed
     * @since GIP.00.01
     */
    public function getNested()
    {
        return $this->_nested;
    }

    /**
     * Element constructor.
     * @param $attr1
     * @param $attr2
     * @since GIP.00.01
     */
    public function __construct($id, $value)
    {
        $this->_id = $id;
        $this->_value = $value;
    }

    /**
     * @param $value
     * @return mixed
     * @since GIP.00.01
     */
    public function setValue($value)
    {
        $this->_value = $value;
        return $this->_value;
    }

    /**
     * @return mixed
     * @since GIP.00.01
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * @return mixed
     * @since GIP.00.01
     */
    public function getId()
    {
        return $this->_id;
    }

}