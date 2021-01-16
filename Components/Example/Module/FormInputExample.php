<?php

/**
 * SG-HTML5form - FormInputExample
 */

namespace GIndie\Platform\Components\Example\Module;

use \GIndie\ScriptGenerator\HTML5\Category\FormInput;

/**
 * Description of FormInputExample
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package ScriptGenerator
 * @subpackage HTML5
 *
 * @version 0B.F0
 * 
 * @since 18-01-30
 * @edit 19-08-01
 * - Moved from ScriptGenerator\HTML5form
 */
class FormInputExample extends \GIndie\Platform\Controller\Module
{

    /**
     * 
     * @since UT.00.01
     */
    const NAME = "FormInput";

    /**
     * 
     * @since UT.00.01
     * @return array
     */
    public static function RequiredRoles()
    {
        return ["AS"];
    }

    /**
     * 
     * @since UT.00.02
     * @return \GIndie\Platform\View\Widget
     * @edit UT.00.03
     */
    protected function widgetReload($id, $class, $selected)
    {
        switch ($id) {
            case "ii-iii-i":
                $form = FormInput::form();
                $form->addContent(FormInput::inputButton());
                $form->addContent("<br>");
                $form->addContent(FormInput::inputCheckbox());
                $form->addContent("<br>");
                $form->addContent(FormInput::inputColor());
                $form->addContent("<br>");
                $form->addContent(FormInput::inputDate());
                $form->addContent("<br>");
                $form->addContent(FormInput::inputDateTimeLocal());
                $form->addContent("<br>");
                $form->addContent(FormInput::inputEmail());
                return $this->widgetCodeElement($form);
            case "ii-iii-ii":
                $form = FormInput::form();
                $form->addContent(FormInput::inputFile());
                $form->addContent("<br>");
                $form->addContent(FormInput::inputHidden());
                $form->addContent("<br>");
                $form->addContent(FormInput::inputImage());
                $form->addContent("<br>");
                $form->addContent(FormInput::inputMonth());
                $form->addContent("<br>");
                $form->addContent(FormInput::inputNumber());
                $form->addContent("<br>");
                $form->addContent(FormInput::inputPassword());
                $form->addContent("<br>");
                $form->addContent(FormInput::inputRadio());
                $form->addContent("<br>");
                $form->addContent(FormInput::inputRange());
                return $this->widgetCodeElement($form);
            case "ii-iii-iii":
                $form = FormInput::form();
                $form->addContent(FormInput::inputReset());
                $form->addContent("<br>");
                $form->addContent(FormInput::inputSearch());
                $form->addContent("<br>");
                $form->addContent(FormInput::inputSubmit());
                $form->addContent("<br>");
                $form->addContent(FormInput::inputTel());
                $form->addContent("<br>");
                $form->addContent(FormInput::inputText());
                $form->addContent("<br>");
                $form->addContent(FormInput::inputTime());
                $form->addContent("<br>");
                $form->addContent(FormInput::inputURL());
                $form->addContent("<br>");
                $form->addContent(FormInput::inputWeek());
                return $this->widgetCodeElement($form);
            default:
                return parent::widgetReload($id, $class, $selected);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function configActions()
    {
        
    }

    private function widgetCodeElement(\GIndie\ScriptGenerator\HTML5\Node $element)
    {
        return "<pre>" . \htmlspecialchars($element) . "</pre>" . $element;
    }

    public function configPlaceholders()
    {
        $this->configPlaceholder("i-i-i")->typeHTMLString("");
        $this->configPlaceholder("ii-iii-i")->typeHTMLString("THIS MUST NOT APPEAR");
        $this->configPlaceholder("ii-iii-ii")->typeHTMLString("THIS MUST NOT APPEAR");
        $this->configPlaceholder("ii-iii-iii")->typeHTMLString("THIS MUST NOT APPEAR");
    }

    public static function description()
    {
        
    }

    public static function name()
    {
        
    }

}
