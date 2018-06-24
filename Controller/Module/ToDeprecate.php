<?php

/**
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @package GIndie\Platform\Controller\Instance\Module
 * 
 * @version 0C.10
 * @since 18-03-13
 */

namespace GIndie\Platform\Controller\Module;

/**
 * GI-Platform-DVLP - ToDeprecate
 */
trait ToDeprecate
{

    /**
     * Use runRecordActionGipEdit instead
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
     * Use runRecordForm instead
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
     * Use runRecordAction instead
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
     * Use runRecordAction instead
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
     * Use runFormRequest instead
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
     * Use cnstrctTableFromSearch instead
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
