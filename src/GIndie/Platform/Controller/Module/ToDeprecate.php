<?php

namespace GIndie\Platform\Controller\Module;

/**
 * GI-Platform-DVLP - ToDeprecate
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version A0
 * @since 18-03-13
 */
trait ToDeprecate
{

    /**
     * 
     * @param type $action
     * @param type $id
     * @param type $class
     * @return type
     * @since 18-03-13
     * @deprecated since 18-03-13
     */
    protected function _recordAction($action, $id, $class)
    {
        return $this->actionHandlerRecord($action, $id, $class);
    }

    /**
     * 
     * @param type $action
     * @param type $id
     * @param type $class
     * @return type
     * @since 18-03-14
     * @deprecated since 18-03-14
     */
    protected function _recordModalForm($action, $id, $class)
    {
        return $this->runFormRequest($action, $id, $class);
    }

}
