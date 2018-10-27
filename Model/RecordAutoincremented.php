<?php

/**
 * GI-Platform-DVLP - RecordAutoincremented
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform
 *
 * @version UNDEFINED
 * @since 18-10-27
 */

namespace GIndie\Platform\Model;

/**
 * Description of RecordAutoincremented
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
abstract class RecordAutoincremented extends Record
{

    /**
     * @since 18-10-27
     */
    const ATTR_ID = "id";

    /**
     * The primary key of the record.
     * @edit 18-10-27
     * - Added from Record
     */
    const PRIMARY_KEY = "id";

    /**
     * If the primary key is autoincremented
     * @edit 18-10-27
     * - Added from Record
     */
    const AUTOINCREMENT = true;

}
