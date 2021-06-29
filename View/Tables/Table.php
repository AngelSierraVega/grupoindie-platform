<?php
/**
 * GI-Platform-DVLP - Table
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\View
 *
 * @version 0C.FC
 * @since 18-11-04
 */

namespace GIndie\Platform\View\Tables;

use GIndie\ScriptGenerator\HTML5\Category\StylesSemantics;
use GIndie\Platform\View\Widget;
use GIndie\Common\Parser\Moneda;

/**
 * @edit 18-11-04
 * - Copied code from View\Table
 * @edit 18-11-07
 * - Created instanceFromArray(), getData()
 */
class Table extends \GIndie\ScriptGenerator\Dashboard\Tables\Table
{

    /**
     * Instancia el modelo de datos
     * 
     * @var \GIndie\Platform\Model\Record 
     * @since 18-11-04
     */
    protected $recordInstance;

    /**
     * Nombre de la llave primaria del modelo
     * 
     * @var string 
     * @since 18-11-04
     */
    protected $pkAttribute;

    /**
     * 
     * @var mixed|null
     * @since 18-11-04
     */
    protected $selectedValue;

    /**
     * @var boolean 
     * @since 18-11-04
     */
    protected $dprCreate = false;

    /**
     * @var boolean 
     * @since 18-11-04
     */
    protected $dprEdit = false;

    /**
     * @var boolean 
     * @since 18-11-04
     */
    protected $dprDelete = false;

    /**
     * @var boolean 
     * @since 18-11-04
     */
    protected $dprState = false;

    /**
     *
     * @var string 
     * @since 18-11-04
     */
    protected $dprRecordClass = null;

    /**
     * @var boolean 
     * @since 18-11-04
     */
    private $showFooter;

    /**
     *
     * @var array|\GIndie\Platform\Model\Record\Command
     * @since 09-03-21
     * @edit 19-03-27
     * - Use of \GIndie\Platform\Model\Record\Command
     */
    protected $recordCommands;

    /**
     * Construye una tabla HTML con funcionalidad de DataTable.
     * @param \GIndie\Platform\Model\Table  $table
     * @param boolean $selectable
     * @param string|null $selectedId
     * @since GIP.00.01
     * @edit 19-03-27
     * - Use of \GIndie\Platform\Model\Record\Command
     */
    public function __construct($classname, $showFooter = false)
    {
        parent::__construct();
        switch (false)
        {
            case \is_string($classname):
                \trigger_error("classname should be string. Called in " . \get_called_class(),
                    \E_USER_ERROR);
            case \is_subclass_of($classname, \GIndie\Platform\Model\Record::class, true):
                \trigger_error("classname should be subclass of Record. Called in " . \get_called_class(),
                    \E_USER_ERROR);
        }
        $this->recordInstance = $classname::instance();
        $this->showFooter = $showFooter;
        $this->dprRecordClass = $classname;
        $this->recordCommands = [];
        foreach ($classname::commands() as $idCommand => $objCommand) {
            switch (true)
            {
                case ($idCommand == "gip-create"):
                    break;
                case \is_null($this->recordInstance->getValidRolesFor($idCommand)):
                case \GIndie\Platform\Current::hasRole($this->recordInstance->getValidRolesFor($idCommand)):
                    $this->recordCommands[] = $objCommand;
                    break;
                default:
                    break;
            }
//            var_dump($idCommand);
//            var_dump($objCommand);
//            var_dump($this->recordInstance->getValidRolesFor($idCommand));
//            if (\GIndie\Platform\Current::hasRole($this->recordInstance->getValidRolesFor($idCommand))) {
//                if ($idCommand != "gip-create") {
//                    $this->recordCommands[] = $objCommand;
//                }
//
////                $this->dprCreate = true;
//            }
        }
//        var_dump($this->recordCommands);
//        var_dump($classname::commands());
//        var_dump($this->recordInstance->commands());
//        if (\GIndie\Platform\Current::hasRole($this->recordInstance->getValidRolesFor("gip-create"))) {
//            $this->dprCreate = true;
//        }
//        if (\GIndie\Platform\Current::hasRole($this->recordInstance->getValidRolesFor("gip-edit"))) {
//            $this->dprEdit = true;
//        }
//        if (\GIndie\Platform\Current::hasRole($this->recordInstance->getValidRolesFor("gip-delete"))) {
//            $this->dprDelete = true;
//        }
//        if (\GIndie\Platform\Current::hasRole($this->recordInstance->getValidRolesFor("gip-state"))) {
//            $this->dprState = true;
//        }
        $this->pkAttribute = $classname::PRIMARY_KEY;
        $this->addClass("display table-bordered");
        $this->setId(\GIndie\Platform\Security::tokenizeSecure(static::class));

//        $tableHandler = new \GIndie\DBHandler\MySQL57\Handler\Table($this->recordInstance);
//        $this->queryRows = $tableHandler->selectAll();
//        $query = \GIndie\DBHandler\MySQL57\Statement\DataManipulation::select($this->recordInstance->getAttributeNames(), [$this->recordInstance->databaseName() => $this->recordInstance->name()]);
//        $query->setLimit(100);
//        $result = \GIndie\DBHandler\MySQL57::query($query);
//        $this->queryRows = $result->fetch_all(\MYSQLI_ASSOC);
    }

    /**
     * 
     * @param array $selectors
     * @param array $conditions
     * @param array $params
     * @since 18-11-14
     * @edit 18-11-16
     * - Upgraded to Record:::fetchAssoc()
     * @edit 19-01-08
     * - Graciously handle more than 100000 rows
     * @edit 19-01-24
     * - Changed to 110000 rows
     */
    public function readFromDB(array $selectors, array $conditions = [], array $params = [])
    {
        $this->queryRows = $this->recordInstance->fetchAssoc($selectors, $conditions, $params);
        
        if (\count($this->queryRows) > 110000) {
            $this->addContent(\GIndie\Platform\View\Alert::warning("No se puede visualizar la tabla completa pues contiene más de 110000 registros: " . \count($this->queryRows) . "."));
            $this->queryRows = \array_slice($this->queryRows, 0, 110000, true);
        }
        $this->addContent($this->tableContent());
        return true;
//        $select = $this->recordInstance->sttmtSelect($selectors);
//        foreach ($conditions as $condition) {
//            switch (true)
//            {
//                case \is_array($condition):
//                    $expr1 = \array_keys($condition)[0];
//                    $expr2 = \array_values($condition)[0];
//                    $select->addConditionEquals($expr1, $expr2);
//                    break;
//                default:
//                    $select->addCondition($condition);
//                    break;
//            }
//        }
//
//        if ($this->recordInstance->groupBy() !== null) {
//            $select->addGroupBy($this->recordInstance->groupBy(), true);
//        }
//        $databaseConnection = \GIndie\Platform\Current::Connection();
//        $result = $databaseConnection->query($select);
//        $this->queryRows = [];
//        while ($row = $result->fetch_assoc()) {
//            $tmpInstance = $this->recordInstance;
//            $this->queryRows[$row[$tmpInstance::PRIMARY_KEY]] = $row;
//        }
//        $this->addContent($this->tableContent());
    }

    /**
     * 
     * @return array
     * @since 18-11-07
     */
    public function getData()
    {
        return $this->queryRows;
    }

    /**
     * 
     * @param array $data
     * @since 18-11-07
     */
    public function instanceFromArray(array $data)
    {
        $this->queryRows = $data;
        $this->addContent($this->tableContent());
    }

    /**
     *
     * @var array 
     */
    private $queryRows;

    /**
     * 
     * @return boolean
     * @edit 19-03-21
     * - Use of $recordCommands
     */
    private function isEditable()
    {
        return (\count($this->recordCommands) > 0);
        //if ($this->dprCreate || $this->dprEdit || $this->dprState || $this->dprDelete) {
//        if ($this->dprEdit || $this->dprState || $this->dprDelete) {
//            return true;
//        }
//        return false;
    }

    /**
     * @todo Eliminar estilos, pasar a CSS global
     * Define codigo Javascript customizados al interior del Nodo actual.
     * @since GIP.00.01
     * @return string
     */
    public function defineScript()
    {
        $title = $this->recordInstance->getName();
        ob_start();
        ?>
        <script>
            var columns = [<?= $this->getColumns(); ?>];
            var title = "<?= $title; ?>";
            $(document).ready(function () {
                create_datatable("<?= $this->getId(); ?>", {
                    "title": title,
                    "columns": columns,
                    "search": false,
                    "export": false,
                    "pagination": false,
                    "selectable": true
                });
            });
        </script>
        <?php
        $str = ob_get_contents();
        ob_end_clean();
        //return "";
        return $str;
    }

    protected function getColumns()
    {
        $int = 0;
        $arrayTmp = [$int];
        if ($this->isEditable()) {
            $int = $int + 1;
        }
        foreach ($this->recordInstance->getAttributesDisplay() as $value) {
            $int = $int + 1;
            $arrayTmp[] = $int;
        }
        return \join(",", $arrayTmp);
    }

    /**
     * 
     * @param type $rowId
     * @return \GIndie\ScriptGenerator\HTML5\Category\StylesSemantics\Div
     * @todo Use inner var
     * @edit 19-03-21
     */
    protected function _btnGroup($rowId)
    {
        $bntGroup = new StylesSemantics\Div("", ["class" => "btn-group btn-group-xs"]);
        foreach ($this->recordCommands as $command) {
            switch ($command->getCommandId())
            {
                case "gip-edit":
                    $gipAction = "form-edit";
                    break;
                case "gip-delete":
                    $gipAction = "form-delete";
                    break;
//                case "gip-edit":
//                    $gipAction = "form-edit";
//                    break;
                default:
                    $gipAction = $command->getCommandId();
                    break;
            }
            $context = $command->getContext();
            $icon = $command->getIcon();

            $gipActionId = $rowId;
            $gipModal = $command->getSize();
            $gipClass = $command->getExecutableClassname();
//            $gipSelectedId = "gip-selected-id";
            $button = Widget\Buttons::Custom($context, $icon, $gipAction, $gipActionId, $gipModal,
                    $gipClass);
            $bntGroup->addContent($button);
        }
//        if ($this->dprDelete) {
////            $button = Widget\Buttons::CustomDanger(Icons::Delete(),
////                                                   "form-delete", $rowId, \TRUE,
////                                                   $this->dprRecordClass);
//            $button = Widget\Buttons::Delete($this->dprRecordClass, $rowId);
//            $bntGroup->addContent($button);
//        }
//        if ($this->dprEdit) {
//            $button = Widget\Buttons::Edit($this->dprRecordClass, $rowId);
//            $bntGroup->addContent($button);
//        }
        return $bntGroup;
    }

//    
//    public function addRow($content){
//        $this->addContent("<a>".$content."</a>");
//    }

    /**
     * Construye el marcado HTML del contenido del Nodo actual
     * @todo Deprecar función y construir Nodos
     * @since GIP.00.01
     * @edit 18-10-29
     * - Se corrigió bug en generación de botones
     */
    protected function tableContent($selectedId = null)
    {
        ob_start();
        ?>
        <thead> 
            <tr> 
                <th>#</th> 
                <?php
                if ($this->isEditable()) {
                    ?>
                    <th>Acciones</th>
                    <?php
                }
                foreach ($this->recordInstance->getAttributesDisplay() as $colName) {
                    ?>
                    <th>
                        <?=
                        //if()
                        $this->recordInstance->getLabelOf($colName)
                        //$colName
                        ?></th>
                    <?php
                }
                ?> 
            </tr> 
        </thead> 
        <tbody> 
            <?php
            $inc = 0;
            $totales = [];
//        $total = 0;
//        var_dump($this->queryRows);
            foreach ($this->queryRows as $key => $row) {
                $inc++;
                ?>
                <tr <?= strcmp($selectedId, $row[$this->pkAttribute]) == 0 ? 'class="selected"' : "" ?> gip-record="<?= $row[$this->pkAttribute]; ?>"> 
                    <th scope="row"><?= $inc; ?></th>
                    <?php
                    if ($this->isEditable()) {
                        ?>
                        <td class="text-center"><?= $this->_btnGroup($row[$this->pkAttribute]); ?></td>
                        <?php
                    }

                    foreach ($this->recordInstance->getAttributesDisplay() as $columnName) {
                        $column = $this->recordInstance->getAttribute($columnName);
                        $this->recordInstance->setValueOf($columnName, $row[$columnName]);
                        ?>
                        <td >
                            <?php
                            switch ($column->getType())
                            {
                                case \GIndie\Platform\Model\Attribute::TYPE_CURRENCY:
                                    if (!isset($totales[$columnName])) {
                                        $totales[$columnName] = 0;
                                    }
                                    $totales[$columnName] += \floatval($row[$columnName]);
//                                $total = $total + \floatval($row[$columnName]);
                                default:
                                    echo $this->recordInstance->getDisplayOf($columnName);
                            }
                            ?></td>
                        <?php
                    }
                    ?> 
                </tr> 
                <?php
            }
            ?>
        </tbody> 
        <?php
        if ($this->showFooter) {
            ?>
            <tfoot>
                <tr>
                    <td></td>
                    <?php
                    if ($this->isEditable()) {
                        ?>
                        <td></td>
                        <?php
                    }
                    foreach ($this->recordInstance->getAttributesDisplay() as $colName) {
                        $columnTmp = $this->recordInstance->getAttribute($colName);
                        ?>
                        <td>
                            <?php
                            switch ($columnTmp->getType())
                            {

                                case \GIndie\Platform\Model\Attribute::TYPE_CURRENCY:
                                    if (isset($totales[$colName])) {
                                        echo Moneda::contable($totales[$colName]);
                                    }
//                                if (isset($total)) {
//                                        $total = bcadd(\strval($total), 0, 2);
//                                    echo Moneda::contable($total);
//                                        echo isset($total) ? "$" . $total : "";
//                                }
                                    break;

                                default:
                                    echo "";
                                    break;
                            }
                            ?>
                        </td>
                        <?php
                    }
                    ?> 
                </tr>
            </tfoot>
            <?php
        }

        $str = ob_get_contents();
        ob_end_clean();
        return $str;
    }

}
