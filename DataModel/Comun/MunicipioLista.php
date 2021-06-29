<?php

/**
 * GI-PLTFRM - MunicipioLista
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2021 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform
 *
 * @version 0C.B0
 * @since 21-06-21
 */

namespace GIndie\Platform\DataModel\Comun;

/**
 * Description of MunicipioLista
 *
 * @author Angel
 */
class MunicipioLista extends \GIndie\Platform\Model\ListSimple
{

    /**
     * {@inheritdoc}
     * @return string
     * @since 21-06-21
     */
    public static function RelatedRecord()
    {
        return Municipio::class;
    }
    

}