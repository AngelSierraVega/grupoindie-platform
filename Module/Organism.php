<?php

/**
 * GI-Platform-DVLP - Organism
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2019 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\Module
 *
 * @version 0B.00
 * @since 19-02-13
 */

namespace GIndie\Platform\Module;

use GIndie\Platform\DataModel\Resources\GIPList;

/**
 * @edit 19-02-13
 * - Copied code from \MunicipioMineralReforma\Predial\Modulo\Sistema\UnidadesAdministrativas
 */
class Organism extends \GIndie\Platform\Controller\Module
{

    /**
     * {@inheritdoc}
     * @since 19-02-13
     */
    public static function name()
    {
        return "Unidades administrativas";
    }

    /**
     * {@inheritdoc}
     * @since 19-02-13
     */
    public static function description()
    {
        return "Este módulo administra las Unidades Administrativas (áreas).";
    }

    /**
     * {@inheritdoc}
     * @since 19-02-13
     */
    public static function category()
    {
        return "Sistema";
    }

    /**
     * 
     * @return array
     * @since 19-02-13
     */
    public static function requiredRoles()
    {
        return ["AS"];
    }

    /**
     * 
     * @since 19-02-13
     */
    public function configPlaceholders()
    {
        $this->placeholder("i-ii-i")->listSimple(GIPList\Units::class)->addSlave("i-ii-ii");
        $this->placeholder("i-ii-ii")->typeRecordDynamic(\GIndie\Platform\DataModel\Platform\AdministrativeUnit::class,
            "gip-selected-id");
    }

    /**
     * {@inheritdoc}
     * @since 19-02-13
     */
    public static function configActions()
    {
//        static::setActionModel("@createTbl01", Tbl01Autoincremented::class, "gip-create");
    }

}
