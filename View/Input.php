<?php
/**
 * GI-Platform-DVLP - 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\View
 *
 * @version 0D.10
 * @since 
 */

namespace GIndie\Platform\View;

use GIndie\Platform\Model\Attribute;

/**
 * Description of Input
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @edit 18-03-22
 * @edit 19-04-13
 * - Added TYPE_COLOR
 */
class Input
{

    /**
     * 
     * @param       \GIndie\Platform\Model\Attribute $attribute
     * 
     * @edit 2017-05-31 <robertogs.soft@hotmail.com> 
     *      - Evalua si el elemento esta required
     * @edit 2017-06-12 <angel.sierra.vega@gmail.com>
     *      - Se actualizó el marcado para input checkbox
     * @edit 18-12-11
     * - Added change trigger on enum
     * @edit 19-02-20
     * - Removed note DIRECT visualization
     */
    public static function constructFromAttribute(\GIndie\Platform\Model\Attribute $attribute, $value, $recordId)
    {
        $form_element = '';
        if (strcmp($value, "GIP-UNDEFINED") == 0) {
            $value = "";
        }
        $required = "";
        if ($attribute->getRestrictionRequired()) {
            $required = "required='required'";
        }
        $restrictions = " ";
        foreach ($attribute->getRestrictions() as $key => $val_res) {
            $restrictions .= "$key='$val_res' ";
        }
        switch ($attribute->getType())
        {
            case Attribute::TYPE_STRING:
                $form_element = "<input class='form-control' type='text' id='{$attribute->getName()}' name='{$attribute->getName()}' value='" .
                    $value . "' " . $required . $restrictions . " >";
                break;
            case Attribute::TYPE_NUMERIC:
                $form_element = "<input class='form-control' type='number' id='{$attribute->getName()}' name='{$attribute->getName()}' value='" .
                    $value . "' " . $required . $restrictions . " >";
                break;
            case Attribute::TYPE_BOOLEAN:
                $form_element = static::Checkbox($attribute->getName(), $value);
                break;
            case Attribute::TYPE_DATE:
                $form_element = "<input class='form-control' type='date' id='{$attribute->getName()}' name='{$attribute->getName()}' value='" .
                    $value . "' " . $required . $restrictions . " >";
                break;
            case Attribute::TYPE_DATETIME:
//                $value = \date("d/m/Y H:i:s", \strtotime($value)); 
                $value = \date("Y-m-d\TH:i:s", \strtotime($value)); 
//                $value
                $form_element = "<input class='form-control' type='datetime-local' id='{$attribute->getName()}' name='{$attribute->getName()}' value='" .
                    $value . "' " . $required . $restrictions . " >";
                break;

            case Attribute::TYPE_PASSWORD:
                $form_element = "<input class='form-control' type='password' id='{$attribute->getName()}' name='{$attribute->getName()}' value='" .
                    $value . "' " . $required . $restrictions . " >";
                break;
            case Attribute::TYPE_EMAIL:
                $form_element = "<input class='form-control' type='email' id='{$attribute->getName()}' name='{$attribute->getName()}' value='" .
                    $value . "' " . $required . $restrictions . " >";
                break;
            case Attribute::TYPE_TIMESTAMP:
                if ($value == "") {
                    $value = 0;
                }
                $form_element = "<input class='form-control dateinputtext' type='text' id='{$attribute->getName()}' name='{$attribute->getName()}' value='" .
                    \date("Y-m-d", $value) . "' " . $required . " >";
                break;
            case Attribute::TYPE_FOREIGN_KEY:
                $form_element = static::selectFromAttribute($attribute, $value, $recordId);
                //$form_element = $this->_inputFK($attribute, $value);
                break;
            case Attribute::TYPE_OPTIONGROUP:
                /* $form_element = "<input class='form-control' type='text' id='{$attribute->getName()}' name='{$attribute->getName()}' value='" . $attribute->getValue() . "' ".$required." >"; */
                $form_element = "<input type='radio' id='{$attribute->getName()}' name='{$attribute->getName()}' value='" . $value . "' " . $required . " > I have a car";
                break;
            case Attribute::TYPE_ENUM:
                $form_element = "<select class='form-control selectpicker' "
                    . "data-live-search='false' id='{$attribute->getName()}' "
                    . "name='{$attribute->getName()}' " . $required . " >"
                    . static::_selectOptionsFromEnum($value, $attribute->getEnumOptions())
                    . "</select>";
                $form_element .= '<script>
                $(document).ready(function () {
                $("#' . $attribute->getName() . '").selectpicker({size: 8});});</script>';
                $scriptTemp = "";
                if (($slaveAttr = $attribute->getSlave()) !== \NULL) {
                    $recordClass = \urlencode($attribute->getRecordClass());
//                    $recordClass = \urlencode("NON");
                    ob_start();
                    ?>
                    <script>
                        $(document).ready(function () {
                            $("#<?= $attribute->getName(); ?>").change(function () {
                                $("#<?= $slaveAttr; ?>").parent().replaceWith("<div><div id='<?= $slaveAttr; ?>'>Cargando contenido, por favor espere...</div></div>");
                                var data = {
                                    'gip-action': "get-input",
                                    'gip-action-id': '<?= $slaveAttr; ?>',
                                    'gip-selected-id': this.value,
                                    'gip-action-class': "<?= $recordClass; ?>",
                                    'gip-record-id': "<?= $recordId; ?>"
                                };
                                $.ajax({
                                    type: "POST",
                                    data: data,
                                    url: "?", //
                                    success: function (data) {
                                        $("#<?= $slaveAttr; ?>").parent().replaceWith(data);
                                        //parent(".form-group")
                                    }
                                });
                            });
                            setTimeout(function () {
                                $("#<?= $attribute->getName(); ?>").change();
                            }, 50);
                            //$("#<?= ""; //$attribute->getName();                  ?>").change();
                        });
                    </script>
                    <?php
                    $scriptTemp = ob_get_contents();
                    ob_end_clean();
                }
                $form_element .= $scriptTemp;
                break;
            case Attribute::TYPE_HIDDEN:
                $form_element = "<input type='hidden' "
                    . "id='{$attribute->getName()}' "
                    . "name='{$attribute->getName()}' "
                    . "value='{$value}' "
                    . " >"
                    . "</input>";
                break;
            case Attribute::TYPE_CURRENCY:
                $form_element = "<input class='form-control' type='number' id='{$attribute->getName()}' name='{$attribute->getName()}' value='" .
                    $value . "' " . $required . $restrictions . " >";
                break;
//            case Attribute::TYPE_FILE:
//                $form_element = new \GIndie\ScriptGenerator\HTML5\Category\FormInput\Input\File();
//                $form_element->addClass("form-control");
//                $form_element->setId("fileToUpload");
//                $form_element->setName("fileToUpload");
//                $form_element = '<input type="hidden" name="MAX_FILE_SIZE" value="30000" />' . $form_element;
//                break;
            case Attribute::TYPE_COLOR:
                $form_element = new \GIndie\ScriptGenerator\HTML5\Category\FormInput\Input\Color();
                $form_element->addClass("form-control");
                $form_element->setId($attribute->getName());
                $form_element->setName($attribute->getName());
                $form_element->setValue($value);
                break;
            default:
                \trigger_error("Unrecognized type " . $attribute->getType() . " using text",
                    \E_USER_WARNING);
                $form_element = "<input class='form-control' type='text' id='{$attribute->getName()}' name='{$attribute->getName()}' value='" .
                    $value . "' " . $required . " >";
                break;
        }
        switch (\TRUE)
        {
            case ($attribute->getType() == Attribute::TYPE_HIDDEN):
                $rtnStr = $form_element;
                break;
            case \TRUE:
                $rtnStr = '<div class="form-group ';
                $rtnStr .= $attribute->getSize();
                //clase checkbox modifica la etiqueta default de un input.
                //$rtnStr .= $attribute->getType() == Record::TYPE_BOOLEAN ? ' checkbox">' : '">';
                $rtnStr .= '">';
                $rtnStr .= "<label for='{$attribute->getName()}'>";
                if ($attribute->getHelp() !== \NULL) {
                    $icon = Icons::Help();
                    //$icon->setAttribute("data-toggle", "tooltip");
                    //$icon->setAttribute("data-placement", "top");
                    $icon->setAttribute("title", $attribute->getHelp());
                    //$icon->setAttribute("container", "body");
                    $rtnStr .= "<sup>" . $icon . "</sup>&nbsp";
                }
                $rtnStr .= $attribute->getLabel() . "</label>";
                $rtnStr .= $form_element;
//                if (!\is_null($attribute->getHelp())) {
//                    $rtnStr .= "<i>Nota: " . $attribute->getHelp() . "</i>";
//                }
                $rtnStr .= '</div>';
                break;
        }
        return $rtnStr;
    }

    /**
     * 
     * @param type $label
     * @param type $name
     * @param type $formElement
     * @return string
     * @edit 18-03-12
     */
    public static function FomGroupClean($label, $name, $formElement)
    {
        $rtnStr = '<div class="form-group';
        $rtnStr .= '">';
        $rtnStr .= "<label for='{$name}'>";
        $rtnStr .= $label . "</label>";
        $rtnStr .= $formElement;
        $rtnStr .= '</div>';
        return $rtnStr;
    }

    public static function formGroup($attribute, $form_element)
    {
        return static::FomGroupClean($attribute->getLabel(), $attribute->getName(), $form_element);
    }

    public static function Number($name, $value, $required = \FALSE)
    {
        $required = "";
        if ($required) {
            $required = "required='required'";
        }
        $form_element = "<input class='form-control' type='number' id='{$name}' name='{$name}' value='" .
            $value . "' " . $required . " >";
        return $form_element;
    }

    /**
     * 
     * @param type $name
     * @param type $value
     * @return string
     * @since 18-03-22
     */
    public static function hidden($name, $value)
    {
        $form_element = "<input type='hidden' id='{$name}' name='{$name}' value='" .
            $value . "' >";
        return $form_element;
    }

    /**
     * 
     * @param type $name
     * @param type $value
     * @param string $required
     * @param type $placeholder
     * @param type $helpBlock
     * @return type
     * @edit 19-01-14
     * - Use of $required
     */
    public static function Text($name, $value, $required = false, $placeholder = "", $helpBlock = null)
    {
//        $required = "";
        if ($required) {
//            var_dump($required);
            $required = "required='required'";
        }
        $form_element = "<input class='form-control' type='text' placeholder='{$placeholder}' id='{$name}' name='{$name}' value='" .
            $value . "' " . $required . " >";
        if ($helpBlock !== null) {
            $form_element .= "<p class='help-block'>{$helpBlock}</p>";
        }
        return $form_element;
    }

    public static function Disabled($name, $value, $required = \false, $placeholder = "")
    {
        $required = "";
        if ($required) {
            $required = "";
        }
        $form_element = "<input class='form-control' type='text' placeholder='{$placeholder}' id='{$name}' name='{$name}' value='" .
            $value . "' disabled >";
        return $form_element;
    }

    public static function Checkbox($name, $value)
    {
        ob_start();
        ?>
        <br>
        <input type="checkbox" name="<?= $name; ?>" 
               value="<?= $value; ?>"
               <?= $value == "1" ? " checked " : "" ?>
               >
               <?php
               $form_element = ob_get_contents();
               ob_end_clean();
               return $form_element;
           }

           public static function selectFromAttribute(\GIndie\Platform\Model\Attribute $attribute, $selectedId, $recordId)
           {
               $recordClass = $attribute->getRecordClass();
               $required = "";
               if ($attribute->getRestrictionRequired()) {
                   $required = "required='required'";
               }
               $class = $attribute->getFkClass();
               $options = $attribute->getFkRestrictions();
               //$recordClass = \get_class($this->_record);
               if (\strcmp($recordClass, $class::RelatedRecord()) == 0) {
                   $options[] = $recordClass::PRIMARY_KEY . " != '" . $recordId . "'";
               }
               $form_element = "<select class='form-control selectpicker' "
                   . "data-live-search='true' id='{$attribute->getName()}' "
                   . "name='{$attribute->getName()}' " . $required . " >"
                   . static::_selectOptionsFromList($selectedId, $class, $options,
                       $attribute->getNotNull())
//                    . $this->_dynamicOptionsForSelect($value, $class, $options)
                   . "</select>";

               $form_element .= '<script>
                $(document).ready(function () {
                $("#' . $attribute->getName() . '").selectpicker({size: 8});});</script>';
               $scriptTemp = "";
               if (($slaveAttr = $attribute->getSlave()) !== \NULL) {
                   $recordClass = urlencode($recordClass);
                   ob_start();
                   ?>
            <script>
                $(document).ready(function () {
                    $("#<?= $attribute->getName(); ?>").change(function () {
                        $("#<?= $slaveAttr; ?>").parent().replaceWith("<div><div id='<?= $slaveAttr; ?>'>Cargando contenido, por favor espere...</div></div>");
                        var data = {
                            'gip-action': "get-input",
                            'gip-action-id': '<?= $slaveAttr; ?>',
                            'gip-selected-id': this.value,
                            'gip-action-class': "<?= $recordClass; ?>",
                            'gip-record-id': "<?= $recordId; ?>"
                        };
                        $.ajax({
                            type: "POST",
                            data: data,
                            url: "?", //
                            success: function (data) {
                                $("#<?= $slaveAttr; ?>").parent().replaceWith(data);
                                //parent(".form-group")
                            }
                        });
                    });
                    setTimeout(function () {
                        $("#<?= $attribute->getName(); ?>").change();
                    }, 50);
                    //$("#<?= ""; //$attribute->getName();                  ?>").change();
                });
            </script>
            <?php
            $scriptTemp = ob_get_contents();
            ob_end_clean();
        }
        return $form_element . $scriptTemp;
    }

    public static function _selectOptionsFromList($selectedId, $class, $params = [], $notNull = \TRUE)
    {
        $rtnStr = "";
        $tmpList = new $class($params);
        if ($notNull) {
            
        } else {
            $rtnStr .= "<option value='NULL'>Sin definir</option>";
        }
        //$rtnStr = "";
        foreach ($tmpList->getElements() as $elementId) {
            $rtnStr .= static::_selectOptionFromElement($tmpList->getElementAt($elementId),
                    $selectedId, 0);
        }

        return $rtnStr;
//        
//        $rtnStr .= $this->_optionsFromList($tmpList, $selectedId, 0);
//        return $rtnStr;
    }

    private static function _optionsFromList($list, $selectedId, $indent)
    {
        $rtnStr = "";
        foreach ($list->getElements() as $elementId) {
            $rtnStr .= static::_selectOptionFromElement($list->getElementAt($elementId),
                    $selectedId, $indent);
        }
        return $rtnStr;
    }

    private static function _selectOptionFromElement(\GIndie\Platform\Model\Element $element, $selectedId, $indent)
    {
        $rtnStr = "<option value='" . $element->getId() . "'";
        if ($element->getCategory()) {
            $rtnStr .= " disabled>";
        } else {
            $rtnStr .= ($selectedId === $element->getId()) ? " selected>" : ">";
        }
        $i = 0;
        $rtnStr .= "";
        while ($i < $indent) {
            $rtnStr .= "&nbsp&nbsp";
            $i++;
        }
        $rtnStr .= "-&nbsp";
        $rtnStr .= $element->getValue() . "</option>";
        if (($tmpList = $element->getNested() ) !== \NULL) {
            $indent++;
            $rtnStr .= static::_optionsFromList($tmpList, $selectedId, $indent);
        }
        return $rtnStr;
    }

    private static function _selectOptionsFromEnum($selectedId, $options = [])
    {
        $rtnStr = "";
        foreach ($options as $key => $value) {
            $rtnStr .= "<option value='" . $key . "'";
            $rtnStr .= ($selectedId === $key) ? " selected>" : ">";
            $rtnStr .= $value . "</option>";
        }
        return $rtnStr;
    }

}
