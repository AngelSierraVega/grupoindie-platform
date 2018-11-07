<?php

/**
 * GI-Platform-DVLP - 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\View
 *
 * @version 0C.B0
 * @since 17-04-20
 */

namespace GIndie\Platform;

/**
 * [description]
 * @edit 18-10-19
 */
trait WidgetsDefinition
{

    /**
     * @var         array [description]
     * @edit 18-04-01
     * @edit 18-06-18
     * - Added o-o-o, ii-ii-i-small, ii-ii-ii-large
     * @edit 18-10-29
     * - Added ii-ii-i-large, ii-ii-ii-small
     * @edit 18-12-07
     * - Added i-ii-ii-small-a, i-ii-ii-small-b
     * @edit 18-12-11
     * - Added i-i-i-b
     */
    protected $WidgetsDefinition = [
        "o-o-o" => "",
        "i-i-i" => "",
        "i-ii-i" => "",
        "i-ii-i-large" => "",
        "i-ii-ia" => "", "i-ii-ib" => "",
        "i-ii-ii" => "",
        "i-ii-ii-small" => "",
        "i-ii-ii-small-a" => "",
        "i-ii-ii-small-b" => "",
        "i-i-i-b"=> "",
        "i-iii-i" => "", "i-iii-ii" => "", "i-iii-iii" => "",
        "ii-i-i" => "",
        "ii-ii-i-large" => "","ii-ii-ii-small" => "",
        "ii-ii-i" => "", "ii-ii-i-small" => "", "ii-ii-ii" => "", "ii-ii-ii-large" => "",
        "ii-iii-i" => "", "ii-iii-ii" => "", "ii-iii-iii" => "",
        "iii-i-i" => "",
        "iii-ii-i" => "", "iii-ii-ii" => "",
        "iii-iii-i" => "", "iii-iii-ii" => "", "iii-iii-iii" => ""
    ];

}
