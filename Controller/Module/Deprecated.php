<?php

/**
 * GI-Platform-DVLP - Deprecated
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\Controller\Instance\Module
 *
 * @version 0D.00
 * @since 18-05-21
 */

namespace GIndie\Platform\Controller\Module;

/**
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @edit 18-06-24
 * - Added trigger to configPlaceholder()
 * - recordActionGipEdit(), runFormRequest(), actionHandlerRecord(), 
 * _recordAction(), _recordModalForm(), _searchTable(): Moved from ToDeprecate
 */
trait Deprecated
{

    /**
     * Use cnstrctTableFromSearch instead
     * @since 17-??-??
     * @param string $class
     * @return \GIndie\Platform\View\Table
     * @deprecated since 18-03-20
     */
    protected function _searchTable($class)
    {
        \trigger_error("Use cnstrctTableFromSearch instead", \E_USER_DEPRECATED);
        return $this->cnstrctTableFromSearch($class);
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
        \trigger_error("Use runFormRequest instead", \E_USER_DEPRECATED);
        return $this->runFormRequest($action, $id, $class);
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
        \trigger_error("Use runRecordAction instead", \E_USER_DEPRECATED);
        return $this->runRecordAction($action, $id, $class);
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
        \trigger_error("Use runRecordAction instead", \E_USER_DEPRECATED);
        return $this->runRecordAction($action, $id, $class);
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
        \trigger_error("Use runRecordForm instead", \E_USER_DEPRECATED);
        return $this->runRecordForm($action, $id, $class);
    }

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
        \trigger_error("Use runRecordActionGipEdit instead", \E_USER_DEPRECATED);
        return $this->runRecordActionGipEdit($action, $id, $class);
    }

    /**
     * Use placeholder() instead
     * @deprecated since 18-03-30
     * @var string $widgetPlaceholder
     * @return \GIndie\Platform\Controller\Module\Placeholder
     */
    public function configPlaceholder($placeholderId)
    {
        \trigger_error("Use placeholder instead", \E_USER_DEPRECATED);
        return static::placeholder($placeholderId);
    }

}
