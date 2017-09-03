<?php
/**
 * GIplatform - Form 2017-04-28
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.05
 */

namespace GIndie\Platform\View;

use GIndie\Generator\DML\HTML5;
use GIndie\Generator\DML\HTML5\Category\StylesSemantics;
use GIndie\Generator\DML\HTML5\Bootstrap3;
use GIndie\Platform\Model\Record;
use GIndie\Platform\Model\Attribute;

/**
 * Description of Form
 * 
 *   
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class Form extends HTML5\Category\FormInput\Form
{

    /**
     * @since GIP.00.05
     * @var \GIndie\Platform\Model\Database\Record 
     */
    private $_record;

    /**
     * 
     * @param string $formId
     * @param \GIndie\Platform\Model\Record $record
     * 
     * @version     GIP.00.05
     * @edit 2017-06-18 <angel.sierra@grupoindie.com>
     *      - Se agregó token único en formularios
     */
    public function __construct(Record $record = \NULL, $uniqueToken = \TRUE,
                                $customTarget = \FALSE)
    {
        parent::__construct();
        $this->_record = $record;
        $this->setId(\GIndie\Platform\Security::tokenize(\time()));

        //autocomplete="on"
        //$this->setAttribute("autocomplete","off");
        //$this->setAction("login");
        $this->setMethod("post");
        $this->addContent(StylesSemantics::Div("",
                                               ["class" => "gip-form-response"]));
        if ($uniqueToken) {
            $secure_token = \GIndie\Platform\Security::tokenizeUnique($this->getId());
            $form_element = "<input type='hidden' "
                    . "name='gip-token' "
                    . "value='{$secure_token}' "
                    . " >"
                    . "</input>";
            $this->addContent($form_element);
        }
        if ($customTarget !== \FALSE) {
            $this->setTarget($customTarget);
        } else {
            $this->setTarget('#' . $this->getId() . " .gip-form-response");
        }
        //var_dump($this->_record);
        if ($this->_record !== \NULL) {
            foreach ($this->_record->getAttributesForm() as $attrName) {
                //var_dump($attrName);
                if (strcmp($record::PRIMARY_KEY, $attrName) !== 0) {
                    $this->addContent(Input::constructFromAttribute(
                                    $this->_record->getAttribute($attrName),
                                                                 $this->_record->getValueOf($attrName),
                                                                                            $record->getId()));
//                    $this->_createInput(
//                    $this->_record->getAttribute($attrName)
//                    , $this->_record->getValueOf($attrName)));
                } else {
                    if ($record::AUTOINCREMENT == \FALSE) {
                        $this->addContent(Input::constructFromAttribute(
                                        $this->_record->getAttribute($attrName),
                                                                     $this->_record->getValueOf($attrName),
                                                                                                $record->getId()));
//                        $this->addContent(
//                                $this->_createInput(
//                                        $this->_record->getAttribute($attrName)
//                                        , $this->_record->getValueOf($attrName)));
                    }
                }
            }
        }
        //$this->addScript("  $('#{$formId}').validate({debug: false}); ");
        //$this->addScriptOnDocumentReady(" $(\"[type='checkbox']\").bootstrapSwitch();   $('.dateinputtext').datetimepicker(); $('.selectpicker').selectpicker({size: 4});");
    }

    public function defineScript()
    {
        $formId = $this->getId();
        ob_start();
        ?>
        <script>
            $("#<?= $formId; ?>").validate({debug: false});
            $("[type='checkbox']").bootstrapSwitch();
            //$('[data-toggle="tooltip"]').tooltip();
            //$(".dateinputtext").datetimepicker();
            //            $(".selectpicker").selectpicker({size: 8});
            $(document).ready(function () {
                $("[type='checkbox']").bootstrapSwitch();
                //$('[data-toggle="tooltip"]').tooltip();
                //$(".dateinputtext").datetimepicker();
                //                $(".selectpicker").selectpicker({size: 8});
            });
        </script>
        <?php
        $script = ob_get_contents();
        ob_end_clean();
        return $script;
    }

}
