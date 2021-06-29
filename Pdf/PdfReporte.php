<?php
/**
 * FacturaElectronica - PdfFactura
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Empresarial\BitacoraCitas\Plataforma
 * 
 * @since 21-06-01
 * @version DOING
 */

namespace GIndie\Empresarial\BitacoraCitas\Plataforma\Controlador;

/**
 * 
 * 
 */
class PdfReporteDPR {

    /**
     * 
     * 
     * @param string $title
     * @param string $documento
     * @return \static
     * 
     * @since 21-06-01
     */
    public static function getInstance($titulo, \GIndie\Empresarial\BitacoraCitas\Plataforma\ModeloDatos\Doctor $encabezado, $documento) {
        return new static($titulo, $encabezado, $documento);
    }

    /**
     * 
     * @param string $title
     * @param string $documento
     * @since 21-06-01
     */
    private function __construct($title, \GIndie\Empresarial\BitacoraCitas\Plataforma\ModeloDatos\Doctor $encabezado, $documento) {
        $this->RutaLogo = \pathinfo($_SERVER["SCRIPT_FILENAME"], \PATHINFO_DIRNAME);
        $this->RutaLogo .= \GIndie\FacturaElectronica\INIHandler::getValue("Cliente", "rutaLogo");

        $this->Pdf = new \GIndie\Platform\Pdf\MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, "LETTER", true, 'UTF-8', false);

        /* Añadiendo información acerca de la creación del PDF. OPCIONAL */
        //$this->Pdf->SetCreator(PDF_CREATOR); /* Nombre del creador */
//        $this->Pdf->SetAuthor(\GIndie\FacturaElectronica\INIHandler::getValue("Emisor", "razonSocial")); /* Nombre del autor */
        $this->Pdf->SetTitle($title); /* Título del PDF */
        $this->Pdf->SetSubject('Reporte autogenerado con la Plataforma de Grupo INDIE'); /* Asunto del PDF */
//        $this->Pdf->SetKeywords('pdf, factura, xml, cfdi'); /* Palabras clave del documento */

        $this->Pdf->htmlFooter = $this->pieNota();
        $this->cabecera($title,$encabezado);
        $this->Pdf->setHtmlHeader($this->cabecera($title,$encabezado));

        /* Colocando el nombre de la fuente, el estilo y el tamaño  de la fuente en la cabecera y el pie de página */
        /* Requiere el nombre de la fuente, su estilo (negrita, italica) y su tamaño */
        $this->Pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 8));
        $this->Pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        /* Determinando los margenes del documento */
        $this->Pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT); /* Margenes para todo el documento */
        $this->Pdf->SetHeaderMargin(PDF_MARGIN_HEADER); /* Margen de la cabecera */
        $this->Pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        /* Activar los saltos de página cuando se llegue al limite del documento */
        $this->Pdf->SetAutoPageBreak(TRUE, 33);

        /* Activar el factor de escalamiento de las imágenes */
        $this->Pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        /* Estableciendo la fuenta a usar en el contenido del documento */
        $this->Pdf->SetFont('dejavusans', '', 7.8);

        /* Insertando la pagina donde se mostrará la factura */
        $this->Pdf->AddPage();

        /* Actualizando la posición del cursor en Y despues de que se ingresara la cabecera */
        //$this->Pdf->setY($this->Pdf->tmpMargin);
        //$this->Pdf->setY($this->Pdf->current_y);

        /* Generando el contenido del PDF personalizado */
        $this->documento($documento);
    }

    /**
     * 
     * @since 21-06-01
     * @return string
     */
    private function cabecera($titulo, \GIndie\Empresarial\BitacoraCitas\Plataforma\ModeloDatos\Doctor $encabezado) {
        \ob_start();
        ?>
        <-- Datos cabecera -->
        <table cellpadding="1" bgcolor="#0404B4" color="#FFFFFF">
<!--            <tr align="center">
                <th colspan="12"><h2><strong><?= $titulo; ?></strong></h2></th>
            </tr>-->
            <tr>
                <td colspan="4" align="center"> <-- Logo del documento -->
                    <img src="<?= $this->RutaLogo; ?>" alt="Logo" style="float:left; width:100px; height:100px;">
                </td>
                <td colspan="3" align="center"> 
                    <th colspan="12"><h2><strong><?= $titulo; ?></strong></h2></th>
                </td>
                <td colspan="5">
                    <-- Datos de la factura -->
                    <table cellpadding="1" align="center">
                        <tr>
                            <td colspan="2" bgcolor="#2E9AFE"><strong><?= $encabezado->getLabelOf($encabezado::CLM_NOMBRE_COMPLETO); ?></strong></td>
                        </tr>
                        <tr align="center">
                            <td colspan="2"><?= $encabezado->getValueOf($encabezado::CLM_NOMBRE_COMPLETO);  ?></td>
                        </tr>
                        <tr align="center">
                            <td colspan="2" bgcolor="#2E9AFE"><strong><?= $encabezado->getLabelOf($encabezado::CLM_TELEFONO); ?></strong></td>
                        </tr>
                        <tr align="center">
                            <td colspan="2"><?= $encabezado->getValueOf($encabezado::CLM_TELEFONO); ?></td>
                        </tr>
                        <tr align="center">
                            <td colspan="2" bgcolor="#2E9AFE"><strong><?= $encabezado->getLabelOf($encabezado::CLM_CORREO); ?></strong></td>
                        </tr>
                        <tr align="center">
                            <td colspan="2"><?= $encabezado->getValueOf($encabezado::CLM_CORREO); ?></td>
                        </tr>
                        <tr align="center">
                            <td colspan="2" bgcolor="#2E9AFE"><strong><?= $encabezado->getLabelOf($encabezado::CLM_CEDULA); ?></strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="12" align="right"><?= $encabezado->getValueOf($encabezado::CLM_CEDULA); ?></td>
            </tr>
        </table>
        <table> <-- Cuatro colores de la cabecera -->
            <tr><td bgcolor="#045FB4"></td><td bgcolor="#2E9AFE"></td></tr>
            <tr><td bgcolor="#0404B4"></td><td bgcolor="#2E2EFE"></td></tr>
        </table>
        <br />
        <?php
        $htmlData = \ob_get_contents();
        \ob_end_clean();
        return $htmlData;
    }

    /**
     * 
     * @since 21-06-01
     * @return string
     */
    private function pieNota() {
        \ob_start();
        ?>
        <table cellpadding="1" align="center" bgcolor="#0404B4" color="#FFFFFF">
            <tr>
                <td>Documento autogenerado <strong>https://grupoindie.com</strong> </td>
            </tr>
        </table>
        <?php
        $htmlData = \ob_get_contents();
        \ob_end_clean();
        return $htmlData;
    }

    /**
     * Método para generar el código HTML del contenido del documento. 
     * Como parametro se recibe un objeto SimpleXMLElement
     * 
     * @param string $htmlData
     * @since 21-06-01
     */
    private function documento($htmlData) {
        /* HTML que contendrá el contenido del PDF */

        /* Se añade el contenido HTML al documento */
        $this->Pdf->writeHTML($htmlData, true, false, true, false, '');
    }

    /**
     * Mandar peticion de descarga del PDF
     * 
     * @since 21-06-01
     * @param string $filepath
     */
    public function guardarArchivo($filepath) {
        return $this->Pdf->Output($filepath, 'F');
    }

    /**
     * @since 21-06-01
     * @var string Variable que almacena la ruta del logo
     */
    private $RutaLogo;

    /**
     * @since 21-06-01
     * @var TCPDF Variable que almacena el objeto TCPDF
     */
    private $Pdf;

}
