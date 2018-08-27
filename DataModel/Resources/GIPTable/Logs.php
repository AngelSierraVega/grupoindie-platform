<?php

/**
 * GI-Platform-DVLP - Logs
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform
 *
 * @version OC.70
 * @since 18-08-27
 */

namespace GIndie\Platform\DataModel\Resources\GIPTable;

/**
 * Description of Logs
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Logs extends \GIndie\Platform\Model\Table
{

    /**
     * @since 18-08-27
     */
    public static function relatedRecord()
    {
        return \GIndie\Platform\DataModel\Platform\LogUser::class;
    }

}
