<?php

/**
 * GI-Platform-DVLP - 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\View
 * 
 * @version 0C.A0
 * @since 17-04-21
 */

namespace GIndie\Platform\View;

//use GIndie\Generator\DML\HTML5\Category\StylesSemantics;
//use GIndie\Generator\DML\HTML5\Bootstrap3\Component\Panel;
//use \GIndie\Generator\DML\HTML5\Bootstrap3\Component\Button;
//use GIndie\Platform\View\Widget\Buttons;
use GIndie\ScriptGenerator\Dashboard;

/**
 * Description of Widget
 * 
 * @since   
 * @author  Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @edit 18-03-22
 */
class Widget extends Dashboard\Widget
{

    /**
     * 
     * @param array $params
     * @return $this
     */
    public function addActionHeading(array $params)
    {
        $form = new \GIndie\Platform\View\Form(null, true, isset($params["target"]) ? $params["target"] : false);
        !isset($params["gip-action"]) ?: $form->setAttribute("gip-action", $params["gip-action"]);
        !isset($params["gip-action-id"]) ?: $form->setAttribute("gip-action-id", $params["gip-action-id"]);
        switch (false)
        {
            case \is_null($this->getHeadingBody()):
                $this->getHeadingBody()->addContent($form);
                break;
            case \is_null($this->getBody()):
                $this->getBody()->addContent($form);
                break;
            case \is_null($this->getBodyFooter()):
                $this->getBodyFooter()->addContent($form);
                break;
            case \is_null($this->getFooter()):
                $this->getFooter()->addContent($form);
                break;
            default:
                $this->getHeading()->addContent($form);
                break;
        }
        $button = new \GIndie\ScriptGenerator\Bootstrap3\Component\Button(isset($params["action-name"]) ? $params["action-name"] : "Submit", "submit");
        $button->addClass("btn-sm");
        !isset($params["context"]) ?: $button->setContext($params["context"]);
        $button->setForm($form->getId());
        $this->addButtonHeading($button);
        return $this;
    }

}
