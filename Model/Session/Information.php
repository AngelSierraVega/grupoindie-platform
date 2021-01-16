<?php

/*
 * Copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @license file://LICENSE
 */

namespace GIndie\Platform\Model\Session;

use GIndie\Platform\Model\Record;

/**
 * Defines a Record Model for session information.
 *
 * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @since       2017-05-02
 * @package GIndie\Platform\Model
 *
 * @version DEPRECATED
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
