<?php

/**
 * GI-Platform-DVLP - SessionHandler
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\Model
 *
 * @version 0C.10
 * @since 17-05-08
 * @todo Upgrade class
 */

namespace GIndie\Platform\Model\Database\Connection;

use GIndie\Platform\Model\Database\Connection;

/**
 * Description of SystemAdministrator

 */
class SystemAdministrator extends Connection {

    /**
     * Defines the username
     * @var string 
     */
    protected static $USERNAME = "grupoind_main";//"straffon_default";
    //mr_demo: mrdemo_admin
    //Straffsa: straffon_default
    //GrupoINDIE: grupoind_main

    /**
     * Defines the user password
     * @var string 
     */
    protected static $PASSWORD = "YJiYZn5ars2";
    //mr_demo: (%C4{rg6}FrZ
    //Straffsa: %wn0Zx5]EZu}
    //GrupoINDIE: YJiYZn5ars2

}
