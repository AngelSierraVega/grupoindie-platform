<?php

/**
 * GI-Platform-DVLP - Help
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2019 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\Module
 *
 * @version 0D.10
 * @since 19-04-05
 */

namespace GIndie\Platform\Module;

use GIndie\Platform\View;
//use MunicipioMineralReforma\Predial\ModeloDatos\Recursos;
use MunicipioMineralReforma\Predial\ModeloDatos;
use GIndie\ScriptGenerator\Bootstrap3;

/**
 * Description of Help
 *
 * @edit 19-04-05
 * - Added code
 */
class Help extends \GIndie\Platform\Controller\Module
{

    /**
     * {@inheritdoc}
     * @since 19-04-05
     */
    public static function name()
    {
        return "Ayuda";
    }

    /**
     * {@inheritdoc}
     * @since 19-04-05
     */
    public static function description()
    {
        return "Despliega las acciones que el usuario actual puede realizar y sus temas de ayuda.";
    }


    /**
     * {@inheritdoc}
     * 
     * @since 19-04-05
     */
    public function configPlaceholders()
    {
        $this->placeholder("wdgtModulosAcciones")->setColumnSize(12);
        $this->placeholder("wdgtHelp")->setColumnSize(12);
    }

    /**
     * {@inheritdoc}
     * @@since 19-04-05
     */
    public static function configActions()
    {
//        static::setActionModel("@createTbl01", Tbl01Autoincremented::class, "gip-create");
    }

    /**
     * 
     * @return \GIndie\Platform\View\Widget
     * @since 19-04-05
     */
    public function wdgtRoles()
    {
        $rtnWidget = new View\Widgets\Table(ModeloDatos\Plataforma\Base\Rol::class);
        return $rtnWidget;
    }

    /**
     * 
     * @return \GIndie\Platform\View\Widget
     * @since 19-04-05
     */
    public function wdgtUsuarioRoles()
    {
        $rtnWidget = new View\Widget("wdgtUsuarioRoles");
        return $rtnWidget;
    }

    /**
     * 
     * @return \GIndie\Platform\View\Widget
     * @since 19-04-05
     */
    public function wdgtModulosAcciones()
    {
        $formulario = new View\Form(null, false, "#wdgtHelp");
        $formulario->setId("setHelpTopic");
        $formulario->setAttribute("gip-action", "@viewHelp");
        $formulario->addSubmitOnChange();
        $rtnWidget = new View\Widget("Listado de temas de ayuda", true);
        $rtnWidget->getHeadingBody()->addContent(View\Alert::info("Haga click sobre un tema (texto azul) para acceder a su ayuda."));
        $rtnWidget->setContext("primary");
        $table = new \GIndie\Framework\View\Table();
        $table->addHeader(["Acción", "Categoría", "Módulo"]);
        $table->addClass("table-striped");
        \GIndie\Platform\Current::Instance()->config();
        foreach (\GIndie\Platform\Current::Instance()->getModules() as $className => $category) {
            if (\GIndie\Platform\Current::hasRole($className::requiredRoles())) {
                foreach ($className::getHelpTopics() as $actionId => $actionData) {
//                    if (\GIndie\Platform\Current::hasRole($actionData["actionRequirements"])) {
//                        
//                    }
                    $element = \GIndie\Framework\View\FormInput::inputRadio();
                    $element->setAttribute("name", "@helpId");
                    $element->setId(\urlencode($className) . "-" . $actionId);
                    $element->setAttribute("value", \urlencode($className) . "-" . $actionId);
                    $element->setAttribute("hidden");
                    $par = \GIndie\ScriptGenerator\HTML5\Category\Basic::paragraph($actionData["actionDescription"]);
                    $par->addClass("text-info");
                    $formCtrl = Bootstrap3\FormInput\FormGroup::instance($par, $element);
                    $formCtrl->removeClass("form-group");
                    $row = $table->addRowGetPointer([$formCtrl, $category, $className::name()]);
                }
            }
        }
        $formulario->addContent($table);
        $rtnWidget->getHeadingBody()->addContent($formulario);
        return $rtnWidget;
    }

    /**
     * 
     * @return \GIndie\Platform\View\Widget
     * @since 19-04-05
     */
    public function wdgtHelp()
    {
        if (isset($_POST["@helpId"])) {
            $splitted = \explode("-", $_POST["@helpId"]);
            $className = \urldecode($splitted[0]);
            $actionId = \urldecode($splitted[1]);
            $topic = $className::getHelpTopic($actionId);
            $rtnWidget = new View\Widget($topic["actionDescription"], true);
            $rtnWidget->getHeadingBody()->addContent($className::getHelpContent($actionId));
            $rtnWidget->setContext("info");
//            return $classname::getHelpContent($actionId);
        } else {
            $rtnWidget = new View\Widget("", false);
        }

        return $rtnWidget;
    }

    /**
     * 
     * {@inheritdoc}
     * @since 19-04-05
     */
    public function run($action, $id, $class, $selected)
    {
        switch ($action)
        {
            case "@viewHelp":
                return $this->wdgtHelp();
                break;
            default:
                return parent::run($action, $id, $class, $selected);
                break;
        }
    }

    /**
     * @since 19-04-05
     * @return array
     */
    public static function requiredRoles()
    {
        return ["AS", "FE-CLNT"];
    }

}
