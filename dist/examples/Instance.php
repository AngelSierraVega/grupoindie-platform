<?php

/**
 * Platform - Instance 
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 */

/**
 * Description of Instance
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @version GIP.00.00 2017-12-26 Class created
 * @edit GIP.00.01
 * - Added code from GIndie\DBHandler\Platform\DBHandler
 */
class Instance extends \GIndie\Platform\Instance
{

    /**
     * @since GIP.00.01
     */
    const CONFIG_CLASS = "Config";

    /**
     * @since GIP.00.01
     */
    const BRAND_NAME = "BRAND_NAME";

    /**
     *  @since GIP.00.01
     */
    public function config()
    {
        $this->setModule(Module::class);
    }

}
