<?php

/**
 * GI-PLTFRM - Abstracto
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
 * Description of Abstracto
 *
 * @author Angel
 */
abstract class Abstracto extends \GIndie\Platform\Model\Record {

    /**
     * {@inheritdoc}
     * @since 21-06-21
     */
    const SCHEMA = "grupoind_pltfrm_cmn";

    /**
     * {@inheritdoc}
     * @return string
     * @since 21-06-21
     */
    public static function databaseClassname() {
        return \GIndie\Platform\DataModel\Comun::class;
    }

    /**
     * {@inheritdoc}
     * @since 21-06-21
     */
    public static function configAttributes() {
        parent::configAttributesFromColumnDefinition();
    }

}
