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
 * @version 0C.10
 * @since 18-03-13
 */
trait ToDeprecate
{

    /**
     * @param string $action
     * @param string $id
     * @param string $class
     * @return type
     * @deprecated since 18-03-15
     */
    protected function recordActionGipEdit($action, $id, $class)
    {
        return $this->runRecordActionGipEdit($action, $id, $class);
    }

    /**
     * 
     * @param string $action
     * @param string $id
     * @param string $class
     * @return type
     * @deprecated since 18-03-15
     */
    protected function runFormRequest($action, $id, $class)
    {
        return $this->runRecordForm($action, $id, $class);
    }

    /**
     * @param string $action
     * @param string $id
     * @param string $class
     * @return type
     * @deprecated since 18-03-15
     */
    protected function actionHandlerRecord($action, $id, $class)
    {
        return $this->runRecordAction($action, $id, $class);
    }

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
        return $this->runRecordAction($action, $id, $class);
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

    /**
     * @since 17-??-??
     * @param string $class
     * @return \GIndie\Platform\View\Table
     * @deprecated since 18-03-20
     */
    protected function _searchTable($class)
    {
        return $this->cnstrctTableFromSearch($class);
    }

}
