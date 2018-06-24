<?php

/**
 * GIplatform - Platform 
 *
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 *
 * @package GIndie\Platform\Controller\Instance
 * 
 * @version 0C.10
 * @since 17-05-22
 */

namespace GIndie\Platform\Controller;

use \GIndie\Platform\View;

/**
 *
 * @edit GIP.00.04 18-01-14
 * - Bitácora restaurada
 * @edit 18-03-14
 * - Moved methods to trait Platform/ToUpgrade or Platform/ToDeprecate
 */
abstract class Platform
{

    /**
     * @since 18-03-14
     */
    use Platform\ToDeprecate;
    use Platform\ToUpgrade;
}
