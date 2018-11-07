<?php

/**
 * GI-Platform-DVLP - Instance
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\Components\Example
 *
 * @version 0B.F0
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
    const BRAND_NAME = "MMR-PRDL";

    /**
     * @since 18-11-29
     */
    public function config()
    {
        $this->setModule(Module\M01TableAndRecord::class);
        $this->setModule(Module\M02Searchs::class);
        $this->setModule(Module\M03Lists::class);
        $this->setModule(Module\M04Reports::class);
    }

}
