<?php
/**
 * GI-Platform-DVLP - ErrorHandler
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2019 Angel Sierra Vega. Grupo INDIE.
 * @license file://LICENSE
 *
 * @package GIndie\Platform\Module
 *
 * @version 0B.00
 * @since 19-02-13
 */

namespace GIndie\Platform\Module;

use GIndie\Platform\View;
use GIndie\ScriptGenerator\Bootstrap3\Component\Alert;

/**
 * 
 * @edit 19-02-13
 * - Copied code from \MunicipioMineralReforma\Predial\Modulo\Sistema\ManejoErrores
 */
class ErrorHandler extends \GIndie\Platform\Controller\Module
{

    /**
     * {@inheritdoc}
     * @since 18-12-28
     */
    public static function description()
    {
        return "Desde este módulo se pueden administrar los reportes de error de PHP";
    }

    /**
     * {@inheritdoc}
     * @since 18-12-28
     */
    public static function name()
    {
        return "Manejador de errores";
    }

    /**
     * {@inheritdoc}
     * @since 18-12-28
     */
    public static function category()
    {
        return "Sistema";
    }

    /**
     * @since 18-03-21
     */
    public function configPlaceholders()
    {
        //$this->configPlaceholder("i-i-i")->typeHTMLString("THIS MUST NOT APPEAR");
        $this->placeholder("ii-i-i")->typeHTMLString("THIS MUST NOT APPEAR");
//        $this->placeholder("ii-iii-i")->typeHTMLString("THIS MUST NOT APPEAR");
//        $this->placeholder("ii-iii-ii")->typeHTMLString("THIS MUST NOT APPEAR");
//        $this->placeholder("ii-iii-iii")->typeHTMLString("THIS MUST NOT APPEAR");
        $this->placeholder("iii-i-i")->typeHTMLString("THIS MUST NOT APPEAR");
        $this->placeholder("widgetPHPErrorLog");
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
     * @since 18-03-21
     * @return \GIndie\Platform\View\Widget
     */
    protected function widgetGeneralInfo()
    {

        $rtnWidget = new View\Widget("Información general (MySQL)", true, true);
//        $button = View\Widget\Buttons::CustomSuccess("Crear respaldo", "modal-crear-respaldo",
//                null, true);
//        $rtnWidget->addButtonHeading($button);
        $rtnWidget->addButtonHeading(\GIndie\Platform\View\Widget\Buttons::Reload());
        $rtnWidget->setContext("primary");
        $link = \GIndie\DBHandler\MySQL57::getConnection();
        $rtnWidget->getBody()->addContent("<b>Versión:</b> " . \mysqli_get_server_info($link)); //mysqli_stat
        $rtnWidget->getBody()->addContent("<br>");
        $rtnWidget->getBody()->addContent("<b>Status:</b> " . \mysqli_stat($link));
        $rtnWidget->getBody()->addContent("<br>");
        $result = $link->query("select @@basedir,@@sql_mode,@@log_error,@@datadir;")->fetch_assoc();
        $rnt = "<b>Variable basedir:</b> " . $result["@@basedir"];
        $rnt .= "<br><b>Variable datadir:</b> " . $result["@@datadir"];
        $rnt .= "<br><b>Variable sql_mode:</b> " . $result["@@sql_mode"];
        $rnt .= "<br><b>Variable log_error:</b> " . $result["@@log_error"];
        $rtnWidget->getBody()->addContent($rnt);
        $rtnWidget->getBody()->addContent("<br>");
        return $rtnWidget;
    }

    /**
     * @since 18-03-22
     * @return \GIndie\Platform\View\Widget
     */
    protected function widgetErrorLog()
    {
        $query = \GIndie\DBHandler\MySQL57::query("select @@log_error;")->fetch_assoc();
        $rtnWidget = new View\Widget("Error log (MySQL) <sub>" . $query["@@log_error"] . "</sub>",
            true, true);
        $rtnWidget->setContext("primary");
        $rtnWidget->addButtonHeading(View\Widget\Buttons::CustomDanger("Vaciar log",
                "modal-vaciar-log", null, true));
        $rtnWidget->addButtonHeading(View\Widget\Buttons::Reload());
        $content = \file_get_contents($query["@@log_error"]);
        $rtnWidget->getBody()->addContent("<pre>{$content}</pre>");
        return $rtnWidget;
    }

    /**
     * @since 18-12-28
     * @return \GIndie\Platform\View\Widget
     */
    public function widgetPHPErrorLog()
    {
        $ruta = \ini_get('error_log');
        switch (true)
        {
            case $ruta == "":
            case \is_null($ruta);
                $rtnWidget = new View\Widget("No se encontró el archivo de log de errores",
                    "Definir en php.ini error_log = /var/log/php-scripts.log");
                break;
            default:
                $rtnWidget = new View\Widget("Error log (PHP) <sub>{$ruta}</sub>", true, true);
                $rtnWidget->setContext("primary");
//                $rtnWidget->addButtonHeading(View\Widget\Buttons::CustomDanger("Vaciar log",
//                        "modal-vaciar-log", null, true));
                $rtnWidget->addButtonHeading(View\Widget\Buttons::Reload());
                $content = \file_get_contents($ruta);
                $rtnWidget->getBody()->addContent("<pre>{$content}</pre>");
                break;
        }

        return $rtnWidget;
    }

    /**
     * @since 18-03-21
     * @return type
     */
    private function codigoMySQL()
    {
        \ob_start();
        ?>
        ALTER EVENT `mr_ingresos`.`evt_expirar_ordenes`
        ON SCHEDULE EVERY 1 DAY STARTS '<?= \date("Y-m-d", \strtotime("+ 1 day")) ?> 00:00:10';
        <?php
        $out = \ob_get_contents();
        \ob_end_clean();
        return $out;
    }

    /**
     * @since 18-03-21
     * @return type
     */
    private function codigoINI()
    {
        \ob_start();
        ?>
        ...
        [mysqld]
        ...
        event_scheduler = ON                          
        <?php
        $out = \ob_get_contents();
        \ob_end_clean();
        return $out;
    }

    /**
     * 
     * @return type
     * @since 18-03-21
     */
    private function textoPlanificadorDesactivado()
    {
        \ob_start();
        ?>
        <p>Para activar <em>automáticamente</em> el planificador de eventos al 
            reiniciar MySQL defina la variable <kbd>event_scheduler = ON</kbd>
            dentro de <mark>la categoría</mark> <kbd>[mysqld]</kbd> 
            desde el archivo de configuración de MySQL.</p>
        <p><small>Archivo de configuración en Red Hat, Fedora y derivados:</small>
            <br><samp>/etc/my.cnf</samp></p>
        <p><small>Archivo de configuración en Ubuntu, Debian y derivados:</small>
            <br><samp>/etc/mysql/my.cnf</samp></p>
        <pre><?= $this->codigoINI(); ?></pre>
        <?php
        $out = \ob_get_contents();
        \ob_end_clean();
        return $out;
    }

    /**
     * 
     * @param array $array
     * @return string
     * @since 18-03-21
     */
    private function parseAssoc(array $array)
    {
        $rtnStr = "";
        foreach ($array as $key => $value) {
            switch (true)
            {
                case \is_null($value):break;
                default:
                    $rtnStr .= "<b>{$key}</b>: {$value}<br>";
                    break;
            }
        }
        return $rtnStr;
    }

    /**
     * 
     * @return \GIndie\Platform\View\Modal\Content
     * @since 18-03-22
     */
    private function modalCrearRespaldo()
    {
        $modal = View\Modal\Content::primary("Crear respaldo", "");
        $form = new View\Form(null, true, "#gip-modal");
        $form->setAttribute("gip-action", "action-crear-respaldo");
        $path = \GIndie\Platform\Current::Instance()->rutaRespaldos() . "respaldo_" . \date("Y_m_d") . ".sql";
        $input = View\Input::Text("ruta-respaldo", $path, true);
        $input = View\Input::FomGroupClean("Ruta completa al archivo", "ruta-respaldo", $input);
        $form->addContent($input);
        $modal->addContent($form);
        $button = new \GIndie\ScriptGenerator\Bootstrap3\Component\Button("Crear respaldo",
            "submit");
        $button->setContext("success");
        $button->setForm($form->getId());
        $modal->addFooterButton($button);
        return $modal;
    }

    /**
     * 
     * @since 18-03-22
     * @return \GIndie\Platform\View\Modal\Content
     */
    private function actionCrearRespaldo()
    {
        $rtnModal = null;
        try {
            $host = "localhost";
            $username = \GIndie\DBHandler\INIHandler::getValue("users", "main_username");
            $password = \GIndie\DBHandler\INIHandler::getValue("users", "main_password");
            $database_name = \GIndie\Platform\Model\Record::SCHEMA;
            $dump = new \Ifsnop\Mysqldump\Mysqldump('mysql:host=' . $host . ';dbname=' . $database_name,
                $username, $password);
            $dump->start($_POST["ruta-respaldo"]);
            $rtnModal = View\Modal\Content::success("Crear respaldo", "Respaldo creado con éxito.");
        } catch (\Exception $e) {
            $rtnModal = View\Modal\Content::warning("Algo salió mal", $e->getMessage());
        }
        return $rtnModal;
    }

    /**
     * @since 18-02-22
     * @param string $pathToFile
     * @return \GIndie\Platform\View\Modal\Content
     */
    protected function modalVaciarLog($pathToLogFile)
    {
        $modal = View\Modal\Content::warning("Vaciar log", "");
        $form = new View\Form(null, true, "#gip-modal");
        $form->setAttribute("gip-action", "action-vaciar-log");
        $dir = \GIndie\Platform\Current::Instance()->rutaRespaldos();
        $dir = \realpath($dir);
        $input = View\Input::Text("ruta-respaldo",
                $dir . DIRECTORY_SEPARATOR . \basename($pathToLogFile) . \date(".ymd.His") . "",
                false, "No se creará respaldo",
                "Si deja vacío este campo no se intentará crear un respaldo");
        $input = View\Input::FomGroupClean("Respaldo", "ruta-respaldo", $input);
        $form->addContent($input);
        $form->addContent(View\Input::hidden("ruta-log", $pathToLogFile));
        $modal->addContent($form);
        $button = new \GIndie\ScriptGenerator\Bootstrap3\Component\Button("Vaciar log", "submit");
        $button->setContext("warning");
        $button->setForm($form->getId());
        $modal->addFooterButton($button);
        return $modal;
    }

    /**
     * @since 18-02-22
     * @return \GIndie\Platform\View\Modal\Content
     */
    protected function actionVaciarLog()
    {
        switch (false)
        {
            case (empty($_POST["ruta-respaldo"]) == false):
                break;
            case \file_exists(\dirname($_POST["ruta-respaldo"])):
                return View\Modal\Content::warning("Algo salió mal",
                        "El directorio no pudo ser leido.");
            case \copy($_POST["ruta-log"], $_POST["ruta-respaldo"]):
                return View\Modal\Content::warning("Algo salió mal",
                        "No se pudo copiar el archivo.");
        }
        if (\file_put_contents($_POST["ruta-log"], "") !== false) {
            $modal = View\Modal\Content::success("Vaciar log", "Archivo vaciado con éxito.");
        } else {
            $modal = View\Modal\Content::warning("Algo salió mal",
                    "No se pudo vaciar el archivo log.");
        }
        return $modal;
    }

    /**
     * 
     * @since 18-03-21
     * 
     * @param string $action
     * @param string $id
     * @param string $class
     * @param string $selected
     * 
     * @return mixed
     * @edit 18-03-22
     */
    public function run($action, $id, $class, $selected)
    {
        $rtn = null;
        switch ($action)
        {
            case "modal-vaciar-log":
                $query = \GIndie\DBHandler\MySQL57::query("select @@log_error;")->fetch_assoc();
                $rtn = $this->modalVaciarLog($query["@@log_error"]);
                break;
            case "action-vaciar-log":
                $rtn = $this->actionVaciarLog();
                break;
            case "modal-crear-respaldo":
                $rtn = $this->modalCrearRespaldo();
                break;
            case "action-crear-respaldo":
                $rtn = $this->actionCrearRespaldo();
                break;
            case "activar-planificador":
                $result = \GIndie\DBHandler\MySQL57::query("SET GLOBAL event_scheduler = ON;");
                $rtn = $this->widgetEventScheduler();
                if (!$result) {
                    $rtn->getHeadingBody()->addContent(
                        Alert::danger(\GIndie\DBHandler\MySQL57::getConnection()->error)
                    );
                }
                break;
            case "desactivar-planificador":
                $result = \GIndie\DBHandler\MySQL57::query("SET GLOBAL event_scheduler = OFF;");
                $rtn = $this->widgetEventScheduler();
                if (!$result) {
                    $rtn->getHeadingBody()->addContent(
                        Alert::danger(\GIndie\DBHandler\MySQL57::getConnection()->error)
                    );
                }
                break;
            case "actualizar-evento":
                $result = \GIndie\DBHandler\MySQL57::query($this->codigoMySQL());
                $rtn = $this->widgetEventoExpirarOrden();
                if ($result) {
                    $rtn->getHeadingBody()->addContent(
                        Alert::success(\date("H:i:s") . " Evento actualizado")
                    );
                } else {
                    $rtn->getHeadingBody()->addContent(
                        Alert::danger(\GIndie\DBHandler\MySQL57::getConnection()->error)
                    );
                }
                break;
            case "ejecutar-proceso":
                $result = \GIndie\DBHandler\MySQL57::query("CALL `mr_ingresos`.`prc_expirar_ordenes`;");
                if ($result) {
                    $rtn = Alert::success(\date("H:i:s") . " Proceso ejecutado. Filas afectadas: " . \GIndie\DBHandler\MySQL57::getConnection()->affected_rows);
                } else {
                    $rtn = Alert::danger(\GIndie\DBHandler\MySQL57::getConnection()->error);
                }
                break;
            default:
                $rtn = parent::run($action, $id, $class, $selected);
                break;
        }
        return $rtn;
    }

    /**
     * 
     * @param string $id
     * @param string $class
     * @param string $selected
     * 
     * @since 18-03-21
     * 
     * @return \GIndie\Platform\View\Widget
     */
    protected function widgetReload($id, $class, $selected)
    {
        $widget = null;
        switch ($id)
        {
            case "ii-i-i":
                $widget = $this->widgetGeneralInfo();
                break;
            case "ii-iii-i":
//                $widget = $this->widgetEventScheduler();
                break;
            case "ii-iii-ii":
//                $widget = $this->widgetEventoExpirarOrden();
                break;
            case "ii-iii-iii":
//                $widget = $this->widgetProcedimientoExpirarOrden();
                break;
            case "iii-i-i":
                $widget = $this->widgetErrorLog();
                break;
            default:
                $widget = parent::widgetReload($id, $class, $selected);
                break;
        }
        return $widget;
    }

    /**
     * 
     * @return array
     * @since 18-03-21
     */
    public static function requiredRoles()
    {
        return ["AS"];
    }

}
