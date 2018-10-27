<?php
/**
 * GI-Platform-DVLP - 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\View
 * 
 * @version 0C.00
 * @since 17-06-17
 */

namespace GIndie\Platform\View;

use GIndie\Generator\DML\HTML5\Category\StylesSemantics\Div;
use GIndie\Platform\Model\Table as ModelTable;
use GIndie\Generator\DML\HTML5\Category\StylesSemantics;

/**
 * Description of Table
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @since GIP.00.01
 * @edit 18-04-02
 */
class Table extends Div
{

    /**
     * Almacenar el modelo de la base de datos
     * @var \GIndie\Platform\Model\Table 
     * @since GIP.00.01
     */
    protected $_model;

    /**
     * Almacenar el nombre del atributo que almacena el ID de cada fila
     * @var string 
     * @since GIP.00.01
     */
    protected $_rowIdAttribute;
    protected $_create = \FALSE;
    protected $_edit = \FALSE;
    protected $_delete = \FALSE;
    protected $_state = \FALSE;
    protected $_relatedRecord = \NULL;
    private $_showFooter;

    /**
     * Construye una tabla HTML con funcionalidad de DataTable.
     * @param \GIndie\Platform\Model\Table  $table
     * @param boolean $selectable
     * @param string|null $selectedId
     * @since GIP.00.01
     */
    public function __construct(ModelTable $table, $showFooter = \FALSE,
                                $selectedId = \NULL)
    {
        $this->_showFooter = $showFooter;
        $relatedRecord = $table::RelatedRecord();
        if ($relatedRecord !== \NULL) {
            $this->_relatedRecord = $relatedRecord;

            //$roles = ;
            if (\GIndie\Platform\Current::hasRole($table::getValidRolesFor("gip-create"))) {
                $this->_create = \TRUE;
            }

            //$roles = ;
            if (\GIndie\Platform\Current::hasRole($table::getValidRolesFor("gip-edit"))) {
                $this->_edit = \TRUE;
            }

            //$roles = ;
            if (\GIndie\Platform\Current::hasRole($table::getValidRolesFor("gip-delete"))) {
                $this->_delete = \TRUE;
            }

            //$roles = ;
            if (\GIndie\Platform\Current::hasRole($table::getValidRolesFor("gip-state"))) {
                $this->_state = \TRUE;
            }
        }

        $this->_model = $table;
        $this->_rowIdAttribute = $table::PrimaryKey();
        parent::__construct("", ["class" => "display table table-bordered"]);
        $this->setTag("table");
        $this->setId(\GIndie\Platform\Security::tokenizeSecure(static::class));
        $this->addContent($this->tableContent($selectedId));
    }

    private function _isEditable()
    {
        //if ($this->_create || $this->_edit || $this->_state || $this->_delete) {
        if ($this->_edit || $this->_state || $this->_delete) {
            return \TRUE;
        }
        return \FALSE;
    }

    /**
     * @todo Eliminar estilos, pasar a CSS global
     * Define codigo Javascript customizados al interior del Nodo actual.
     * @since GIP.00.01
     * @return string
     */
    public function defineScript()
    {
        $tableModel = $this->_model;
        $title = $tableModel::Name();
        ob_start();
        ?>
        <script>
            var columns = [<?= $this->_getColumns(); ?>];
            var title = "<?= $title; ?>";
            $(document).ready(function () {
                create_datatable("<?= $this->getId(); ?>", {"title": title, "columns": columns, "search": false, "export": false, "pagination": false, "selectable": true});
            });
        </script>
        <?php
        $str = ob_get_contents();
        ob_end_clean();
        //return "";
        return $str;
    }

    protected function _getColumns()
    {
        $int = 0;
        $arrayTmp = [$int];
        if ($this->_isEditable()) {
            $int = $int + 1;
        }
        foreach ($this->_model->getColumns() as $value) {
            $int = $int + 1;
            $arrayTmp[] = $int;
        }
        return join(",", $arrayTmp);
    }

    protected function _btnGroup($rowId)
    {
        $bntGroup = new StylesSemantics\Div("",
                                            ["class" => "btn-group btn-group-xs"]);
        if ($this->_delete) {
//            $button = Widget\Buttons::CustomDanger(Icons::Delete(),
//                                                   "form-delete", $rowId, \TRUE,
//                                                   $this->_relatedRecord);
            $button = Widget\Buttons::Delete($this->_relatedRecord, $rowId);
            $bntGroup->addContent($button);
        }
        if ($this->_edit) {
            $button = Widget\Buttons::Edit($this->_relatedRecord, $rowId);
            $bntGroup->addContent($button);
        }
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
     */
    protected function tableContent($selectedId)
    {
        ob_start();
        ?>
        <thead> 
            <tr> 
                <th>#</th> 
                <?php
                if ($this->_isEditable()) {
                    ?>
                    <th>Acciones</th>
                    <?php
                }
                foreach ($this->_model->getColumns() as $colName) {
                    ?>
                    <th>
                        <?=
                        //if()
                        $this->_model->getLabel($colName)
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
            $total = 0;
            foreach ($this->_model->getRows() as $row) {
                $inc++;
                ?>
                <tr <?= strcmp($selectedId, $row->getValue($this->_rowIdAttribute)) == 0 ? 'class="selected"' : "" ?> gip-record="<?= $row->getValue($this->_rowIdAttribute); ?>"> 
                    <th scope="row"><?= $inc; ?></th>
                    <?php
                    if ($this->_isEditable()) {
                        ?>
                        <td class="text-center"><?= $this->_btnGroup($row->getValue("id")); ?></td>
                        <?php
                    }

                    foreach ($this->_model->getColumns() as $columnName) {
                        $column = $this->_model->getColumn($columnName);
                        ?>
                        <td >
                            <?php
                            switch ($column->getType())
                            {
                                case \GIndie\Platform\Model\Attribute::TYPE_CURRENCY:
                                    $total = $total + \floatval($this->_model->getValueOf($row->getValue($this->_rowIdAttribute),
                                                                                                         $columnName));
                                default:
                                    echo $this->_model->getDisplayOf($row->getValue($this->_rowIdAttribute),
                                                                                    $columnName);
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
        if ($this->_showFooter) {
            ?>
            <tfoot>
                <tr>
                    <td></td>
                    <?php
                    if ($this->_isEditable()) {
                        ?>
                        <td></td>
                        <?php
                    }
                    foreach ($this->_model->getColumns() as $colName) {
                        $columnTmp = $this->_model->getColumn($colName);
                        ?>
                        <td>
                            <?php
                            switch ($columnTmp->getType())
                            {

                                case \GIndie\Platform\Model\Attribute::TYPE_CURRENCY:
                                    if (isset($total)) {
                                        $total = bcadd(\strval($total), 0, 2);
                                        echo isset($total) ? "$" . $total : "";
                                    }
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
