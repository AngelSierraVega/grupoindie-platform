<?php

/**
 * GI-Platform-DVLP - Instance
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\Components\Example
 *
 * @version 0C.A7
 * @since 18-11-29
 */

namespace GIndie\Platform\Components\Example;

/**
 * Description of Instance
 *
 */
class Instance extends \GIndie\Platform\Instance
{

    /**
     * Nombre del sistema.
     * @since 18-11-29
     */
    const BRAND_NAME = "INSTANCE EXAMPLE";

    /**
     * @since 18-11-29
     * @edit 19-11-04
     */
    public function config()
    {
        $this->setModule(Module\M01TableAndRecord::class);
        $this->setModule(Module\M02Searchs::class);
        $this->setModule(Module\M03Lists::class);
        $this->setModule(Module\M04Reports::class);
        $this->setModule(Module\FormInputExample::class);
    }

}
