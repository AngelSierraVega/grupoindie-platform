<?php

/**
 * FacturaElectronica - MYPDF 2017-??-??
 * @copyright (C) 2021 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform
 * 
 * @since 21-06-01
 * @version DOING
 */

namespace GIndie\Platform\Pdf;

/**
 * Extendiendo la clase TCPDF para generar cabeceras y pie de páginas personalizadas
 * 
 * @edit FE.00.01
 *  - Clase copiada de proyecto \WebServiceTimbrado
 * @edit FE.00.02 18-01-11
 * - Added and use $htmlFooter
 * @edit FE.00.03 18-03-07
 * - Created AddPage(), $tmpMargin
 */
class MYPDF extends \TCPDF
{

    /**
     *
     * @var type 
     * @since FE.00.03
     */
    private $tmpMargin;

    /**
     * 
     * @param type $orientation
     * @param type $format
     * @param type $keepmargins
     * @param type $tocpage
     * @since FE.00.03
     */
    public function AddPage($orientation = '', $format = '', $keepmargins = false, $tocpage = false)
    {
        parent::AddPage($orientation, $format, false, true);
        $this->SetTopMargin($this->tmpMargin);
    }

    /**
     * @since FE.00.02
     * @var string|null 
     */
    public $htmlFooter;
    private $htmlHeader; /* Variable que almacena el contenido de la cabecera del HTML */

    /**
     * Método para colocar el HTML de la cabecera
     * @param type $htmlHeader
     * 
     * @since FE.00.01
     */
    public function setHtmlHeader($htmlHeader)
    {
        $this->htmlHeader = $htmlHeader;
    }

    /**
     * Sobrecargando el método de la cabecera para cargar el HTML a la cabecera del PDF
     * @since FE.00.01
     * @edit 18-03-19
     * - Se agregó imagen de fondo desde archivo INI
     */
    public function Header()
    {
        $rutaFondo = \GIndie\FacturaElectronica\INIHandler::getValue("Cliente", "rutaFondo");
        if ($rutaFondo) {
            $rutaFondo = \pathinfo($_SERVER["SCRIPT_FILENAME"], \PATHINFO_DIRNAME) . $rutaFondo;
            // get the current page break margin
            $bMargin = $this->getBreakMargin();
            // get current auto-page-break mode
            $auto_page_break = $this->AutoPageBreak;
            // disable auto-page-break
            $this->SetAutoPageBreak(false, 0);
            $this->Image($rutaFondo, 0, 0, 216, 279, '', '', '', false, 300, '', false, false, 0);
            // restore auto-page-break status
            $this->SetAutoPageBreak($auto_page_break, $bMargin);
            // set the starting point for the page content
            $this->setPageMark();
        }
        $this->writeHTMLCell(
                $w = 0, $h = 0, $x = '', $y = '', $this->htmlHeader, $border = 0, 1, $fill = 0, $reseth = true, $align
                = 'top', $autopadding = true);
        $this->tmpMargin = $this->getY();
    }

    /**
     * Sobrecargando el método de la cabecera para cargar el HTML a la cabecera del PDF
     * @since FE.00.01
     */
    public function Footer()
    {
        $this->SetY(-30);
        // Set font
        //$this->SetFont('helvetica', 'I', 8);
        // Page number
        //$this->htmlFooter .= 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages();
        $this->writeHTMLCell(
                $w = 0, $h = 0, $x = '', $y = '', $this->htmlFooter, $border = 0, 1, $fill = 0, $reseth = true, $align
                = 'bottom', $autopadding = true);
        //$this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

}
