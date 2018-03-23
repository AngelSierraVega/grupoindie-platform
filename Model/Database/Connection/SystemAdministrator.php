<?php

/*
 * Copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * This software is protected under GNU: you can use, study and modify it
 * but not distribute it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 */

namespace GIndie\Platform\Model\Database\Connection;

use GIndie\Platform\Model\Database\Connection;

/**
 * Description of SystemAdministrator
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @since 2017-05-08
 * @version GIP.00.01
 */
class SystemAdministrator extends Connection {

    /**
     * Defines the username
     * @var string 
     * @version GIP.00.01
     */
    protected static $USERNAME = "mrdemo_admin";//"straffon_default";

    /**
     * Defines the user password
     * @var string 
     * @version GIP.00.01
     */
    protected static $PASSWORD = "(%C4{rg6}FrZ";//"%wn0Zx5]EZu}";

}