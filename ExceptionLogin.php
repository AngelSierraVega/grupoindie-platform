<?php

/**
 * @copyright (c) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 * 
 * @version GIP.00.00
 */

namespace GIndie\Platform;

class ExceptionLogin extends \Exception{
    public function __construct($message = "", $code = 0,
                                \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

