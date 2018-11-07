<?php

/**
 * MMR-PRDL0-DVLP - ModeloDatos
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Dirección de Informática. Municipio Mineral de la Reforma.
 *
 * @package MunicipioMineralReforma\Predial\Modulo\Sistema
 *
 * @version DOING 00.90
 * @since 18-12-09
 */

namespace MunicipioMineralReforma\Predial\Modulo\Sistema;

use GIndie\Platform\View;
use GIndie\ScriptGenerator\HTML5;

/**
 * Description of ModeloDatos
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class ModeloDatos extends \GIndie\Platform\Controller\Module
{

    /**
     * @since 18-12-09
     */
    const NAME = "ModeloDatos";

    /**
     * @since 18-12-09
     */
    public function configPlaceholders()
    {
        $this->placeholder("wdgtBasesDatos")->setColumnSize(6);
        $this->placeholder("wdgtTablas")->setColumnSize(6);
    }
    
    /**
     * {@inheritdoc}
     * @since 19-01-29
     */
    public static function configActions()
    {
//        static::setActionModel("@createTbl01", Tbl01Autoincremented::class, "gip-create");
    }

    /**
     * 
     * @return \GIndie\Platform\View\Widget
     * @since 18-12-09
     */
    public function wdgtBasesDatos()
    {
        $rtnWidget = new View\Widget("wdgtBasesDatos", true);
        $form = \GIndie\Framework\View\FormInput::formPostOnSelf("selectDatabase");
        $form = new View\Form(null, false, "#wdgtTablas");
        $form = new View\Form(null, false, false);
        $form->setAttribute("gip-action", "@selectRow");
        $form->addContent(View\Input::hidden("@placeholderId", "wdgtBasesDatos"));
        $form->addSubmitOnChange();
        $table = new \GIndie\ScriptGenerator\Dashboard\Tables\Selectable();
        $table->addHeader(["", "Name", "Class"]);
        $databases = [\MunicipioMineralReforma\Predial\ModeloDatos\Plataforma\Base\BaseDatosPlataforma::getInstance()];
        foreach ($databases as $databaseInstance) {
            $table->addSelectableRow(\urlencode(\get_class($databaseInstance)),
                [$databaseInstance->name(), \get_class($databaseInstance)]);
        }
        $form->addContent($table);
        $rtnWidget->getHeadingBody()->addContent($form);
        return $rtnWidget;
    }

    /**
     * 
     * @param string $placeholderId
     * @param string $selectedId
     * @return \GIndie\ScriptGenerator\HTML5\Category\StylesSemantics\Span
     * @since 18-05-20
     */
    protected function runActionSelectRow($placeholderId, $selectedId)
    {
//        return "TEST";
        $this->databaseClassname = $selectedId;
        return HTML5\Category\StylesSemantics::span()->addContent(View\Javascript::reloadWidget("wdgtTablas"));
        return HTML5\Category\StylesSemantics::span()->addScriptOnDocumentReady('triggerInteraction("' . $placeholderId . '", "' . $selectedId . '");');
    }

    /**
     *
     * @var string
     * @since 18-12-09
     */
    private $databaseClassname;

    /**
     * 
     * @return \GIndie\Platform\View\Widget
     * @since 18-12-09
     */
    public function wdgtTablas()
    {
        $rtnWidget = new View\Widget("wdgtTablas", true, true);
        switch (true)
        {
            case isset($this->databaseClassname):
                $rtnWidget->setContext("success");
                $rtnWidget->getHeadingBody()->addContent("test");

                break;

            default:
                break;
        }
        return $rtnWidget;
    }

    /**
     * 
     * @return array|string
     * @since 18-12-09
     */
    public static function requiredRoles()
    {
        return ["NONE"];
    }

}
