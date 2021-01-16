<?php

/**
 * GI-Platform-DVLP - SystemLogs
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\Module
 *
 * @version 0B.00
 * @since 18-11-28
 */

namespace GIndie\Platform\Module;

/**
 * 
 * @edit 19-02-13
 * - Copied code from MunicipioMineralReforma\Predial\Modulo\Sistema\BitacoraGlobal
 */
class SystemLogs extends \GIndie\Platform\Controller\Module
{

    /**
     * {@inheritdoc}
     * @since 19-02-13
     */
    public static function name()
    {
        return "Bitácora global";
    }

    /**
     * {@inheritdoc}
     * @since 19-02-13
     */
    public static function description()
    {
        return "A través de este módulo se puede acceder a la bitácora global del sistema";
    }

    /**
     * {@inheritdoc}
     * @since 19-02-13
     */
    public static function category()
    {
        return "Sistema";
    }

    /**
     * {@inheritdoc}
     * @since 19-02-13
     */
    public function configPlaceholders()
    {
//        $this->placeholder("o-o-o")->typeCallable([$this, "wdgtModuleInfo"]);
        $this->placeholder("i-i-i")->typeCallable([$this, "wdgtBusquedaBitacora"]);
    }

    /**
     * {@inheritdoc}
     * @since 19-02-13
     */
    public static function configActions()
    {
//        static::setActionModel("@createTbl01", Tbl01Autoincremented::class, "gip-create");
    }

    /**
     * {@inheritdoc}
     * @since 19-02-13
     */
    protected function tableSearch($class)
    {
        if (($_POST["pltfrm_cta_fk"] == "NULL") && empty($_POST["timestamp"]) && empty($_POST["notes"])) {
            return "<p class='text-warning text-center'>Por favor ingrese al menos un criterio de búsqueda</p>";
        }
        return parent::tableSearch($class);
    }

    /**
     * Widget de búsqueda de bitácora
     * 
     * @return \GIndie\Platform\View\Widget
     * @since 19-02-13
     */
    public function wdgtBusquedaBitacora()
    {
        $widget = $this->widgetTableSearch(
//            \MunicipioMineralReforma\Predial\ModeloDatos\Plataforma\Base\BitacoraUsuario::class,
            \GIndie\Platform\DataModel\Platform\LogUser::class,
            ["pltfrm_cta_fk", ["timestamp" => \time()], "notes"]);
        return $widget;
    }

    /**
     * {@inheritdoc}
     * @since 19-02-13
     */
    public static function requiredRoles()
    {
        return ["AS"];
    }

    /**
     * 
     * @param string $pathToFile
     * @return \GIndie\Platform\View\Modal\Content
     * 
     * @since 19-02-13
     * @todo Debugear y probar método
     */
    protected function modalRespaldarRegistros()
    {
        $modal = View\Modal\Content::warning("Respaldar registros", "");
        if ($this->bitacoraTabla) {
            $form = new View\Form(null, true, "#gip-modal");
            $form->setAttribute("gip-action", "action-respaldar-registros");
            $rutaRespaldos = \realpath(Current::Instance()->rutaRespaldos());
            //"respaldo_bitacora_usuario_" . \date("ymd_His") . ".csv"
            $input = View\Input::Text("ruta-respaldo", $rutaRespaldos, true, "",
                    "El nombre del archivo se creará automaticamente en formato CSV");
            $input = View\Input::FomGroupClean("Directorio de respaldo", "ruta-respaldo", $input);
            $form->addContent($input);
            $modal->addContent($form);
            $button = new \GIndie\ScriptGenerator\Bootstrap3\Component\Button("Respaldar registros",
                "submit");
            $button->setContext("warning");
            $button->setForm($form->getId());
            $modal->addFooterButton($button);
            $modal->addContent("<p><b>Registros a eliminar/respaldar: </b>" . \count($this->bitacoraTabla->getRows()) . "</p>");
        } else {
            $modal->addContent("<p>Ningún registro disponible.</p>");
        }
        return $modal;
    }

    /**
     * 
     * @param string $pathToFile
     * @return \GIndie\Platform\View\Modal\Content
     * @since 19-02-13
     * @todo Debugear y probar método
     */
    protected function actionRespaldarRegistros()
    {
        if ($this->bitacoraTabla) {
            if (\file_exists($_POST["ruta-respaldo"])) {
                $filename = $_POST["ruta-respaldo"] . DIRECTORY_SEPARATOR . "respaldo_bitacora_usuario_" . \date("ymd_His") . ".csv";
                $file = \fopen($filename, "w");
                \fwrite($file, \pack("CCC", 0xef, 0xbb, 0xbf));
                $tablaBitacora = $this->bitacoraTabla;
                $count = 0;
                $orArray = [];
                foreach ($tablaBitacora->getRows() as $id => $row) {
                    $tmpArray = [];
                    $orArray[] = "id='" . $tablaBitacora->getValueOf($id, "id") . "'";
                    foreach ($tablaBitacora->ColumnNames() as $columnName) {
                        switch ($columnName)
                        {
                            default:
                                $value = $tablaBitacora->getValueOf($id, $columnName);
                                break;
                        }
                        $tmpArray[$columnName] = $value;
                    }
                    \fputcsv($file, $tmpArray);
                    $count++;
                }
                \fclose($file);
                $modal = View\Modal\Content::success("Respaldar registros", "");
                $modal->addContent("<p>- Proceso de respaldo</p>");
                $modal->addContent("<p><b>Archivo de respaldo creado: </b>{$filename}</p>");
                $modal->addContent("<p><b>Registros respaldados: </b>{$count}</p>");
                $modal->addContent("<p>- Proceso de eliminación</p>");
                $stmDelete = "DELETE FROM `mr_ingresos`.`bitacora_usuario` WHERE (" . \join(" OR ",
                        $orArray) . ");";
                if (\GIndie\DBHandler\MySQL::query($stmDelete)) {
                    $numEliminados = \GIndie\DBHandler\MySQL::getConnection()->affected_rows;
                    $modal->addContent("<p><b>Registros eliminados: </b>{$numEliminados}</p>");
                    $modal->addContent(View\Javascript::reloadWidget("ii-i-i"));
                } else {
                    $modal->addContent("Algo salió mal en el proceso de eliminación: " . \GIndie\DBHandler\MySQL::getConnection()->error);
                    $modal->getHeader()->setBackground("danger");
                }
            } else {
                $modal = View\Modal\Content::warning("Algió salió mal", "");
                $modal->addContent("<p>Ruta no válida.</p>");
            }
        } else {
            $modal = View\Modal\Content::warning("Algió salió mal", "");
            $modal->addContent("<p>Ningún registro disponible.</p>");
        }
        return $modal;
    }

    /**
     * 
     * 
     * @param string $action
     * @param string $id
     * @param string $class
     * @param string $selected
     * 
     * @return mixed
     * 
     * @since 19-02-13
     * @todo Debugear y probar método
     */
    public function run($action, $id, $class, $selected)
    {
        $rtn = null;
        switch ($action)
        {
            case "modal-respaldar-registros":
                $rtn = $this->modalRespaldarRegistros();
                break;
            case "action-respaldar-registros":
                $rtn = $this->actionRespaldarRegistros();
                break;
            default:
                $rtn = parent::run($action, $id, $class, $selected);
        }
        return $rtn;
    }

}
