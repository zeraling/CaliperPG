<?php
/**
 * Html2Pdf Library - example
 *
 * HTML => PDF converter
 * distributed under the OSL-3.0 License
 *
 * @package   Html2pdf
 * @author    Laurent MINGUET <webmaster@html2pdf.fr>
 * @copyright 2017 Laurent MINGUET
 */
require_once '../../vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

ob_start();

?>
C39| CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9. <br>
<barcode dimension="1D" type="C39" value="123456" label="none" style="width:30mm; height:6mm;"></barcode>
<br><br>
C39+| CODE 39 with checksum
<br>
<barcode dimension="1D" type="C39+" value="123456" label="none"  style="width:30mm; height:6mm;"></barcode>
<br><br>
C39E| CODE 39 EXTENDED
<br>
<barcode dimension="1D" type="C39E" value="123456" label="none"  style="width:30mm; height:6mm;"></barcode>
<br><br>
C39E+| CODE 39 EXTENDED + CHECKSUM
<br>
<barcode dimension="1D" type="C39E+" value="123456" label="none" style="width:30mm; height:6mm;"></barcode>
<br><br>
C93| CODE 93 - USS-93
<br>
<barcode dimension="1D" type="C93" value="123456" label="none"  style="width:30mm; height:6mm;"></barcode><br><br>
S25| Standard 2 of 5
<br>
<barcode dimension="1D" type="S25" value="123456" label="none"  style="width:30mm; height:6mm;"></barcode><br><br>
S25+| Standard 2 of 5 + CHECKSUM
<br>
<barcode dimension="1D" type="S25+" value="123456" label="none"  style="width:30mm; height:6mm;"></barcode><br><br>
I25| Interleaved 2 of 5
<br>
<barcode dimension="1D" type="I25" value="123456" label="none"  style="width:30mm; height:6mm;"></barcode><br><br>
I25+| Interleaved 2 of 5 + CHECKSUM
<br>
<barcode dimension="1D" type="I25+" value="123456" label="none"  style="width:30mm; height:6mm;"></barcode><br><br>
C128| CODE 128
<br>
<barcode dimension="1D" type="C128" value="123456" label="none"  style="width:30mm; height:6mm;"></barcode><br><br>
C128A| CODE 128 A
<br>
<barcode dimension="1D" type="C128A" value="123456" label="none"  style="width:30mm; height:6mm;"></barcode><br><br>
C128B| CODE 128 B
<br>
<barcode dimension="1D" type="C128B" value="123456" label="none"  style="width:30mm; height:6mm;"></barcode><br><br>
C128C| CODE 128 C
<br>
<barcode dimension="1D" type="C128C" value="123456" label="none"  style="width:30mm; height:6mm;"></barcode><br><br>

EAN8| EAN 8
<br>
<barcode dimension="1D" type="EAN8" value="123456" label="none"  style="width:30mm; height:6mm;"></barcode><br><br>
EAN13| EAN 13
<br>
<barcode dimension="1D" type="EAN13" value="123456" label="none"  style="width:30mm; height:6mm;"></barcode><br><br>
UPCA| UPC-A
<br>
<barcode dimension="1D" type="UPCA" value="123456" label="none"  style="width:30mm; height:6mm;"></barcode><br><br>
UPCE| UPC-E
<br>
<barcode dimension="1D" type="UPCE" value="123456" label="none"  style="width:30mm; height:6mm;"></barcode><br><br>
MSI| MSI (Variation of Plessey code)
<br>
<barcode dimension="1D" type="MSI" value="123456" label="none"  style="width:30mm; height:6mm;"></barcode><br><br>
MSI+| MSI + CHECKSUM (modulo 11)
<br>
<barcode dimension="1D" type="MSI+" value="123456" label="none"  style="width:30mm; height:6mm;"></barcode><br><br>

CODABAR| CODABAR
<br>
<barcode dimension="1D" type="CODABAR" value="123456" label="none"  style="width:30mm; height:6mm;"></barcode><br><br>

<?php

$content = ob_get_clean();

try {
    $html2pdf = new Html2Pdf('P', 'A4', 'fr');
    $html2pdf->writeHTML($content);
    $html2pdf->output('exemple09.pdf');
    exit;
} catch (Html2PdfException $e) {
    $html2pdf->clean();

    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
    exit;
}