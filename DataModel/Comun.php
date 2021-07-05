<?php

/**
 * GI-PLTFRM - Comun
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2021 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\DataModel
 *
 * @version 0D.00
 * @since 21-06-20
 */

namespace GIndie\Platform\DataModel;

/**
 * Description of Comun
 *
 * @author Angel
 */
class Comun extends \GIndie\DBHandler\MySQL57\Instance\Database {

    /**
     * {@inheritdoc}
     * @since 21-06-16
     * @return array|string
     */
    public static function getTableClassnames() {
        return [
            //Pais::class, 
            Comun\Estado::class, Comun\Municipio::class
        ];
    }

    /**
     * {@inheritdoc}
     * @since 21-06-16
     * @return string
     */
    public static function name() {
        return "grupoind_pltfrm_cmn";
    }

}
