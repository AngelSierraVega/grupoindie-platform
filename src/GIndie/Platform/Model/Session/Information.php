<?php

/*
 * Copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * This software is protected under GNU: you can use, study and modify it
 * but not distribute it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 */

namespace GIndie\Platform\Model\Session;

use GIndie\Platform\Model\Record;

/**
 * Defines a Record Model for session information.
 *
 * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @version     GIP.00.01
 * @since       2017-05-02
 */
class Information extends Record {

    /**
     * @since     GIP.00.01
     */
    const NAME = "Session information";

    public function defineAttributes() {
        $this->defineAttribute("timestamp_session_start")->setType(self::TYPE_TIMESTAMP);
        $this->defineAttribute("timestamp_last_authentication")->setType(self::TYPE_TIMESTAMP);
        $this->defineAttribute("authentication_method");
    }

    /**
     * Creates a new record model for session information.
     * 
     * @since       GIP.00.01
     * 
     * @var         string $timestamp
     * @var         string $authenticationMethod
     */
    public function __construct($timestamp, $authenticationMethod) {
        parent::__construct();
        $this->defineAttribute("timestamp_session_start")->setValue($timestamp);
        $this->defineAttribute("timestamp_last_authentication")->setValue($timestamp);
        $this->defineAttribute("authentication_method")->setValue($authenticationMethod);
    }

}
