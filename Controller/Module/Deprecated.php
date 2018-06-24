<?php

/**
 * GI-Platform-DVLP - Deprecated
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\Controller\Instance\Module
 *
 * @version 0C.30
 * @since 18-05-21
 */

namespace GIndie\Platform\Controller\Module;

/**
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
trait Deprecated
{

    /**
     * Use placeholder() instead
     * @deprecated since 18-03-30
     * @var string $widgetPlaceholder
     * @return \GIndie\Platform\Controller\Module\Placeholder
     */
    public function configPlaceholder($placeholderId)
    {
        return static::placeholder($placeholderId);
    }

}
