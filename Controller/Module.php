<?php

/**
 * Description of Module
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\Controller\Instance\Module
 * 
 * @version 0D.40
 * @since 17-05-23
 */

namespace GIndie\Platform\Controller;

use GIndie\ScriptGenerator\HTML5;
use GIndie\ScriptGenerator\Bootstrap3;
//use GIndie\Platform\Model;
use GIndie\Platform\View;
//use GIndie\Generator\DML\HTML5\Bootstrap3 AS Bootstrap3ToDeprecate;
//use GIndie\Generator\DML\HTML5 AS HTML5ToDeprecate;
use GIndie\Platform\View\Widget;
use GIndie\ScriptGenerator\Bootstrap3\Instance\Button\DropdownSingle;

/**
 * @edit 18-03-05
 * - Created widgetTableFromModel()
 * @edit 18-05-21
 * - Use Module\Deprecated;
 * @edit 18-06-24
 * - runActionSelectRow(), run(): Moved from \GIndie\Platform\Controller\Module.
 * @uses GIndie\Platform\Controller\Module\RunRecordAction
 * @edit 18-10-19
 * - Added wdgtModuleInfo()
 * @edit 18-11-05
 * - Use of Record instead of Table for some cases
 * - Moved back methods from Module\ToUpgrade
 * - Removed use of deprecated libs
 * - Removed dependency to Straffsa\SII
 * @edit 18-11-27
 * - Updated search
 * @edit 18-12-21
 * - Use \GIndie\Platform\DataDefinition
 * @todo debug use of Record instead of Table
 */
abstract class Module extends Platform implements \GIndie\Platform\DataDefinition\Module
{

    /**
     * {@inheritdoc}
     * 
     * @since 18-12-21
     */
    public static function category()
    {
        return null;
    }

/**
     * @since 18-03-13
     * @edit 18-03-14
     * @edit 18-05-21
     * @edit 18-06-24
     * - Added Module\RunRecordAction
     * @edit 18-12-21
     * - Moved back code from Module\RunRecordAction
     */
//    use Module\RunRecordAction;
    use Module\ToUpgrade;
    use Module\ToDeprecate;
    use Module\Upgrading;
    use Module\Deprecated;

    /**
     * Placeholder o-o-o. Module info.
     * 
     * @return \GIndie\Platform\View\Widget
     * @since 18-10-19
     * @edit 18-12-21
     * @edit 19-01-19
     * @edit 19-01-28
     * @edit 19-01-30
     * - Graciously handles Module Info - Module Help
     */
    public function wdgtModuleInfo()
    {
        if (isset($_POST["@helpId"])) {
            $rtnWidget = new View\Widget("", false, true);
            $rtnWidget->getHeading()->getTitle()->addContent(HTML5\Category\Phrase::emphasis("Ayuda del módulo - "));
            $rtnWidget->getHeading()->getTitle()->addContent(
                HTML5\Category\Phrase::strong(static::name()));
            $rtnWidget->getHeading()->addContent(HTML5\Category\Basic::paragraph(static::getHelpTopic($_POST["@helpId"])["actionDescription"]));
            $rtnWidget->getBody()->addContent($this->getHelpContent($_POST["@helpId"]));
            $rtnWidget->setContext("warning");
            $rtnWidget->addButtonHeading($this->cnstrctHelpDropdown());
        } else {
            $rtnWidget = new View\Widget("");
            $rtnWidget->getHeading()->getTitle()->addContent(HTML5\Category\Phrase::emphasis(\is_null(
                        static::category()) ? "" : static::category() . " - "));
            $rtnWidget->getHeading()->getTitle()->addContent(
                HTML5\Category\Phrase::strong(static::name()));
            $rtnWidget->getHeading()->addContent(HTML5\Category\Basic::paragraph(static::description()));
            $rtnWidget->setContext("info");
            if (\count(static::getHelpTopics()) > 0) {
                $rtnWidget->addButtonHeading($this->cnstrctHelpDropdown());
            }
        }
        $rtnWidget->setAttribute("style", "overflow:visible;");

        return $rtnWidget;
    }

    /**
     * 
     * @return \GIndie\ScriptGenerator\Bootstrap3\Instance\Button\DropdownSingle
     * @since 19-01-28
     * @edit 19-01-30
     */
    private function cnstrctHelpDropdown()
    {
        $formulario = new View\Form(null, false, "#o-o-o");
        $formulario->setId("setModuleHelp");
        $formulario->setAttribute("gip-action", "@setModuleHelp");
        $formulario->addSubmitOnChange();
        $help = new DropdownSingle(View\Icons::Help() . " Ayuda del módulo", []);
        if (isset($_POST["@helpId"])) {
            $help->button->setContext("info");
            $listItem = new HTML5\Category\Lists\ListItem();
            $element = \GIndie\Framework\View\FormInput::inputRadio();
            $element->removeClass("btn");
            $element->removeClass("btn-default");
            $element->setId("helpId-moduleInfo");
            $element->setAttribute("hidden");
            $formCtrl = Bootstrap3\FormInput\FormGroup::instance("Información del módulo", $element);
            $formCtrl->setAttribute("style", "color:Black;");
            $listItem->addContent($formCtrl);
            $help->dropdownMenu->addListElement($listItem);
        } else {
            $help->button->setContext("warning");
        }
        foreach (static::getHelpTopics() as $actionId => $actionData) {
            if (isset($_POST["@helpId"]) && $_POST["@helpId"] == $actionId) {
                
            } else {
                $listItem = new HTML5\Category\Lists\ListItem();
                $element = \GIndie\Framework\View\FormInput::inputRadio();
                $element->removeClass("btn");
                $element->removeClass("btn-default");
                $element->setAttribute("name", "@helpId");
                $element->setId("helpId-" . $actionId);
                $element->setAttribute("value", $actionId);
                $element->setAttribute("hidden");
                $formCtrl = Bootstrap3\FormInput\FormGroup::instance($actionData["actionDescription"],
                        $element);
                $formCtrl->setAttribute("style", "color:Black;");
                $listItem->addContent($formCtrl);
                $help->dropdownMenu->addListElement($listItem);
            }
        }
        $formulario->addContent($help);
        return $formulario;
    }

    /**
     * 
     * @param string $actionId
     * @return \GIndie\Framework\View\Table
     * @since 19-01-28
     * @edit 19-01-30
     */
    public static function getHelpContent($actionId)
    {
        $rtnTable = new \GIndie\Framework\View\Table();
        $rtnTable->addClass("table-striped table-bordered table-hover");
        $rtnTable->addHeader(["", HTML5\Category\Basic::header(5,
                "Requerimiento: " . static::getHelpTopic($actionId)["actionDescription"]), ""]);
        $rtnTable->addHeader(["#", "Descripción", "Ayuda visual"]);
        foreach (static::getActionHelp($actionId) as $helpIndex => $helpData) {
            $assets = \GIndie\Platform\INIHandler::getCategoryValue("Config", "assets_url");
            $src = $assets . "\\tmp\\" . $helpData["imageId"] . ".jpg";
            $img = HTML5\Category\Images::img($src, $helpData["imageId"]);
            $img->setAttribute("style", "max-width: 400px;"); //
            $rtnTable->addRow([$helpIndex, $helpData["text"], $img]);
        }
        return $rtnTable;
    }

    /**
     * 
     * @return array
     * @since 19-01-28
     */
    public static function getHelpTopics()
    {
        if (!is_array(self::$actionTopic)) {
            self::$actionTopic = [];
        }
        if (!isset(self::$actionTopic[static::class])) {
            static::configActions();
        }
        return isset(self::$actionTopic[static::class]) ? self::$actionTopic[static::class] : [];
    }

    /**
     * 
     * @param string $actionId
     * @return array
     */
    public static function getHelpTopic($actionId)
    {
        if (!is_array(self::$actionTopic)) {
            self::$actionTopic = [];
        }
        if (!isset(self::$actionTopic[static::class])) {
            static::configActions();
        }
        return isset(self::$actionTopic[static::class][$actionId]) ? self::$actionTopic[static::class][$actionId] : [];
    }

    /**
     * 
     * {@inheritdoc}
     * @since 19-01-28
     */
    public static function getActionHelp($actionId)
    {
        if (!isset(self::$actionHelp[static::class])) {
            static::configActions();
        }
        return self::$actionHelp[static::class][$actionId];
    }

    /**
     * @param string $placeholderId
     * @return \GIndie\Platform\Controller\Module\Placeholder
     * @since 18-03-30
     */
    public function placeholder($placeholderId)
    {
        if (\count($this->_placeholder) == 0) {
            $this->_placeholder["o-o-o"] = new Module\Placeholder("o-o-o");
            $this->_placeholder["o-o-o"]->typeCallable([$this, "wdgtModuleInfo"]);
        }
        if (!isset($this->_placeholder[$placeholderId])) {
            $this->_placeholder[$placeholderId] = new Module\Placeholder($placeholderId);
            if (!\in_array($placeholderId, \array_keys($this->WidgetsDefinition))) {
                $this->_placeholder[$placeholderId]->typeCallable([$this, $placeholderId]);
            }
        }
        $rnt = &$this->_placeholder[$placeholderId];
        return $rnt;
    }

/**
     * @since 18-12-07
     */
    use \GIndie\Platform\WidgetsDefinition;

    /**
     * 
     * @param type $id
     * @param type $class
     * @param type $selected
     * @return type
     * @since 18-12-03
     */
    protected function runGetInput($id, $class, $selected)
    {
        $record = $class::findById($_POST["gip-record-id"]);
        $attribute = $record->getAttribute($id);
        switch ($attribute->getType())
        {

            case \GIndie\Platform\Model\Attribute::TYPE_FOREIGN_KEY:
                return $form_element = \GIndie\Platform\View\Input::selectFromAttribute($attribute,
                        $record->getValueOf($attribute->getName()), $_POST["gip-record-id"]);
            default:
                return View\Input::constructFromAttribute($attribute,
                        $record->getValueOf($attribute->getName()), $_POST["gip-record-id"]);
        }
    }

    /**
     * 
     * {@inheritdoc}
     * 
     * @since 19-01-28
     */
    protected function _createLog($action, $id, $class, $selected)
    {
        switch ($action)
        {
            case "@setModuleHelp":
                break;
            default:
                parent::_createLog($action, $id, $class, $selected);
                break;
        }
    }

    /**
     * 
     * @param string $action
     * @param string $id
     * @return mixed
     * @since 17-01-05
     * @edit 18-03-15
     * @edit 18-05-20
     * - Handle action @selectRow
     * @edit 18-06-24
     * - Moved token validation funcionality to runRecordAction()
     */
    public function run($action, $id, $class, $selected)
    {
        $this->_createLog($action, $id, $class, $selected);
        switch ($action)
        {
            case "@setModuleHelp":
                return $this->widgetReload("o-o-o", $class, $selected);
                break;
            case "@selectRow":
                return $this->runActionSelectRow($_POST["@placeholderId"], $_POST["@selectedId"]);
            case "reportSearch":
                $_table = $this->_searchTable($class);
                return new \GIndie\Platform\View\TableReport($_table);
            case "tableSearch":
                return static::tableSearch($class);
            case "get-input":
                return $this->runGetInput($id, $class, $selected);
            case "form-create":
            case "form-edit":
            case "form-delete":
            case "form-activate":
            case "form-deactivate":
                return static::runRecordForm($action, $id, $class);
            case "gip-create":
            case "gip-edit":
            case "gip-delete":
            case "gip-activate":
            case "gip-deactivate":
                return static::runRecordAction($action, $id, $class);
            case "widget-reload":
                return $this->widgetReload($id, $class, $selected);
            default:
                if ($class != "undefined") {
                    if ($class != \NULL) {
                        if ($selected == \NULL) {
                            $selected = $id;
                        }
                        $obj = $class::findById($selected);
                        return $obj->run($action, $id, $selected);
                    }
                }
                return parent::run($action, $id, $class, $selected);
        }
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
//        return HTML5\Category\StylesSemantics::span()->addContent(View\Javascript::reloadWidget($widgetId));
        return HTML5\Category\StylesSemantics::span()->addScriptOnDocumentReady('triggerInteraction("' . $placeholderId . '", "' . $selectedId . '");');
    }

    /**
     * 
     * @param type $action
     * @param type $id
     * @param type $class
     * @return type
     * @throws \Exception
     * @edit 18-03-14
     * @edit 18-03-15
     * - Explode content into smaller methods
     * @edit 18-06-24
     * - Added token validation funcionality
     * @edit 18-12-21
     * - Moved from trait Module\RunRecordAction 
     */
    protected function runRecordAction($action, $id, $class)
    {
        $response = HTML5\Category\StylesSemantics::Span();
        if (!isset($_POST["gip-token"])) {
            $msj = "Falló validación de token.";
            $modalContent = $this->cnstrctModal("Operación ilegal", $msj);
            $modalContent->getHeader()->setBackground("danger");
            $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
            return $response;
        }
        $tokenValidation = \GIndie\Platform\Current::uniqueTokenValidate($_POST["gip-token"]);
        if (!$tokenValidation) {
            $msj = "Falló validación de token.";
            $modalContent = $this->cnstrctModal("Operación ilegal", $msj);
            $modalContent->getHeader()->setBackground("danger");
            $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
            return $response;
        }
        try {
            switch ($action)
            {
                case "gip-create":
                    $modalContent = $this->runRecordActionGipCreate($action, $id, $class);
                    break;
                case "gip-edit":
                    $modalContent = $this->runRecordActionGipEdit($action, $id, $class);
                    break;
                case "gip-deactivate":
                    $modalContent = $this->runRecordActionGipDeactivate($action, $id, $class);
                    break;
                case "gip-activate":
                    $modalContent = $this->runRecordActionGipActivate($action, $id, $class);
                    break;
                case "gip-delete":
                    $modalContent = $this->runRecordActionGipDelete($action, $id, $class);
                    break;
                default:
                    $msj = "Contacte al administrador del sistema si el problema persiste.";
                    $modalContent = View\Modal\Content::danger("Algo salió mal en la ejecución",
                            $msj);
//                    $modalContent = $this->cnstrctModal(, $msj);
//                    $modalContent->getHeader()->setBackground("danger");
                    \trigger_error("Unable to run recordAction: gip-action={$action} gip-action-id={$id} gip-action-class={$class}",
                        \E_USER_ERROR);
                    break;
            }
        } catch (\GIndie\Platform\ExceptionMySQL $exc) {
            $msj = \GIndie\Platform\ExceptionMySQL::handleException($exc);
            $modalContent = View\Modal\Content::warning("Algo salió mal. Error de usuario.", $msj);
//            $modalContent = $this->cnstrctModal("Algo salió mal. Error de usuario.",
//                                                $msj);
//            $modalContent->getHeader()->setBackground("warning");
        }
        $response->addScript("$('#gip-modal .modal-content').html('{$modalContent}');");
        return $response;
    }

    /**
     * @since 18-03-15
     * 
     * @param string $action
     * @param string $id
     * @param string $class
     * 
     * @return \GIndie\ScriptGenerator\Bootstrap3\Component\Modal\Content
     * @edit 18-12-21
     * - Moved from trait Module\RunRecordAction 
     * 
     */
    protected function runRecordActionGipCreate($action, $id, $class)
    {
        $record = $class::findById($id);
        $record->run($action);
        $msj = "El registro ha sido creado exitosamente.";
        $modalContent = View\Modal\Content::succcess("Registro creado.", $msj);
//        $modalContent = $this->cnstrctModal("Registro creado.", $msj);
//        $modalContent->getHeader()->setBackground("success");
        return $modalContent;
    }

    /**
     * @since 18-03-15
     * 
     * @param string $action
     * @param string $id
     * @param string $class
     * 
     * @return \GIndie\ScriptGenerator\Bootstrap3\Component\Modal\Content
     * 
     * @edit 18-12-21
     * - Moved from trait Module\RunRecordAction 
     * 
     */
    protected function runRecordActionGipDeactivate($action, $id, $class)
    {
        $record = $class::findById($id);
        $record->run($action);
        $msj = "El registro ha sido desactivado exitosamente.";
        $modalContent = View\Modal\Content::succcess("Registro desactivado.", $msj);
//        $modalContent = $this->cnstrctModal("Registro desactivado.", $msj);
//        $modalContent->getHeader()->setBackground("success");
        return $modalContent;
    }

    /**
     * @since 18-03-15
     * 
     * @param string $action
     * @param string $id
     * @param string $class
     * 
     * @return \GIndie\ScriptGenerator\Bootstrap3\Component\Modal\Content
     * 
     * @edit 18-12-21
     * - Moved from trait Module\RunRecordAction 
     * 
     */
    protected function runRecordActionGipActivate($action, $id, $class)
    {
        $record = $class::findById($id);
        $record->run($action);
        $msj = "El registro ha sido activado exitosamente.";
        $modalContent = View\Modal\Content::succcess("Registro activado.", $msj);
//        $modalContent = $this->cnstrctModal("Registro activado.", $msj);
//        $modalContent->getHeader()->setBackground("success");
        return $modalContent;
    }

    /**
     * @since 18-03-15
     * 
     * @param string $action
     * @param string $id
     * @param string $class
     * 
     * @return \GIndie\ScriptGenerator\Bootstrap3\Component\Modal\Content
     * 
     * @edit 18-12-21
     * - Moved from trait Module\RunRecordAction 
     * 
     */
    protected function runRecordActionGipDelete($action, $id, $class)
    {
        $record = $class::findById($id);
        $record->run($action);
        $msj = "El registro ha sido eliminado exitosamente.";
        $modalContent = View\Modal\Content::succcess("Registro eliminado.", $msj);
        return $modalContent;
    }

    /**
     * @since 18-01-24
     * 
     * @param type $action
     * @param type $id
     * @param type $class
     * 
     * @return \GIndie\ScriptGenerator\Bootstrap3\Component\Modal\Content
     * 
     * @edit 18-03-14
     * @edit 18-03-15
     * - Refactor method to runRecordActionGipEdit
     * - Use cnstrctModal()
     * @edit 18-12-21
     * - Moved from trait Module\RunRecordAction 
     */
    protected function runRecordActionGipEdit($action, $id, $class)
    {
        $record = $class::findById($id);
        try {
            $record->run($action);
            $msj = "El registro ha sido actualizado exitosamente.";
            $modalContent = View\Modal\Content::succcess("Registro actualizado.", $msj);
        } catch (\GIndie\Platform\ExceptionMySQL $exc) {
            $msj = \GIndie\Platform\ExceptionMySQL::handleException($exc);
            $modalContent = View\Modal\Content::warning("Error de usuario", $msj);
        }
        return $modalContent;
    }

    /**
     * @since 18-04-01
     * @return \GIndie\ScriptGenerator\Bootstrap3\Component\Alert
     */
    public static function cnstrctLoadingMsj()
    {
        return Bootstrap3\Component\Alert::info("Cargando contenido por favor espere...");
    }

    /**
     * @since 17-04-23
     * @var string 
     * @deprecated since 18-12-21
     * const NAME = "UnnamedModule";
     */

    /**
     * @since 17-04-21
     */
    public function __construct()
    {
        $this->config();
    }

    /**
     * 
     * @param type $record
     * @param type $gipAction
     * @param type $uniqueToken
     * @param type $customTarget
     * @return \GIndie\Platform\View\Form
     * @since 18-06-14
     */
    protected function cnstrctForm($record, $gipAction = null, $uniqueToken = true, $customTarget = false)
    {
        switch ($gipAction)
        {
            case "form-edit":
            case "form-create":
                $form = new View\Form($record, $uniqueToken, $customTarget);
                break;
            case "form-delete":
            case "form-deactivate":
            case "form-activate":
                $form = new View\Form(null, $uniqueToken, $customTarget);
                break;
        }
        switch ($gipAction)
        {
            case "form-edit":
                $form->setAttribute("gip-action", "gip-edit");
                break;
            case "form-create":
                $form->setAttribute("gip-action", "gip-create");
                break;
            case "form-delete":
                $form->setAttribute("gip-action", "gip-delete");
                break;
            case "form-deactivate":
                $form->setAttribute("gip-action", "gip-deactivate");
                break;
            case "form-activate":
                $form->setAttribute("gip-action", "gip-activate");
                break;
            case null:
                break;
            default:
                $form->setAttribute("gip-action", $gipAction);
                \trigger_error("To verify", \E_USER_WARNING);
                break;
        }
        return $form;
    }

    /**
     * 
     * @since 17-04-28
     * @edit 18-12-07
     * @todo Deprecate
     */
    public function config()
    {
        $this->configPlaceholders();
    }

    /**
     * 
     * @param string $action
     * @return strin|null
     * @since 18-03-14
     */
    public static function getActionName($action)
    {
        $rntValue = null;
        switch ($action)
        {
            case "form-edit":
                $rntValue = "Guardar datos";
                break;
            case "form-create":
                $rntValue = "Crear";
                break;
            case "form-activate":
                $rntValue = "Activar";
                break;
            case "form-delete":
                $rntValue = "Eliminar";
                break;
            case "form-deactivate":
                $rntValue = "Desactivar";
                break;
        }
        return $rntValue;
    }

    /**
     * 
     * @param string $action
     * @return string|null
     * @since 18-03-14
     */
    public static function getActionContext($action)
    {
        $rntValue = null;
        switch ($action)
        {
            case "form-edit":
            case "form-create":
            case "form-activate":
                $rntValue = Bootstrap3\Component\Button::$COLOR_SUCCESS;
                break;
            case "form-delete":
                $rntValue = Bootstrap3\Component\Button::$COLOR_DANGER;
                break;
            case "form-deactivate":
                $rntValue = Bootstrap3\Component\Button::$COLOR_WARNING;
                break;
        }
        return $rntValue;
    }

    /**
     *
     * @var array 
     * @since 18-03-13
     */
    protected $searchValues = [];

    /**
     * 
     * @param type $classname
     * @param type $attribute
     * @return string|null
     * @since 18-03-13
     */
    protected function getSearchValue($classname, $attribute)
    {
        $rntValue = null;
        if (isset($this->searchValues[$classname][$attribute])) {
            $rntValue = $this->searchValues[$classname][$attribute];
        }
        return $rntValue;
    }

    /**
     * 
     * @param type $actionId
     * @return mixed
     * @since 19-01-30
     */
    public static function getActionDescription($actionId)
    {
        $rtnValue = "";
        switch ($actionId)
        {
            case "form-deactivate":
                $rtnValue = View\Alert::info("Confirme que desea desactivar el registro.");
                break;
            default:
                break;
        }
        return $rtnValue;
    }

    /**
     * 
     * @param string $action
     * @param string $id
     * @param string $class
     * @return \GIndie\ScriptGenerator\Bootstrap3\Component\Modal\Content
     * @edit 18-03-13
     * - Handler for form on non editable record
     * @edit 18-03-14
     * - Return ModalContent
     * @edit 18-07-13
     * - Use View\Modal\Content
     * @edit 18-11-20
     * - Handle $recordDisplay = "GIP-UNDEFINED"
     */
    protected function runRecordForm($action, $id, $class)
    {
        if ($class::IS_VIEW) {
            $class = $class::getClassnameRecord();
        }
        $record = $class::findById($id);
        $form = $this->cnstrctForm($record, $action);
        $form->setAttribute("gip-action-class", $class);
        $form->setAttribute("gip-action-id", $id);
        $actionName = static::getActionName($action);
        $actionContext = static::getActionContext($action);
        $recordDisplay = $record->getDisplay();
        switch ($recordDisplay)
        {
            case "GIP-UNDEFINED":
                $recordDisplay = "";
                break;
        }
        $modalTitle = $actionName . " <b>" .
            $record->getName() . "</b> <i>" .
            $recordDisplay . "</i>";
        $modalContent = View\Modal\Content::defaultModalContent($modalTitle, $form, true);
        $modalContent->getHeader()->setBackground("primary");
        $modalContent->addContent(static::getActionDescription($action));
        $btn = new Bootstrap3\Component\Button($actionName,
            Bootstrap3\Component\Button::TYPE_SUBMIT);
        $btn->setForm($form->getId())->setValue("Submit");
        $btn->setContext($actionContext);
        $modalContent->addFooterButton($btn);
        return $modalContent;
    }

    /**
     * 
     * @param type $_classname
     * @param array $_searchColumns
     * @param array $_params
     * @param array $buttons
     * @return \GIndie\Platform\View\Widget
     * @edit 18-03-12
     * - Se agregó código para separar los inputs y sus errores en filas
     * @edit 18-04-03
     * - Removed autosubmit
     * @edit 18-11-05
     * - Use of Record instead of Table
     * @edit 18-11-07
     * - Upgrade search button and name
     * @edit 19-01-11
     * - Trigger error when attribute is not defined
     */
    protected function widgetTableSearch($_classname, array $_searchColumns, array $_params = [], array $buttons = [])
    {
//        $record = $_classname::RelatedRecord();
//        $record::instance();
        $record = $_classname::instance();
        $form = new \GIndie\Platform\View\Form(null, false, "#tempContent");
        $form->setAttribute("gip-action", "tableSearch");
        $form->setAttribute("gip-action-class", $_classname);
        $form->setAttribute("autocomplete", "off");
        //$form->addContent($_classname);
        $size = 0;
        foreach ($_searchColumns as $attribute) {
            if (\is_array($attribute)) {
                foreach ($attribute as $key => $value) {
                    $recordAttr = $record::getAttribute($key);
                    if (\is_bool($recordAttr)) {
                        \trigger_error("Attribute {$key} not defined in model {$_classname}",
                            \E_USER_ERROR);
                    } else {
                        $tmpAttr = \GIndie\Platform\View\Input::constructFromAttribute($recordAttr,
                                $value, \NULL);
                    }
                }
            } else {
                if ($record::getAttribute($attribute)) {
                    $recordAttr = $record::getAttribute($attribute);
                    $value = static::getSearchValue($_classname, $attribute);
                    //$value = $_classname;
                    //$value = isset($_POST[$attribute]) ? $_POST[$attribute] : "";
                    $tmpAttr = \GIndie\Platform\View\Input::constructFromAttribute($recordAttr,
                            $value, \NULL);
                } else {
                    \trigger_error($attribute . " not defined in " . $record::SCHEMA . "." . $record::TABLE . " " . \get_class($record),
                        \E_USER_ERROR);
                }
            }
            if ($recordAttr->getSize()) {
                $tmpSize = $recordAttr->getSize();
                $tmpSize = \explode("-", $tmpSize);
                $tmpSize = \array_pop($tmpSize);
                $size += (integer) $tmpSize;
                if ($size > 12) {
                    $form->addContent("<div class='row col-xs-12'></div>");
                    $size = (integer) $tmpSize;
                }
            }
            $form->addContent($tmpAttr);
        }

        $widget = new \GIndie\Platform\View\Widget("" . $_classname::NAME, \FALSE, $form,
            "<div id='tempContent'></div>");
//        $widget->getBody()->addContent("<input type='submit' form='".$form->getId()."'/>");
//        $reloadButton = Widget\Buttons::Reload($_classname);
//        $widget->addButtonHeading($reloadButton);
        $widget->addButtonHeading("<input class='btn btn-sm btn-success' value='Buscar' type='submit' form='" . $form->getId() . "'/>");

//        $searchButton = \GIndie\Platform\View\Widget\Buttons::CustomSuccess("<span class=\"glyphicon glyphicon-search\"></span>", \NULL, \NULL, \FALSE, \NULL);
//        $searchButton->setForm($form->getId());
//        $widget->addButtonHeading($searchButton);
        //$widget->addContent(\GIndie\Platform\View\Javascript::submitOnChange($form->getId()));
        $widget->addScriptOnDocumentReady("$('#" . $form->getId() . "').submit();");
//        foreach ($buttons as $tmpButton) {
//            $_actionId = $tmpButton["gipActionId"];
//            if (strcmp($_actionId, "gip-selected-id") == 0) {
//                if (isset($_POST["gip-selected-id"])) {
//                    $_actionId = $_POST["gip-selected-id"];
//                    $this->_selectedId = $_actionId;
//                } else {
//                    //this->_selectedId = "NONE";
//                    $_actionId = $this->_selectedId;
//                }
//            }
//            $tmpButton = \GIndie\Platform\View\Widget\Buttons::Custom($tmpButton["context"], $tmpButton["icon"], $tmpButton["gipAction"], $_actionId, $tmpButton["gipModal"], $tmpButton["gipClass"]);
//            $widget->addButtonHeading($tmpButton);
//        }
        $widget->setContext("primary");
        return $widget;
    }

    /**
     * 
     * @param string $classname
     * @param string $params
     * @return \GIndie\Platform\View\Widget\WidgetReport
     * @since 18-03-30
     */
    protected function widgetReportFromModel($classname, $params = [])
    {
        if (\is_subclass_of($classname, \GIndie\Platform\Model\Table::class, true)) {
            $rtnWidget = new Widget\WidgetReport(new $classname($params));
            return $rtnWidget;
        }
        \trigger_error($classname . " is not subclass of \GIndie\Platform\Model\Table",
            \E_USER_ERROR);
    }

    /**
     * @param string $classname
     * @param array $params
     * @return \GIndie\Platform\View\Widget\WidgetTable
     */
    protected function widgetTableFromModel($classname, $params = [])
    {
        if (\is_subclass_of($classname, \GIndie\Platform\Model\Table::class, true)) {
            $rtnWidget = new Widget\WidgetTable(new $classname($params));
            return $rtnWidget;
        }
        \trigger_error($classname . " is not subclass of \GIndie\Platform\Model\Table",
            \E_USER_ERROR);
    }

    /**
     * 
     * @param type $class
     * @return array
     * @since 18-03-30
     * @edit 18-11-05
     * - Use of Record instead of Table
     * @edit 18-11-27
     * - Stores result by attribute name
     * - Return array instead of string
     */
    protected function cnstrctSearchParamsFromPost($class)
    {
//        $record = $class::RelatedRecord();
        $record = $class::instance();
        $searchArray = [];
        foreach ($record::getAttributeNames() as $attrName) {
            if (\array_key_exists($attrName, $_POST)) {
                $this->searchValues[$class][$attrName] = $_POST[$attrName];
                switch ($record::getAttribute($attrName)->getType())
                {
                    case \GIndie\Platform\Model\Attribute::TYPE_DATE:
                        $tmp = \explode(" a ", $_POST[$attrName]);
                        if (\sizeof($tmp) > 1) {
                            $searchArray[$attrName . "_a"] = $attrName . ">='$tmp[0]'";
                            $searchArray[$attrName . "_b"] = $attrName . "<='" . $tmp[1] . ' 23:59:59' . "'";
                        } else {
                            $searchArray[$attrName] = $attrName . " LIKE '%" . $_POST[$attrName] . "%'";
                        }
                        break;
                    case \GIndie\Platform\Model\Attribute::TYPE_TIMESTAMP:
                        $tmp = \explode(" a ", $_POST[$attrName]);
                        if (\sizeof($tmp) > 1) {
                            $searchArray[$attrName . "_a"] = $attrName . ">='" . \strtotime($tmp[0]) . "'";
                            $searchArray[$attrName . "_b"] = $attrName . "<='" . \strtotime($tmp[1] . " 23:59:59") . "'";
                        } else {
                            $searchArray[$attrName . "_a"] = $attrName . ">='" . \strtotime($_POST[$attrName]) . "'";
                            $searchArray[$attrName . "_b"] = $attrName . "<='" . \strtotime($_POST[$attrName] . " 23:59:59") . "'";
                        }
                        break;
                    default:
                        switch ($_POST[$attrName])
                        {
                            case "":
                            case "NULL":
                                break;
                            case "NOT NULL":
                                $searchArray[$attrName] = $attrName . " IS NOT NULL ";
                                break;
                            default:
                                $searchArray[$attrName] = $attrName . " LIKE '%" . $_POST[$attrName] . "%'";
                                break;
                        }
                        break;
                }
            }
        }
        /**
         * @edit 18-11-27
         * if (\sizeof($searchArray) > 0) {
         *     $searchArray = [\join(" AND ", $searchArray)];
         * }
         */
        return $searchArray;
    }

    /**
     * @since 17-??-??
     * @param string $class
     * @return \GIndie\Platform\View\Table
     * @edit 18-03-20
     * - Renamed from _searchTable to  cnstrctTableFromSearch
     */
    protected function cnstrctTableFromSearch($class)
    {
        $_table = new $class($this->cnstrctSearchParamsFromPost($class));
        return $_table;
    }

    /**
     * @todo error handling
     * 
     * @since 17-04-21
     *          
     * @param string $widgetPlaceholder
     * @return null|\GIndie\Platform\Controller\Main\WidgetInterface
     */
    public function getWidget($placeholderid)
    {
        if (\array_key_exists($placeholderid, $this->_placeholder)) {
            return $this->_placeholder[$placeholderid];
        } else {
            return NULL;
        }
    }

    /**
     * @param string $id
     * @param string $class
     * @param string $selected
     * 
     * 
     * @return null|\GIndie\Platform\Controller\Main\WidgetInterface
     * @edit 18-12-09
     */
    protected function widgetReload($id, $class, $selected)
    {
        $placeholder = \GIndie\Platform\Current::Module()->getWidget($id);
        switch (true)
        {
            case \is_null($placeholder):
                \trigger_error("id: {$id}, class: {$class}, selected: {$selected}", \E_USER_ERROR);
                break;
            default:
                $placeholder = $placeholder->call($selected);
                break;
        }
//        @edit 18-10-19
//        * - Added validation for ModuleInfo
//        if ($this->validateModuleInfo == false) {
//            \trigger_error("wdgtModuleInfo() must be called", \E_USER_ERROR);
//        }
        return $placeholder;
    }

    /**
     * 
     * @param type $class
     * @return \GIndie\Platform\View\Tables\TablePagination
     * @edit 18-11-05
     * - Use of Record instead of Table
     */
    protected function tableSearch($class)
    {
        $table = new \GIndie\Platform\View\Tables\TablePagination($class);
        $table->readFromDB($class::getSelectorsDisplay(),
            $this->cnstrctSearchParamsFromPost($class));
        return $table;
    }

    /**
     * @since 2017-04-28
     * @var array 
     */
    private $_placeholder = [];

    /**
     * 
     * @return type
     * @since 18-12-07
     */
    public function getPlaceholderIds()
    {
        return \array_keys($this->_placeholder);
    }

    /**
     * 
     * @return array|\GIndie\Platform\Controller\Module\Placeholder
     * @since 18-12-07
     */
    public function getPlaceholders()
    {
        return $this->_placeholder;
    }

    /**
     * 
     * @return type
     */
    public function getWidgets()
    {
        return $this->_placeholder;
    }

    /**
     * 
     * @return string Un string de un array asociativo para javascript
     */
    public function fetchMasterSlaves()
    {
        $rtnArray = [];
        foreach ($this->_placeholder as $placeholder => $interface) {
            $tmpSlaves = [];
            foreach ($interface->getSlaves() as $_tmp) {
                $tmpSlaves[] = "" . $_tmp;
            }
            $rtnArray[] = ["" . $placeholder => $tmpSlaves];
        }
        $string = json_encode($rtnArray);
        $string = str_replace("},{", ",", $string);
        $string = substr($string, 0, -1);
        $string = substr($string, 1);
        $string = $string . ";";
        return $string;
    }

    /**
     *
     * @var array 
     * @since 19-01-28
     */
    private static $actionTopic;

    /**
     * 
     * @param type $actionId
     * @param type $relatedModel
     * @param type $relatedAction
     * @since 19-01-21
     * @edit 19-01-28
     * - Funcional method
     */
    protected static function setActionModel($actionId, $relatedModel, $relatedAction)
    {
        if (!is_array(self::$actionTopic)) {
            self::$actionTopic = [];
        }
        switch ($relatedAction)
        {
            case "gip-create":
                $actionDescription = "Crear " . $relatedModel::name();
                $actionContext = "success";
                $actionButton = View\Icons::Create();
                break;
            case "gip-edit":
                $actionDescription = "Modificar " . $relatedModel::name();
                $actionContext = "success";
                $actionButton = View\Icons::Edit();
                break;
            case "gip-delete":
                $actionDescription = "Eliminar " . $relatedModel::name();
                $actionContext = "danger";
                $actionButton = View\Icons::Delete();
                break;
            case "gip-deactivate":
                $actionDescription = "Desactivar " . $relatedModel::name();
                $actionContext = "default";
                $actionButton = View\Icons::Active();
                break;
            case "gip-activate":
                $actionDescription = "Activar " . $relatedModel::name();
                $actionContext = "success";
                $actionButton = View\Icons::Active();
                break;
        }
        self::$actionTopic[static::class][$actionId] = [
            "actionDescription" => $actionDescription,
            "actionContext" => $actionContext,
            "actionDisplay" => $actionButton];
        return true;
    }

    /**
     * 
     * @param string $actionId
     * @param string $actionDescription
     * @param mixed $actionDisplay
     * @param string $actionContext
     * @return boolean
     * @since 19-01-21
     * @edit 19-01-30
     * - Funcional method
     */
    protected static function setActionCustom($actionId, $actionDescription, $actionDisplay, $actionContext, $actionRequirements)
    {
        if (!is_array(self::$actionTopic)) {
            self::$actionTopic = [];
        }
        if (\GIndie\Platform\Current::hasRole($actionRequirements)) {
            self::$actionTopic[static::class][$actionId] = [
                "actionDescription" => $actionDescription,
                "actionContext" => $actionContext,
                "actionDisplay" => $actionDisplay,
                "actionRequirements" => $actionRequirements];
        }
        return true;
    }

    /**
     *
     * @var array 
     * @since 19-01-28
     */
    private static $actionHelp;

    /**
     * 
     * @param string $actionId
     * @param float $helpIndex
     * @param string $text
     * @param string $imageId
     * @since 19-01-21
     * @edit 19-01-28
     * - Funcional method
     */
    protected static function setActionHelp($actionId, $helpIndex, $text, $imageId)
    {
        if (!is_array(self::$actionHelp)) {
            self::$actionHelp = [];
        }
        self::$actionHelp[static::class][$actionId][$helpIndex] = ["text" => $text, "imageId" => $imageId];
        return true;
    }

}
